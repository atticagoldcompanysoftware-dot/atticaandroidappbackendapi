<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SMS
{
    private array $json = [];
    private ?string $mobile = null;
    private ?string $message = null;

    private ?string $current_template_key = null;
    private int $last_http_code = 0;
    private string $last_response = '';
    private string $last_error = '';

    public function __construct(?string $mobile = null)
    {
        $this->mobile = $mobile;
        $this->json = config('sms', []);

        $jsonPath = config('sms.json_path');
        if ($jsonPath && is_readable($jsonPath)) {
            $decoded = json_decode((string) file_get_contents($jsonPath), true);
            if (is_array($decoded)) {
                $this->json = array_replace_recursive($this->json, $decoded);
            }
        }
    }

    public function setMobile(string $mobile): self
    {
        $this->mobile = $mobile;
        return $this;
    }

    private function send_sms(): bool
    {
        return $this->send_via_get();
    }

    private function send_sms_curl(): bool
    {
        return $this->send_via_get();
    }

    private function build_from_template(string $tpl, array $vars): string
    {
        foreach ($vars as $v) {
            $tpl = preg_replace('/\{\#var\#\}/', (string) $v, $tpl, 1) ?? $tpl;
        }
        return $tpl;
    }

    private function resolve_template_id_for_message(): string
    {
        if ($this->current_template_key && isset($this->json['SMS'][$this->current_template_key]['Template_ID'])) {
            return (string) $this->json['SMS'][$this->current_template_key]['Template_ID'];
        }

        if (!empty($this->json['SMS']) && is_array($this->json['SMS'])) {
            foreach ($this->json['SMS'] as $info) {
                $tpl = (string) ($info['Template'] ?? '');
                $tid = (string) ($info['Template_ID'] ?? '');
                if (!$tpl || !$tid) {
                    continue;
                }

                $needle = trim((string) preg_replace('/\s*\{\#var\#\}\s*/', ' ', $tpl));
                $hay = trim((string) $this->message);
                $needle = (string) preg_replace('/\s+/', ' ', $needle);
                $hay = (string) preg_replace('/\s+/', ' ', $hay);

                if ($needle !== '' && stripos($hay, $needle) !== false) {
                    return $tid;
                }
            }
        }

        return '';
    }

    private function resolve_sender_for_template(): string
    {
        if ($this->current_template_key) {
            $templateSender = (string) ($this->json['SMS'][$this->current_template_key]['Sender'] ?? '');
            if (trim($templateSender) !== '') {
                return $templateSender;
            }
        }

        return (string) ($this->json['Sender'] ?? '');
    }

    private function send_via_get(): bool
    {
        $apiKey = $this->json['API'] ?? '';
        $baseURL = rtrim((string) ($this->json['BaseURL'] ?? 'https://api-alerts.solutionsinfini.com/v3/'), '/') . '/';
        $entityId = $this->json['Entity_ID'] ?? '';
        $sender = $this->resolve_sender_for_template();

        if (!$apiKey || !$sender || !$this->mobile || !$this->message) {
            $missing = [];
            if (!$apiKey) {
                $missing[] = 'API';
            }
            if (!$sender) {
                $missing[] = 'Sender';
            }
            if (!$this->mobile) {
                $missing[] = 'mobile';
            }
            if (!$this->message) {
                $missing[] = 'message';
            }

            Log::warning('SMS: Missing fields', ['missing' => $missing]);
            return false;
        }

        $templateId = $this->resolve_template_id_for_message();

        $params = [
            'method' => 'sms',
            'api_key' => $apiKey,
            'to' => $this->mobile,
            'sender' => $sender,
            'message' => $this->message,
        ];

        if ($templateId !== '') {
            $params['template_id'] = $templateId;
            $params['dlttemplateid'] = $templateId;
            $params['tempid'] = $templateId;
        }

        if ($entityId !== '') {
            $params['entity_id'] = $entityId;
            $params['peid'] = $entityId;
        }

        $response = Http::connectTimeout(10)->timeout(20)->get($baseURL, $params);

        $this->last_http_code = $response->status();
        $this->last_response = (string) $response->body();
        $this->last_error = $response->successful() ? '' : (string) $response->reason();

        if ($response->successful()) {
            Log::info('SMS: Sent OK', [
                'http_code' => $this->last_http_code,
                'response' => mb_substr($this->last_response, 0, 500),
            ]);
            return true;
        }

        Log::error('SMS: Send failed', [
            'http_code' => $this->last_http_code,
            'error' => $this->last_error,
            'response' => mb_substr($this->last_response, 0, 500),
        ]);
        return false;
    }

    public function bm_login(string $bm_name, string $otp, ?string $mobile = null): bool
    {
        $this->mobile = $mobile ?? $this->mobile;
        $tpl = $this->json['SMS']['BM_Login']['Template'] ?? '';

        if ($tpl) {
            $this->message = $this->build_from_template($tpl, [$bm_name, $otp]);
            $this->current_template_key = 'BM_Login';
        } else {
            $this->message = "Dear {$bm_name}, use this One Time Password (OTP): {$otp} to log in to your Attica Gold Company Account.";
            $this->current_template_key = null;
        }

        return $this->send_sms_curl();
    }

    public function customer_verification(string $customer_name, string $otp, ?string $mobile = null): bool
    {
        $this->mobile = $mobile ?? $this->mobile;
        $tpl = $this->json['SMS']['Customer_Verification']['Template'] ?? '';

        if ($tpl) {
            $this->message = $this->build_from_template($tpl, [$customer_name, $otp]);
            $this->current_template_key = 'Customer_Verification';
        } else {
            $this->message = "Dear {$customer_name}, Welcome to Attica Gold Company, your registration code is {$otp}.";
            $this->current_template_key = null;
        }

        return $this->send_sms_curl();
    }

    public function case_notification(string $lawyer_name, string $caseid, string $case_date, ?string $mobile = null): bool
    {
        $this->mobile = $mobile ?? $this->mobile;
        $tpl = $this->json['SMS']['Lawyer_Case_Reminder']['Template'] ?? '';

        if ($tpl) {
            $this->message = $this->build_from_template($tpl, [$lawyer_name, $caseid, $case_date]);
            $this->current_template_key = 'Lawyer_Case_Reminder';
        } else {
            $this->message = "Dear {$lawyer_name}, Your upcoming date for case {$caseid}, is nearing your case is on {$case_date}.";
            $this->current_template_key = null;
        }

        return $this->send_sms_curl();
    }

    public function branch_link(string $url, ?string $mobile = null): bool
    {
        $this->mobile = $mobile ?? $this->mobile;
        $tpl = $this->json['SMS']['Branch_Address']['Template'] ?? '';

        if ($tpl) {
            $this->message = $this->build_from_template($tpl, [$url]);
            $this->current_template_key = 'Branch_Address';
        } else {
            $this->message = "Dear Customer, Thank you for choosing Attica Gold Company, Click the link to find your nearest branch: {$url}";
            $this->current_template_key = null;
        }

        return $this->send_sms_curl();
    }

    public function te_cash_move(
        string $te_name,
        string $from_branch,
        string $to_branch,
        string $amount_rupees,
        string $date_str,
        ?string $mobile = null
    ): bool {
        $this->mobile = $mobile ?? $this->mobile;
        $tpl = $this->json['SMS']['TE_Cash_Move']['Template'] ?? '';

        if ($tpl) {
            $this->message = $this->build_from_template($tpl, [$te_name, $from_branch, $to_branch, $amount_rupees, $date_str]);
            $this->current_template_key = 'TE_Cash_Move';
        } else {
            $this->message = "Dear {$te_name}, Cash movement approved from {$from_branch} to {$to_branch} of Rs {$amount_rupees} on {$date_str}. Please coordinate and confirm receipt. - Attica Gold Company";
            $this->current_template_key = null;
        }

        return $this->send_sms_curl();
    }

    public function last_http_code(): int
    {
        return $this->last_http_code;
    }

    public function last_response(): string
    {
        return $this->last_response;
    }

    public function last_error(): string
    {
        return $this->last_error;
    }
}

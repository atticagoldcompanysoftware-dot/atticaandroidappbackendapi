<?php

return [
    'json_path' => env('SMS_JSON_PATH', base_path('sms.json')),

    'API' => env('SMS_API_KEY', ''),
    'BaseURL' => env('SMS_BASE_URL', 'https://api-alerts.solutionsinfini.com/v3/'),
    'Entity_ID' => env('SMS_ENTITY_ID', ''),
    'Sender' => env('SMS_SENDER', ''),

    'SMS' => [
        'BM_Login' => [
            'Template' => env('SMS_TEMPLATE_BM_LOGIN', ''),
            'Template_ID' => env('SMS_TEMPLATE_ID_BM_LOGIN', ''),
            'Sender' => env('SMS_TEMPLATE_SENDER_BM_LOGIN', ''),
        ],
        'Customer_Verification' => [
            'Template' => env('SMS_TEMPLATE_CUSTOMER_VERIFICATION', ''),
            'Template_ID' => env('SMS_TEMPLATE_ID_CUSTOMER_VERIFICATION', ''),
            'Sender' => env('SMS_TEMPLATE_SENDER_CUSTOMER_VERIFICATION', ''),
        ],
        'Lawyer_Case_Reminder' => [
            'Template' => env('SMS_TEMPLATE_LAWYER_CASE_REMINDER', ''),
            'Template_ID' => env('SMS_TEMPLATE_ID_LAWYER_CASE_REMINDER', ''),
            'Sender' => env('SMS_TEMPLATE_SENDER_LAWYER_CASE_REMINDER', ''),
        ],
        'Branch_Address' => [
            'Template' => env('SMS_TEMPLATE_BRANCH_ADDRESS', ''),
            'Template_ID' => env('SMS_TEMPLATE_ID_BRANCH_ADDRESS', ''),
            'Sender' => env('SMS_TEMPLATE_SENDER_BRANCH_ADDRESS', ''),
        ],
        'TE_Cash_Move' => [
            'Template' => env('SMS_TEMPLATE_TE_CASH_MOVE', ''),
            'Template_ID' => env('SMS_TEMPLATE_ID_TE_CASH_MOVE', ''),
            'Sender' => env('SMS_TEMPLATE_SENDER_TE_CASH_MOVE', ''),
        ],
    ],
];

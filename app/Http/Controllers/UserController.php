<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\SMS;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class UserController extends Controller
{
    public function userLogin(Request $request)
    {
        $request->validate([
            'phone' => ['required', 'digits_between:10,15'],
        ]);

        $phone = (string) $request->input('phone');
        $otp = (string) random_int(100000, 999999);
        $user = User::where('phone', $phone)->first();

        if (!$user) {
            $user = new User();
            $user->phone = $phone;
        }

        $user->otp = $otp;
        $user->save();

        $sent = false;
        try {
            $sent = app(SMS::class)
                ->setMobile($phone)
                ->bm_login('User', $otp);
        } catch (\Throwable $e) {
            Log::error('Login OTP SMS failed', ['error' => $e->getMessage(), 'phone' => $phone]);
        }

        if (!$sent) {
            return response()->json([
                'status' => false,
                'message' => 'OTP generated, but SMS failed. Check SMS config/logs.',
            ], 500);
        }

        return response()->json([
            'status' => true,
            'message' => 'OTP sent successfully',
        ]);
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => ['required', 'digits:6'],
        ]);

        $otp = (string) $request->input('otp');
        $user = User::where('otp', $otp)->first();

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid OTP',
            ], 400);
        }

        $user->otp = null;
        $user->save();
        $token = $user->createToken('mytoken')->plainTextToken;

        return response()->json([
            'token' => $token,
            'user' => $user,
            'message' => 'Login Success',
            'status' => 'success',
        ]);
    }


    public function loggedUser()
    {
        $loggeduser = auth()->user();
        return response([
            'user' => $loggeduser,
            'message' => 'Logged User Data',
            'status' => 'success'
        ], 200);
    }


}

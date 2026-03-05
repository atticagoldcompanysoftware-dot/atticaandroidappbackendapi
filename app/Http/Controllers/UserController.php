<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\SMS;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;


class UserController extends Controller
{


    public function mobileRegister(Request $request)
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





    public function updateMpin(Request $request)
    {
        $request->validate([
            'mpin' => ['required', 'digits:6', 'confirmed'],
        ]);

        $user = auth()->user();
        if (!$user) {
            return response()->json([
                'message' => 'Unauthenticated',
                'status' => false,
            ], 401);
        }

        $user->password = Hash::make((string) $request->input('mpin'));
        $user->save();

        return response()->json([
            'message' => 'MPIN updated successfully',
            'status' => 'success',
        ]);
    }


    public function userNameUpdate(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => 'required'
        ]);

        $user = auth()->user();
        if (!$user) {
            return response()->json([
                'message' => 'Unauthenticated',
                'status' => false,
            ], 401);
        }

        $user->name = (string) $request->input('name');
        $user->email = (string) $request->input('email');
        $user->device_id = (string) $request->input('device_id');
        $user->customerid = 'AGPL' . random_int(100000, 999999);
        $user->save();


        return response()->json([
            'user' => $user,
            'customerid' => $user->customerid,
            'message' => 'Name and Email updated successfully',
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



    public function login(Request $request)
    {
        $request->validate([
            'device_id' => ['required', 'string'],
            'mpin' => ['required', 'digits:6'],
        ]);

        $deviceId = (string) $request->input('device_id');
        $mpin = (string) $request->input('mpin');

        $user = User::where('device_id', $deviceId)->first();

        if ($user && $user->password && Hash::check($mpin, $user->password)) {
            $token = $user->createToken('mytoken')->plainTextToken;

            return response()->json([
                'token' => $token,
                'user' => $user,
                'message' => 'Login Success',
                'status' => 'success',
            ], 200);
        }

        return response()->json([
            'message' => 'The provided credentials are incorrect',
            'status' => 'failed',
        ], 401);
    }
}

<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::post('user/mobile/register', [UserController::class, 'mobileRegister']);
Route::post('user/verify-otp', [UserController::class, 'verifyOtp']);
Route::post('user/login', [UserController::class, 'login']);


Route::middleware('auth:sanctum')->group(function () {
    Route::get('/logged/user', [UserController::class, 'loggedUser']);
    Route::post('/user/mpin/update', [UserController::class, 'updateMpin']);
    Route::post('/user/name/update', [UserController::class, 'userNameUpdate']);
});

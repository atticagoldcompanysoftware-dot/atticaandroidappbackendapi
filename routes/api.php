<?php

use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('user/login', [UserController::class, 'userLogin']);
Route::post('user/verify-otp', [UserController::class, 'verifyOtp']);



Route::middleware('auth:sanctum')->group(function () {
    Route::get('/logged/user', [UserController::class, 'loggedUser']);
});

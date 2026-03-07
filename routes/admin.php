<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\RateController;
use App\Http\Controllers\Admin\UserController;

Route::get('/test', function () {
    return "Abhiram";
});

Route::group(
    ['prefix' => 'admin'],
    function () {
        Route::get('/login', [AdminController::class, 'login'])->name('admin-login');
        Route::post('/login', [AdminController::class, 'loginPost'])->name('admin-login-post');
        Route::group(
            ['middleware' => 'auth:admin'],
            function () {
                Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin-dashboard');
                Route::get('/logout', [Admincontroller::class, 'adminLogout'])->name('admin-logout');
                Route::get('/profile', [Admincontroller::class, 'adminProfile'])->name('admin-profile');
                Route::post('/profile/update', [AdminController::class, 'adminProfileUpdate'])->name('admin-profile-update');
                Route::get('/change/password', [Admincontroller::class, 'changePassword'])->name('admin-change-password');
                Route::post('/update/password', [AdminController::class, 'updatePassword'])->name('admin-password-update');



                Route::get('/user/index', [UserController::class, 'index'])->name('user-list');
                Route::get('/user/delete/{id}', [UserController::class, 'delete'])->name('user-delete');

                Route::get('/rate', [RateController::class, 'index'])->name('rate-index');
                Route::get('/rate/edit/{id}', [RateController::class, 'edit'])->name('rate-edit');
            }
        );
    }
);

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ProductController;
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
                Route::post('/rate/update', [RateController::class, 'update'])->name('rate-update');

                Route::get('/product/create', [ProductController::class, 'create'])->name('product-create');
                Route::post('/product/store', [ProductController::class, 'store'])->name('product-store');
                Route::get('/product/index', [ProductController::class, 'index'])->name('product-index');
                Route::get('/product/edit/{id}', [ProductController::class, 'edit'])->name('product-edit');
                Route::post('/product/update', [ProductController::class, 'update'])->name('product-update');
            }
        );
    }
);

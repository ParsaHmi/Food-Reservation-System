<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\AdminController;


Route::get('/root', function () {
    return view('welcome');
});
Route::get('/', function () {
    return "started";
});

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::get('/password/reset', [ResetPasswordController::class, 'showResetForm'])->name('resetPassword');


Route::middleware('web')->group(function () {
    Route::get('/admin', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    // افزودن کاربر
    Route::post('/admin/users/add', [AdminController::class, 'addUser'])->name('admin.users.add');

    // ورود با آیدی
    Route::post('/admin/users/loginById', [AdminController::class, 'loginById'])->name('admin.users.loginById');

    // مدیریت غذا
    Route::post('/admin/foods/add', [AdminController::class, 'addFood'])->name('admin.foods.add');
    Route::post('/admin/foods/update', [AdminController::class, 'updateFood'])->name('admin.foods.update');
});


// Route::get('/password/reset', function() {
    //     return view('auth.passwords.email');
    // })->name('password.request');
    
    // Route::post('enter', [LoginController::class, 'enter'])->name('enter.submit');



// Route::post('password/email', 'ForgotPasswordController@sendResetLinkEmail');
// Route::get('password/reset/{token}', 'ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'ResetPasswordController@reset');

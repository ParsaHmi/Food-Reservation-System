<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminLoginController;


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
    // Route::prefix('admin')->name('admin.')->group(function () {

    // نمایش فرم ورود ادمین
    Route::get('/admin/login', [AdminLoginController::class, 'showLoginForm'])->name('admin.login');
    // بررسی فرم و ورود
    Route::post('/admin/login', [AdminLoginController::class, 'login'])->name('admin.login.submit');
    // صفحه داشبورد ادمین (بعد از ورود موفق)
    Route::get('/admin', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    // افزودن کاربر
    Route::get('/admin/users/change', [AdminController::class, 'changeUserForm'])->name('admin.users.change');
    
    Route::get('/admin/users', [AdminController::class, 'usersManagement'])->name('admin.users.index');
    
    // ایجاد کاربر جدید
    Route::post('/admin/users', [AdminController::class, 'store'])->name('admin.users.store');
    
    // حذف کاربر
    Route::delete('/admin/users', [AdminController::class, 'destroy'])->name('admin.users.delete');
    
    
    
    // ورود با آیدی
    Route::get('/admin/users/login', [AdminController::class, 'loginByUsernameForm'])->name('admin.users.loginByUsernameForm');
    
    // مدیریت غذا
    Route::get('/admin/foods/edit', [AdminController::class, 'editFoods'])->name('admin.foods.edit');
    
    
    
});

// Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
// Route::get('/password/reset', function() {
    //     return view('auth.passwords.email');
    // })->name('password.request');
    
    // Route::post('enter', [LoginController::class, 'enter'])->name('enter.submit');



// Route::post('password/email', 'ForgotPasswordController@sendResetLinkEmail');
// Route::get('password/reset/{token}', 'ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'ResetPasswordController@reset');

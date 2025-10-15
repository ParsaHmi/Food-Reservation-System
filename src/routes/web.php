<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserPasswordController;
use App\Http\Controllers\AdminLoginController;
use App\Http\Controllers\UserReservationController;



Route::get('/root', function () {
    return view('welcome');
});
Route::get('/', function () {
    return "started";
});

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


Route::get('/password/reset', [ResetPasswordController::class, 'showForm'])->name('resetPassword');
Route::post('/password/reset', [ResetPasswordController::class, 'resetPassword']);


// User Reservation Routes
Route::middleware('auth')->group(function () {
    Route::get('/weekly-reservations', [UserReservationController::class, 'weeklyReservations'])->name('user.weekly-reservations');
    Route::post('/reservations', [UserReservationController::class, 'storeReservation'])->name('user.store-reservation');
    Route::post('/reservations/delete', [UserReservationController::class, 'deleteReservation'])->name('user.delete-reservation');
});




// Admin Routes - بدون middleware اضافی
Route::prefix('admin')->group(function () {
    // Login as User
    Route::get('/login-as-user', [AdminController::class, 'showLoginAsUserForm'])->name('admin.login-as-user.form');
    Route::post('/login-by-id', [AdminController::class, 'loginById'])->name('admin.login-by-id');
    
    // Switch back to admin
    Route::get('/switch-back', [AdminController::class, 'switchBackToAdmin'])->name('admin.switch-back');
});






Route::middleware('auth')->group(function () {
    // ... routes قبلی
    Route::get('/change-password', [UserPasswordController::class, 'showChangePasswordForm'])->name('change-password');
    Route::post('/change-password', [UserPasswordController::class, 'changePassword'])->name('change-password.post');
});



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
        
    Route::get('/admin/foods/create', [AdminController::class, 'foodCreate'])->name('admin.foods.create');
    Route::post('/admin/foods', [AdminController::class, 'foodStore'])->name('admin.foods.store');

    // حذف غذا - DELETE 
    Route::delete('admin/foods/{id}', [AdminController::class, 'foodDestroy'])->name('admin.foods.destroy');   



});

// Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
// Rc', oute::get('/password/reset', function() {
    //     return view('auth.passwords.email');
    // })->name('password.request');
    
    // Route::post('enter', [LoginController::class, 'enter'])->name('enter.submit');



// Route::post('password/email', 'ForgotPasswordController@sendResetLinkEmail');
// Route::get('password/reset/{token}', 'ResetPasswordController@showResetForm')->name('password.reset');
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


Route::middleware('auth')->group(function () {
    Route::get('/weekly-reservations', [UserReservationController::class, 'weeklyReservations'])->name('user.weekly-reservations');
    Route::post('/reservations', [UserReservationController::class, 'storeReservation'])->name('user.store-reservation');
    Route::post('/reservations/delete', [UserReservationController::class, 'deleteReservation'])->name('user.delete-reservation');
});


Route::prefix('admin')->group(function () {
    Route::get('/login-as-user', [AdminController::class, 'showLoginAsUserForm'])->name('admin.login-as-user.form');
    Route::post('/login-by-id', [AdminController::class, 'loginById'])->name('admin.login-by-id');
    Route::get('/switch-back', [AdminController::class, 'switchBackToAdmin'])->name('admin.switch-back');
});



Route::middleware('auth')->group(function () {
    Route::get('/change-password', [UserPasswordController::class, 'showChangePasswordForm'])->name('change-password');
    Route::post('/change-password', [UserPasswordController::class, 'changePassword'])->name('change-password.post');
});


Route::middleware('web')->group(function () {
    Route::get('/admin/login', [AdminLoginController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/admin/login', [AdminLoginController::class, 'login'])->name('admin.login.submit');
    Route::get('/admin', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/admin/users/change', [AdminController::class, 'changeUserForm'])->name('admin.users.change');
    Route::get('/admin/users', [AdminController::class, 'usersManagement'])->name('admin.users.index');
    Route::post('/admin/users', [AdminController::class, 'store'])->name('admin.users.store');
    Route::delete('/admin/users', [AdminController::class, 'destroy'])->name('admin.users.delete');
    Route::get('/admin/users/login', [AdminController::class, 'loginByUsernameForm'])->name('admin.users.loginByUsernameForm');
    Route::get('/admin/foods/edit', [AdminController::class, 'editFoods'])->name('admin.foods.edit');
    Route::get('/admin/foods/create', [AdminController::class, 'foodCreate'])->name('admin.foods.create');
    Route::post('/admin/foods', [AdminController::class, 'foodStore'])->name('admin.foods.store');
    Route::delete('admin/foods/{id}', [AdminController::class, 'foodDestroy'])->name('admin.foods.destroy');   
});
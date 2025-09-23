<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AdminLoginController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.admin-login');
    }

    public function login(Request $request)
    {
        $username = $request->input('username');
        $password = $request->input('password');

        // بررسی اعتبار (مقدار ثابت برای نمونه)
        if ($username === 'admin' && $password === '1234') {
            // احراز هویت موفق
            Session::put('is_admin', true);
            return redirect()->route('admin.dashboard');
        } else {
            // خطای ورود
            return redirect()->back()->with('error', 'Username or Password is incorrect.');
        }
    }
}

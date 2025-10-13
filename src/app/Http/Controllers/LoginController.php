<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        // اعتبارسنجی فرم
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string'
        ]);

        $credentials = $request->only('username', 'password');

        // چک کردن authentication واقعی
        if (Auth::attempt($credentials)) {
            // ورود موفق
            $request->session()->regenerate();
            // return redirect('/dashboard'); // استفاده از URL مستقیم
            return "afarin";
        }

        // ورود ناموفق
        return back()->withErrors([
            'login_error' => 'Invalid username or password.',
        ])->withInput();
    }
}
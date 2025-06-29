<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('username', 'password');

        // if (Auth::attempt($credentials)) {
            $username = $request->input('username');
            $password = $request->input('password');
    
        // }
            return view('result', compact('username', 'password'));
            // return redirect()->intended('/dashboard');

        return back()->withErrors([
            'username' => 'نام کاربری یا رمز عبور نادرست است.',
        ]);
    }
}

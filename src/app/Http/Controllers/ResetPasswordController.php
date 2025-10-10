<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ResetPasswordController extends Controller
{
    /**
     * نمایش فرم ریست پسورد
     */
    public function showForm()
    {
        return view('resetpassword');
    }

    /**
     * پردازش ریست پسورد
     */
    public function resetPassword(Request $request)
    {
        // اعتبارسنجی
        $request->validate([
            'username' => 'required|string',
            'user_id' => 'required|integer'
        ]);

        // پیدا کردن کاربر
        $user = User::where('username', $request->username)
                   ->where('id', $request->user_id)
                   ->first();

        // اگر کاربر پیدا نشد
        if (!$user) {
            return back()->with('error', '❌ User not found with these credentials!');
        }

        // ایجاد پسورد جدید: name + last_name
        $newPassword = $user->name . $user->last_name;
        
        // به‌روزرسانی پسورد
        $user->password = Hash::make($newPassword);
        $user->save();

        // نمایش پیام موفقیت
        return back()->with('success', "✅ Password reset successfully! New password: <strong>{$newPassword}</strong>");
    }
}
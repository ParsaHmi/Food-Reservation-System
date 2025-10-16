<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ResetPasswordController extends Controller
{
    public function showForm()
    {
        return view('resetpassword');
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'user_id' => 'required|integer'
        ]);
        $user = User::where('username', $request->username)
                   ->where('id', $request->user_id)
                   ->first();

        if (!$user) {
            return back()->with('error', '❌ User not found with these credentials!');
        }

        $newPassword = $user->name . $user->last_name;
        $user->password = Hash::make($newPassword);
        $user->save();

        return back()->with('success', "✅ Password reset successfully! New password: <strong>{$newPassword}</strong>");
    }
}
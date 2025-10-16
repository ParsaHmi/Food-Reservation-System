<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function create()
    {
        return view('admin.users.create');
    }


    public function loginByUsernameForm()
    {
        return view('admin.users.login-by-username');
    }

    
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'username' => 'required|string|unique:users',
            'password' => 'required|min:6',
        ]);

        User::create([
            'id' => $request->id,
            'name' => $request->name,
            'last_name' => $request->last_name,
            'username' => $request->username,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->back()->with('success', 'User created successfully!');
    }


    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->back()->with('success', 'User deleted successfully!');
    }


    public function index()
    {
        $users = User::all();
        return view('admin.users.index', compact('users'));
    }
}
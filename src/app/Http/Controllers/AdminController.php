<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Food;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function dashboard()
    {
        if (!session()->get('is_admin')) {
            return redirect()->route('admin.login')->with('error', 'You must be admin!');
        }
    
        return view('admin.dashboard'); // یا متن ساده مثل: return "welcome admin!";
    }
    

    public function addUser(Request $request)
    {
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt('default123');
        $user->save();

        return back()->with('success', 'User created!');
    }

    public function loginById(Request $request)
    {
        $user = User::find($request->id);
        if ($user) {
            Auth::login($user);
            return redirect('/');
        }
        return back()->withErrors(['User not found']);
    }

    public function addFood(Request $request)
    {
        Food::create([
            'name' => $request->name,
            'price' => $request->price
        ]);
        return back()->with('success', 'Food added');
    }

    public function updateFood(Request $request)
    {
        $food = Food::find($request->id);
        if ($food) {
            $food->update([
                'name' => $request->name,
                'price' => $request->price
            ]);
            return back()->with('success', 'Food updated');
        }
        return back()->withErrors(['Food not found']);
    }
}

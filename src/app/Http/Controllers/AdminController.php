<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Food;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


class AdminController extends Controller
{
    public function dashboard()
    {
        if (!session()->get('is_admin')) {
            return redirect()->route('admin.login')->with('error', 'You must be admin!');
        }
    
        return view('admin.dashboard');
    }
    




    public function changeUserForm()
    {
        return view('admin.users'); // این ویو را بعداً می‌سازیم
    }
    


    public function store(Request $request)
    {

        try {
            $id = $request->id;
            $name = $request->name;
            $lastname = $request->lastname;
            $username = $request->username;
            $password = Hash::make($request->password);
            
            DB::table('users')->insert([
                'id' => $id,
                'name' => $name,
                'last_name' => $lastname,
                'username' => $username,
                'password' => $password
            ]);
            
            return back()->with('success', 'User created successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to create user: ' . $e->getMessage());
        }
    }
    

    
    
    public function deleteUser(Request $request)
    {
        $request->validate(['user_id' => 'required|numeric']);
        
        $user = User::findOrFail($request->user_id);
        $user->delete();
        
        return back()->with('success', 'user deleted successfully');
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





<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Food;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Illuminate\Support\Collection;


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
        $users = DB::table('users')->orderBy('id', 'desc')->get();
        return view('admin.users', compact('users'));
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
    
    
    public function destroy(Request $request)
    {
        try {
            $request->validate([
                'user_id' => 'required|integer|exists:users,id',
            ]);

            DB::table('users')->where('id', $request->user_id)->delete();

            return back()->with('success', 'User deleted successfully!');
            
        } catch (\Exception $e) {
            return back()->with('error', 'Error deleting user: ' . $e->getMessage());
        }
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


    public function editFoods(Request $request)
    {
        $selectedDate = $request->get('date', Carbon::now()->format('Y-m-d'));
        $currentDate = Carbon::parse($selectedDate);
        $startOfWeek = $currentDate->copy()->startOfWeek(Carbon::SATURDAY);
        
        $days = ['Saturday', 'Sunday', 'Monday', 'Tuesday', 'Wednesday'];
        $weekDays = [];
        
        foreach ($days as $index => $dayName) {
            $dayDate = $startOfWeek->copy()->addDays($index);
            $weekDays[] = [
                'name' => $dayName,
                'date' => $dayDate->format('Y-m-d'),
                'display_date' => $dayDate->format('d F Y'),
                'foods' => Food::whereDate('date', $dayDate->format('Y-m-d'))->get()
            ];
        }

        $weekDays = new Collection($weekDays);
        $previousWeek = $startOfWeek->copy()->subWeek()->format('Y-m-d');
        $nextWeek = $startOfWeek->copy()->addWeek()->format('Y-m-d');
        $currentWeek = $startOfWeek->format('Y-m-d');
        $weekDaysCollection = collect($weekDays);
        
        $totalFoods = $weekDaysCollection->sum(function($day) {
            return count($day['foods']);
        });
        
        $daysWithFood = $weekDaysCollection->filter(function($day) {
            return count($day['foods']) > 0;
        })->count();
        
        $totalPrice = $weekDaysCollection->sum(function($day) {
            return collect($day['foods'])->sum('price');
        });
        
        return view('admin.foods.index', compact(
            'weekDays', 
            'previousWeek', 
            'nextWeek', 
            'currentWeek',
            'selectedDate',
            'totalFoods',
            'daysWithFood',
            'totalPrice'
        ));
    }


    public function foodCreate()
    {
        return view('admin.foods.create');
    }

    public function foodStore(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:30',
            'date' => 'required|date',
            'description' => 'nullable|string',
            'food_id' => [
                'required',
                'integer',
                function ($attribute, $value, $fail) use ($request) {
                    $exists = Food::where('date', $request->date)
                                ->where('food_id', $value)
                                ->exists();
                    if ($exists) {
                        $fail("Food ID {$value} already exists for date {$request->date}.");
                    }
                },
            ]
        ]);

        Food::create($validated);

        return redirect()->route('admin.foods.edit') // مطمئن شوید به صفحه درست redirect می‌کنید
            ->with('success', 'Food added successfully!');
    }


    public function foodDestroy($id)
    {
        try {
            $food = Food::findOrFail($id);
            $food->delete();

            return redirect()->route('admin.foods.edit')
                ->with('success', 'Food deleted successfully!');
                
        } catch (\Exception $e) {
            return redirect()->route('admin.foods.edit')
                ->with('error', 'Error deleting food: ' . $e->getMessage());
        }
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


    public function loginByUsernameForm(){
        return view('admin.users.login-by-username');
    }

    
    public function showLoginAsUserForm()
    {
        if (!Auth::user()->is_admin) {
            abort(403, 'Access denied. Admin only.');
        }
        return view('admin.login-as-user');
    }
    
    public function loginById(Request $request)
    {
        $request->validate([
            'username' => 'required|string'
        ]);
        $user = User::where('username', $request->username)->first();
        if (!$user) {
            return back()->withErrors([
                'login_error' => 'User not found. Available users are shown below.',
            ])->withInput();
        }
        if ($user->is_admin) {
            return back()->withErrors([
                'login_error' => 'Cannot login as another admin.',
            ])->withInput();
        }
   
        session(['admin_id' => Auth::id()]);
        Auth::login($user);
        $request->session()->regenerate();
            
        return redirect()->route('user.weekly-reservations')
            ->with('success', "You are now logged in as {$user->username}");
    }
    
    public function switchBackToAdmin()
    {
        $adminId = session('admin_id');
        if ($adminId) {
            $admin = User::findOrFail($adminId);
            Auth::login($admin);
            session()->forget('admin_id');
            return redirect()->route('admin.dashboard')
                ->with('success', 'Switched back to admin account.');
        }
        return redirect('/admin');
    }

}

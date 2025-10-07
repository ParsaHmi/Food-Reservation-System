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







    public function loginById(Request $request)
    {
        $user = User::find($request->id);
        if ($user) {
            Auth::login($user);
            return redirect('/');
        }
        return back()->withErrors(['User not found']);
    }


    // public function editFoods(){
    //     return 'salam';
    // }

public function editFoods(Request $request)
{
// دریافت تاریخ از URL یا استفاده از تاریخ جاری
    $selectedDate = $request->get('date', Carbon::now()->format('Y-m-d'));
    $currentDate = Carbon::parse($selectedDate);
    
    // پیدا کردن شنبه هفته جاری
    $startOfWeek = $currentDate->copy()->startOfWeek(Carbon::SATURDAY);
    
    // ایجاد آرایه‌ای از روزهای هفته (شنبه تا چهارشنبه)
    $days = ['شنبه', 'یکشنبه', 'دوشنبه', 'سه‌شنبه', 'چهارشنبه'];
    $weekDays = []; // این آرایه است
    foreach ($days as $index => $dayName) {
        $dayDate = $startOfWeek->copy()->addDays($index);
        $weekDays[] = [
            'name' => $dayName,
            'date' => $dayDate->format('Y-m-d'),
            'display_date' => $dayDate->format('d F Y'),
            'foods' => Food::whereDate('date', $dayDate->format('Y-m-d'))->get()
        ];
    }

    // تبدیل آرایه به Collection
    $weekDays = new Collection($weekDays);
    // تاریخ‌های هفته قبل و بعد
    $previousWeek = $startOfWeek->copy()->subWeek()->format('Y-m-d');
    $nextWeek = $startOfWeek->copy()->addWeek()->format('Y-m-d');
    $currentWeek = $startOfWeek->format('Y-m-d');
    
    $weekDaysCollection = collect($weekDays);
    
    // محاسبات
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


public function createFood(Request $request){
    return "hi";
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





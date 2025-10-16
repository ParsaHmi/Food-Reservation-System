<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class UserReservationController extends Controller
{
    public function weeklyReservations(Request $request)
    {
        $user_id = Auth::id();
        $currentWeek = $request->get('date') ? Carbon::parse($request->get('date')) : Carbon::now();
        $startOfWeek = $currentWeek->copy()->startOfWeek();
        
        $weekDays = [];
        for ($i = 0; $i < 7; $i++) {
            $date = $startOfWeek->copy()->addDays($i);
            $weekDays[] = [
                'name' => $date->format('l'),
                'date' => $date->format('Y-m-d'),
                'display_date' => $date->format('d F Y'),
                'is_today' => $date->isToday(),
            ];
        }

        $previousWeek = $startOfWeek->copy()->subWeek()->format('Y-m-d');
        $nextWeek = $startOfWeek->copy()->addWeek()->format('Y-m-d');

        $allFoods = DB::table('foods')
            ->whereBetween('date', [
                $startOfWeek->format('Y-m-d'),
                $startOfWeek->copy()->endOfWeek()->format('Y-m-d')
            ])
            ->get();

        $userReservations = DB::table('reservation')
            ->join('foods', 'reservation.food_id', '=', 'foods.id')
            ->where('reservation.user_id', $user_id)
            ->whereBetween('reservation.reservation_date', [
                $startOfWeek->format('Y-m-d 00:00:00'),
                $startOfWeek->copy()->endOfWeek()->format('Y-m-d 23:59:59')
            ])
            ->select(
                'reservation.user_id',
                'reservation.food_id',
                'reservation.reservation_date',
                'reservation.eaten',
                'reservation.created_at',
                'reservation.updated_at',
                'foods.name as food_name',
                'foods.description'
            )
            ->get();

        $reservationsByDate = [];
        foreach ($userReservations as $reservation) {
            $date = Carbon::parse($reservation->reservation_date)->format('Y-m-d');
            $reservationsByDate[$date][] = $reservation;
        }

        $foodsByDate = [];
        foreach ($allFoods as $food) {
            $foodDate = Carbon::parse($food->date)->format('Y-m-d');
            $foodsByDate[$foodDate][] = $food;
        }

        foreach ($weekDays as &$day) {
            $day['reservations'] = $reservationsByDate[$day['date']] ?? [];
            $day['available_foods'] = $foodsByDate[$day['date']] ?? [];
            $day['reserved_food_id'] = count($day['reservations']) > 0 ? $day['reservations'][0]->food_id : null;
        }

        return view('weekly-reservations', compact(
            'weekDays', 
            'currentWeek', 
            'previousWeek', 
            'nextWeek'
        ));
    }


    public function storeReservation(Request $request)
    {
        $request->validate([
            'food_id' => 'required|integer|exists:foods,id',
            'reservation_date' => 'required|date',
        ]);

        $user_id = Auth::id();

        $existingReservation = DB::table('reservation')
            ->where('user_id', $user_id)
            ->whereDate('reservation_date', $request->reservation_date)
            ->first();

        if ($existingReservation) {
            DB::table('reservation')
                ->where('user_id', $user_id)
                ->whereDate('reservation_date', $request->reservation_date)
                ->update([
                    'food_id' => $request->food_id,
                    'updated_at' => now(),
                ]);
        } else {
            DB::table('reservation')->insert([
                'user_id' => $user_id,
                'food_id' => $request->food_id,
                'reservation_date' => $request->reservation_date . ' 12:00:00',
                'eaten' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return redirect()->route('user.weekly-reservations')
            ->with('success', 'Food reserved successfully!');
    }
    


    public function deleteReservation(Request $request)
    {
        $request->validate([
            'reservation_date' => 'required|date',
        ]);

        $user_id = Auth::id();

        $deleted = DB::table('reservation')
            ->where('user_id', $user_id)
            ->whereDate('reservation_date', $request->reservation_date)
            ->delete();

        if ($deleted) {
            return back()->with('success', 'Reservation deleted successfully!');
        } else {
            return back()->with('error', 'Reservation not found or already deleted.');
        }
    }

}
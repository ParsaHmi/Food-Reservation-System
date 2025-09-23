<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class FoodController extends Controller
{
    public function edit()
    {
        return view('admin.foods.edit');
    }
}

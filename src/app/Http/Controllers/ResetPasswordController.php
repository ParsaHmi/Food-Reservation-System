<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ResetPasswordController extends Controller
{
    public function showResetForm()
    {
        return "reset password";
    }

    public function reset()
    {
        return "reseting ...";
    }
}

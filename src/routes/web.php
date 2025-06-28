<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('authentication');
});

Route::get('/root', function () {
    return view('welcome');
});

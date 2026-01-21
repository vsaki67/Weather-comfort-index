<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/dashboard');
});

// Auth0 built-in routes
//Route::get('/login', '\Auth0\Laravel\Http\Controller\LoginController@login')->name('login');
//Route::get('/callback', '\Auth0\Laravel\Http\Controller\LoginController@callback')->name('callback');
//Route::get('/logout', '\Auth0\Laravel\Http\Controller\LogoutController@logout')->name('logout');

Route::get('/dashboard', function () {
    return view('dashboard');
});

Route::get('/', function () {
    return redirect('/dashboard');
});

// Auth0 SDK auto-registers: /login, /logout, /callback
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth');

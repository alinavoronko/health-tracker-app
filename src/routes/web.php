<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


/*temporary routes; should be changed after creating resources*/
Route::get('/', function () {
    return view('home');
});
Route::get('/dashboard', function () {
    return view('dashboard');
});

Route::get('/marathon/edit', function () {
    return view('edit_marathon');
});
Route::get('/friends', function () {
    return view('friends');
});

Route::get('/login', function () {
    return view('login');
});
Route::get('/marathon', function () {
    return view('marathon');
});
Route::get('/marathons', function () {
    return view('marathons');
});

Route::get('/marathon/new', function () {
    return view('new_marathon');
});

Route::get('/signup', function () {
    return view('signup');
});

Route::get('/password/recover', function () {
    return view('recover');
});


Route::get('/settings', function () {
    return view('settings');
});

Route::get('/stats', function () {
    return view('stats');
});
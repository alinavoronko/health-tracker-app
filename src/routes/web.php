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
use App\Http\Controllers\MarathonController;
use App\Http\Controllers\FriendController;
use App\Http\Controllers\ActivityController;
Route::get('/dashboard', [ActivityController::class, 'show']);



Route::resource('marathons', MarathonController::class);

Route::resource('friends', FriendController::class)->only([
    'index'
]);



/*temporary routes; should be changed after creating resources*/
Route::get('/', function () {
    return view('login');
});
Route::get('/dashboard', function () {
    return view('dashboard');
});



Route::get('/login', function () {
    return view('login');
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
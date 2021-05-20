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
use App\Http\Controllers\AdminController;

//Route::get('/dashboard', [ActivityController::class, 'index']);



Route::resource('marathons', MarathonController::class);
Route::resource('admin', AdminController::class);
Route::resource('activities', ActivityController::class);

Route::resource('friends', FriendController::class)->only([
    'index'
]);

Route::get('/goal/create', [ ActivityController::class, 'createGoal']);
//store goal ADD ROUTE

Route::post('/block',[ AdminController::class, 'block']);


// Route::get('/', function () {
//     return view('welcome');
// });

 Route::get('/dashboard', [ActivityController::class, 'index'])->middleware(['auth'])->name('dashboard');


// Route::get('/dashboard', function () {
//     //return view('dashboard');
//     return 'Hello friend!';
// })->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';



// Route::get('/oops', function () {
//     return view('oops');
// })->name['oops'];



Route::get('/', function () {
    return redirect()->route('login');
    
});



Route::get('/signup', function () {
    return view('signup');
});

Route::get('/password/recover', function () {
    return view('recover');
});


Route::get('/settings', function () {
    return view('settings');
})->middleware(['auth'])->name('settings');

Route::get('/stats', function () {
    return view('stats');
})->middleware(['auth'])->name('stats');
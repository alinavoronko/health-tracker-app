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
use App\Http\Controllers\SettingController;

use App\Services\FriendService;
use App\Services\MarathonService;
use App\Services\RecordService;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

//Middleware for limiting the number of requests per minute
Route::middleware(['throttle:global'])->group( function () {
Route::get('/', function () {
    return redirect(App::getLocale());
});

Route::prefix('{lang}')->middleware(['setlocale'])->where(['lang' => '[a-z]{2}'])->group(function () {

    Route::resource('marathons', MarathonController::class)->middleware(['auth']);
    Route::resource('admin', AdminController::class)->middleware(['auth']);
    Route::resource('activities', ActivityController::class)->middleware(['auth']);
    Route::resource('settings', SettingController::class)->middleware(['auth']);

    Route::resource('friends', FriendController::class)->only([
        'index', 'store', 'destroy'
    ])->middleware(['auth']);
 
    Route::get('/stats/download', [ActivityController::class, 'downloadStatistics'])->middleware(['auth'])->name('download.stats');
    
    Route::post('/friends/goal', [FriendController::class, 'addFriendGoal'])->name('friend.goal');
    Route::post('/marathons/join', [MarathonController::class, 'join'])->name('marathons.join');
    Route::put('/friends/trainer', [FriendController::class, 'setTrainer'])->name('friend.trainer');

    Route::get('/goal/create', [ActivityController::class, 'createGoal'])->middleware(['auth'])->name('goal.create');
    Route::post('/goal/store', [ActivityController::class, 'storeGoal'])->middleware(['auth'])->name('goal.store');
    Route::post('/settings/pass', [SettingController::class, 'changePass'])->middleware(['auth'])->name('pass.change');
    // //TEST
    // Route::post('/settings/test', [SettingController::class, 'test'])->middleware(['auth'])->name('settings.test');
    Route::post('/record/create', [ActivityController::class, 'addRecord'])->middleware(['auth'])->name('record.create');
    Route::post('/friends/request', [FriendController::class, 'acceptReject'])->middleware(['auth'])->name('friends.request');


    Route::post('/block', [AdminController::class, 'block'])->middleware(['auth']);


    // Route::get('/', function () {
    //     return view('welcome');
    // });

    Route::get('/dashboard', [ActivityController::class, 'index'])->middleware(['auth'])->name('dashboard');

    // Route::get('/goals/create', function () {
    //     return (view('setGoal'));
    // })->middleware(['auth'])->name('goals.create');


    require __DIR__ . '/auth.php';





    Route::get('/', function () {
        if (Auth::check()) return redirect()->route('dashboard', ['lang' => App::getLocale()]);
        return redirect()->route('login', ['lang' => App::getLocale()]);
    });

    // Route::get('/signup', function () {
    //     $countries=Country::all();
    //     return view('signup', compact('countries'));
    // });

    // Route::get('/password/recover', function () {
    //     return view('recover');
    // });


    // Route::get('/settings', function () {
    //     return view('settings');
    // })->middleware(['auth'])->name('settings');

    Route::get('/stats', [ActivityController::class, 'stats'])->middleware(['auth'])->name('stats');
});

Route::post('/google/update', [SettingController::class, 'updateGoogleData'])->middleware(['auth'])->name('google.update');
Route::get('/googleauth', [SettingController::class, 'googleAuth'])->middleware(['auth']);
Route::get('/country/{country}', [SettingController::class, 'getStates']);
Route::get('/state/{state}', [SettingController::class, 'getCities']);
});

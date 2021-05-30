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

//Route::get('/dashboard', [ActivityController::class, 'index']);

Route::get('/', function () {
    return redirect(App::getLocale());
});

Route::prefix('{lang}')->middleware(['setlocale'])->where(['lang' => '[a-z]{2}'])->group(function () {

    Route::resource('marathons', MarathonController::class);
    Route::resource('admin', AdminController::class);
    Route::resource('activities', ActivityController::class);
    Route::resource('settings', SettingController::class);

    Route::resource('friends', FriendController::class)->only([
        'index', 'store', 'destroy'
    ]);

    Route::post('/friends/goal', [FriendController::class, 'addFriendGoal'])->name('friend.goal');
    Route::put('/friends/trainer', [FriendController::class, 'setTrainer'])->name('friend.trainer');

    Route::get('/goal/create', [ActivityController::class, 'createGoal'])->middleware(['auth'])->name('goal.create');
    Route::post('/goal/store', [ActivityController::class, 'storeGoal'])->middleware(['auth'])->name('goal.store');
    Route::post('/settings/usr', [SettingController::class, 'userStore'])->middleware(['auth'])->name('user.store');
    Route::post('/record/create', [ActivityController::class, 'addRecord'])->middleware(['auth'])->name('record.create');
    Route::post('/friends/request', [FriendController::class, 'acceptReject'])->middleware(['auth'])->name('friends.request');
    

    Route::post('/block', [AdminController::class, 'block']);


    // Route::get('/', function () {
    //     return view('welcome');
    // });

    Route::get('/dashboard', [ActivityController::class, 'index'])->middleware(['auth'])->name('dashboard');

    // Route::get('/goals/create', function () {
    //     return (view('setGoal'));
    // })->middleware(['auth'])->name('goals.create');


    require __DIR__ . '/auth.php';



    // Route::get('/oops', function () {
    //     return view('oops');
    // })->name['oops'];



    Route::get('/', function () {
        if (Auth::check()) return redirect()->route('dashboard', ['lang' => App::getLocale()]);
        return redirect()->route('login', ['lang' => App::getLocale()]);
    });

    Route::get('/signup', function () {
        return view('signup');
    });

    Route::get('/password/recover', function () {
        return view('recover');
    });


    // Route::get('/settings', function () {
    //     return view('settings');
    // })->middleware(['auth'])->name('settings');

    Route::get('/stats', [ActivityController::class, 'stats'])->middleware(['auth'])->name('stats');
});

Route::get('/googleauth', [SettingController::class, 'googleAuth'])->middleware(['auth']);

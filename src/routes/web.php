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
use App\Services\FriendService;
use App\Services\MarathonService;
use App\Services\RecordService;
use Illuminate\Support\Facades\Http;

//Route::get('/dashboard', [ActivityController::class, 'index']);



Route::resource('marathons', MarathonController::class);
Route::resource('admin', AdminController::class);
Route::resource('activities', ActivityController::class);

Route::resource('friends', FriendController::class)->only([
    'index', 'store'
]);

Route::get('/goal/create', [ ActivityController::class, 'createGoal']);
//store goal ADD ROUTE

Route::post('/block',[ AdminController::class, 'block']);


// Route::get('/', function () {
//     return view('welcome');
// });

 Route::get('/dashboard', [ActivityController::class, 'index'])->middleware(['auth'])->name('dashboard');

 Route::get('/goals/create', function (){return(view('setGoal'));})->middleware(['auth'])->name('goals.create');
// Route::get('/dashboard', fun ction () {
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


Route::get('/test/friends', function (FriendService $friendService) {
    // Get user with id 0 friends
    // $friends = Http::get('http://friends:8080/api/user/3/friend/request?requestState=RECEIVED');

    // dd($friends->json());

    //$addFriend = $friendService->addFriend(2, 4);

    // $friendService->acceptFriendRequest(4, 2);

    // $friendRequests = $friendService->getFriendRequests(4);
    $friends = $friendService->getFriends(2);

    dd($friends[0]->createdAt);

    // dd([$friendRequests, $friends]);

    return 'hi';
});

Route::get('/test/records', function (RecordService $recordService) {
    // $records = Http::get('http://records:8080/api/goal-list');
    // dd($records->json());

    $goal = $recordService->addUserGoal(5, 1, 1000.0);

    dd($goal);


    return 'hi';
});

Route::get('/test/marathon', function (MarathonService $marathonService) {
    $marathons = $marathonService->getMarathons();

    dd($marathons);

    return 'hi';
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

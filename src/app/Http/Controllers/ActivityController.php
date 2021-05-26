<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\FriendService;
use App\Services\RecordService;
use DateInterval;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ActivityController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(FriendService $friend, RecordService $rec)
    {
        $userId = Auth::user()->id;

        $reqs=$friend->getFriendRequests($userId);
        $ids=$reqs->map(function ($rec) {
            //friendID in camelCase as in the service
            return($rec->friendId);
        })->all();
        //all transforms laravel collection into an array
        $users=User::whereIn('id', $ids)->get();


        $frs = $friend->getFriends($userId);
        $friendIds=$frs->map(function ($rec) {
            return($rec->friendId);
        })->all();
        $friends=User::whereIn('id', $friendIds)->get();

        // $gls=$rec->getGoalList();

        $to = new DateTime();
        $from = new DateTime();
        $month = new DateInterval('P1M');

        $from->sub($month);

        $sleep = $rec->getTimeline($userId, $from, $to)->toJson();
        $steps = $rec->getTimeline($userId, $from, $to, 'STEPS')->toJson();

        $dates = [
            'to' => $to->format('Y-m-d\TH:i:s.u') . 'Z',
            'from' => $from->format('Y-m-d\TH:i:s.u') . 'Z',
        ];

        //SQL: select <> from table where column_name in <>
        return view('dashboard', compact('users', 'friends', 'sleep', 'steps', 'dates'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('createRecord');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($_lang, $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($_lang, $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $_lang, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($_lang, $id)
    {
        //
    }

    public function createGoal(){

    }

    public function storeGoal(){

    }

}

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
    public function __construct()
    {
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

        $reqs = $friend->getFriendRequests($userId);
        $ids = $reqs->map(function ($rec) {
            //friendID in camelCase as in the service
            return ($rec->friendId);
        })->all();
        //all transforms laravel collection into an array
        $users = User::whereIn('id', $ids)->get();


        $frs = $friend->getFriends($userId);
        $friendIds = $frs->map(function ($rec) {
            return ($rec->friendId);
        })->all();
        $friends = User::whereIn('id', $friendIds)->get();

        // $gls=$rec->getGoalList();

        $statistics = $this->getStatistics($rec, $userId);

        //SQL: select <> from table where column_name in <>
        return view('dashboard', array_merge(compact('users', 'friends'), $statistics));
    }

    public function stats(RecordService $rec, FriendService $friendService)
    {
        $userId = Auth::user()->id;

        $statistics = [
            'day' => $this->getStatistics($rec, $userId, 'day'),
            'week' => $this->getStatistics($rec, $userId, 'week'),
            'month' => $this->getStatistics($rec, $userId, 'month'),
        ];

        $goals = $friendService->getTrainers($userId)
            ->map(function ($trainer) {
                return $trainer->friendId;
            })
            ->map(function ($trainerId) use ($rec, $userId) {
                $g = $rec->getUserGoals($userId, 'STEPS', $trainerId);

                if ($g->count() === 0) return null;

                return $g[0];
            });

        $stepsGoal = $rec->getUserGoals($userId, 'STEPS');

        $goals = $goals->merge($stepsGoal)
            ->filter(function ($value, $key) {
                return !!$value;
            });

        $interval = $this->getInterval('day');

        $from = $interval['from'];
        $to = $interval['to'];

        $todayTotal = $rec->getTimeline($userId, $from, $to, 'STEPS')->reduce(function ($acc, $steps, $_key) {
            return $acc + $steps;
        }, 0);

        return view('stats', compact('statistics', 'stepsGoal', 'goals', 'todayTotal'));
    }

    private function getInterval($period) {
        $unit = '1M';

        if ($period === 'day') $unit = '1D';
        if ($period === 'week') $unit = '7D';

        $to = new DateTime();
        $from = new DateTime();
        $interval = new DateInterval('P' . $unit);

        $from->sub($interval);

        return compact('to', 'from');
    }

    private function getStatistics(RecordService $rec, $userId, $period = 'month')
    {
        $interval = $this->getInterval($period);

        $from = $interval['from'];
        $to = $interval['to'];

        $dates = [
            'to' => $to->format('Y-m-d\TH:i:s.u') . 'Z',
            'from' => $from->format('Y-m-d\TH:i:s.u') . 'Z',
        ];

        $sleep = $rec->getTimeline($userId, $from, $to)->toJson();
        $steps = $rec->getTimeline($userId, $from, $to, 'STEPS')->toJson();
        $weight = $rec->getTimeline($userId, $from, $to, 'WEIGHT')->toJson();

        return compact('dates', 'sleep', 'steps', 'weight');
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

    public function createGoal()
    {
    }

    public function storeGoal()
    {
    }
}

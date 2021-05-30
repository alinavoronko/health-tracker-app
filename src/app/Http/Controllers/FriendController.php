<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\FriendService;
use App\Services\RecordService;
use DateInterval;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FriendController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(FriendService $friendService, RecordService $recordService, Request $request)
    {
        $period = $request->period ?? 'DAY';
        $activity = $request->activity ?? 'STEPS';

        $userId = Auth::id();

        $unit = '1D';

        if ($period === 'WEEK') $unit = '7W';
        if ($period === 'MONTH') $unit = '1M';

        $to = new DateTime();
        $from = new DateTime();

        $interval = new DateInterval('P' . $unit);
        $from->sub($interval);

        $trainees = $friendService->getTrainees($userId)->map(function ($trainee) {
            return $trainee->userId;
        })->toArray();

        $friends = $friendService->getFriends($userId)->map(function ($friend) use ($recordService, $from, $to, $activity, $trainees) {
            $friend->friend = User::find($friend->friendId);
            $timeline = $recordService->getTimeline($friend->friendId, $from, $to, $activity);

            $accumulated = $timeline->reduce(function ($acc, $record, $_key) {
                return $acc + $record;
            }, 0);

            if ($activity != 'STEPS') {
                $count = $timeline->count() !== 0 ? $timeline->count() : 1;
                $accumulated /= $count;
            }

            $friend->value = $accumulated;

            $friend->isTrainee = in_array($friend->friendId, $trainees);

            return $friend;
        });

        return view('friends', compact('friends', 'period', 'activity'));
    }

    public function addFriendGoal(Request $request, RecordService $recordService) {
        $userId = Auth::id();

        $traineeId = $request->traineeId;
        $goal = $request->goal;

        $recordService->addUserGoal($traineeId, $goal, 'STEPS', 'DAY', $userId);

        return redirect()->back();
    }

    public function setTrainer(Request $request, FriendService $friends)
    {
        $userId = Auth::id();

        // dd($userId, $request->friendId, $request->action === 'remove');

        $friends->setTrainer($userId, $request->friendId, $request->action === 'remove');

        return redirect()->back();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, FriendService $friend)
    {
        $isOK=json_decode($request->getContent(), true);

        $tba=User::where('email', '=', $isOK['email'])->firstOrFail();
        $friend->addFriend(Auth::user()->id, $tba->id);
        return response('ok');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

  

    public function acceptReject(FriendService $fr, Request $request ){
        $userId=Auth::id();
        $friendId=$request->friendId;
        if($request->type=='accept'){ $fr->acceptFriendRequest($userId, $friendId);}
        elseif ($request->type=='reject'){$fr->declineFriendRequest($userId, $friendId);}
        return redirect()->back();
    }
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
    public function destroy(FriendService $friendService, $_lang, $id)
    {
        $userId = Auth::id();

        $friendService->removeFriend($userId, $id);

        return redirect()->back();
    }
}

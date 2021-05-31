<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\MarathonService;
use App\Services\RecordService;
use DateInterval;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MarathonController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(MarathonService $mar)
    {
     
        $usrMar=$mar->getUsersMarathons(Auth::user()->id);
        // dd($usrMar, Auth::user()->id);

        foreach ($usrMar as $mar) {
            $author = User::findOrFail($mar->creatorId);
            $mar->authName = $author->name;
            $mar->authSurname=$author->surname;
            $date = new DateTime($mar->startDate);
            $mar->startDate=$date->format('d-m-Y');
            $date->add(new DateInterval('P7D'));

            $mar->endDate=$date->format('d-m-Y');
    }


        return view('marathons',compact('usrMar'));

    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       return view('new_marathon');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
 


    public function store(Request $request, MarathonService $mar)
    {
        $request->validate([
            'startDate' => 'required|after:yesterday',
            'goal' => 'required|numeric|min:500|max:1000000'
        ]);
        $userId = Auth::user()->id;
        $date = new DateTime($request->startDate);
        $r=$mar->createMarathon($userId, $request->goal, $date);
        // dd($r);
        $mar->joinMarathon($r->id, $userId);
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($_lang, $id, MarathonService $mar, RecordService $rec)
    {
        $marathon= $mar->getMarathon($id);
        $from=new DateTime( $marathon->startDate);
        $to=new DateTime( $marathon->startDate);
        $to=$to->add(new DateInterval('P7D'));
       
        $user=Auth::user()->id;
        // $marathon->participantInfo=[];
       $participantInfo=[];
        foreach($marathon->participants as $participant){
            $part = User::findOrFail($participant);
            $userResults=$rec->getUserRecordsByType($part->id, 'STEPS', $from, $to);
            $sum=$userResults->reduce(function ($carry, $item) {
                return $carry + $item->value;
            }, 0);
            $part->stepCount=$sum;
            
           $participantInfo[]=$part;
        }
        //usort works with integers, not boolean values
        usort($participantInfo, function($a, $b) {return $b->stepCount - $a->stepCount;});
        return view('marathon', compact('marathon', 'user', 'participantInfo'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($_lang, $id)
    {
       return view('edit_marathon');
    }

    public function join(Request $request, MarathonService $mar){
        $mar->joinMarathon($request->marathon, $request->user);
        return redirect()->back();
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
}

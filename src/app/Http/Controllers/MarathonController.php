<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\MarathonService;
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
    public function show($_lang, $id, MarathonService $mar)
    {
        $marathon= $mar->getMarathon($id);
        dd($marathon);
        return view('marathon', compact('marathon'));
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

<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\GoogleFitService;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use function PHPUnit\Framework\isNull;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(GoogleFitService $gf)
    {
        $user = Auth::user();

        // dd($gf->getSleep($user, DateTime::createFromFormat('U', '1619470800'), DateTime::createFromFormat('U', '1621285200')));

        $authUrl = $gf->getAuthUrl();

        return view('settings', compact('user', 'authUrl'));
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
    public function store(Request $request)
    {
        $usr = User::find(Auth::user()->id);


        $request->validate([
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'dob' => 'date_format:Y-m-d|before:today|required',
            "height"=> 'required|numeric|min:50|max:250',
            // "city"=>??
            //Add city constraint?
        ]);
        $usr->name=$request->name;
        $usr->surname=$request->surname;
        $usr->dob=$request->dob;
        $usr->height=$request->height;
        $usr->city_id=$request->city;
        $usr->save();
        return redirect()->back();

    }

// public function test(){

//     dd('Hello!');
// }
    public function changePass(Request $request)
    {
     
      

//oldPassword, password, confirmPassword
$request->validate([
    'oldPassword' => 'required',
    'password' => 'required|string|min:8',
    'confirmPassword' => 'required|same:password',
]);

$user = Auth::user();

// if (!Hash::check($request->oldPassword, $user->password)){
   
//     return redirect(route('settings.index', ['lang' => App::getLocale()]))->withErrors('Entered password did not match the old one!');
// }
// $user->fill([
//     'password' => Hash::make($request->password)
// ])->save();


if (! Auth::guard('web')->validate([
    'email' => $request->user()->email,
    'password' => $request->oldPassword,
])) {
    //print error message
    return redirect(route('settings.index', ['lang' => App::getLocale()]))->withErrors('Entered password did not match the old one!');
}
$user->fill([
    'password' => Hash::make($request->password)
])->save();


        return redirect(route('settings.index', ['lang' => App::getLocale()]));

    }

    public function googleAuth(Request $request)
    {
        $user = Auth::user();

        $user->googleAuth = $request->code;
        $user->save();

        return redirect(route('settings.index', [ 'lang' => App::getLocale() ]));
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
}

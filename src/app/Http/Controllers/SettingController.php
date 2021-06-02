<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\State;
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
        $countries=Country::all(); //tbp
        // dd($gf->getSleep($user, DateTime::createFromFormat('U', '1619470800'), DateTime::createFromFormat('U', '1621285200')));
        $userCity=$user->city;//tbp
        $userState=$userCity->state;//tbp
        $userCountry=$userState->country; //tbp -selected
        $states=$userCountry->states;//tbp
        $cities=$userState->cities;//tbp
        $authUrl = $gf->getAuthUrl();

        return view('settings', compact('user', 'authUrl', 'countries', 'states', 'cities', 'userCity', 'userState', 'userCountry'));
    }

    public function getStates($country){
        $coun=Country::findOrFail($country);
        $states=$coun->states;
        return $states->toJson();
    }

    public function getCities($state){
        $stat=State::findOrFail($state);
        $cities=$stat->cities;
        return $cities->toJson();
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
            'name' => 'required|string|max:60',
            'surname' => 'required|string|max:90',
            'dob' => 'required|before:-13years|date_format:Y-m-d',
            'height'=> 'required|numeric|min:50|max:250',
            'city'=> 'required|numeric'
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
  
    return redirect(route('settings.index', ['lang' => App::getLocale()]))->withErrors(['notMatchingErr' =>'Entered password did not match the old one!']);
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

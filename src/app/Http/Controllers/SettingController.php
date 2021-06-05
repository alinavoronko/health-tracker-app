<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\State;
use App\Models\User;
use App\Services\GoogleFitService;
use App\Services\RecordService;
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
    public function index(GoogleFitService $gf, RecordService $recordService)
    {
        $user = Auth::user();
        $countries=Country::all(); //tbp
        $userCity=$user->city;//tbp
        $userState=$userCity->state;//tbp
        $userCountry=$userState->country; //tbp -selected
        $states=$userCountry->states;//tbp
        $cities=$userState->cities;//tbp
        $authUrl = $gf->getAuthUrl();

        return view('settings', compact('user', 'authUrl', 'countries', 'states', 'cities', 'userCity', 'userState', 'userCountry'));
    }

    public function updateGoogleData(RecordService $recordService, GoogleFitService $gf) {
        $user = Auth::user();

        if (!$user->googleAuth) {
            return response('User is not google authorized', 403);
        }

        $userRecords = $recordService->getUserRecords($user->id);

        $lastGoogleSleep = null;
        $lastGoogleStep = null;

        foreach($userRecords as $record) {
            if ($record->dataSource === 'google') {
                if ($record->type === 'SLEEP') {
                    if (!$lastGoogleSleep) {
                        $lastGoogleSleep = $record;
                        continue;
                    }

                    if (new DateTime($lastGoogleSleep->untilTime) < new DateTime($record->untilTime)) {
                        $lastGoogleSleep = $record;
                        continue;
                    }
                }

                if ($record->type === 'STEPS') {
                    if (!$lastGoogleStep) {
                        $lastGoogleStep = $record;
                        continue;
                    }

                    if (new DateTime($lastGoogleStep->fromTime) < new DateTime($record->fromTime)) {
                        $lastGoogleStep = $record;
                        continue;
                    }
                }
            }
        }

        $latestStepDate = new DateTime('2021-04-01T00:00:00.000000Z');
        $latestSleepDate = new DateTime('2021-01-01T00:00:00.000000Z');

        if ($lastGoogleSleep) {
            $latestSleepDate = new DateTime($lastGoogleSleep->untilTime);
        }

        if ($lastGoogleStep) {
            $latestStepDate = new DateTime($lastGoogleStep->untilTime);
        }


        $this->processGoogleSteps($latestStepDate, $gf, $recordService);
        $this->processGoogleSleep($latestSleepDate, $gf, $recordService);

        return redirect()->back();
    }

    private function processGoogleSteps($latestStepDate, $gf, $recordService) {
        $user = Auth::user();

        $stepData = $gf->getSteps($user, $latestStepDate, new DateTime());

        $stepData = array_map(function ($data) {
            $from = DateTime::createFromFormat('U', $data['startTimeMillis'] / 1000);
            $to = DateTime::createFromFormat('U', $data['endTimeMillis'] / 1000);

            $data['from'] = $from;
            $data['to'] = $to;

            $val = array_reduce($data['dataset'], function ($setCarry, $set) {
                $pointSum = array_reduce($set['point'], function ($pointCarry, $point) {
                    $value = array_reduce($point['value'], function ($valueCarry, $setValue) {
                        $valueCarry += $setValue['intVal'] ?? 0;
                        return $valueCarry;
                    }, 0);

                    $pointCarry += $value;

                    return $pointCarry;
                }, 0);

                $setCarry += $pointSum;

                return $setCarry;
            }, 0);

            $data['value'] = $val;

            return $data;
        }, $stepData);

        foreach ($stepData as $data) {
            $recordService->addUserRecord($user->id, $data['value'], $data['from']->format('Y-m-d\TH:i:s.u\Z'), $data['to']->format('Y-m-d\TH:i:s.u\Z'), 'STEPS', 'google');
        }
    }

    private function processGoogleSleep($latestSleepDate, GoogleFitService $gf, RecordService $recordService) {
        $user = Auth::user();

        $sleepData = $gf->getSleep($user, $latestSleepDate, new DateTime());

        $sleepData = array_map(function ($data) {


            $from = DateTime::createFromFormat('U', $data['startTimeMillis'] / 1000);
            $to = DateTime::createFromFormat('U', $data['endTimeMillis'] / 1000);

            $diff = $to->getTimestamp() - $from->getTimestamp();
            $hours = $diff / (60 * 60);

            $data['from'] = $from;
            $data['to'] = $to;
            $data['hours'] = $hours;

            return $data;
        }, $sleepData);

        foreach ($sleepData as $sleep) {
            $recordService->addUserRecord($user->id, $sleep['hours'], $sleep['from']->format('Y-m-d\TH:i:s.u\Z'), $sleep['to']->format('Y-m-d\TH:i:s.u\Z'), 'SLEEP', 'google');
        }
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

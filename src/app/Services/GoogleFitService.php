<?php

namespace App\Services;

use DateTime;
use DateTimeZone;
use Illuminate\Support\Facades\Http;

class GoogleFitService
{

    private $url;

    public function __construct($url = 'http://googlefit:3000/')
    {
        $this->url = $url;
    }

    public function getAuthUrl()
    {
        $data = Http::get($this->url . 'google-url');

        return $data->json()['authUrl'];
    }

    public function getSteps($user, DateTime $from, DateTime $to)
    {

        $tz = new DateTimeZone("UTC");
        $to->setTimezone($tz);
        $from->setTimezone($tz);

        $toStamp = strtotime($to->format('Y-m-d H:i:sP')) . '000';
        $fromStamp = strtotime($from->format('Y-m-d H:i:sP')) . '000';

        $userId = $user->id;
        $authCode = $user->googleAuth;

        // dd($authCode);

        $data = Http::get($this->url . 'steps', [
            'user' => $userId,
            'authCode' => $authCode,
            'from' => $fromStamp,
            'to' => $toStamp,
        ]);

        return $data->json();
    }

    public function getSleep($user, DateTime $from, DateTime $to)
    {

        $tz = new DateTimeZone("UTC");
        $to->setTimezone($tz);
        $from->setTimezone($tz);

        $toStamp = strtotime($to->format('Y-m-d H:i:sP')) . '000';
        $fromStamp = strtotime($from->format('Y-m-d H:i:sP')) . '000';

        $userId = $user->id;
        $authCode = $user->googleAuth;

        $data = Http::get($this->url . 'sleep', [
            'user' => $userId,
            'authCode' => $authCode,
            'from' => $fromStamp,
            'to' => $toStamp,
        ]);

        return $data->json();
    }
}

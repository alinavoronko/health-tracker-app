<?php

namespace App\Services;

use App\Models\Marathon;
use DateTime;
use DateTimeZone;
use Illuminate\Support\Facades\Http;

class MarathonService
{

    private $url;

    public function __construct($url = 'http://marathon/api/')
    {
        $this->url = $url;
    }

    public function getMarathons()
    {
        $marathons = Http::get($this->getMarathonUrl());

        return $this->toModel($marathons->collect(), Marathon::class);
    }

    public function getMarathon($marathonId)
    {
        $marathon = Http::get($this->getMarathonUrl() . '/' . $marathonId);

        return $this->mapper($marathon->json(), Marathon::class);
    }

    public function createMarathon($creatorId, $goal, DateTime $startDate = null)
    {
        if ($startDate == null) {
            $utc = new DateTimeZone("UTC");
            $date = new DateTime();
            $startDate = $date;
        }

        $startDate->setTimezone($utc);
        $startDate = $startDate->format('Y-m-d\TH:i:s.u') . 'Z';

        $marathon = Http::post($this->getMarathonUrl(), compact('startDate', 'goal', 'creatorId'));

        return $this->mapper($marathon->json(), Marathon::class);
    }

    public function joinMarathon($marathonId, $participantId)
    {
        $url = $this->getMarathonUrl() . '/' . $marathonId . '/Join' . '?participantId=' . $participantId;

        $response = Http::post($url);

        return $response->successful();
    }

    public function getUsersMarathons($userId)
    {
        $marathons = Http::get($this->getMarathonUrl() . '/Friend/' . $userId);

        return $this->toModel($marathons->collect(), Marathon::class);
    }

    private function getMarathonUrl()
    {
        return $this->url . 'Marathon';
    }

    private function modelMapper($model)
    {
        return function ($entry) use ($model) {
            return $this->mapper($model, $entry);
        };
    }

    private function mapper($model, $entry)
    {
        $friendRequest = new $model();

        foreach ($entry as $key => $value) {
            if ($key == 'participants') {
                $friendRequest->$key = array_map(function ($entry) {
                    return $entry['participantId'];
                }, $value);
            } else {
                $friendRequest->$key = $value;
            }
        }

        return $friendRequest;
    }

    private function toModel($collection, $model)
    {
        return $collection->map($this->modelMapper($model));
    }
}

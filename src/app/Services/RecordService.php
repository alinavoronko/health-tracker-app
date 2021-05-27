<?php

namespace App\Services;

use App\Models\Goal;
use App\Models\Record;
use DateTime;
use DateTimeZone;
use Illuminate\Support\Facades\Http;

class RecordService
{

    private $url;
    private MapperService $mapperService;

    public function __construct(MapperService $mapperService, $url = 'http://records:8080/api/')
    {
        $this->url = $url;
        $this->mapperService = $mapperService;
    }

    public function getGoalList()
    {
        $goals = Http::get($this->url . 'goal-list');

        return $goals->json();
    }

    public function getRecordList()
    {
        $records = Http::get($this->url . 'record-list');

        return $records->json();
    }

    public function addUserGoal($userId, $value, $type = 'STEPS', $timePeriod = 'DAY', $creatorId = -1)
    {
        if ($creatorId == -1) $creatorId = $userId;

        $createdGoal = Http::post($this->getGoalUrl($userId), compact('userId', 'creatorId', 'timePeriod', 'type', 'value'));

        return $this->mapperService->mapper(Goal::class, $createdGoal->json());
    }

    public function getUserGoals($userId, $goalType, $creatorId = -1)
    {
        if ($creatorId == -1) $creatorId = $userId;

        $requestUrl = $this->getGoalUrl($userId) . '/' . $goalType;
        $userGoals = Http::get($requestUrl, [
            'creatorId' => $creatorId
        ]);

        return $this->mapperService->toModel($userGoals->collect(), Goal::class);
    }

    public function getUserRecords($userId, $from = null, $to = null)
    {
        $params = [];

        if ($from && $to) {
            $params = [
                'from' => $from,
                'to' => $to,
            ];
        }

        $records = Http::get($this->getRecordUrl($userId), $params);

        return $this->mapperService->toModel($records->collect(), Record::class);
    }

    public function getUserRecordsByType($userId, $recordType = 'SLEEP', $from = null, $to = null)
    {
        $params = [];

        if ($from && $to) {
            $params = [
                'from' => $from,
                'to' => $to,
            ];
        }

        $records = Http::get($this->getRecordUrl($userId) . '/' . $recordType, $params);

        return $this->mapperService->toModel($records->collect(), Record::class);
    }

    public function addUserRecord($userId, $value, $fromTime, $untilTime, $type = 'SLEEP')
    {
        $dataSource = 'custom';

        $record = Http::post($this->getRecordUrl($userId), compact($value, $fromTime, $untilTime, $type, $dataSource));

        return $this->mapperService->mapper($record->json(), Record::class);
    }

    public function getTimeline($userId, DateTime $fromDate, DateTime $toDate, $recordType = 'SLEEP')
    {
        $url = $this->constructUrl($userId) . '/timeline/' . $recordType;

        $utc = new DateTimeZone("UTC");

        $toDate->setTimezone($utc);
        $fromDate->setTimezone($utc);

        $toDate = $toDate->format('Y-m-d\TH:i:s.u') . 'Z';
        $fromDate = $fromDate->format('Y-m-d\TH:i:s.u') . 'Z';

        $records = Http::get($url, compact('fromDate', 'toDate'));

        return $records->collect();
    }

    private function getGoalUrl($userId)
    {
        return $this->constructUrl($userId) . '/goal';
    }

    private function getRecordUrl($userId)
    {
        return $this->constructUrl($userId) . '/record';
    }

    private function constructUrl($userId)
    {
        return $this->url . 'user/' . $userId;
    }
}

<?php

namespace App\Services;

use App\Models\Friend;
use App\Models\FriendRequest;
use Illuminate\Support\Facades\Http;

class FriendService
{

    private $url;
    private MapperService $mapperService;

    public function __construct(MapperService $mapperService, $url = 'http://friends:8080/api/')
    {
        $this->url = $url;
        $this->mapperService = $mapperService;
    }

    public function getFriends($userId)
    {
        $response = Http::get($this->constructUrl($userId));

        return $this->mapperService->toModel($response->collect(), Friend::class);
    }

    public function addFriend($userId, $friendId)
    {
        $response = Http::post($this->constructUrl($userId) . '?friendId=' . $friendId);

        return $this->mapperService->mapper(Friend::class, $response->json());
    }

    public function removeFriend($userId, $friendId)
    {
        $response = Http::delete($this->constructUrl($userId) . '?friendId=' . $friendId);

        return $response->successful();
    }

    public function getFriendRequests($userId, $state = 'RECEIVED')
    {
        $requestUrl = $this->constructRequestUrl($userId);

        $response = Http::get($requestUrl, ['requestState' => $state]);

        return $this->mapperService->toModel($response->collect(), FriendRequest::class);
    }

    public function acceptFriendRequest($userId, $friendId)
    {
        return $this->updateFriendRequest($userId, $friendId, 'ACCEPTED');
    }

    public function declineFriendRequest($userId, $friendId)
    {
        return $this->updateFriendRequest($userId, $friendId, 'DECLINED');
    }

    public function getTrainer($userId)
    {
        $url = $this->constructTrainerUrl($userId);

        $trainer = Http::get($url);

        return $this->mapperService->toModel($trainer->collect(), Friend::class);
    }

    public function getTrainees($userId)
    {
        $url = $this->constructTrainerUrl($userId) . '/trainee';

        $trainee = Http::get($url);

        return $this->mapperService->toModel($trainee->collect(), Friend::class);
    }

    public function setTrainer($userId, $trainerId, $revoke = false)
    {
        $revokeRequest = $revoke ? 'true' : 'false';
        $request = $this->constructTrainerUrl($userId) . '?revoke=' . $revokeRequest . '&trainerId=' . $trainerId;

        $response = Http::put($request);

        return $this->mapperService->mapper(Friend::class, $response->json());
    }

    private function updateFriendRequest($userId, $friendId, $state)
    {
        $requestUrl = $this->constructRequestUrl($userId) . '?friendId=' . $friendId . '&requestState=' . $state;

        $response = Http::put($requestUrl);

        return $this->mapperService->mapper(FriendRequest::class, $response->json());
    }

    private function constructRequestUrl($userId)
    {
        return $this->constructUrl($userId) . '/request';
    }

    private function constructUrl($userId)
    {
        return $this->url . 'user/' . $userId . "/friend";
    }

    private function constructTrainerUrl($userId)
    {
        return $this->url . 'user/' . $userId . '/trainer';
    }
}

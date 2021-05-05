package org.xapik.friends.controller;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.web.bind.annotation.*;
import org.xapik.friends.database.model.FriendRequest;
import org.xapik.friends.database.model.RequestState;
import org.xapik.friends.service.FriendService;

@RestController
@RequestMapping("user/{userId}/friend/request")
public class FriendRequestsController {

    final FriendService friendService;

    @Autowired
    public FriendRequestsController(FriendService friendService) {
        this.friendService = friendService;
    }

    @GetMapping
    public Iterable<FriendRequest> getFriendRequests(@PathVariable int userId, @RequestParam(value = "requestState", defaultValue = "RECEIVED", required = false) RequestState requestState) {
        return friendService.getFriendRequests(userId, requestState);
    }

    @PutMapping
    public FriendRequest updateFriendRequest(@PathVariable int userId, @RequestParam int friendId, @RequestParam RequestState requestState) {
        return friendService.updateFriendRequest(userId, friendId, requestState);
    }

}

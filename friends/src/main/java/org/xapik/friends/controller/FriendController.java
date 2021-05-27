package org.xapik.friends.controller;

import org.springframework.web.bind.annotation.*;
import org.xapik.friends.database.model.Friend;
import org.xapik.friends.service.FriendService;

@RestController
@RequestMapping("user/{userId}/friend")
public class FriendController {

    final FriendService friendService;

    public FriendController(FriendService friendService) {
        this.friendService = friendService;
    }

    @GetMapping
    public Iterable<Friend> getFriendList(@PathVariable int userId) {
        return friendService.getFriendList(userId);
    }

    @PostMapping
    public Friend addFriend(@PathVariable int userId, @RequestParam int friendId) {
        return friendService.addFriend(userId, friendId);
    }

    @DeleteMapping
    public void deleteFriend(@PathVariable int userId, @RequestParam int friendId) {
        friendService.deleteFriend(userId, friendId);
    }

}

package org.xapik.friends.controller;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.web.bind.annotation.*;
import org.xapik.friends.database.model.Friend;
import org.xapik.friends.service.FriendService;

import java.util.Optional;

@RestController
@RequestMapping("/user/{userId}/trainer")
public class TrainerController {

    final FriendService friendService;

    @Autowired
    public TrainerController(FriendService friendService) {
        this.friendService = friendService;
    }

    @GetMapping
    public Optional<Friend> getTrainer(@PathVariable int userId) {
        return friendService.getTrainer(userId);
    }

    @PutMapping
    public Friend setTrainer(
            @PathVariable int userId,
            @RequestParam int trainerId,
            @RequestParam(value = "revoke", required = false) boolean revoke
    ) {
        return friendService.setTrainer(userId, trainerId, !revoke);
    }
}

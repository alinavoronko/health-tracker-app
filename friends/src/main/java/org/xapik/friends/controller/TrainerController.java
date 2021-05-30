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
    public Iterable<Friend> getTrainer(@PathVariable int userId) {
        return friendService.getTrainers(userId);
    }

    @GetMapping("/trainee")
    public Iterable<Friend> getTrainee(@PathVariable int userId) {
        return friendService.getTrainees(userId);
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

package org.xapik.friends.service;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;
import org.xapik.friends.database.model.Friend;
import org.xapik.friends.database.model.FriendIdentity;
import org.xapik.friends.database.repository.FriendRepository;

import java.util.Optional;

@Service
public class FriendService {

    final FriendRepository friendRepository;

    final FriendRequestService friendRequestService;

    @Autowired
    public FriendService(FriendRepository friendRepository, FriendRequestService friendRequestService) {
        this.friendRepository = friendRepository;
        this.friendRequestService = friendRequestService;
    }

    public Iterable<Friend> getFriendList(int userId) {
        return friendRepository.getFriendByUserId(userId);
    }

    public Optional<Friend> getTrainer(int userId) {
        var trainers = friendRepository.findFirstByUserIdAndIsTrainer(userId, true).iterator();

        return trainers.hasNext() ? Optional.of(trainers.next()) : Optional.empty();
    }

    public Friend addFriend(int userId, int friendId) {
        var friendIdentity = new FriendIdentity(userId, friendId);
        var existingFriend = friendRepository.findById(friendIdentity);

        if (existingFriend.isPresent()) {
            return existingFriend.get();
        }

        var friend = new Friend();
        friend.setUserId(userId);
        friend.setFriendId(friendId);

        friendRequestService.addFriendRequest(friendId, userId);

        return friendRepository.save(friend);
    }

    public Friend setTrainer(int userId, int trainerId, boolean isTrainer) {
        var friendId = new FriendIdentity(userId, trainerId);
        var friend = friendRepository.findById(friendId).orElseThrow();

        if (Boolean.FALSE.equals(friend.getIsApproved())) {
            return null;
        }

        friend.setIsTrainer(isTrainer);

        var previousTrainers = friendRepository.findFirstByUserIdAndIsTrainer(userId, true);
        previousTrainers.forEach(trainer -> trainer.setIsTrainer(false));

        friendRepository.saveAll(previousTrainers);

        return friendRepository.save(friend);
    }

    public void deleteFriend(int userId, int friendId) {
        var userIdentity = new FriendIdentity(userId, friendId);
        var friendIdentity = new FriendIdentity(friendId, userId);

        friendRepository.findById(userIdentity).ifPresent(friendRepository::delete);
        friendRepository.findById(friendIdentity).ifPresent(friendRepository::delete);

        friendRequestService.deleteFriend(userId, friendId);
    }
}


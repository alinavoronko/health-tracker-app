package org.xapik.friends.service;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.context.ApplicationEventPublisher;
import org.springframework.stereotype.Service;
import org.xapik.friends.database.model.Friend;
import org.xapik.friends.database.model.FriendIdentity;
import org.xapik.friends.database.repository.FriendRepository;
import org.xapik.friends.event.friend.FriendAddedEvent;
import org.xapik.friends.event.friend.FriendDeletedEvent;

import java.util.List;
import java.util.Optional;

@Service
public class FriendService {

    private final FriendRepository friendRepository;

    private final ApplicationEventPublisher publisher;

    @Autowired
    public FriendService(FriendRepository friendRepository, ApplicationEventPublisher applicationEventPublisher) {
        this.friendRepository = friendRepository;
        this.publisher = applicationEventPublisher;
    }

    public Iterable<Friend> getFriendList(int userId) {
        return friendRepository.getFriendByUserIdAndIsApproved(userId, true);
    }

    public Iterable<Friend> getTrainers(int userId) {
        return friendRepository.findAllByUserIdAndIsTrainer(userId, true);
    }

    public Iterable<Friend> getTrainees(int userId) {
        return friendRepository.findAllByFriendIdAndIsTrainer(userId, true);
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

        this.publisher.publishEvent(new FriendAddedEvent(userId, friendId));

        return friendRepository.save(friend);
    }

    public void acceptFriend(int userId, int friendId) {
        var identity = new FriendIdentity(friendId, userId);
        var friend = friendRepository.findById(identity).orElseThrow();

        friend.setIsApproved(true);

        var newFriend = new Friend();
        newFriend.setUserId(userId);
        newFriend.setFriendId(friendId);
        newFriend.setIsApproved(true);

        friendRepository.saveAll(List.of(friend, newFriend));
    }

    public Friend setTrainer(int userId, int trainerId, boolean isTrainer) {
        var friendId = new FriendIdentity(userId, trainerId);
        var friend = friendRepository.findById(friendId).orElseThrow();

        if (Boolean.FALSE.equals(friend.getIsApproved())) {
            return null;
        }

        friend.setIsTrainer(isTrainer);

//        var previousTrainers = friendRepository.findFirstByUserIdAndIsTrainer(userId, true);
//        previousTrainers.forEach(trainer -> trainer.setIsTrainer(false));

//        friendRepository.saveAll(previousTrainers);

        return friendRepository.save(friend);
    }

    public void deleteFriend(int userId, int friendId) {
        var userIdentity = new FriendIdentity(userId, friendId);
        var friendIdentity = new FriendIdentity(friendId, userId);

        friendRepository.findById(userIdentity).ifPresent(friendRepository::delete);
        friendRepository.findById(friendIdentity).ifPresent(friendRepository::delete);

        this.publisher.publishEvent(new FriendDeletedEvent(userId, friendId));
    }
}


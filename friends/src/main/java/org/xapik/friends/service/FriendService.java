package org.xapik.friends.service;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;
import org.xapik.friends.database.model.Friend;
import org.xapik.friends.database.model.FriendIdentity;
import org.xapik.friends.database.model.FriendRequest;
import org.xapik.friends.database.model.RequestState;
import org.xapik.friends.database.repository.FriendRepository;
import org.xapik.friends.database.repository.FriendRequestRepository;

import java.util.List;
import java.util.Optional;

@Service
public class FriendService {

    final FriendRepository friendRepository;
    final FriendRequestRepository friendRequestRepository;

    @Autowired
    public FriendService(FriendRepository friendRepository, FriendRequestRepository friendRequestRepository) {
        this.friendRepository = friendRepository;
        this.friendRequestRepository = friendRequestRepository;
    }

    public Iterable<Friend> getFriendList(int userId) {
        return friendRepository.getFriendByUserIdAndIsApproved(userId, true);
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

        addFriendRequest(friendId, userId);

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

        friendRequestRepository.findById(userIdentity).ifPresent(friendRequestRepository::delete);
        friendRequestRepository.findById(friendIdentity).ifPresent(friendRequestRepository::delete);
    }


    public Iterable<FriendRequest> getFriendRequests(int userId, RequestState requestState) {
        return friendRequestRepository.getFriendRequestsByUserIdAndRequestStateIs(userId, requestState);
    }

    public FriendRequest addFriendRequest(int userId, int friendId) {
        var friendRequest = new FriendRequest();
        friendRequest.setFriendId(friendId);
        friendRequest.setUserId(userId);

        return friendRequestRepository.save(friendRequest);
    }

    public FriendRequest updateFriendRequest(int userId, int friendId, RequestState requestState) {
        var friendIdentity = new FriendIdentity(userId, friendId);

        var friendRequest = friendRequestRepository.findById(friendIdentity).orElseThrow();

        friendRequest.setRequestState(requestState);

        if (requestState.equals(RequestState.ACCEPTED)) {
            acceptFriend(userId, friendId);
        }

        return friendRequestRepository.save(friendRequest);
    }
}


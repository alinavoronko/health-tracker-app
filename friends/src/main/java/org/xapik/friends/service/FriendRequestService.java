package org.xapik.friends.service;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.context.ApplicationEventPublisher;
import org.springframework.stereotype.Service;
import org.xapik.friends.database.model.FriendIdentity;
import org.xapik.friends.database.model.FriendRequest;
import org.xapik.friends.database.model.RequestState;
import org.xapik.friends.database.repository.FriendRequestRepository;
import org.xapik.friends.event.friend.FriendAcceptedEvent;

@Service
public class FriendRequestService {

    private final FriendRequestRepository friendRequestRepository;

    private final ApplicationEventPublisher publisher;

    @Autowired
    public FriendRequestService(FriendRequestRepository friendRequestRepository, ApplicationEventPublisher applicationEventPublisher) {
        this.friendRequestRepository = friendRequestRepository;
        this.publisher = applicationEventPublisher;
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
            publisher.publishEvent(new FriendAcceptedEvent(userId, friendId));
        }

        return friendRequestRepository.save(friendRequest);
    }

    public void deleteFriendRequest(int userId, int friendId) {
        var userIdentity = new FriendIdentity(userId, friendId);
        var friendIdentity = new FriendIdentity(friendId, userId);

        friendRequestRepository.findById(userIdentity).ifPresent(friendRequestRepository::delete);
        friendRequestRepository.findById(friendIdentity).ifPresent(friendRequestRepository::delete);
    }
}

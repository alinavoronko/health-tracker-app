package org.xapik.friends.event.friend;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.context.event.EventListener;
import org.springframework.stereotype.Component;
import org.xapik.friends.service.FriendRequestService;

@Component
public class FriendRequestEventListener {

    private final FriendRequestService friendRequestService;

    @Autowired
    public FriendRequestEventListener(FriendRequestService friendRequestService) {
        this.friendRequestService = friendRequestService;
    }

    @EventListener
    public void handleFriendAddedEvent(FriendAddedEvent friendAddedEvent) {
        friendRequestService.addFriendRequest(friendAddedEvent.getFriendId(), friendAddedEvent.getUserId());
    }

    @EventListener
    public void handleFriendDeletedEvent(FriendDeletedEvent friendDeletedEvent) {
        friendRequestService.deleteFriendRequest(friendDeletedEvent.getUserId(), friendDeletedEvent.getFriendId());
    }
}

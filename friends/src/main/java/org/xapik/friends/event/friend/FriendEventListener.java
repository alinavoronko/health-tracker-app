package org.xapik.friends.event.friend;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.context.event.EventListener;
import org.springframework.stereotype.Component;
import org.xapik.friends.service.FriendService;

@Component
public class FriendEventListener {

    private final FriendService friendService;

    @Autowired
    public FriendEventListener(FriendService friendService) {
        this.friendService = friendService;
    }

    @EventListener
    public void handleFriendAcceptedEvent(FriendAcceptedEvent friendAcceptedEvent) {
        this.friendService.acceptFriend(friendAcceptedEvent.getUserId(), friendAcceptedEvent.getFriendId());
    }
}

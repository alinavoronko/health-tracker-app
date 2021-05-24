package org.xapik.friends.event.friend;

public class FriendAcceptedEvent extends AbstractFriendEvent {
    public FriendAcceptedEvent(int userId, int friendId) {
        super(userId, friendId);
    }
}

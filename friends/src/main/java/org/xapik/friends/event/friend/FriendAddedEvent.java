package org.xapik.friends.event.friend;

public class FriendAddedEvent extends  AbstractFriendEvent {
    public FriendAddedEvent(int userId, int friendId) {
        super(userId, friendId);
    }
}

package org.xapik.friends.event.friend;

public class FriendDeletedEvent extends AbstractFriendEvent {
    public FriendDeletedEvent(int userId, int friendId) {
        super(userId, friendId);
    }
}

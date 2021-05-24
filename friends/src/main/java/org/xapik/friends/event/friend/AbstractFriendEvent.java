package org.xapik.friends.event.friend;

import lombok.AllArgsConstructor;
import lombok.Data;

@Data
@AllArgsConstructor
public abstract class AbstractFriendEvent {
    private int userId;
    private int friendId;
}

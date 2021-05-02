package org.xapik.friends.database.model;

import lombok.AllArgsConstructor;
import lombok.Data;

import java.io.Serializable;

@Data
@AllArgsConstructor
public class FriendIdentity implements Serializable {
    private Integer userId;
    private Integer friendId;
}

package org.xapik.friends.database.repository;

import org.springframework.data.repository.CrudRepository;
import org.xapik.friends.database.model.Friend;
import org.xapik.friends.database.model.FriendIdentity;

public interface FriendRepository extends CrudRepository<Friend, FriendIdentity> {

    Iterable<Friend> getFriendByUserIdAndIsApproved(int userId, boolean isApproved);

    Iterable<Friend> findFirstByUserIdAndIsTrainer(int userId, boolean isTrainer);
}

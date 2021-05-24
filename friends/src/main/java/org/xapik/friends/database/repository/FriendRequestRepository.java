package org.xapik.friends.database.repository;

import org.springframework.data.repository.CrudRepository;
import org.xapik.friends.database.model.FriendIdentity;
import org.xapik.friends.database.model.FriendRequest;
import org.xapik.friends.database.model.RequestState;

public interface FriendRequestRepository extends CrudRepository<FriendRequest, FriendIdentity> {

    Iterable<FriendRequest> getFriendRequestsByUserIdAndRequestStateIs(int userId, RequestState requestState);

}


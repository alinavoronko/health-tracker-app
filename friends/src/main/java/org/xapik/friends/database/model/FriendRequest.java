package org.xapik.friends.database.model;

import lombok.Data;
import lombok.NoArgsConstructor;
import org.hibernate.annotations.CreationTimestamp;
import org.hibernate.annotations.UpdateTimestamp;

import javax.persistence.*;
import javax.validation.constraints.NotNull;
import javax.validation.constraints.PositiveOrZero;
import java.util.Date;

@Data
@Entity
@NoArgsConstructor
@IdClass(FriendIdentity.class)
public class FriendRequest {
    @Id
    @NotNull
    @PositiveOrZero
    private Integer userId;

    @Id
    @NotNull
    @PositiveOrZero
    private Integer friendId;

    private RequestState requestState = RequestState.RECEIVED;

    @CreationTimestamp
    @Temporal(TemporalType.TIMESTAMP)
    private Date createdAt;

    @UpdateTimestamp
    @Temporal(TemporalType.TIMESTAMP)
    private Date updatedAt;
}

package org.xapik.friends.database.model;

import lombok.*;
import org.hibernate.annotations.ColumnDefault;
import org.hibernate.annotations.CreationTimestamp;
import org.hibernate.annotations.UpdateTimestamp;

import javax.persistence.*;
import javax.validation.constraints.NotNull;
import javax.validation.constraints.Null;
import javax.validation.constraints.PositiveOrZero;
import java.io.Serializable;
import java.util.Date;

import org.xapik.friends.database.model.FriendIdentity;

@Data
@Entity
@NoArgsConstructor
@IdClass(FriendIdentity.class)
public class Friend implements Serializable {
    @Id
    @PositiveOrZero
    private Integer userId;

    @Id
    @NotNull
    @PositiveOrZero
    private Integer friendId;

    @ColumnDefault("0")
    private Boolean isApproved = false;

    @ColumnDefault("0")
    private Boolean isTrainer = false;

    @CreationTimestamp
    @Temporal(TemporalType.TIMESTAMP)
    private Date createdAt;

    @UpdateTimestamp
    @Temporal(TemporalType.TIMESTAMP)
    private Date updatedAt;
}

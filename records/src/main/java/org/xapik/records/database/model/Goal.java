package org.xapik.records.database.model;

import org.springframework.data.cassandra.core.cql.PrimaryKeyType;
import org.springframework.data.cassandra.core.mapping.CassandraType;
import org.springframework.data.cassandra.core.mapping.PrimaryKeyColumn;
import org.springframework.data.cassandra.core.mapping.Table;
import org.xapik.records.PeriodType;
import org.xapik.records.RecordType;

import javax.validation.constraints.NotNull;
import java.time.LocalDateTime;
import java.util.Objects;

@Table
public class Goal {
    @PrimaryKeyColumn(name = "user_id", ordinal = 0, type = PrimaryKeyType.PARTITIONED)
    private int userId;

    @PrimaryKeyColumn(name = "creator_id", ordinal = 3)
    private int creatorId;

    @NotNull(message = "Goal type is mandatory")
    @PrimaryKeyColumn(name = "type", ordinal = 1)
    @CassandraType(type = CassandraType.Name.INT)
    private RecordType type;

    @PrimaryKeyColumn(name = "created_at", ordinal = 4)
    private LocalDateTime createdAt;

    @NotNull(message = "Time Period is mandatory")
    @PrimaryKeyColumn(name = "time_period", ordinal = 2)
    @CassandraType(type = CassandraType.Name.INT)
    private PeriodType timePeriod;

    private float value;

    public Goal() {}

    public Goal(int userId, int creatorId, @NotNull(message = "Goal type is mandatory") RecordType type, LocalDateTime createdAt, @NotNull(message = "Time Period is mandatory") PeriodType timePeriod, float value) {
        this.userId = userId;
        this.creatorId = creatorId;
        this.type = type;
        this.createdAt = createdAt;
        this.timePeriod = timePeriod;
        this.value = value;
    }

    @Override
    public boolean equals(Object o) {
        if (this == o) return true;
        if (o == null || getClass() != o.getClass()) return false;
        Goal goal = (Goal) o;
        return userId == goal.userId && creatorId == goal.creatorId && Float.compare(goal.value, value) == 0 && type == goal.type && createdAt.equals(goal.createdAt) && timePeriod == goal.timePeriod;
    }

    @Override
    public int hashCode() {
        return Objects.hash(userId, creatorId, type, createdAt, timePeriod, value);
    }

    @Override
    public String toString() {
        return "Goal{" +
                "userId=" + userId +
                ", creatorId=" + creatorId +
                ", type=" + type +
                ", createdAt=" + createdAt +
                ", timePeriod=" + timePeriod +
                ", value=" + value +
                '}';
    }

    public int getUserId() {
        return userId;
    }

    public void setUserId(int userId) {
        this.userId = userId;
    }

    public int getCreatorId() {
        return creatorId;
    }

    public void setCreatorId(int creatorId) {
        this.creatorId = creatorId;
    }

    public RecordType getType() {
        return type;
    }

    public void setType(RecordType type) {
        this.type = type;
    }

    public LocalDateTime getCreatedAt() {
        return createdAt;
    }

    public void setCreatedAt(LocalDateTime createdAt) {
        this.createdAt = createdAt;
    }

    public PeriodType getTimePeriod() {
        return timePeriod;
    }

    public void setTimePeriod(PeriodType timePeriod) {
        this.timePeriod = timePeriod;
    }

    public float getValue() {
        return value;
    }

    public void setValue(float value) {
        this.value = value;
    }
}

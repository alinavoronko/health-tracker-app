package org.xapik.records.database.model;

import org.springframework.data.cassandra.core.cql.PrimaryKeyType;
import org.springframework.data.cassandra.core.mapping.CassandraType;
import org.springframework.data.cassandra.core.mapping.Column;
import org.springframework.data.cassandra.core.mapping.PrimaryKeyColumn;
import org.springframework.data.cassandra.core.mapping.Table;
import org.xapik.records.RecordType;

import javax.validation.constraints.NotBlank;
import javax.validation.constraints.NotNull;
import java.time.LocalDateTime;
import java.util.Objects;

@Table
public class Record {
    @NotNull(message = "UserID is mandatory")
    @PrimaryKeyColumn(name = "user_id", ordinal = 0, type = PrimaryKeyType.PARTITIONED)
    private int userId;
    @NotNull(message = "Record type is mandatory")
    @PrimaryKeyColumn(name = "type", ordinal = 1)
    @CassandraType(type = CassandraType.Name.INT)
    private RecordType type;
    @NotNull(message = "Until time is mandatory")
    @PrimaryKeyColumn(name = "until_time", ordinal = 2)
    private LocalDateTime untilTime;
    private float value;
    @Column("from_time")
    @NotNull(message = "From time is mandatory")
    private LocalDateTime fromTime;
    @Column("data_source")
    @NotBlank(message = "Data source is mandatory")
    private String dataSource;

    public Record(int userId, RecordType type, float value, LocalDateTime untilTime, LocalDateTime fromTime, String dataSource) {
        this.userId = userId;
        this.type = type;
        this.value = value;
        this.untilTime = untilTime;
        this.fromTime = fromTime;
        this.dataSource = dataSource;
    }

    @Override
    public boolean equals(Object o) {
        if (this == o) return true;
        if (o == null || getClass() != o.getClass()) return false;
        var userRecord = (Record) o;
        return userId == userRecord.userId && Float.compare(userRecord.value, value) == 0 && type == userRecord.type && untilTime.equals(userRecord.untilTime) && fromTime.equals(userRecord.fromTime) && dataSource.equals(userRecord.dataSource);
    }

    @Override
    public int hashCode() {
        return Objects.hash(userId, type, value, untilTime, fromTime, dataSource);
    }

    @Override
    public String toString() {
        return "Record{" +
                "userId=" + userId +
                ", type=" + type +
                ", value=" + value +
                ", untilTime=" + untilTime +
                ", fromTime=" + fromTime +
                ", dataSource='" + dataSource + '\'' +
                '}';
    }

    public int getUserId() {
        return userId;
    }

    public void setUserId(int userId) {
        this.userId = userId;
    }

    public RecordType getType() {
        return type;
    }

    public void setType(RecordType type) {
        this.type = type;
    }

    public float getValue() {
        return value;
    }

    public void setValue(float value) {
        this.value = value;
    }

    public LocalDateTime getUntilTime() {
        return untilTime;
    }

    public void setUntilTime(LocalDateTime untilTime) {
        this.untilTime = untilTime;
    }

    public LocalDateTime getFromTime() {
        return fromTime;
    }

    public void setFromTime(LocalDateTime fromTime) {
        this.fromTime = fromTime;
    }

    public String getDataSource() {
        return dataSource;
    }

    public void setDataSource(String dataSource) {
        this.dataSource = dataSource;
    }
}

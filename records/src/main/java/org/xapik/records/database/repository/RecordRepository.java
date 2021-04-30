package org.xapik.records.database.repository;

import org.springframework.data.cassandra.repository.AllowFiltering;
import org.springframework.data.cassandra.repository.ReactiveCassandraRepository;
import org.xapik.records.RecordType;
import org.xapik.records.database.model.Record;
import reactor.core.publisher.Flux;

import java.time.LocalDateTime;

public interface RecordRepository extends ReactiveCassandraRepository<Record, Integer> {
    Flux<Record> findByUserId(int userId);
    Flux<Record> findByUserIdAndType(int userId, RecordType recordType);

    @AllowFiltering
    Flux<Record> findByUserIdAndFromTimeGreaterThanEqual(int userId, LocalDateTime fromTime);
    @AllowFiltering
    Flux<Record> findByUserIdAndUntilTimeLessThanEqual(int userId, LocalDateTime untilTime);

    @AllowFiltering
    Flux<Record> findByUserIdAndTypeAndFromTimeGreaterThanEqual(int userId, RecordType recordType, LocalDateTime fromTime);
    Flux<Record> findByUserIdAndTypeAndUntilTimeLessThanEqual(int userId, RecordType recordType, LocalDateTime untilTime);

    @AllowFiltering
    Flux<Record> findByUserIdAndUntilTimeLessThanEqualAndFromTimeGreaterThanEqual(int userId, LocalDateTime untilTime, LocalDateTime fromTime);
    Flux<Record> findByUserIdAndTypeAndUntilTimeLessThanEqualAndFromTimeGreaterThanEqual(int userId, RecordType type, LocalDateTime untilTime, LocalDateTime fromTime);
}

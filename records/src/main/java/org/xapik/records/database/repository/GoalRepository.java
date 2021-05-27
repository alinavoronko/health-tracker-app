package org.xapik.records.database.repository;

import org.springframework.data.cassandra.repository.ReactiveCassandraRepository;
import org.xapik.records.PeriodType;
import org.xapik.records.RecordType;
import org.xapik.records.database.model.Goal;
import reactor.core.publisher.Flux;

public interface GoalRepository extends ReactiveCassandraRepository<Goal, Integer> {

    Flux<Goal> findFirstByUserIdAndTypeAndTimePeriodAndCreatorId(int userId, RecordType recordType, PeriodType timePeriod, int creatorId);

}

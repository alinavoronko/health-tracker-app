package org.xapik.records.service;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;
import org.xapik.records.PeriodType;
import org.xapik.records.RecordType;
import org.xapik.records.database.model.Goal;
import org.xapik.records.database.repository.GoalRepository;
import reactor.core.publisher.Flux;
import reactor.core.publisher.Mono;

import java.time.LocalDateTime;
import java.util.Arrays;
import java.util.stream.Collectors;

@Service
public class GoalService {

    final GoalRepository goalRepository;

    @Autowired
    public GoalService(GoalRepository goalRepository) {
        this.goalRepository = goalRepository;
    }

    public Flux<Goal> getUserGoals(int userId, RecordType goalType, int creatorId) {
        var goals = Arrays.stream(PeriodType.values())
                .map(periodType -> goalRepository.findFirstByUserIdAndTypeAndTimePeriodAndCreatorId(userId, goalType, periodType, creatorId))
                .collect(Collectors.toList());

        return Flux.merge(goals);
    }

    public Mono<Goal> addGoal(Goal goal) {
        goal.setCreatedAt(LocalDateTime.now());

        return goalRepository.save(goal);
    }

}

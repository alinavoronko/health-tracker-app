package org.xapik.records.service;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;
import org.xapik.records.RecordType;
import org.xapik.records.database.model.Record;
import org.xapik.records.database.repository.RecordRepository;
import reactor.core.publisher.Flux;
import reactor.core.publisher.Mono;

import java.time.LocalDateTime;
import java.util.Arrays;
import java.util.stream.Collectors;

@Service
public class RecordService {

    final RecordRepository recordRepository;

    @Autowired
    public RecordService(RecordRepository recordRepository) {
        this.recordRepository = recordRepository;
    }

    public Flux<Record> getAllUserRecords(int userId, LocalDateTime fromDate, LocalDateTime toDate) {
        var recordTypeStream = Arrays.stream(RecordType.values());

        if (fromDate != null && toDate != null) {
            var records = recordTypeStream.map(
                    recordType -> recordRepository.findByUserIdAndTypeAndUntilTimeLessThanEqualAndUntilTimeGreaterThanEqual(userId, recordType, toDate, fromDate)
            ).collect(Collectors.toList());

            return Flux.merge(records);
        }

        if (fromDate != null) {
            var records = recordTypeStream.map(
                    recordType -> recordRepository.findByUserIdAndTypeAndUntilTimeGreaterThanEqual(userId, recordType, fromDate)
            ).collect(Collectors.toList());

            return Flux.merge(records);
        }

        if (toDate != null) {
            var records = recordTypeStream.map(
                    recordType -> recordRepository.findByUserIdAndTypeAndUntilTimeLessThanEqual(userId, recordType, toDate)
            ).collect(Collectors.toList());

            return Flux.merge(records);
        }

        return recordRepository.findByUserId(userId);
    }

    public Flux<Record> getAllUserRecordsByType(int userId, RecordType recordType, LocalDateTime fromDate, LocalDateTime toDate) {
        if (fromDate != null && toDate != null) {
            return recordRepository.findByUserIdAndTypeAndUntilTimeLessThanEqualAndUntilTimeGreaterThanEqual(userId, recordType, toDate, fromDate);
        }

        if (fromDate != null) {
            return recordRepository.findByUserIdAndTypeAndUntilTimeGreaterThanEqual(userId, recordType, fromDate);
        }

        if (toDate != null) {
            return recordRepository.findByUserIdAndTypeAndUntilTimeLessThanEqual(userId, recordType, toDate);
        }

        return recordRepository.findByUserIdAndType(userId, recordType);
    }

    public Mono<Record> addUserRecord(Record userRecord) {
        return recordRepository.save(userRecord);
    }
}

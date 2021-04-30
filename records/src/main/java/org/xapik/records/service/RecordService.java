package org.xapik.records.service;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;
import org.xapik.records.RecordType;
import org.xapik.records.database.model.Record;
import org.xapik.records.database.repository.RecordRepository;
import reactor.core.publisher.Flux;
import reactor.core.publisher.Mono;

import java.time.LocalDateTime;

@Service
public class RecordService {

    final RecordRepository recordRepository;

    @Autowired
    public RecordService(RecordRepository recordRepository) {
        this.recordRepository = recordRepository;
    }

    public Flux<Record> getAllUserRecords(int userId, LocalDateTime fromDate, LocalDateTime toDate) {
        if (fromDate != null && toDate != null) {
            return recordRepository.findByUserIdAndUntilTimeLessThanEqualAndFromTimeGreaterThanEqual(userId, toDate, fromDate);
        }

        if (fromDate != null) {
            return recordRepository.findByUserIdAndFromTimeGreaterThanEqual(userId, fromDate);
        }

        if (toDate != null) {
            return recordRepository.findByUserIdAndUntilTimeLessThanEqual(userId, toDate);
        }

        return recordRepository.findByUserId(userId);
    }

    public Flux<Record> getAllUserRecordsByType(int userId, RecordType recordType, LocalDateTime fromDate, LocalDateTime toDate) {
        if (fromDate != null && toDate != null) {
            return recordRepository.findByUserIdAndTypeAndUntilTimeLessThanEqualAndFromTimeGreaterThanEqual(userId, recordType, toDate, fromDate);
        }

        if (fromDate != null) {
            return recordRepository.findByUserIdAndTypeAndFromTimeGreaterThanEqual(userId, recordType, fromDate);
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

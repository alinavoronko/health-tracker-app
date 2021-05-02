package org.xapik.records.service;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;
import org.xapik.records.RecordType;
import org.xapik.records.database.model.Record;
import org.xapik.records.database.repository.RecordRepository;
import reactor.core.publisher.Flux;
import reactor.core.publisher.Mono;

import java.time.LocalDateTime;
import java.time.format.DateTimeFormatter;
import java.util.Arrays;
import java.util.Map;
import java.util.stream.Collectors;

@Service
public class RecordService {

    final RecordRepository recordRepository;

    @Autowired
    public RecordService(RecordRepository recordRepository) {
        this.recordRepository = recordRepository;
    }

    public Flux<Record> getAllUserRecords(int userId, LocalDateTime fromDate, LocalDateTime toDate) {
        if (fromDate == null && toDate == null) {
            return recordRepository.findByUserId(userId);
        }

        var recordTypeStream = Arrays.stream(RecordType.values());

        var records = recordTypeStream.map(
                recordType -> this.getAllUserRecordsByType(userId, recordType, fromDate, toDate)
        ).collect(Collectors.toList());

        return Flux.merge(records);
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

    public Mono<Map<String, Double>> getTimeline(int userId, RecordType recordType, LocalDateTime fromDate, LocalDateTime toDate) {
        // 1. Retrieve all records from fromDate to toDate
        // 2. Based on period return aggregated values by Day

        var records = this.getAllUserRecordsByType(userId, recordType, fromDate, toDate);

        return records.collectMultimap(
                userRecord -> userRecord.getUntilTime().format(DateTimeFormatter.ISO_LOCAL_DATE),
                Record::getValue).map(
                map -> map.entrySet().stream().collect(
                        Collectors.toMap(
                                Map.Entry::getKey,
                                entry -> entry.getValue().stream().mapToDouble(a -> a).sum()
                        )
                ));
    }
}

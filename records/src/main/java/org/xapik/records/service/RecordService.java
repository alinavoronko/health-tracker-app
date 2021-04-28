package org.xapik.records.service;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;
import org.xapik.records.database.model.Record;
import org.xapik.records.database.repository.RecordRepository;
import reactor.core.publisher.Flux;

@Service
public class RecordService {

    final RecordRepository recordRepository;

    @Autowired
    public RecordService(RecordRepository recordRepository) {
        this.recordRepository = recordRepository;
    }

    public Flux<Record> getAllUserRecords(int userId) {
        return recordRepository.findByUserId(userId);
    }
}

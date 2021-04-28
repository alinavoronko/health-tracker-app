package org.xapik.records.controller;

import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.PathVariable;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RestController;
import org.xapik.records.database.model.Record;
import org.xapik.records.service.RecordService;
import reactor.core.publisher.Flux;

@RestController
@RequestMapping("user/{userId}/record")
public class RecordController {

    final RecordService recordService;

    public RecordController(RecordService recordService) {
        this.recordService = recordService;
    }

    @GetMapping
    public Flux<Record> getUserRecords(@PathVariable int userId) {
        return recordService.getAllUserRecords(userId);
    }
}

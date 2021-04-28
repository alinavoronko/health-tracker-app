package org.xapik.records.controller;

import org.springframework.http.MediaType;
import org.springframework.web.bind.annotation.*;
import org.xapik.records.database.model.Record;
import org.xapik.records.service.RecordService;
import reactor.core.publisher.Flux;
import reactor.core.publisher.Mono;

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

    @PostMapping
    public Mono<Record> addUserRecord(@RequestBody Record _record) {
        return recordService.addUserRecord(_record);
    }

}

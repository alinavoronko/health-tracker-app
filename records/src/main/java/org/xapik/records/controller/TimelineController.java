package org.xapik.records.controller;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.format.annotation.DateTimeFormat;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.PathVariable;
import org.springframework.web.bind.annotation.RequestParam;
import org.springframework.web.bind.annotation.RestController;
import org.xapik.records.RecordType;
import org.xapik.records.service.RecordService;
import reactor.core.publisher.Mono;

import java.time.LocalDateTime;
import java.util.Map;

@RestController
public class TimelineController {

    final RecordService recordService;

    @Autowired
    public TimelineController(RecordService recordService) {
        this.recordService = recordService;
    }

    @GetMapping("/user/{userId}/timeline/{recordType}")
    public Mono<Map<String, Double>> getTimeline(
            @PathVariable int userId,
            @PathVariable RecordType recordType,
            @RequestParam
            @DateTimeFormat(iso = DateTimeFormat.ISO.DATE_TIME)
                    LocalDateTime fromDate,
            @RequestParam
            @DateTimeFormat(iso = DateTimeFormat.ISO.DATE_TIME)
                    LocalDateTime toDate
    ) {
      return recordService.getTimeline(userId, recordType, fromDate, toDate);
    }

}

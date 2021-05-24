package org.xapik.records.controller;

import org.springframework.format.annotation.DateTimeFormat;
import org.springframework.http.HttpStatus;
import org.springframework.validation.FieldError;
import org.springframework.web.bind.MethodArgumentNotValidException;
import org.springframework.web.bind.annotation.*;
import org.xapik.records.RecordType;
import org.xapik.records.database.model.Record;
import org.xapik.records.service.RecordService;
import reactor.core.publisher.Flux;
import reactor.core.publisher.Mono;

import javax.validation.Valid;
import java.time.LocalDateTime;
import java.util.HashMap;
import java.util.Map;

@RestController
@RequestMapping("user/{userId}/record")
public class RecordController {

    final RecordService recordService;

    public RecordController(RecordService recordService) {
        this.recordService = recordService;
    }

    @GetMapping
    public Flux<Record> getUserRecords(
            @PathVariable int userId,
            @RequestParam(value = "from", required = false)
            @DateTimeFormat(iso = DateTimeFormat.ISO.DATE_TIME)
                    LocalDateTime fromDate,
            @RequestParam(value = "to", required = false)
            @DateTimeFormat(iso = DateTimeFormat.ISO.DATE_TIME)
                    LocalDateTime toDate
    ) {
        return recordService.getAllUserRecords(userId, fromDate, toDate);
    }

    @GetMapping("/{recordType}")
    public Flux<Record> getUserRecordsByType(
            @PathVariable int userId,
            @PathVariable RecordType recordType,
            @RequestParam(value = "from", required = false)
            @DateTimeFormat(iso = DateTimeFormat.ISO.DATE_TIME)
                    LocalDateTime fromDate,
            @RequestParam(value = "to", required = false)
            @DateTimeFormat(iso = DateTimeFormat.ISO.DATE_TIME)
                    LocalDateTime toDate
    ) {
        return recordService.getAllUserRecordsByType(userId, recordType, fromDate, toDate);
    }

    @PostMapping
    public Mono<Record> addUserRecord(@Valid @RequestBody Record requestRecord) {
        return recordService.addUserRecord(requestRecord);
    }

    @ResponseStatus(HttpStatus.BAD_REQUEST)
    @ExceptionHandler(MethodArgumentNotValidException.class)
    public Map<String, Map<String, String>> handleValidationException(MethodArgumentNotValidException ex) {
        Map<String, String> errors = new HashMap<>();

        ex.getBindingResult().getAllErrors().forEach(error -> {
            String fieldName = ((FieldError) error).getField();
            String errorMessage = error.getDefaultMessage();
            errors.put(fieldName, errorMessage);
        });

        Map<String, Map<String, String>> result = new HashMap<>();
        result.put("errors", errors);

        return result;
    }

}

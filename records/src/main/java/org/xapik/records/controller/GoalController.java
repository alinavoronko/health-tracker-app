package org.xapik.records.controller;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.http.HttpStatus;
import org.springframework.validation.FieldError;
import org.springframework.web.bind.MethodArgumentNotValidException;
import org.springframework.web.bind.annotation.*;
import org.xapik.records.RecordType;
import org.xapik.records.database.model.Goal;
import org.xapik.records.service.GoalService;
import reactor.core.publisher.Flux;
import reactor.core.publisher.Mono;

import javax.validation.Valid;
import java.util.HashMap;
import java.util.Map;

@RestController
@RequestMapping("user/{userId}/goal")
public class GoalController {

    final GoalService goalService;

    @Autowired
    public GoalController(GoalService goalService) {
        this.goalService = goalService;
    }

    @GetMapping("/{goalType}")
    public Flux<Goal> getUserGoals(@PathVariable int userId, @PathVariable RecordType goalType, @RequestParam int creatorId) {
        return goalService.getUserGoals(userId, goalType, creatorId);
    }

    @PostMapping
    public Mono<Goal> addGoal(@PathVariable int userId, @Valid @RequestBody Goal goal) {
        goal.setUserId(userId);
        return goalService.addGoal(goal);
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

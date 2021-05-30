package org.xapik.records.controller;

import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.RestController;
import org.xapik.records.RecordType;

import java.util.Arrays;
import java.util.Collections;
import java.util.List;

@RestController
public class InfoController {
    @GetMapping("record-list")
    public List<RecordType> recordTypeList() {
        return Arrays.asList(RecordType.values());
    }

    @GetMapping("goal-list")
    public List<RecordType> goalList() {
        return Collections.singletonList(RecordType.STEPS);
    }
}

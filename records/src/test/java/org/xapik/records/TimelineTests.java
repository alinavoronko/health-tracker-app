package org.xapik.records;

import org.junit.jupiter.api.Test;
import org.junit.jupiter.api.extension.ExtendWith;
import org.mockito.Mock;
import org.mockito.junit.jupiter.MockitoExtension;
import org.springframework.boot.test.context.SpringBootTest;
import org.xapik.records.database.model.Record;
import org.xapik.records.database.repository.RecordRepository;
import org.xapik.records.service.RecordService;
import reactor.core.publisher.Flux;
import reactor.core.publisher.Mono;
import reactor.test.StepVerifier;

import java.time.LocalDateTime;
import java.time.format.DateTimeFormatter;
import java.util.HashMap;
import java.util.Map;

import static org.junit.jupiter.api.Assertions.assertNotNull;
import static org.mockito.Mockito.when;

@SpringBootTest
@ExtendWith(MockitoExtension.class)
class TimelineTests {

    @Mock
    RecordRepository recordRepositoryMock;

    @Test
    void testOneRecord() {
        assertNotNull(recordRepositoryMock);

        DateTimeFormatter formatter = DateTimeFormatter.ISO_LOCAL_DATE_TIME;
        LocalDateTime untilTime = LocalDateTime.parse("2021-04-12T10:15:30");
        LocalDateTime fromTime = LocalDateTime.parse("2021-03-12T10:15:30");

        when(recordRepositoryMock.findByUserIdAndTypeAndUntilTimeLessThanEqualAndUntilTimeGreaterThanEqual(0, RecordType.STEPS, untilTime, fromTime))
                .thenReturn(Flux.just(new Record(0, RecordType.STEPS, 1000.0f, untilTime, fromTime, "test")));

        RecordService recordService = new RecordService(recordRepositoryMock);
        Mono<Map<String, Double>> timeline = recordService.getTimeline(0, RecordType.STEPS, fromTime, untilTime);

        Map<String, Double> expected = new HashMap<>();
        expected.put("2021-04-12", 1000.0);

        StepVerifier.create(timeline.log())
            .expectNext(expected)
            .verifyComplete();
    }


    @Test
    void testTwoDaysRecords() {
        assertNotNull(recordRepositoryMock);

        DateTimeFormatter formatter = DateTimeFormatter.ISO_LOCAL_DATE_TIME;
        LocalDateTime untilTime = LocalDateTime.parse("2021-06-12T10:15:30");
        LocalDateTime time1 = LocalDateTime.parse("2021-05-12T10:15:30");
        LocalDateTime time2 = LocalDateTime.parse("2021-04-12T10:15:30");
        LocalDateTime fromTime = LocalDateTime.parse("2021-03-12T10:15:30");

        when(recordRepositoryMock.findByUserIdAndTypeAndUntilTimeLessThanEqualAndUntilTimeGreaterThanEqual(0, RecordType.STEPS, untilTime, fromTime))
                .thenReturn(Flux.just(
                        new Record(0, RecordType.STEPS, 1000.0f, time2, fromTime, "test"),
                        new Record(0, RecordType.STEPS, 1000.0f, untilTime, time1, "test")
                ));

        RecordService recordService = new RecordService(recordRepositoryMock);
        Mono<Map<String, Double>> timeline = recordService.getTimeline(0, RecordType.STEPS, fromTime, untilTime);

        Map<String, Double> expected = new HashMap<>();
        expected.put("2021-04-12", 1000.0);
        expected.put("2021-06-12", 1000.0);

        StepVerifier.create(timeline.log())
                .expectNext(expected)
                .verifyComplete();
    }

    @Test
    void testTwoRecordsSameDay() {
        assertNotNull(recordRepositoryMock);

        DateTimeFormatter formatter = DateTimeFormatter.ISO_LOCAL_DATE_TIME;
        LocalDateTime untilTime = LocalDateTime.parse("2021-06-12T10:15:30");
        LocalDateTime time1 = LocalDateTime.parse("2021-05-12T10:15:30");
        LocalDateTime fromTime = LocalDateTime.parse("2021-03-12T10:15:30");

        when(recordRepositoryMock.findByUserIdAndTypeAndUntilTimeLessThanEqualAndUntilTimeGreaterThanEqual(0, RecordType.STEPS, untilTime, fromTime))
                .thenReturn(Flux.just(
                        new Record(0, RecordType.STEPS, 1000.0f, untilTime, fromTime, "test"),
                        new Record(0, RecordType.STEPS, 1000.0f, untilTime, time1, "test")
                ));

        RecordService recordService = new RecordService(recordRepositoryMock);
        Mono<Map<String, Double>> timeline = recordService.getTimeline(0, RecordType.STEPS, fromTime, untilTime);

        Map<String, Double> expected = new HashMap<>();
        expected.put("2021-06-12", 2000.0);

        StepVerifier.create(timeline.log())
                .expectNext(expected)
                .verifyComplete();
    }
}

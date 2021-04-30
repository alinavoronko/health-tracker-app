CREATE
KEYSPACE healthtracker WITH replication = {'class': 'SimpleStrategy', 'replication_factor': 1};

CREATE TABLE healthtracker.record
(
    user_id     int,
    type        int,
    until_time  timestamp,
    from_time   timestamp,
    value       float,
    data_source text,
    PRIMARY KEY (user_id, type, until_time, from_time)
);

CREATE TABLE healthtracker.goal
(
    user_id     int,
    creator_id  int,
    type        int,
    created_at  timestamp,
    time_period int,
    value       float,
    PRIMARY KEY (user_id, type, time_period, creator_id, created_at)
)
WITH CLUSTERING ORDER BY (type ASC, time_period ASC, creator_id ASC, created_at DESC);

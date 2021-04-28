CREATE KEYSPACE healthtracker WITH replication = {'class': 'SimpleStrategy', 'replication_factor': 1};

CREATE TABLE healthtracker.record (
  user_id int,
  type int,
  until_time timestamp,
  value float,
  from_time timestamp,
  data_source text,
  PRIMARY KEY (user_id, type, until_time)
);



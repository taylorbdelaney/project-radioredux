use russelzb;

DROP TABLE IF EXISTS radio_redux_test;

CREATE TABLE radio_redux_test (
	title varchar(128) not null,
	artist varchar(128) not null,
	rank int not null,
	year int not null,
	trackID VARCHAR(255) unique not null
);



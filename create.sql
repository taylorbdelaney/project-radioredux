
use delanetc;


DROP TABLE IF EXISTS users;
DROP TABLE IF EXISTS preferences;

CREATE TABLE users (
	id INT not null auto increment,
	registration_date DATE not null,
	first_name VARCHAR(15) not null,
	last_name VARCHAR(15) not null,
	email VARCHAR(255) unique not null,
	password CHAR(40) not null,
	PRIMARY KEY(id),
	CHECK (id > 0 )
	
);

CREATE TABLE preferences (
	user_id INT not null,
	song_year INT not null,
	FOREIGN KEY (user_id) references users(id);

); 


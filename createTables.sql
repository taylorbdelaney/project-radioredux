use russelzb;

drop table if exists preferences;
drop table if exists songs;
drop table if exists users;

create table users (
	id int not null auto_increment,
	first_name varchar(50),
	last_name varchar(50),
	email varchar(50) not null,
	PRIMARY KEY (id),
	CHECK (id>0)
) engine = InnoDB;

create table songs (
	id int not null auto_increment,
	title varchar(50) not null,
	artist varchar(50) not null,
	rank int not null,
	year year(4) not null,
	PRIMARY KEY (id),
	CHECK (id>0),
	CHECK (year <= now())
) engine = InnoDB;

create table preferences (
	id int not null auto_increment,
	user_id int not null,
	song_year year(4) not null,
	PRIMARY KEY (id),
	CHECK (id>0),
	FOREIGN KEY (user_id) references users(id),
	CHECK (year <= now())
) engine = InnoDB;

use delanetc;

-- populate table: users --
insert into users(registration_date, first_name, last_name, email, password) values (NOW(), 'Catherine', 'Little', 'clittlee@yahoo.co.jp', SHA1('tjlXoP'));
insert into users(registration_date, first_name, last_name, email, password) values (NOW(), 'Peter', 'Bishop', 'pbishop12@intel.com', SHA1('Xx25I8'));
insert into users(registration_date, first_name, last_name, email, password) values (NOW(), 'Benjamin', 'Howell', 'bhowell2x@example.com', SHA1('fPiL8Wzv'));

-- populate table: preferences --
insert into preferences(user_id, song_year) values (10, 2010);
insert into preferences(user_id, song_year) values (10, 1970);

insert into preferences(user_id, song_year) values (748, 1987);

insert into preferences(user_id, song_year) values (153, 1993);
insert into preferences(user_id, song_year) values (153, 1996);


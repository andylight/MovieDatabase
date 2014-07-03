--CS143 Project-1B
--AUTHOR:Ali Vala BARBAROS
--create.sql

CREATE TABLE Movie(
	id INT NOT NULL,
	title VARCHAR(100) NOT NULL,
	year INT NOT NULL,
	rating VARCHAR(10),
	company VARCHAR(50),
--movie id must be unique and not null, hence it can be primary key
	PRIMARY KEY (id),
--id must be between 0 and MaxMovieID
	CHECK( id >= 0 AND id <= MaxMovieID(id) ),
--year can't be lower than zero
	CHECK( year > 0 ),
--rating must be one of the MPAA rating below
	CHECK( rating IN ('G','PG','PG-13','R','NC-17','NR') )
) 
--high performance table engine enables foreign key spec
ENGINE=INNODB,
--default encoding is UTF8
CHARACTER SET utf8;


CREATE TABLE Actor(
	id INT NOT NULL,
	last VARCHAR(20),
	first VARCHAR(20),
	sex VARCHAR(6),
	dob DATE,
	dod DATE,
--id can be the primary key for Actor table, since it must be unique and not null
	PRIMARY KEY (id),
--id must be between 0 and MaxPersonID
	CHECK( id >= 0 AND id <= MaxPersonID(id) ),
--gender must be either of them
	CHECK( sex IN ('Male','Female') )
) ENGINE=INNODB,
  CHARACTER SET utf8;


CREATE TABLE Director(
	id INT NOT NULL,
	last VARCHAR(20),
	first VARCHAR(20),
	dob DATE,
	dod DATE,
--id can be the primary key for Director table, since it must be unique and not null
	PRIMARY KEY (id),
--id must be between 0 and MaxPersonID
	CHECK( id >= 0 AND id <= MaxPersonID(id) )
) ENGINE=INNODB,
  CHARACTER SET utf8;


CREATE TABLE MovieGenre(
	mid INT NOT NULL,
	genre VARCHAR(20),
--MovieGenre table cannot contain information on mid that is not in the Movie table id field
	FOREIGN KEY (mid) REFERENCES Movie(id),
--mid must be between 0 and MaxMovieID
	CHECK( mid >= 0 AND mid <= MaxMovieID(id) )
) ENGINE=INNODB,
  CHARACTER SET utf8;


CREATE TABLE MovieDirector(
	mid INT NOT NULL,
	did INT NOT NULL,
--MovieDirector table cannot contain information on mid that is not in the Movie table id field
	FOREIGN KEY (mid) REFERENCES Movie(id),
--MovieDirector table cannot contain information on did that is not in the Director table id field
	FOREIGN KEY (did) REFERENCES Director(id),
--mid must be between 0 and MaxMovieID
	CHECK( mid >= 0 AND mid <= MaxMovieID(id) ),
--did must be between 0 and MaxPersonID
	CHECK( did >= 0 AND did <= MaxPersonID(id) )
) ENGINE=INNODB;


CREATE TABLE MovieActor(
	mid INT NOT NULL,
	aid INT NOT NULL,
	role VARCHAR(50),
--MovieActor table cannot contain information on mid that is not in the Movie table id field
	FOREIGN KEY (mid) REFERENCES Movie(id),
--MovieActor table cannot contain information on aid that is not in the Movie table id field
	FOREIGN KEY (aid) REFERENCES Actor(id),
--mid must be between 0 and MaxMovieID
	CHECK( mid >= 0 AND mid <= MaxMovieID(id) ),
--id must be between 0 and MaxPersonID
	CHECK( aid >= 0 AND aid <= MaxPersonID(id) )
) ENGINE=INNODB,
  CHARACTER SET utf8;


CREATE TABLE Review(
	name VARCHAR(20),
	time TIMESTAMP,
	mid INT NOT NULL,
	rating INT,
	comment VARCHAR(500),
--Review table cannot contain information on mid that is not in the Movie table id field
	FOREIGN KEY (mid) REFERENCES Movie(id),
--rating must be between 0 and 5. 
	CHECK( rating >= 0 AND rating <= 5),
--mid must be between 0 and MaxMovieID
	CHECK( mid >= 0 AND mid <= MaxMovieID(id) )
) ENGINE=INNODB,
  CHARACTER SET utf8;


CREATE TABLE MaxMovieID(
	id INT NOT NULL
) ENGINE=INNODB;


CREATE TABLE MaxPersonID(
	id INT NOT NULL
) ENGINE=INNODB;


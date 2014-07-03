--CS143 Project-1B
--Author:Ali Vala BARBAROS
--load.sql

--Bulk Load Movie Data
LOAD DATA LOCAL INFILE './data/movie.del' INTO TABLE Movie
FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"';

--Bulk Load Actor Data
LOAD DATA LOCAL INFILE './data/actor1.del' INTO TABLE Actor
FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"';

LOAD DATA LOCAL INFILE './data/actor2.del' INTO TABLE Actor
FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"';

LOAD DATA LOCAL INFILE './data/actor3.del' INTO TABLE Actor
FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"';

--Bulk Load Director Data
LOAD DATA LOCAL INFILE './data/director.del' INTO TABLE Director
FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"';

--Bulk Load MovieGenre Data
LOAD DATA LOCAL INFILE './data/moviegenre.del' INTO TABLE MovieGenre
FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"';

--Bulk Load MovieDirector Data
LOAD DATA LOCAL INFILE './data/moviedirector.del' INTO TABLE MovieDirector
FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"';

--Bulk Load MovieActor Data
LOAD DATA LOCAL INFILE './data/movieactor1.del' INTO TABLE MovieActor
FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"';

LOAD DATA LOCAL INFILE './data/movieactor2.del' INTO TABLE MovieActor
FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"';

--Insert MaxMovieID and MaxPersonID tuples according to the specs
INSERT INTO MaxMovieID VALUES(4750);
INSERT INTO MaxPersonID VALUES(69000);




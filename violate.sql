--CS143 Project-1B
--AUTHOR:Ali Vala BARBAROS
--violate.sql


--THREE PRIMARY KEY CONSTRAINTS
--1)id is primary key in Movie
--2)id is primary key in Actor
--3)id is primary key in Director

INSERT INTO Movie VALUES(501,'V for Vendetta',2005,'R','Universal');
--ERROR 1062 (23000): Duplicate entry '501' for key 1

INSERT INTO Actor VALUES(1,'Barbaros','Ali Vala','Male','1453-05-29','');
--ERROR 1062 (23000): Duplicate entry '1' for key 1

INSERT INTO Director VALUES(300,'Barbaros','Ali Vala','1453-05-29','');
--ERROR 1062 (23000): Duplicate entry '300' for key 1



--SIX REFERANTIAL INTEGRITY CONSTRAINTS
--1)MovieGenre mid --> Movie id
--2)MovieDirector mid --> Movie id
--3)MovieDirector did --> Director id
--4)MovieActor mid --> Movie id
--5)MovieActor aid --> Actor id
--6)Review mid --> Movie id

--1)We can not delete any id in Movie table since they reference to MovieGenre mid field.
DELETE FROM Movie WHERE id<330; 
--ERROR 1451 (23000): Cannot delete or update a parent row: a foreign key constraint fails (`CS143/MovieGenre`, CONSTRAINT `MovieGenre_ibfk_1` FOREIGN KEY (`mid`) REFERENCES `Movie` (`id`))
 
--2)We can not update any mid in MovieDirector table since they reference to Movie id field.
UPDATE MovieDirector SET mid = 0;
--ERROR 1452 (23000): Cannot add or update a child row: a foreign key constraint fails (`CS143/MovieDirector`, CONSTRAINT `MovieDirector_ibfk_1` FOREIGN KEY (`mid`) REFERENCES `Movie` (`id`))

--3)We can not update any did in MovieDirector table since they reference to Director id field.
UPDATE MovieDirector SET did = did - 2;
--ERROR 1452 (23000): Cannot add or update a child row: a foreign key constraint fails (`CS143/MovieDirector`, CONSTRAINT `MovieDirector_ibfk_2` FOREIGN KEY (`did`) REFERENCES `Director` (`id`))

--4)We can not update any mid in MovieActor table since they reference to Movie id field.
UPDATE MovieActor SET mid = mid - 1;
--ERROR 1452 (23000): Cannot add or update a child row: a foreign key constraint fails (`CS143/MovieActor`, CONSTRAINT `MovieActor_ibfk_1` FOREIGN KEY (`mid`) REFERENCES `Movie` (`id`))

--5)We can not update any aid in MovieActor table since they reference to Actor id field.
UPDATE MovieActor SET aid = mid - 5;
--ERROR 1452 (23000): Cannot add or update a child row: a foreign key constraint fails (`CS143/MovieActor`, CONSTRAINT `MovieActor_ibfk_2` FOREIGN KEY (`aid`) REFERENCES `Actor` (`id`))

--6)We can not insert any tuple whose mid is inconsistent with Movie id into the Review table.
INSERT INTO Review VALUES ('Despicable me', '2012-02-13', -100, 10, 'Animation Comedy');
--ERROR 1452 (23000): Cannot add or update a child row: a foreign key constraint fails (`TEST/Review`, CONSTRAINT `Review_ibfk_1` FOREIGN KEY (`mid`) REFERENCES `Movie` (`id`))



--THREE CHECK constraints

--1)Check that the Movie id is less than MaxMovieID(id) which is 
INSERT INTO Movie VALUES (4890, 'Dugun Dernek', 2013, 'G', 'Limon Studios');

--2)Check that the Movie rating is valid MPAA rating('G','PG','PG-13','R','NC-17','NR').
INSERT INTO Movie VALUES (11555, 'Recep Ivedik-5', 2014, '+18', 'Pana');

--3)Check that the sex of the actor is either Male or Female
INSERT INTO Actor VALUES (91111, 'ledger', 'Heath','homo','10.10.1984','13.12.2009');





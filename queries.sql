--CS143 Project-1B
--Author:Ali Vala BARBAROS
--queries.sql

--The names of all the actors in the movie 'Die Another Day' in the format:<firstname>+space+<lastname>
--CONCAT_WS doesn't return NULL value even if one of the first or last names is NULL.
--Taking the natural join of the three tables and select the actors' first and last names of the 'Die Another Day' James Bond movie.  
SELECT CONCAT_WS(' ',first,last) AS Actors_of_Die_Another_Day 
FROM Actor,Movie,MovieActor 
WHERE title='Die Another Day' AND Movie.id=mid AND Actor.id=aid;


--The count of all the actors who acted in multiple movies
--Using MovieActor table, all we need to do is just finding actor ids that have more than one movie id matching by using GROUP BY and HAVING statements. Then returning the number of this actor ids.
SELECT COUNT(aid) FROM (SELECT aid FROM MovieActor GROUP BY aid HAVING COUNT(DISTINCT mid) > 1) actorid;


--Who is the most hilarious actress of all times? :)
--A.K.A Find the actress who played in the largest number of comedy movies. Find her name and show the number of comedy films that she has been acted in so far.
--First find the all comedy movies. Then take natural join with Actor, MovieActor. Group by actor id and return COUNT(*) as num_comedy_films. This will give us all the total number of comedy movies played by each actress. However, we cannot use MAX(COUNT(*)).Therefore we can follow this strategy: we begin with writing a query to find all the total number of comedy movies played by each actress,and then nest it as a subquery of a larger query that finds those actresses whose total number of comedy movies is greater than or equal to all the number of comedy movies that played by all actress. This strategy gives us the result that could be produced by MAX(COUNT(*)) if we are able to use it in SQL.  
SELECT aid,first,last,COUNT(*) AS num_comedy_movies 
      FROM Actor,MovieActor,(SELECT mid FROM MovieGenre WHERE genre='Comedy') cmid 
      WHERE MovieActor.mid=cmid.mid  AND Actor.id=aid AND sex='Female' 
      GROUP BY aid
      HAVING num_comedy_movies >=ALL (SELECT COUNT(*) 
		        	      FROM Actor,MovieActor,(SELECT mid FROM MovieGenre WHERE genre='Comedy') cmid
      		        	      WHERE MovieActor.mid=cmid.mid  AND Actor.id=aid AND sex='Female'
      		                      GROUP BY aid);


--ALTERNATIVE APPROACH FOR SAME QUERY:
--First find the all comedy movies. Then take natural join with Actor, MovieActor. Group by actor id and descending order by num_movies.Finally take the top row as our result by LIMIT statement.

--SELECT * 
--FROM (SELECT aid,first,last,COUNT(*) AS num_comedy_movies 
--      FROM Actor,MovieActor,(SELECT mid FROM MovieGenre WHERE genre='Comedy') cmid 
--      WHERE MovieActor.mid=cmid.mid  AND Actor.id=aid AND sex='Female' 
--      GROUP BY aid
--      ORDER BY num_comedy_movies DESC
--      ) last_table
--LIMIT 1;















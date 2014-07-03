ALI VALA BARBAROS
UID:704125620
avbarbaros@cs.ucla.edu

1)Since I used relative reference "query.php" in the action option of the <form> tag ,the only assumption that I made is the file name will remain as "query.php".

3)In web query interface("query.php"), NULL values are filled with "N/A" like in the demo application. 

4)In web query interface("query.php"), if there is a query other than start with "SELECT" and "SHOW" statement(case insensetive), it simply outputs: "Sorry, only SELECT and SHOW queries are allowed!" like in the demo application.

2)All specific explanations are made inside source code files' related lines as comments.

-----------------------------------------------------------------------------------------

There are eight pages in my movie database website:

1.Home				(always shows all the page links at the top of the page and rest of the page is empty)
2.Add Actor/Director		(for adding new actor/director)
3.Add Movie Info		(for adding new movie information)
4.Add Movie/Actor Relation	(for adding movie to actor relation)
5.Add Movie/Director Relation	(for adding movie to director relation)
6.Show Actor Info		(for browsing actor information)
7.Show Movie Info		(for browsing movie information)
8.Search			(for searching Actor/Director/Movie)

-------------------------------------------------------------------------------

1) In Add Actor/Director page, I used drop down list for birthday/date of 
death fields to make sure the dates are valid. User needs to fill everything in 
other than date of death(if not applicable). Otherwise it warns to user to fill 
in the specific empty fields.

2) In Add Movie Info page, I implemented an additional search text box for 
choosing valid director that is recorded in database. If the user changes his/her
mind after selecting one existing director, he/she can change the director later  
by clicking a link near the director's name.

3)Adding actors to a movie process can be done by either selecting the 
Add Movie/Actor Relation page or clicking "Add an Actor!" button below the cast
section of every movie information page. I implemented this additional button
for user convenience. By using this button user does not need to select the 
movie title among thousands of movies from drop down menu. The title of the
movie will be automatically selected, since user comes this page from same
movie's info page. User only needs to select the actor and text the
role.

4)Adding review section is at the bottom of the each movie info page.
If the user doesn't fill in his/her name, it automatically recorded as
Anonymous. I limited the text box field length as 500 characters which is
common in most of the existing web review boxes.

5)After all addition processes, the link for checking the result of addition
process made by user is produced for user's checking convenience. By clicking
this link, user can easily check the results of his/her actions. 
 
5)My search engine is also able to search for Directors other than 
Movies/Actors. I implemented this as a means of checking the directors that  
are added by users later.

6)In multi-words search, the space is interpreted as AND relation.

7)I didn't use any CSS in my web site, because of the time constraint. My web 
site does not look so stylish and actually looks pretty simple. However, it is fully functional and runs effectively.

Thank you. 



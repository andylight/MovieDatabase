<html>
<head><title>CS143 Project 1C</title></head>
<body>
<?php
require($DOCUMENT_ROOT . "./index.php");
?>
<?php
if($_GET["id"]){
	$input = $_GET["id"]; // get ID of movie
	$db = mysql_connect("localhost", "cs143", "");
	if(!$db) {
		$errmsg = mysql_error($db);
		print "Connection failed: $errmsg <br />";
		exit(1);
	}
	mysql_select_db("CS143", $db);

	$m = "SELECT title, rating, year, company 
		FROM Movie M
		WHERE id = '$input'";
	$movie = mysql_query($m, $db);

	$d = "SELECT first, last, dob, id
		FROM Director D, MovieDirector MD
		WHERE MD.mid = '$input' AND MD.did = D.id";
	$director = mysql_query($d, $db);

	$a = "SELECT first, last, dob, id, role
		FROM Actor A, MovieActor MA
		WHERE MA.mid = '$input' AND MA.aid = A.id ORDER BY first, last";
	$actor = mysql_query($a, $db);

	$g = "SELECT genre FROM MovieGenre WHERE mid = '$input'";
	$genre = mysql_query($g, $db);

	$re = "SELECT name, time, mid, rating, comment
		FROM Review WHERE mid = '$input'";
	$review = mysql_query($re, $db);

	$ra = "SELECT AVG(rating) FROM Review WHERE mid = '$input' 
		GROUP BY mid";
	$rating = mysql_query($ra, $db);

	if (($movie && mysql_num_rows($movie) > 0) && 
		$director && $genre){
		$m = mysql_fetch_row($movie);
		
		echo "<h2>---Show Movie info about " .$m[0]. "---</h2>";
		echo "<p>";
		echo "Title: <b>$m[0]</b><br/>";
		echo "Producer: <b>$m[3]</b><br/>";
		echo "MPAA Rating: <b>$m[1]</b><br/>";
		echo "Director: <b> ";
		if (mysql_num_rows($director) > 0) {
			$x=0;
			while ($d = mysql_fetch_row($director)){	
				echo "<a href='./directors.php?id=$d[3]'>$d[0] $d[1]</a> ";
				if($x<mysql_num_rows($director)-1){
					echo "| "; // add a pipe unless it's the last one
					$x++;
				}					
			}
			echo "</b><br/>";
		} else { 
			echo "No Director found! ";	
			echo "</b><br/>";
		}
		echo "Genre: <b>";
		$x=0;
		if ( mysql_num_rows($genre) > 0) {
			while ($g = mysql_fetch_row($genre)){
				echo "$g[0] ";
				if($x<mysql_num_rows($genre)-1){
					echo "| "; // add a pipe unless it's the last one
					$x++;
				}
			}
		} else { echo " - not specified -"; }
		echo "</b><br/>";
		echo "Average rating: <b> ";
		if ($rating && mysql_num_rows($rating) > 0) {
			$avgr = mysql_fetch_row($rating);
			if ($avgr[0] > 0)	
				echo round($avgr[0],1). " point.</b>";
			else echo "No ratings yet! </b>";
		} else { echo "No ratings yet! </b>";}	
		echo "<br/><br/>";
		
		echo "<b>Cast: </b><br>";
		if ($actor && mysql_num_rows($actor) > 0){
			while ($a = mysql_fetch_row($actor)){
				// for each element in that row
				echo "<a href = './actors.php?id=$a[3]'>";
				for($x=0; $x<2; $x++){
					echo " $a[$x]";
				}
				echo "</a> ";
				echo "as \"" .$a[4]. "\"<br/>";
	
			}			
		} else { 
			echo "There's no cast for this movie! <br/>"; 
		} 
		
		echo "</p>";
		// see if they want to add more actors
		echo "<form action=\"./addMovieActorLater.php?movie=\" method=\"GET\">";
		echo "<input type=\"hidden\" name=\"movie\" value =".$input."/>";

		echo "<input type=\"submit\" value=\"Add an actor!\"/>";
		echo "</form>";
		echo "<h2> Reviews: </h2>";
		if ($review && mysql_num_rows($review)>0){
			while($r = mysql_fetch_row($review)){


				echo "<p>In " .$r[1]. " <b>$r[0]</b> said: I rate this movie with score <b>" .$r[3]. " </b>point(s), here is my comment:";

				echo "</br><b>Comment:</b> $r[4]</p>";	
			}
		} else { echo "<p> No reviews currently! </p>" ; }
	} else { echo "<b>Not a valid movie!</b>"; }

?>
<form action="./reviewRate.php?id=" method="GET">
<p>
<input type="hidden" name="id" value ="<?php echo $input; ?>"/>
<input type="submit" value="Add Review!" /></p>
</form>
<?php

	mysql_close($db);
}
?>

<p>
Search for other actors/directors/movies: <br/>
<form action="./search.php" method="POST">
<input type ="hidden" name="clicked" value="yes" />
<input type="text" name="search" placeholder="Search!"/><input type="submit" value="Search" />
</form>
</p>


<p><p><p>
</body>
</html>


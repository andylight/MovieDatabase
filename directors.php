<html>
<head><title>CS143 Project 1C</title></head>
<body>
<?php
require($DOCUMENT_ROOT . "./index.php");
?>

<?php
if($_GET["id"]){
	$input = $_GET["id"]; // director ID

	$db = mysql_connect("localhost", "cs143", "");
	if(!$db) {
		$errmsg = mysql_error($db);
		print "Connection failed: $errmsg <br />";
		exit(1);
	}
	mysql_select_db("CS143", $db);

	$query = "SELECT first, last, dob, dod, sex
		FROM Actor WHERE id = '$input'";

	$query2 = "SELECT first, last, dob, dod
		FROM Director WHERE id = '$input'";

	$movies = "SELECT title, role, mid, year
		FROM MovieActor MA, Movie M
		WHERE MA.aid = '$input' AND MA.mid = M.id ORDER BY year DESC";

	$director = "SELECT title, mid, year
		FROM MovieDirector MD, Movie M
		WHERE MD.did = '$input' AND MD.mid = M.id ORDER BY year DESC";

	$check = mysql_query($query, $db);
	$checkdir = mysql_query($query2, $db);
	$mov = mysql_query($movies, $db);
	$dir = mysql_query($director, $db);

	if (
		($checkdir && mysql_num_rows($checkdir) <= 0)){
		
		echo "<b>Not a valid director id.</b>";
	} else {
		if (($check && mysql_num_rows($check) > 0) || 
			($checkdir && (mysql_num_rows($checkdir) > 0))){
		
			$c = mysql_fetch_row($checkdir);
	
			echo "<h2> Results for: $c[0] $c[1]</h2><p>";
			echo "Name: <b>" .$c[0]. " " .$c[1]. "</b><br/>";
			$dob = date("F d, Y", strtotime($c[2])); // format DOB
			echo "Date of Birth: <b>$dob</b><br/>";
			if ($c[3]) // format the death date
				$dod = date("F d, Y", strtotime($c[3])); 
			echo "Date of Death: <b>$dod</b><br/>"; 
	
		} else { echo "<b>Not a valid director id. </b>"; }
	
		echo "<p><p>";
		echo "<b><u><h4> FILMOGRAPHY:</u> </h4></b>";
		echo "<b> Actor: </b><p>";
	
		if ($mov && mysql_num_rows($mov)>0){
			while ($r = mysql_fetch_row($mov)){
				echo "<a href = './movies.php?id=$r[2]'>";
				echo $r[0]."</a> ";
				echo "as \"" .$r[1]. "\"";
				echo " - " .$r[3]. ". <br/>";
			}
		} else { echo " Not an actor in a movie! "; }
	
		echo "</p><p><p>";
		echo "<b> Director: </b><p>";
	
		if ($dir && mysql_num_rows($dir)>0){
			while ($d = mysql_fetch_row($dir)){
				echo "<a href = './movies.php?id=$d[1]'>";
				echo "$d[0]</a> - $d[2] <br/>";
			}
		} else { echo "Not a director of any movie!"; }
		
		echo "<form action=\"./add.php\" method=\"GET\">";
		echo "<input type=\"hidden\" name=\"type\" value =\"5\"/>";
		echo "<input type=\"hidden\" name=\"did\" value =\"$input\"/>";
		echo "<input type=\"submit\" value=\"Add to a movie!\"/>";
		echo "</form>";	
	}

	mysql_close($db);
}
?>
<p>
Search for other actors/directors/movies: <br/>
<form action="./search.php" method="POST" >
<input type ="hidden" name="clicked" value="yes" />
<input type="text" name="search" placeholder="Search!"/><input type="submit" value="Search" />
</form>
</p>

</body>
</html>


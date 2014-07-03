<html>
<head><title>CS143 Project 1C</title></head>
<body>
<?php
require($DOCUMENT_ROOT . "./index.php");
?>

<?php
if($_POST["search"] && ($_POST["clicked"]=="yes")){

	$rawinput = $_POST["search"]; 	
	$newinput = preg_replace('/\s+/', ' ', $rawinput); 
	$words = explode(" ", $newinput); 
	
	if (str_replace(" ", "", $newinput) == ""){	
		echo "<b><p>Please enter a valid input!</p></b>";
	} 
	else {
		echo "<h2>Search results for $rawinput: </h2>";
	
		$db = mysql_connect("localhost", "cs143", "");
		if(!$db) {
			$errmsg = mysql_error($db);
			print "Connection failed: $errmsg <br />";
			exit(1);
		}
		mysql_select_db("CS143", $db);
	
		$tablename = array(Actor, Director, Movie);
		$queries = array();
	
		$input = array();
		foreach ($words as $w){
			array_push($input, mysql_real_escape_string($w));
		}
		
		$queries[0] = "SELECT DISTINCT first, last, dob, id FROM Actor WHERE";
		$queries[1] = "SELECT DISTINCT first, last, dob, id FROM Director WHERE";
		$queries[2] = "SELECT DISTINCT title, id, year FROM Movie WHERE";
	
		if(sizeof($input) > 1){
			$queries[0] .= " (first='$input[0]' AND last='$input[1]')";
			$queries[1] .= " (first='$input[0]' AND last='$input[1]')";
			$queries[2] .= " (title='$newinput') ";
		}
		else{
			$queries[0] .= " first LIKE '%$input[0]%' OR last LIKE '%$input[0]%'";
			$queries[1] .= " first LIKE '%$input[0]%' OR last LIKE '%$input[0]%'";
			$queries[2] .= " title LIKE '%$newinput%'";
		}

		$queries[0] .= " ORDER BY first, last";
		$queries[1] .= " ORDER BY first, last";
		$queries[2] .= " ORDER BY title";
	
		$index = 0;
		foreach($tablename as $table){
			echo "<h4> $table:</h4>";
			$result = mysql_query($queries[$index], $db);
			if ($result && mysql_num_rows($result)>0){
				echo "<p>";
				while ($row = mysql_fetch_row($result)){
					if ($table == Movie)
						echo "<a href = './movies.php?id=$row[1]'>";
					elseif ($table == Actor)
						echo "<a href = './actors.php?id=$row[3]'>";
					else echo "<a href = './directors.php?id=$row[3]'>";
			

		
					if ($table != Movie)
						echo "$row[0] $row[1]</a>($row[2])";
					
					else 
						echo "$row[0]</a>($row[2])";
					
					echo "<br/>";
				} 
				echo "</p>";
			} else { echo "<p><b> No $table found with \"$rawinput\"</b></p>"; }
			$index++;		
		}
		
		mysql_close($db);
	}


} else {
	
	echo "<h2> Search for actors/directors/movies  </h2>";
	
	if ($_POST["clicked"]=="yes")
		echo "<br/><b> Please enter something to search! <b/><br/>";
}
?>

<p>
<br/>
Search for other actors/directors/movies: <br/>
<form method="POST">
<input type ="hidden" name="clicked" value="yes" />
<input type="text" name="search" placeholder="Search!"/><input type="submit" value="Search" />
</form>
</p>

</body>
</html>



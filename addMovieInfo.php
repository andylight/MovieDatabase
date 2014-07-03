<html>
<head><title>CS143 Project 1C</title></head>
<body>
<?php
require($DOCUMENT_ROOT . "./index.php");
?>
</br>
<p>
<form method="POST">
<h3>Add a new movie: </h3>
<input type="hidden" name="clicked" />
<p><b>Director:

<?php
	if ($_GET["did"] > 1){
		$did = $_GET["did"]; // director ID
		
		 $db = mysql_connect("localhost", "cs143", "");
			if(!$db) {
			 $errmsg = mysql_error($db);
				 print "Connection failed: $errmsg <br />";
				 exit(1);
			}
		mysql_select_db("CS143", $db);
	
		$direct = "SELECT first, last, id FROM Director WHERE id = $did";
	
		$result = mysql_query($direct, $db);
			
		if($result && mysql_num_rows($result) > 0){
			$r = mysql_fetch_row($result);
			echo "<a href='./directors.php?id=$did'><b>$r[0] $r[1]</a> </b> "; 
			echo "(For changing the director click <a href='./addMovieInfo.php'><i>here!</i></a>)</br></br>"; // let the person search again
		}

	} elseif ($_GET["did"] == 1) { 
		echo " <a href='./add.php?type=4'><i>change your mind?</i></a>";
	} else {
?>
<form method="POST">
<input type="text" name="director" placeholder="Search a name!"/>
<input type="hidden" name="clicked" value="dirsearch"/>
<input type="submit" value="Search!" />
</p>
</form>
<?php } 

if ($_POST["director"] && ($_POST["clicked"] == "dirsearch")){
	$raw = $_POST["director"]; 			
	$firstc = substr($raw, 0, 1); 		
	$shortflag = 0; 					
	$lengthflag = 0; 				
	
	if ($firstc == "\\") {
		$shortflag = 1;
		$raw = substr($raw, 1);
	}
	
	$newinput = preg_replace('/\s+/', ' ', $raw); 	
	$input = explode(" ", $newinput); 			
	
	foreach ($input as $w){
		if (strlen($w) < 3)
			$lengthflag = 1;
	}
	
	$dquery = "SELECT DISTINCT first, last, id FROM Director WHERE first LIKE '%$input[0]%'";
	foreach($input as $d){
		$dquery .= " OR first LIKE '%$d%' OR last LIKE '%$d%'";
	}
	$dquery .= " ORDER BY first, last";
	
	if (str_replace(" ", "", $newinput) == ""){
		echo "<b><p>Please enter a valid input!</p></b>";
	} elseif ($lengthflag == 1 && $shortflag == 0) {
		echo "<b><p>Please enter at least 3 characters per word!</p></b>";
		echo "</br> To overwrite this, enter '\\' before your search";
	} else {
	
		 $db = mysql_connect("localhost", "cs143", "");
		  if(!$db) {
			 $errmsg = mysql_error($db);
				print "Connection failed: $errmsg <br />";
				exit(1);
		}
		mysql_select_db("CS143", $db);
		
		$result = mysql_query($dquery, $db);
	
		if ($result && mysql_num_rows($result) > 0){
			echo "<p><b>Your search results:</b> <br/>";
					
			echo "<div style=\"border:1px solid #8D6932;width:250px;height:300px;overflow:auto;overflow-y:scroll;overflow-x:hidden;text-align:left\" ><p>";
			
			while ($r = mysql_fetch_row($result)){
				echo "<a href='./addMovieInfo.php?did=$r[2]'>";
				echo "$r[0] $r[1] </a><br/>";
			} echo "</p></div>";
		} else { echo "No director found, please search again!" ; }
		
		mysql_close($db); 
	}

}

?>
<p><b>Title:</b> <input type="text" maxlength="100" name="title"/><br/></p>
<p><b>Company:</b> <input type="text" maxlength="50" name="company"/><br/></p>
<p><b>Year:</b> <input type="text" name="year"/><br/></p>
<p><b>MPAA Rating:</b> 
<select name="MPAA">
<option value="G">G</option>
<option value="NC-17">NC-17</option>
<option value="PG">PG</option>
<option value="PG-13">PG-13</option>
<option value="R">R</option>
</select></p><br/>

<b>Genre (check all that apply):</b> <br/></br/>
<?php
$genres = array("Action", "Adult", "Adventure", "Animation", "Comedy", "Crime",
		"Documentary", "Drama", "Family", "Fantasy", "Horror", "Musical", "Mystery",
		"Romance", "Sci-Fi", "Short", "Thriller", "War", "Western");

$i=0;			
	foreach ($genres as $gen){
		if($i%5 == 0) echo "<br/>";
		echo "<input type=\"checkbox\" name=\"genre[]\" value=\"$gen\"/> $gen &nbsp&nbsp;";
		$i += 1;
	} 
	echo "</p></div>";
?>
<p><input type="submit" value="Add Movie" name="clicked"/></p>
</form>
</p>


<?php
if ($_GET["did"] && $_POST["title"] && $_POST["company"]
&& $_POST["year"] && $_POST["MPAA"] && is_numeric($_POST["year"])){
	
	$title = $_POST["title"];
	$company = $_POST["company"];
	$year = $_POST["year"];
	$did = $_GET["did"];
	$mpaa = $_POST["MPAA"];
	$temp = array("Action", "Adult", "Adventure", "Animation", "Comedy", "Crime",
		"Documentary", "Drama", "Family", "Fantasy", "Horror", "Musical", "Mystery",
		"Romance", "Sci-Fi", "Short", "Thriller", "War", "Western");
	$genres = array();

	if($year > 2025 || $year <1900){
		echo "Please enter a year between 1900 and 2050. ";
	} else {

	for($x=0;$x<19;$x++){
		if(isset($_POST["genre"][$x]))
			array_push($genres, $_POST["genre"][$x]);
	}
	
		$db = mysql_connect("localhost", "cs143", "");
		if(!$db) {
			$errmsg = mysql_error($db);
			print "Connection failed: $errmsg <br />";
			exit(1);
		} 
		mysql_select_db("CS143", $db);
	
		$midquery = "SELECT id FROM MaxMovieID";
		$midsearch = mysql_query($midquery, $db);
		$midfinished = mysql_fetch_row($midsearch);
		$mid = $midfinished[0];
		
		$addm = "INSERT INTO Movie VALUES($mid, '$title', $year, '$mpaa', '$company')";
		$update = "UPDATE MaxMovieID SET id=id+1";
	
		if ($did > 1)
			$adddir = "INSERT INTO MovieDirector VALUES ($mid, $did)";


		if(mysql_query($addm, $db)){
			mysql_query($adddir, $db);
			echo "<p>New Movie:\"$title\" addition into the database is succesfull!</p>";
			echo "View <a href='./movies.php?id=$mid'>\"$title\"</a></br> ";
	
			foreach($genres as $g){
				mysql_query("INSERT INTO MovieGenre VALUES ($mid, '$g')", $db);
			}
			mysql_query($update, $db);
	
		} else { echo "Error in inserting movie, please try again! "; }
		
		mysql_close($db);
	}

	
} elseif ($_POST["clicked"] && (!$_POST["title"] || !$_POST["company"]
|| !$_POST["year"] || !$_POST["MPAA"] || !is_numeric($_POST["year"]))) {
	echo "<b>";
	if (!$_POST["title"])
		echo "Please enter a title. <br/>";
	if (!$_POST["company"])
		echo "Enter a company! <br/>";
	if (!$_POST["year"])
		echo "Enter a year! <br/>";
	if (!$_POST["MPAA"])
		echo "Enter a valid MPAA rating! <br/>";
	if (!is_numeric($_POST["year"]))
		echo "Enter a valid year! <br/>";
	echo "</b>";
}
?>
</body>
</html>

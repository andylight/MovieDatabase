<html>
<body>

<title>CS 143 Movie Database</title>
<?php
require($DOCUMENT_ROOT . "./index.php");
?>

<?php

	$db_connection = mysql_connect("localhost", "cs143", "");
	if(!$db_connection) {
		$err_msg = mysql_error($db_connection);
		print "Connection failed: $errmsg <br/>";
		exit(1);
	}

	mysql_select_db("CS143", $db_connection);

	$result1 = @mysql_query("SELECT * FROM Director ORDER BY last", $db_connection);

	$result2 = @mysql_query("SELECT title, year, id FROM Movie ORDER BY title", $db_connection);
	

	if(!$result1 || !$result2) {
		$message = "Invalid query: " . mysql_error() . "\n";
		die($message);
	}
?>

<form method="POST">
<table width="950" class="searchtablesm">
	<tr>
		<td><font>
			</br>
			Director:
			<select name="director">
			<?php
			while($row = @mysql_fetch_assoc($result1)) {
				echo "<option value='" . $row['id'] . "'>";
				echo $row['first'] . " " . $row['last'];
				echo "</option>";
			}
			?>
			</option>
			</select>
			<hr/></font>
		</td>
	</tr>
</table>
<p>

<table width="950" class="searchtablesm" >
	<tr>
		<td><font>
			</br>
			Movie:
			<select name="movie">
			<?php
			while($row = @mysql_fetch_assoc($result2)) {
				echo "<option value='" . $row['id'] . "'>";
				echo $row['title'];
				echo "</option>";
			}
			?>
			</option>
			</select>
			<hr/></font>
		</td>
	</tr>
</table>
<p>
<br/>
<p><input type="submit" value="Add Relation" name="clicked"/></p>
</form>

<?php

if($_POST["director"] && $_POST["movie"]){

	$did = $_POST["director"];
	$mid = $_POST["movie"];	

	$db = mysql_connect("localhost", "cs143", "");
	 if(!$db) {
		$errmsg = mysql_error($db);
		 print "Connection failed: $errmsg <br />";
		 exit(1);
	 }
	 
	mysql_select_db("CS143", $db);
	
	
	$relation = "INSERT IGNORE INTO MovieDirector VALUES ($mid, $did)";
	
	if (mysql_query($relation, $db)){
		echo "<p><b><u>Sucessfully added director to movie! </b></u>";
		echo "<br/>View your new relation <a href='./movies.php?id=$mid'>here</a></p>";
		} else { echo "<b>Couldn't add actor to movie!</b>"; }
	

	mysql_close($db);
}


?>



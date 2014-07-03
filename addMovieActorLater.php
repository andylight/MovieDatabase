<html>
<body>

<title>CS 143 Movie Database</title>
<?php
require($DOCUMENT_ROOT . "./index.php");
?>


<?php
if($_GET["movie"]){

	$movieid = $_GET["movie"];
	$movieid = intval($movieid);
	$db_connection = mysql_connect("localhost", "cs143", "");
	if(!$db_connection) {
		$err_msg = mysql_error($db_connection);
		print "Connection failed: $errmsg <br/>";
		exit(1);
	}

	mysql_select_db("CS143", $db_connection);

	$result1 = @mysql_query("SELECT * FROM Actor ORDER BY last", $db_connection);
	$query= "SELECT title, id FROM Movie WHERE id=$movieid";
	$mov = mysql_query($query,$db_connection);
	$r = mysql_fetch_row($mov);

?>
<p><h2>Movie Title:"<?php echo "<a href='./movies.php?id=".$r[1]."'><u>" .$r[0]. "</u></a>";}?>"</h2><br/></p>


<form method="POST">
<table width="950" class="searchtablesm">
	<tr>
		<td><font>
			</br>
			Actor:
			<select name="actor">
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

<br/>
<h4>Role : <input type="text" name="role" maxlength="50"/></h4>
<p><input type="submit" value="Add Relation" name="clicked"/></p>
</form>
<?php

if($_POST["actor"] && $_POST["role"]){
	$aid = $_POST["actor"];
	$mid = intval($_GET["movie"]);	
	$role = $_POST["role"];

	$db = mysql_connect("localhost", "cs143", "");
	 if(!$db) {
		$errmsg = mysql_error($db);
		 print "Connection failed: $errmsg <br />";
		 exit(1);
	 }
	 
	mysql_select_db("CS143", $db);
	
	if (str_replace(" ", "", $role) == ""){
		echo "Please enter a valid role!";
	} else {
	
		$Role = mysql_real_escape_string($role);
	
		$relation = "INSERT IGNORE INTO MovieActor VALUES ($mid, $aid, '$Role')";
	
		if (mysql_query($relation, $db)){
			echo "<p><b><u>Successfully added actor to movie! </b></u>";
			echo "<br/>View the new relation <a href='./movies.php?id=$mid'>here</a></p>";
		} else { echo "<b>Couldn't add actor to movie!</b>"; }
	}

	mysql_close($db);
} elseif ($_POST["clicked"] && !$_POST["role"]){
	echo "<b>Please enter a role!</b>";
}

?>
</body>
</html>

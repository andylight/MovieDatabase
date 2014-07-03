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

	$result = @mysql_query("SELECT title, year, id FROM Movie ORDER BY title", $db_connection);
	if(!$result) {
		$message = "Invalid query: " . mysql_error() . "\n";
		die($message);
	}
?>


<table align="center" width="950" class="searchtablesm" >
	<tr>
		<td align="center"><font>
			<form action="./movies.php" method="GET">
			</br>
			Movie:
			<select name="id">
			<?php
			while($row = @mysql_fetch_assoc($result)) {
				echo "<option value='" . $row['id'] . "'>";
				echo $row['title'];
				echo "</option>";
			}
			?>
			</option>
			</select>
			<input type="submit" value="Search"/>
			</form>
			<hr/></font>
		</td>
	</tr>
</table>
<p>
<br/>
Search another: <br/>
<form action="./search.php" method="POST">
<input type ="hidden" name="clicked" value="yes" />
<input type="text" name="search" placeholder="Search something!"/><input type="submit" value="Search" />
</form>
</p>





</body>
</html> 

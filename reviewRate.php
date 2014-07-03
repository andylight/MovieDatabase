<html>

<body>
<?php
require($DOCUMENT_ROOT . "./index.php");
?>


<?php
if($_GET["id"]){
	$movieid = $_GET["id"];

    $db = mysql_connect("localhost", "cs143", "");
     if(!$db) {
        $errmsg = mysql_error($db);
         print "Connection failed: $errmsg <br />";
         exit(1);
     }

	mysql_select_db("CS143", $db);
	
	$query = "SELECT title, id FROM Movie WHERE id = $movieid";
	$mov = mysql_query($query, $db);	

	if ($mov){
		$r = mysql_fetch_row($mov);
?>
<p>
<form method="post">
<p><h2>Review "<?php echo "<a href='./movies.php?id=$r[1]'><u>" .$r[0]. "</u></a>";?>"</h2><br/></p>
<p>Your Name: <input type="text" name="name" maxlength="20"/><br /></p>
<p>Rating:
<select name="rate">
<option value=5>5 - Excellent</option>
<option value=4>4 - Pretty good</option>
<option value=3>3 - Decent</option>
<option value=2>2 - Poor</option>
<option value=1>1 - Terrible</option>
</select></p>
<p>Your comment: <br/>
<textarea name="cmmt" cols="60" rows="8" maxlength="500"></textarea></p>
Up to  500 characters
<input type="hidden" name="clicked" value="1" />
<p><input type="submit" value="Add Review!"/></p>
</form>
</p>

<?php
	} else { echo "<b>Not a valid movie! </b>"; }
} else { echo "<b>Please search a movie you want to rate!</b>"; } 


if($_GET["id"] && $_POST["clicked"]){

	$tempname = $_POST["name"]; 				
	if($tempname==""){
		$tempname="Anonymous";
	}

	$tempcomment = $_POST["cmmt"]; 				
	$id = $_GET["id"]; 				
	$rate = $_POST["rate"]; 		
	$time = time(); 							
	$mysqldate = date( 'Y-m-d H:i:s', $time );  
	$date = date("Y-m-d", $time); 			

	
    $db = mysql_connect("localhost", "cs143", "");
    if(!$db) {
        $errmsg = mysql_error($db);
        print "Connection failed: $errmsg <br />";
        exit(1);
    }

    mysql_select_db("CS143", $db);

	$name = mysql_real_escape_string($tempname);
	$comment = mysql_real_escape_string($tempcomment);
	
	$query = "INSERT INTO Review VALUES
		('$name', '$mysqldate', $id, $rate, '$comment')";

	if(mysql_query($query, $db)){
		echo "<b>Successful add! Thank you $tempname! </b>";
	} else { echo "<b><p>Could not add to the database. </b></p> ";}

	mysql_close($db);

}


?>
<p>
<br/>
Search another movie to rate: <br/>
<form action="./search.php" method="POST">
<input type ="hidden" name="clicked" value="yes" />
<input type="text" name="search" placeholder="Search Movies!"/><input type="submit" value="Search" />
</form>
</p>

</body>
</html> 



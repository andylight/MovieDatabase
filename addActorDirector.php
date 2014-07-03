<html>
<head><title>CS143 Project 1C</title></head>
<body>
<?php
require($DOCUMENT_ROOT . "./index.php");
?>
</br>
<p>
<form method="POST">
<h3>Add a new actor or director: </h3>
<p><b>First: </b><input type="text" name="first" maxlength="20"/><br/></p>
<p><b>Last: </b><input type="text" name="last" maxlength="20" /><br/></p>
<p><b>Gender: </b><input type="radio" name="sex" value="Male" checked/> Male 
<input type="radio" name="sex" value="Female"/> Female</p>
<p><b>Actor or Director: </b>
<input type="checkbox" name="actcheck"/> Actor
<input type="checkbox" name="dircheck"/> Director </p>
<p><b>Date of Birth: </b>
<select name="dobm"><option value="0"></option>

<?php 
$month = array( '01' => 'January', '02' => 'February', '03' => 'March', '04' => 'April',
		'05' => 'May', '06' => 'June', '07' => 'July', '08' => 'August', 
		'09' => 'September', '10' => 'October', '11' => 'November', '12' => 'December');
foreach ($month as $k => $m) echo "<option value=\"$k\">$m</option>"; 

?>
</select>
<select name="dobd"><option value="0"></option>
<?php for ($x=01;$x<32;$x++) echo "<option value=\"$x\">$x</option>"; ?></select>
<select name="doby"><option value="0"></option>
<?php for ($x=2014;$x>1900;$x--) echo "<option value=\"$x\">$x</option>"; ?></select>
(Month - Day - Year) 
</p>
<p><b>Date of Death (if Applicable): </b>
<select name="dodm"><option value="0"></option>
<?php 	// for each month, add to the option list
foreach ($month as $k => $m) echo "<option value=\"$k\">$m</option>";	?></select>
<select name="dodd"><option value="0"></option>
<?php for ($x=01;$x<32;$x++) echo "<option value=\"$x\">$x</option>"; ?></select>
<select name="dody"><option value="0"></option>
<?php for ($x=2014;$x>1900;$x--) echo "<option value=\"$x\">$x</option>"; ?></select>
(Month - Day - Year) 
</p>

<p><input type="submit" value="Add Person" name="clicked"/></p>
</form>
</p>


<?php
if($_POST["first"] && $_POST["last"] && $_POST["doby"] && $_POST["dobm"] && $_POST["dobd"] &&
(isset($_POST["actcheck"]) || isset($_POST["dircheck"]))){

$firsttemp = $_POST["first"]; 			
$lasttemp = $_POST["last"]; 		
$sex = $_POST["sex"]; 		
$aflag = isset($_POST["actcheck"]); 	
$dflag = isset($_POST["dircheck"]); 

$dobd = $_POST["dobd"]; 			
$dobm = $_POST["dobm"]; 		
$doby = $_POST["doby"]; 	
$dob = "$doby-$dobm-$dobd"; 

$dodd = $_POST["dodd"]; 				
$dodm = $_POST["dodm"]; 			
$dody = $_POST["dody"]; 		
$dod = "$dody-$dodm-$dodd"; 	
$dodflag = 0; 		

$success = 0;

$addactor = ""; 
$adddirector = "";

if ($dodd > 0 && $dodm > 0 && $dody > 9){
	$dodflag = 1; 
}


if (str_replace(" ", "", $firsttemp) == ""){ 
	echo "Please enter a first name! "; 
} elseif (str_replace(" ", "", $lasttemp) == ""){ 
	echo "Please enter a last name! ";
} elseif (($dody>0 && ($dodm==0 || $dodd==0)) ||
			$dodm>0 && ($dody==0 || $dodd==0) ||
			$dodd>0 && ($dody==0 || $dodm==0)){
	echo "Enter a valid death date, or leave it blank! ";
} elseif ($dody != 0 && $dodm != 0 && $dodd != 0 && 
		(strtotime($dod) < strtotime($dob))){ 
	echo "Enter a valid death date! A person can't die before he's born! ";
} elseif (($doby%4!=0 && $dobm == 2 && $dobd > 28) ||
		  ($doby%4==0 && $dobm == 2 && $dobd > 29)) { 
	echo "$dobm - $dobd - $doby is not a valid date!";
} elseif (($dobm==4 || $dobm==6 || $dobm==9 || $dobm==11) && $dobd > 30) {
	echo "$dobm - $dobd - $doby is not a valid date!";
} elseif (($dody%4!=0 && $dodm == 2 && $dodd > 28) ||
		  ($dody%4==0 && $dodm == 2 && $dodd > 29)) { 
	echo "$dodm - $dodd - $dody is not a valid date!";
} elseif (($dodm==4 || $dodm==6 || $dodm==9 || $dodm==11) && $dodd > 30) {
	echo "$dodm - $dodd - $dody is not a valid date!";
} else {

	$db = mysql_connect("localhost", "cs143", "");
	if(!$db) {
		$errmsg = mysql_error($db);
		print "Connection failed: $errmsg <br />";
		exit(1);
	}					
	mysql_select_db("CS143", $db);
	
	$first = mysql_real_escape_string($firsttemp);
	$last = mysql_real_escape_string($lasttemp);
	
	$pidquery = "SELECT id FROM MaxPersonID";
	$pidsearch = mysql_query($pidquery, $db);
	$pidfinished = mysql_fetch_row($pidsearch);
	$pid = $pidfinished[0];

	if ($dodflag == 0)
		$addactor = "INSERT INTO Actor VALUES ($pid, '$last', '$first', '$sex', '$dob', NULL)";
	else	 
		$addactor = "INSERT INTO Actor VALUES ($pid, '$last', '$first', '$sex', '$dob', '$dod')";

	if($dodflag == 0)	
		$adddirector = "INSERT INTO Director VALUES ($pid, '$last', '$first', '$dob', NULL)";
	else
		$adddirector = "INSERT INTO Director VALUES ($pid, '$last', '$first', '$dob', '$dod')";

		
	echo "<p>";
	if($aflag){
		if (mysql_query($addactor, $db)){
		echo "Successfully added $firsttemp $lasttemp as an actor. ";
		echo "View your profile <a href='./actors.php?id=$pid'>here</a><br/>";
		$success = 1;
		} else { echo "Adding actor unsuccessful. "; }
	} 
	
	if($dflag){
		if (mysql_query($adddirector, $db)){
		echo "Successfully added $firsttemp $lasttemp as a director. ";
		echo "View your profile <a href='./directors.php?id=$pid'>here</a><br/> ";
			$success = 1;
			} else { echo "Adding director unsuccessful. "; }
		} 
		
		if($success==1)
			mysql_query("UPDATE MaxPersonID SET id=id+1", $db);

		echo "</p>";



		mysql_close($db);
	}
}
elseif ($_POST["clicked"] && (!$_POST["first"] || !$_POST["last"] || 
		$_POST["doby"]=="0" || $_POST["dobm"]=="0" || $_POST["dobd"]=="0" || 
		(!isset($_POST["actcheck"]) && !isset($_POST["dircheck"])))){
		
	echo "<b>";
	if (!$_POST["first"])
		echo "Please enter a first name! <br/>";
	if (!$_POST["last"])
		echo "Please enter a last name! <br/>";
	if (!isset($_POST["actdir"][0]) && !isset($_POST["actdir"][1]))
		echo "Please choose whether you want to add a director or actor. <br/>";
	if ($_POST["doby"]=="0" || $_POST["dobm"]=="0" || $_POST["dobd"]=="0")
		echo "Please enter a valid birthday! <br/>";
	echo "</b>";
}

?>
</body>
</html>

<?php

require_once ("functions.php");

if(!session_id()) session_start();
				
include_once("global.php");
$current_user = $_SESSION['current_user'];

if ($current_user) {
	header ("location: Space.php");
}

if (!isset($_GET['email'])) {
	 header("location: Home.php");
}

$email = $_GET['email'];
$hash = $_GET['hash'];

$sql = dbConnect();
	
if (!$sql) {die ("Cannot connect to server");}
	
if(!session_id()) {
		header ('Location: home.php');
		return "You're not logged in";
}
	
$email = mysqli_real_escape_string($sql , $email);
$hash = mysqli_real_escape_string($sql , $hash);
	
$sql_ac_check = "SELECT * FROM squareusers WHERE Email='$email' AND Activated='0' AND ActivationCode='$hash';";
$query = mysqli_query ($sql, $sql_ac_check);
$result_no = mysqli_num_rows($query);
		
if (0==$result_no) {
	echo "Activation not completed".$email.$hash;
} else {
	$sql_ac = "UPDATE squareusers SET ActivationCode='', Activated='1' WHERE Email='$email';";		
	$query_ac = mysqli_query ($sql, $sql_ac);
	echo "You're activated";
	header("location: home.php");
}

?>
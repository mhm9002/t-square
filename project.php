<?php

require_once ("functions.php");
require_once ("projFunc.php");

if(!session_id()) session_start();
				
include_once("global.php");
$current_user = $_SESSION['current_user'];

if (!$current_user) {
	header ("location: Home.php");
}

require_once 'header.php';

$sql = dbConnect();

$proj_dir = $_GET['folder'];
$proj_dir = mysqli_real_escape_string($sql , $proj_dir);

$sql_query = "SELECT * FROM squareprojects WHERE Folder='$proj_dir' LIMIT 1";

$query = mysqli_query ($sql, $sql_query);
$projectinfo = mysqli_fetch_assoc($query);	

echo ('<h2>'.$projectinfo['Name'].'</h2>');

$team = getProjectTeam ($projectinfo['ProjectID']);
$packages = getProjectPackages ($projectinfo['ProjectID']);

$teamnames="Team Members<hr>";
$task = "";
$pm = array();

foreach ($team as $member) {
	if ($current_user['ID']==$member['UserID']){$task = $member['Task'];}
	if ($member['Task']=="Project Manager"){ $pm= $member;}
	$teamnames .= '<a href='.$member['Link'].'>'.$member['Name'].'('.$member['Trade'].')</a><br>';
} 

if ($task=="Project Manager"){
	echo('<div id="ProjectTeam" class="container-fluid"><button class="FuncBtn" id="AssignProjTeam--'.$projectinfo['ProjectID'].'">Assign Team Member</button><br>'.
	'<button class="FuncBtn" id="AddProjPackage--'.$projectinfo['ProjectID'].'">Add Package</button><br>');
}

if (!$task=="") {
	echo ('<br>'.$teamnames.'</div>');
} else {
	echo('You\'re not assigned in this project. Please contact the project\'s manager Mr./Ms. <a href="'.$pm['Link'].'">'.$pm['Name'].'</a>');
}
?>
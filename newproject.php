<?php
require_once ('header.php');
require_once ('functions.php');
				
include_once('global.php');
$current_user = $_SESSION['current_user'];


if (isset($_POST['registerProject'])) {
	if (!isset($_POST['ProjectName']) && !isset($_POST['Area'])) {
		return 'Mandatory information still missing';
	} else {
		CreateProject ($_POST['ProjectName'],$_POST['ProjectArea'],$_POST['ProjectLocation'],$_POST['ProjectLot'],$_POST['ProjectStatus'],$current_user['ID']);
	}
}

if(!session_id() || !$current_user) {
		header ('Location: home.php');
		return "You're not logged in";
}

echo "<form action='' method='post'>
			
		<div class='row padded'><a class='col-xs-4'>Project Name:</a> <input class='col-xs-4 input-text' type='text' id='ProjectName' name='ProjectName' placeholder='Enter Project name'></div>
		
		<div class='row padded'><a class='col-xs-4'>Project Area (m2) [roughly]:</a> <input class='col-xs-4 input-text' type='text' id='ProjectArea' name='ProjectArea' placeholder='Enter the rough area of the project'></div>
		
		<div class='row padded'><a class='col-xs-4'>Location:</a><input class='col-xs-4 input-text' type='text' id='ProjectLocation' name='ProjectLocation' placeholder='Enter project Details'></input>
		
		<div class='row padded'><a class='col-xs-4'>Lot No.:</a><input class='col-xs-4 input-text' type='text' id='ProjectLot' name='ProjectLot' placeholder='Enter project lot details (number and area)'></input>
		
		<div class='row padded'><a class='col-xs-4'>Status:</a>
		<select class='col-xs-4' id='ProjectStatus' name='ProjectStatus'>
  			<option value='Not started'>Not Started</option>
  			<option value='In progress'>In progress</option>
  			<option value='Postponed'>Postponed</option>
  			<option value='Terminated'>Terminated</option>
  			<option value='Completed'>Completed</option>
		</select>
		</div>
		
		<input type='submit' class='btn btn-primary' id='registerProject' value='Create Project' name='registerProject'></input>
	
</form>";

	echo('</div>');
require_once 'footer.php';
?>
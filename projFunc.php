<?php
require_once ("functions.php");

function getProjectTeam ($projID){
	$sql = DBconnect();
	
	if (!$sql) {die ("Cannot connect to server");}

	if(!session_id()) {
		header ('Location: home.php');
		return "Please login";
	}
	
	$projID = mysqli_real_escape_string($sql, $projID);
	
	$sql_sel = 	"SELECT * FROM squareprojectteams JOIN squareusers ON squareprojectteams.UserID=squareusers.ID WHERE squareprojectteams.ProjectID='$projID';";
	$sel_result = mysqli_query($sql, $sql_sel);
	$result_no = mysqli_num_rows($sel_result);
	
	$arr = array();
	
	if (0==$result_no) {
		return;
	} else {
		while($row = mysqli_fetch_assoc($sel_result)){$arr[] = $row;}
		return $arr;
	}
}

function getProjectPackages ($projID){
	$sql = DBconnect();
	
	if (!$sql) {die ("Cannot connect to server");}

	if(!session_id()) {
		header ('Location: home.php');
		return "Please login";
	}
	
	$projID = mysqli_real_escape_string($sql, $projID);
	
	$sql_sel = 	"SELECT * FROM squarepackages JOIN squareprojects ON squareprojects.ProjectID=squarepackages.ProjectID WHERE squareprojects.ProjectID='$projID';";
	$sel_result = mysqli_query($sql, $sql_sel);
	$result_no = mysqli_num_rows($sel_result);
	
	$arr = array();
	
	if (0==$result_no) {
		return;
	} elseif (1==$result_no) {
		array_push($arr, mysqli_fetch_assoc($sel_result));
		return $arr;
	} else {
		$arr = mysqli_fetch_assoc($sel_result);
		return $arr;
	}
}

function AssignProjectTeam ($arg){
	$projID = $arg[0];
	$userEmail = $arg[1];
	
	$sql = DBconnect();
	
	if (!$sql) {die ("Cannot connect to server");}

	if(!session_id()) {
		header ('Location: home.php');
		return "Please login";
	}
	
	$projID = mysqli_real_escape_string($sql, $projID);
	$userEmail = mysqli_real_escape_string($sql, $userEmail);
	
	$sql_sel = 	"SELECT * FROM squareusers WHERE Email='$userEmail' LIMIT 1;";
	$sel_result = mysqli_query($sql, $sql_sel);
	$result_no = mysqli_num_rows($sel_result);
	$arr = array();
	
	if (0==$result_no) {
		return "The entered user is not registered";
	} else {
		$user = mysqli_fetch_assoc($sel_result);
	}
	
	$userID = $user['ID'];
	$sql_sel2 = "SELECT * FROM squareprojectteams WHERE ProjectID='$projID' AND UserID='$userID';";
	
	$sel_result2 = mysqli_query($sql, $sql_sel2);
	$result_no2 = mysqli_num_rows($sel_result2);
	
	if (0==$result_no) {
		return "The entered user is already assigned ib this project";
	} else {
		$sql_sel3 = "INSERT INTO squareprojectteams (ProjectID, UserID, Task) VALUES ('$projID', '$userID', 'Project Engineer');";	
		$sel_result3 = mysqli_query($sql, $sql_sel3);
		
		if ($sel_result3) {
			return "The team member assignment completed";
		} else {
			return "Error, member not assigned";
		}
	}
}

?>
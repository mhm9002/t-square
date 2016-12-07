<?php
function dbConnect (){
				
	$dbUser = "root";
	$dbPWD = "";
	$dbHost = "localhost";
	$dbname = "t-squaredb";

	$sql = mysqli_connect($dbHost, $dbUser, $dbPWD, $dbname);

	if (!$sql) {
		die ("Cannot connect to server ". mysqli_connect_error);	
	}
	
	return $sql;

}

function URegister($firstname, $lastname, $pwd, $pwd2, $email, $trade) {
	
	$sql = dbConnect();

	$dn = $firstname ." ". $lastname;
	
	//session_start();

	$dname = mysqli_real_escape_string($sql , $dn);
	$pwd = mysqli_real_escape_string($sql , $pwd);
	$pwd2 = mysqli_real_escape_string($sql , $pwd2);
	$email = mysqli_real_escape_string($sql , $email);
	$activation_key = mysqli_real_escape_string($sql , md5($email));
	$trade = mysqli_real_escape_string($sql , $trade);
	
	$sql_sel = "SELECT ID FROM squareusers WHERE Email='$email' LIMIT 1";
	$sel_result = mysqli_query($sql, $sql_sel);
	
	$arr = mysqli_fetch_assoc($sel_result);
		
	if ($arr) {return "This email is already registered. <a href=\"#\">Press here if you lost your password</a>";}
	
	if ($pwd!=$pwd2) {                                        
		return "The entered passwords are not matching, please make sure they are identical";
		
	} else {
		
		//&& checkPWD($pwd)=='ok' && checkEmail ($email)) { 
	
		$pwd = md5($pwd);
		//$activation_key = md5($activation_key);
		
		
		$sql_rg = "INSERT INTO squareusers (ID, Name, Email, Password, Trade, Privilege, Activated, Link, DateRegistered, ActivationCode) VALUES (NULL, '$dname', '$email', '$pwd', '$trade', 'User' , '0' , '', Now(), '$activation_key');";
		$query = mysqli_query ($sql, $sql_rg);
		
		if ($query) {
				
			sendEmail($email,'activation',$activation_key);
			return "Thanks for your registration. <br>A conformation email has been sent to your email. Please use the provided link to confirm your registration";
		}		
	} 	
}

function logout() {
	if(!session_id()) {
		header ('Location:home.php', true, 301); exit;
		return "You're not logged in";}
	session_destroy();
	return true;
	
}

function login($PWD, $email) {
	
	$sql = dbConnect();
	
	if(session_id()) {
		header ('Location: space.php');
		return "You're already logged in";
	}
	
	session_start();
	
	$sql_sel = "SELECT * FROM squareusers WHERE Email='$email' LIMIT 1";
	$sel_result = mysqli_query($sql, $sql_sel);
	$arr = mysqli_fetch_assoc($sel_result);
	
	if ($arr) {
			
			$row_pass = $arr['Password'];
	
			
			if (md5($PWD) == $row_pass) {
				
				include_once("global.php");
				$_SESSION['current_user'] = $arr;
				
				header ('Location: space.php');
				return "Successful Log in ".$arr['ID'];
			} else {
				return "The entered password is incorrect" ;
			}
	} else {
		return "This email is not registered";
	}
}

function getProjectsByUserID($userID, $filter="Active") {
	
	$sql = dbConnect();
			
	if(!session_id()) {
		header ('Location: home.php');
		return "Please login";
	}
	
	$userID = mysqli_real_escape_string($sql, $userID);
	
	if ($filter == "Active") {
		$sql_sel = 	"SELECT * FROM squareprojects WHERE (Manager='$userID' OR Team='$userID') AND (Status='In progress') ORDER BY DateCreated DESC";
	} else {
		$sql_sel = 	"SELECT * FROM squareprojects WHERE Manager='$userID' OR Team='$userID' ORDER BY DateCreated DESC";
	}
	$sel_result = mysqli_query($sql, $sql_sel);
	$result_no = mysqli_num_rows($sel_result);
	
	$arr = array();
	
	if (0==$result_no) {
		return;
	} else {
		while($row = mysqli_fetch_assoc($sel_result)){ 
			$arr[] = $row;
		}
	}
	return $arr;
}

/*function OpenNewProjectPage(){
		header ('Location: newproject.php');
}*/

function CreateProject ($arg){
	$Name = $arg[0];
	$Area = $arg[1];
	$Location = $arg[2];
	$Lot = $arg[3];
	$Status = $arg[4];
	$ManagerID = $_SESSION['current_user']['ID'];
	
	$sql = dbConnect();
	
	if(!session_id()) {
		header ('Location: home.php');
		return "You're not logged in";
	}
	
	$Name = mysqli_real_escape_string($sql , $Name);
	$Area = mysqli_real_escape_string($sql , $Area);
	$Location = mysqli_real_escape_string($sql , $Location);
	$Lot = mysqli_real_escape_string($sql , $Lot);
	$Status = mysqli_real_escape_string($sql , $Status);
	$ManagerID = mysqli_real_escape_string($sql , $ManagerID);
	
	$foldername = preg_replace("/\s+/","", $Lot)."-".preg_replace("/\s+/","",$Name);
	$Link = 'projects/'. $foldername;
	
	mkdir($Link);
	
	$sql_rg = "INSERT INTO squareprojects (ProjectId, Name, Area, Location, Lot, Link, Folder, Status, DateCreated) VALUES (NULL, '$Name', '$Area', '$Location', '$Lot', '$Link', '$foldername', '$Status' , Now());";
	
	$query = mysqli_query ($sql, $sql_rg);
	
	$projectID = mysqli_insert_id($sql);
	
	$sql_r2 = "INSERT INTO squareprojectteams (ProjectID, UserID, Task) VALUES ('$projectID', '$ManagerID', 'Project Manager');";
	
	$query2 = mysqli_query($sql,$sql_r2);
		
	if ($query) {
		return "Thanks for posting";
		header("Location:project.php?folder=".$foldername);
	} else {
		return "Error not posted";
	}
}

function searchInSite() {
	echo "Search will be launched";

}

function sendEmail ($to, $aim, $hash=""){

switch ($aim){
	case "activation":
		$subject = 'Signup | Verification'; // Give the email a subject 
		$message = '
 
Thanks for signing up!

Your account has been created, before you can login with the entered credentials, you have to activate your account by pressing the url below.
			
	http://localhost/t-square/verify.php?email='.$to.'&hash='.$hash.'
 
Happy surfing,
Localhost-Web
			'; // Our message above including the link

	break;
}
                     
$headers = 'From:noreply@localhost-web.com' . "\r\n"; // Set from headers
mail($to, $subject, $message, $headers); // Send our email
}
?>
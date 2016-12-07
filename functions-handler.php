
<?php

require_once("functions.php");
require_once("projFunc.php");

include_once("global.php");
			
$current_user = $_SESSION['current_user'];
			

if(isset($_POST["func"])) {
    
	$act = $_POST["func"];
    
	$args_no = intval($_POST["arg_no"]);
	
	
	if ($args_no>0) {
		$arg = [];
		$i=1;
		while($i <= $args_no){
				array_push($arg, $_POST["arg".$i]);
				$i++;
		}
	}
	
	switch($act) {
        case 'searchInSite': 
			searchInSite();
			break;
        case 'CreateProject' : 
			CreateProject($arg);
			break;
		case 'logout';
			$l=logout();
			if ($l) {
				error_reporting(E_ALL);
				header ('Location:home.php', true, 301); exit;}
			break;
		case 'AssignProjectTeam':
			AssignProjectTeam ($arg);
			break;
		case 'removePost':
			removePost($arg);
			break;
    }
}

?>

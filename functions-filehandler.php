<?php

require_once("files_func.php");

include("global.php");
			
$current_user = $_SESSION['current_user'];

var_dump($_POST);
print_r($_POST);
print_r($_FILES);

if(isset($_POST['func'])) {
    
    //$param = $_POST['fData'];
    
	$act = $_POST['func'];
    
    $files_no = $_POST['file_no']; 
    
    if ($files_no>0) {
		$files = [];
		$i=1;
		while($i <= $files_no){
				array_push($files, $_FILES["file".$i]);
				$i++;
		}
	}
	
	switch($act) {
		case 'uploadPhoto':
			uploadPhoto ($files);
			break;
    }
}

?>

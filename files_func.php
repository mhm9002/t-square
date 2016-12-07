<?php

require_once("functions.php");

function uploadPhoto($photoFiles) {
	$target_dir = "uploads/";
	
	foreach ($photoFiles as $file) {
		$target_file=$target_dir.basename($file['name']);	
		move_uploaded_file($file['tmp_name'],$target_file);	
	}	
}

?>
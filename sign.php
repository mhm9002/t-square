<script src='\js\functions.js'></script>

<?php

require_once ('functions.php');

$msg="";

if (isset($_POST['login_btn'])) {
		
		$msg = login($_POST['loginPassword'],$_POST['loginEmail']);
	}

	if (@$msg) {
		require_once 'header.php'
		
		?>
		
		<html>
		<div class="container-fluid text-center"><a style="display: block; border-radius: 5px; background-color: #ccc; padding: 0 5% 0 5%;">
		<?php echo $msg; ?></a></div> 
		
		</html>
		
		<?php
	}
?>


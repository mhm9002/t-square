<script src='\js\functions.js'></script>

<?php

require_once ("/inc/functions.php");

$msg="";

if (isset($_POST['send-post'])) {
		
		$msg = Save_post ($_POST['user'],$_POST['post-content']);
	}

	if (@$msg) {
		require_once 'header.php'
		
		?>
		
		<html>
		<div class="container-fluid text-center post"><a class="grey-block">
		<?php echo $msg; ?></a></div> 
		
		</html>
		
		<?php
	}
?>


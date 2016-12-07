<script src='\js\functions.js'></script>

<?php

require_once ("functions.php");

$msg="";

if (isset($_POST['register_btn']) && $_POST['email']!=NULL && $_POST['password']!=NULL && $_POST['password2']!=NULL) {
		
		$msg = URegister ($_POST['first-name'],$_POST['last-name'],$_POST['password'],$_POST['password2'], $_POST['email'], $_POST['trade']);

	if (@$msg) {
		require_once 'header.php'
		
		?>
		<html>
		<div class="container-fluid text-center post"><a class="grey-block">
		<?php echo $msg; ?></a></div> 
	
		</html>
	
		<?php
	}

} else { 
	header("location: Home.php");
}

?>


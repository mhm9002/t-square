<?php

require_once ('header.php');

//if (isset($_post['Register'])) { header ("register.php");}

if(session_id()) {
	require_once('global.php');
	$current_user = $_SESSION['current_user'];

	if (!$current_user) {
		header ("location: space.php");
	}
}

?>

<body><html>

	<form action='register.php' method='post'>
			
		<div class="row padded"><a class="col-xs-4">Fisrt Name:</a> <input class="col-xs-4 input-text" type="text" id="fName" name="first-name" placeholder="Enter name"></div>
		<div class="row padded"><a class="col-xs-4">Last Name:</a> <input class="col-xs-4 input-text" type="text" id="lName" name="last-name" placeholder="Enter name"></div>
		<div class="row padded"><a class="col-xs-4">New Password:</a><input class="col-xs-4 input-text" type="password" id="userPasswd" name="password" placeholder="Enter new password of 6 chars and numbers"></input>
		<div class="row padded"><a class="col-xs-4">Confrim Password:</a><input class="col-xs-4 input-text" type="password" id="userPasswd2" name="password2" placeholder="Enter the same password"></input>
		<a class="col-xs-4" id="pwdStatus">Password Status</a></div>
		<div class="row padded"><a class="col-xs-4">Email:</a><input class="col-xs-4 input-text" type="email" id="userEmail" name="email" placeholder="Enter valid email"></input></div>
		<div class="row padded"><a class="col-xs-4">Trade:</a>
		<select class="col-xs-4" id="userTrade" name="trade">
  			<option value="Architectural">Architectural</option>
  			<option value="Structural">Structural</option>
  			<option value="Mechanical">Mechanical</option>
  			<option value="Electrical">Electrical</option>
  			<option value="PMC">Project Management</option>
		</select>
		</div>
		
		<input type="submit" class="btn btn-primary" id="register" value="Register" name="register_btn"></input>
	
	</form>

	<div id="reg_status"><a class="col-xs-4" id="reg_stat"></a></div>
	
	<form action='sign.php' method='post'>
	
		<h2> Log in:</h2>
		<div class="row padded"><a class="col-xs-4">Email:</a><input class="col-xs-4 input-text" type="email" id="loginEmail" name="loginEmail" placeholder="Enter your email"></input></div>
		<div class="row padded"><a class="col-xs-4">Password:</a><input class="col-xs-4 input-text" type="password" id="loginPasswd" name="loginPassword" placeholder="Enter your password"></input></div>
		
		<input type="submit" class="btn btn-primary" id="login" value="Log in" name="login_btn"></input>
	
	</form>
	
	
</html></body>

<?php

require_once ('footer.php')

?>
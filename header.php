<?php 
	
	/*
		This is the template for the hedaer
		
		@package fs_theme
	*/

require_once ('functions.php');

if (!session_id()) {
	$s_vaild = "hidden";
	
} else {
	$s_vaild= "visible";	
	
	require_once ('global.php');
	
	$current_user = $_SESSION['current_user'];
	
	$userID = $current_user['ID'];
	$userName = $current_user['Name'];	
}
?>

<!DOCTYPE html>

<link href="css/bootstrap.css" rel="stylesheet">
<link href="css/main.css" rel="stylesheet">
<link rel="stylesheet" href="css/icon-font.min.css">
<script src="js/jquery-3.1.1.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/main.js"></script>

<html>

<style>

body { padding-top: 70px; }

.input-text {color: #898989; padding: 0 5% 0 5%; }
.fs-shaded {border-style: solid; border-color: red; border-width: 1px; margin: 5px 10% 5px 10%; text-align: center center;}
.padded {padding: 5px 5% 5px 5%;}

.navbar-default {font-size: 30px; text-shadow: 1px 0.4px 2 #ccc;}

.drpmenu {margin-left: 10px; margin-right: 10px;}

a:hover,
a:focus {text-shadow: 1px 2px 8 #ccc;}

</style>
	


<nav class="navbar navbar-default navbar-fixed-top">
  <div class="container-fluid">
    <div class="navbar-header" style="padding: 0 2% 0 0;">
      <a class="navbar-brand" style="font-size: 30px;" href="space.php"><span class="lnr lnr-crop"></span></a>
    </div>
    <ul class="nav navbar-nav" style="padding: 0 2% 0 0;">
		<li class="active"><a href="#"><span class="lnr lnr-home"></span></a></li>
	</ul>
	
	<!-- Hidden for guests -->
	
	<?php echo "<div style=\"visibility:". $s_vaild.";\">"; ?>
		<ul class="nav navbar-nav" style="padding: 0 2% 0 0;">
		<li><a href="#"><span class="lnr lnr-users"></span></a></li>
 		
 		<!--projects-->
 		
		<li class="dropdown">
			<a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false"><span class="lnr lnr-apartment"></span></a>
			
			<ul class="dropdown-menu" style="width: 300px;">
		
				<!--create project option-->
					
				<li id="newproject-divider" class="divider"></li>
				<li class="drpmenu"><button class="btn btn-primary FuncBtn col-xs-10" id="newproject--">New Project</button></li>
				
			</ul>
		</li> 
		
		<!--search-->
		
		<li class="dropdown">
			<a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false"><span class="lnr lnr-magnifier"></span></a>
		
			<ul class="dropdown-menu">
				<li class="drpmenu"><a class="col-xs-12" style="display: inline;">
				<input class="form-control" id="searchbar" type="search"  placeholder="Search"></input>
				<button class="btn btn-primary FuncBtn" type="submit" id="search--"><span class="lnr lnr-magnifier"></span></button><br>
				</a></li>
			</ul>
		</li> 
    </ul></div>

	<ul class="nav navbar-nav navbar-right" style="<?php echo "visibility:". $s_vaild.";>"; ?>">		
		<li><a href="#"><span class="lnr lnr-alarm"></span></a></li> 
		<li><a href="#"><span class="lnr lnr-user"></span></a></li>
		<li><a style="font-size: 12px; text-align:center center;">Hello, <?php echo $userName; ?></a></li> 
		<li class="dropdown" id="ddm">
		<a class="dropdown-toggle" data-toggle="dropdown" href="#ddm" role="button" aria-haspopup="true" aria-expanded="false"><span class="lnr lnr-menu"></span></a>
		<ul class="dropdown-menu">
			<li class="drpmenu"><a class="FuncBtn" id="logout--"><span class="lnr lnr-exit">Logout</span></a></li>
		</ul></li>
	</ul>
 </div><!--container-fluid-->
</nav>
<body><div id="page-area">
<?php 

require_once ("functions.php");

if(!session_id()) session_start();
				
include_once("global.php");
$current_user = $_SESSION['current_user'];

if (!$current_user) {
	header ("location: Home.php");
}

/* superceeded by header forms
if (isset($_POST['send-post'])) {
		
		$msg = Save_post ($_POST['user'],$_POST['post-content']);
		$_POST['status'] = $msg;
}

if (isset($_POST['log-out'])) {
		
		$msg = logout();

}
*/

require_once 'header.php';

if(!session_id() || !$current_user) {
		header ('Location: home.php');
		return "You're not logged in";
} else {
	$projects = getProjectsByUserID ($current_user['ID']);
	//$posts = get
	for ($i=0; $i<count($projects) && $i<6; $i++){
		$name = $projects[$i]['Name'];
		$link = $projects[$i]['Link'];
					
		echo "<li class=\"drpmenu\"><a href=\"".$link." \" id=\"".$projects[$i]['ProjectID']."\">".	$name."</a></li>";
				}
				

}

//if ($posts) {
	//echo ('<div id="post-area">');
	//foreach ($posts as $post) {
	//	post_content($post);
	//}
	
//}
	echo('</div>');
require_once 'footer.php';
?>


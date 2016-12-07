<?php 

if(!session_id()) session_start();
$current_user = array();
if(!isset($_SESSION['current_user'])) {
    $_SESSION['current_user'] = $current_user;
}

?>
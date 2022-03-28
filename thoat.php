<?php 
	session_start();
	unset($_SESSION['name_user']);
	unset($_SESSION['name_id']);
	unset($_SESSION['login']);
	$_SESSION['logout'] = "";
    header("location: index.php");
 ?>
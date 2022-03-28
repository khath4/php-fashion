<?php 
	session_start();
	require_once __DIR__."/../libraries/Function.php";
	unset($_SESSION['name_admin']);
	unset($_SESSION['admin_id']);
	unset($_SESSION['admin_level']);
	$_SESSION['logout']= "";
	header("location:".base_url()."login/");
 ?>
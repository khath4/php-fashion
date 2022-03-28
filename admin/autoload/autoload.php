<?php 
  	session_start();
  	require_once __DIR__. "/../../libraries/Database.php"; 
  	require_once __DIR__."/../../libraries/Function.php";
  	date_default_timezone_set('Asia/Ho_Chi_Minh');
  	$db= new Database;
  	$connect = mysqli_connect("localhost", "root", "", "thoitrang");  
  	if(!isset($_SESSION['admin_id']))
  	{
  	     header("location: ".base_url()."login/");
  	}
  	define("ROOT", $_SERVER['DOCUMENT_ROOT'] . "/public_html/public/uploads/");
    
?>
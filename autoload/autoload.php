<?php 
	session_start();
	require_once __DIR__. "/../libraries/Database.php"; 
	require_once __DIR__."/../libraries/Function.php";
	date_default_timezone_set('Asia/Ho_Chi_Minh');
    $connect = mysqli_connect("localhost", "root", "", "thoitrang");  
  	$db= new Database;
   
  	define("ROOT", $_SERVER['DOCUMENT_ROOT'] . "/public_html/public/uploads/");

  	$category =$db -> fetchAll('danh_muc');
    
    $sqlcontact = "SELECT * FROM lienhe LIMIT 1";
    $contact = $db -> fetchsql($sqlcontact);
    
  	$sqlNew ="SELECT * FROM san_pham WHERE 1 ORDER BY id DESC LIMIT 4";
  	$sqlNew2 ="SELECT * FROM san_pham WHERE 1 ORDER BY id DESC LIMIT 4,4";
  	$productNew=$db ->fetchsql($sqlNew);
  	$productNew2=$db ->fetchsql($sqlNew2);

    $sqlPay ="SELECT * FROM san_pham WHERE 1 ORDER BY LanBan DESC LIMIT 4";
    $sqlPay2 ="SELECT * FROM san_pham WHERE 1 ORDER BY LanBan DESC LIMIT 4,4";
    $productPay=$db ->fetchsql($sqlPay);
    $productPay2=$db ->fetchsql($sqlPay2);

?>
<?php 
	$open ="adver";
  	require_once __DIR__. "/../../autoload/autoload.php"; 

  	$id = intval(getInput('id'));
    if(isset($_SESSION['admin_id']))
    {
      	$EditAdver= $db-> fetchID("adver" ,$id);
      	if(empty($EditAdver))
      	{
      		$_SESSION['error'] = "Dữ liệu không tồn tại.";
      		redirectAdmin('adver');
      	}
      	$HienThi =$EditAdver['HienThi'] == 0 ? 1 : 0;
    
      	$update = $db-> update("adver", array("HienThi" => $HienThi ),array("id" => $id ));
      	if($update > 0)
        {
            $_SESSION['success'] = "Cập nhật thành công.";
            redirectAdmin('adver');
        }
        else 
        {
    		$_SESSION['error'] = "Dữ liệu không thay đổi.";
    		redirectAdmin('adver');
        }
  	}
?>
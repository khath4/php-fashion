<?php 
	$open ="users";
  	require_once __DIR__. "/../../autoload/autoload.php"; 

  	$id = intval(getInput('id'));
    if(isset($_SESSION['admin_id']))
    {
      	$EditCategory= $db-> fetchID("users" ,$id);
      	if(empty($EditCategory))
      	{
      		$_SESSION['error'] = "Dữ liệu không tồn tại.";
      		redirectAdmin('user');
      	}
      	$status =$EditCategory['TrangThai'] == 0 ? 1 : 0;
    
      	$update = $db-> update("users", array("TrangThai" => $status ),array("id" => $id ));
      	if($update > 0)
        {
            $_SESSION['success'] = "Cập nhật thành công.";
            redirectAdmin('user');
        }
        else 
        {
    		$_SESSION['error'] = "Dữ liệu không thay đổi.";
    		redirectAdmin('user');
        }
    }
?>
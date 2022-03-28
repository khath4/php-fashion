<?php 
	  $open ="category";
  	require_once __DIR__. "/../../autoload/autoload.php"; 

  	$id = intval(getInput('id'));
    if(isset($_SESSION['admin_id']))
    {
      	$EditCategory= $db-> fetchID("danh_muc" ,$id);
      	if(empty($EditCategory))
      	{
      		$_SESSION['error'] = "Dữ liệu không tồn tại.";
      		redirectAdmin('category');
      	}
      	$HienThi =$EditCategory['HienThi'] == 0 ? 1 : 0;
    
      	$update = $db-> update("danh_muc", array("HienThi" => $HienThi ),array("id" => $id ));
      	if($update > 0)
        {
            $_SESSION['success'] = "Cập nhật thành công.";
            redirectAdmin('category');
        }
        else 
        {
    		$_SESSION['error'] = "Dữ liệu không thay đổi.";
    		redirectAdmin('category');
        }
    }
?>
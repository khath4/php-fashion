<?php 
	$open ="banner";
  	require_once __DIR__. "/../../autoload/autoload.php"; 

  	$id = intval(getInput('id'));
    if(isset($_SESSION['admin_id']))
    {
      	$EditBanner= $db-> fetchID("banner" ,$id);
      	if(empty($EditBanner))
      	{
      		$_SESSION['error'] = "Dữ liệu không tồn tại.";
      		redirectAdmin('banner');
      	}
      	$HienThi =$EditBanner['HienThi'] == 0 ? 1 : 0;
    
      	$update = $db-> update("banner", array("HienThi" => $HienThi ),array("id" => $id ));
      	if($update > 0)
        {
            $_SESSION['success'] = "Cập nhật thành công.";
            redirectAdmin('banner');
        }
        else 
        {
    		$_SESSION['error'] = "Dữ liệu không thay đổi.";
    		redirectAdmin('banner');
        }
    }
?>
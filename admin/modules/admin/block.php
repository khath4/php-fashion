<?php 
	$open ="admin";
  	require_once __DIR__. "/../../autoload/autoload.php"; 

  	$id = intval(getInput('id'));

  	$Editadmin= $db-> fetchID("admin" ,$id);
  	if(isset($_SESSION['admin_id']) && $_SESSION['admin_level'] >= 2)
  	{
  	    if(($_SESSION['admin_id']) && ($Editadmin['id'] != $_SESSION['admin_id']))
  	    {
  	       	$status =$Editadmin['TrangThai'] == 0 ? 1 : 0;

            $update = $db-> update("admin", array("TrangThai" => $status ),array("id" => $id ));
            if($update > 0)
            {
                $_SESSION['success'] = "Cập nhật thành công.";
                redirectAdmin('admin');
            }
            else 
            {
            	$_SESSION['error'] = "Dữ liệu không thay đổi.";
        		redirectAdmin('admin');
            }   
  	    }
  	    else
  	    {
  	        $_SESSION['error'] = "Bạn không thể thực hiện chức năng này.";
            redirectAdmin('admin');
  	    }
  	}
  	else
  	{
  	    $_SESSION['error'] = "Bạn không thể thực hiện chức năng này với người cùng cấp bậc hoặc lớn hơn bạn.";
        redirectAdmin('admin');
  	}
            
  	if(empty($Editadmin))
  	{
  		$_SESSION['error'] = "Dữ liệu không tồn tại.";
  		redirectAdmin('admin');
  	}
  
?>
<?php 
	$open ="brands";
  	require_once __DIR__. "/../../autoload/autoload.php"; 

  	$id = intval(getInput('id'));
    if(isset($_SESSION['admin_id']))
    {
      	$EditBrands= $db-> fetchID("thuong_hieu" ,$id);
      	if(empty($EditBrands))
      	{
      		$_SESSION['error'] = "Dữ liệu không tồn tại.";
      		redirectAdmin('brands');
      	}
      	$home =$EditBrands['HienThi'] == 0 ? 1 : 0;
    
      	$update = $db-> update("thuong_hieu", array("HienThi" => $home ),array("id" => $id ));
      	if($update > 0)
        {
            $_SESSION['success'] = "Cập nhật thành công.";
            redirectAdmin('brands');
        }
        else 
        {
    		$_SESSION['error'] = "Dữ liệu không thay đổi.";
    		redirectAdmin('brands');
        }
    }
?>
<?php 
 	$open ="adver";
  	require_once __DIR__. "/../../autoload/autoload.php"; 

  	$id = intval(getInput('id'));
    if(isset($_SESSION['admin_id']))
  	{
      	$EditSize= $db-> fetchID("adver" ,$id);
        //Bắt lổi xóa danh mục đã có sản phẩm
       
        $num =$db ->delete("adver" ,$id);
        if($num > 0)
        {
           $_SESSION['success'] = "Xóa thành công.";
           redirectAdmin('adver');
        }
        else 
        {
           $_SESSION['error'] = "Xóa không thành công.";
           redirectAdmin('adver');
        }
    
      	if(empty($EditSize))
      	{
      		$_SESSION['error'] = "Dữ liệu không tồn tại.";
      		redirectAdmin('adver');
      	}
  	}

  	
?>
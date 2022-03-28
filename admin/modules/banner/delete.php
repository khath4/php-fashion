<?php 
 	$open ="banner";
  	require_once __DIR__. "/../../autoload/autoload.php"; 

  	$id = intval(getInput('id'));
  	if(isset($_SESSION['admin_id']))
  	{
      	$Deletebanner= $db-> fetchID("banner" ,$id);
      	$sql ="SELECT id FROM banner WHERE HienThi = 1 ";
      	$count = count($db-> fetchsql($sql));
        if(empty($Deletebanner))
        {
          	$_SESSION['error'] = "Dữ liệu không tồn tại.";
          	redirectAdmin('banner');
        }
        if($count >= 1)
        {
            	
        	if($Deletebanner['HienThi'] == 1)
        	{
        		$_SESSION['error'] = "Bạn không thể xóa banner đang hiển thị.";
        		redirectAdmin('banner');
        	}
        	else
        	{
        		$num =$db ->delete("banner" ,$id);
    		    if($num > 0)
    		    {
    		      	$_SESSION['success'] = "Xóa thành công.";
    		      	redirectAdmin('banner');
    		    }
    		    else 
    		    {
    		      	$_SESSION['error'] = "Xóa không thành công.";
    		      	redirectAdmin('banner');
    		    }
        	}
        	
        }
        else
        {
        	$_SESSION['error'] = "Số lượng banner hiển thị phải lớn hơn 1 ban mới có thể xóa.";
    	    redirectAdmin('banner');
        }
  	}
   
?>
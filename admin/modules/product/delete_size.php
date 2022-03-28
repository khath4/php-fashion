<?php 
 	$open ="product";
  	require_once __DIR__. "/../../autoload/autoload.php"; 

  	$id = intval(getInput('id'));
    if(isset($_SESSION['admin_id']))
    {
      	$Size= $db-> fetchID("ct_size" ,$id);
    
        $sqldetelesize ="SELECT id,SoLuong,id_SanPham,COUNT(id_SanPham) as sl FROM ct_size WHERE id_SanPham ='".$Size['id_SanPham']."'";
    
        $DeleteSize = $db -> fetchsql($sqldetelesize);
    
        foreach ($DeleteSize as $value) {
        	
        	if($value['sl'] > 1)
    	    {
    	  	
    	    	$delete =$db ->delete("ct_size" ,$id);
    	    	if($delete > 0)
    	    	{
    	    		$_SESSION['success'] = "Xóa thành công.";
    	    		header("Location: edit.php?id=".$value['id_SanPham']);
    	    	}
    	    	else 
    	    	{
    	    		$_SESSION['error'] = "Xóa không thành công.";
    	    		header("Location: edit.php?id=".$value['id_SanPham']);
    	    	}
    	    }
    	    else
    	    {
    	        $_SESSION['error'] = "Sản phẩm phải có ít nhất một thuốc tính, Bạn không thể xóa.";
    	        header("Location: edit.php?id=".$value['id_SanPham']);
    	    }
        }
    }
?>
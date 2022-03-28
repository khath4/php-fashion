<?php 
 	$open ="product";
  	require_once __DIR__. "/../../autoload/autoload.php"; 

  	$id = intval(getInput('id'));
    if(isset($_SESSION['admin_id']))
    {
      	$DeleteProduct= $db-> fetchID("san_pham" ,$id);
        $id_product= $db -> fetchOne("chi_tiet_dh" ," id_SanPham = $id ");
        if($id_product == NULL)
        {
      	   
          $delete_size = $db -> delete_size("ct_size",$id); 
        	$num =$db ->delete("san_pham" ,$id);
        	if($num > 0)
        	{
        		$_SESSION['success'] = "Xóa thành công.";
        		redirectAdmin('product');
        	}
        	else 
        	{
        		$_SESSION['error'] = "Xóa không thành công.";
        		redirectAdmin('product');
        	}
        }
        else
        {
            $_SESSION['error'] = "Sản phẩm đã có đơn hàng,Bạn không thể xóa.";
            redirectAdmin('product');
        }
    
        if(empty($DeleteProduct))
        {
          $_SESSION['error'] = "Dữ liệu không tồn tại.";
          redirectAdmin('product');
        }
    }
?>
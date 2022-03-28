<?php 
 	$open ="users";
  	require_once __DIR__. "/../../autoload/autoload.php"; 

  	$id = intval(getInput('id'));
    if(isset($_SESSION['admin_id']) && $_SESSION['admin_level'] >= 2)
  	{
      	$DeleteAdmin= $db-> fetchID("users" ,$id);
        //Bắt lổi xóa danh mục đã có sản phẩm
        $id_product= $db -> fetchOne("don_hang" ," id_Users = $id ");
        if($id_product == NULL)
        {
          	if(empty($DeleteAdmin))
          	{
          		$_SESSION['error'] = "Dữ liệu không tồn tại.";
          		redirectAdmin('user');
          	}
    
          	$num =$db ->delete("users" ,$id);
          	if($num > 0)
          	{
          		$_SESSION['success'] = "Xóa thành công.";
          		redirectAdmin('user');
          	}
          	else 
          	{
          		$_SESSION['error'] = "Xóa không thành công.";
          		redirectAdmin('user');
          	}
        }
        else
        {
            $_SESSION['error'] = "User đã có đơn hàng, Bạn không thể xóa.";
            redirectAdmin('user');
        }
  	}
  	else
  	{
  	    $_SESSION['error'] = "Bạn không đủ quyền đề thực hiện chức năng.";
        redirectAdmin('user');
  	}
?>
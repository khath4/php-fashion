<?php 
 	  $open ="category";
  	require_once __DIR__. "/../../autoload/autoload.php"; 

  	$id = intval(getInput('id'));
    if(isset($_SESSION['admin_id']))
    {
      	$EditCategory= $db-> fetchID("danh_muc" ,$id);
        //Bắt lổi xóa danh mục đã có sản phẩm
        $id_product= $db -> fetchOne("san_pham" ," id_DanhMuc = $id ");
        if($id_product == NULL)
        {
          $num =$db ->delete("danh_muc" ,$id);
          if($num > 0)
          {
            $_SESSION['success'] = "Xóa thành công.";
            redirectAdmin('category');
          }
          else 
          {
            $_SESSION['error'] = "Xóa không thành công.";
            redirectAdmin('category');
          }
        }
        else
        {
            $_SESSION['error'] = "Danh mục đã có sản phẩm,Bạn không thể xóa.";
            redirectAdmin('category');
        }
      	if(empty($EditCategory))
      	{
      		$_SESSION['error'] = "Dữ liệu không tồn tại.";
      		redirectAdmin('category');
      	}
    }
  	
?>
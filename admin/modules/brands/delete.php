<?php 
 	$open ="brands";
  	require_once __DIR__. "/../../autoload/autoload.php"; 

  	$id = intval(getInput('id'));
    if(isset($_SESSION['admin_id']))
    {
      	$EditBrands= $db-> fetchID("thuong_hieu" ,$id);
        //Bắt lổi xóa danh mục đã có sản phẩm
        $id_product= $db -> fetchOne("san_pham" ," id_ThuongHieu = $id ");
        if($id_product == NULL)
        {
          $num =$db ->delete("thuong_hieu" ,$id);
          if($num > 0)
          {
            $_SESSION['success'] = "Xóa thành công.";
            redirectAdmin('brands');
          }
          else 
          {
            $_SESSION['error'] = "Xóa không thành công.";
            redirectAdmin('brands');
          }
        }
        else
        {
            $_SESSION['error'] = "Thương hiệu đã có sản phẩm, Bạn không thể xóa.";
            redirectAdmin('brands');
        }
      	if(empty($EditBrands))
      	{
      		$_SESSION['error'] = "Dữ liệu không tồn tại.";
      		redirectAdmin('brands');
      	}
    }
  	
?>s
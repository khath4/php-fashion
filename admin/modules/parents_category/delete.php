<?php 
 	  $open ="parents_category";
  	require_once __DIR__. "/../../autoload/autoload.php"; 

  	$id = intval(getInput('id'));
    if(isset($_SESSION['admin_id']))
    {
      	$EditParentsCategory= $db-> fetchID("danh_muc_cha" ,$id);
        //Bắt lổi xóa danh mục đã có sản phẩm
        $id_product= $db -> fetchOne("danh_muc" ," id_DanhMC = $id ");
        if($id_product == NULL)
        {
          $num =$db ->delete("danh_muc_cha" ,$id);
          if($num > 0)
          {
            $_SESSION['success'] = "Xóa thành công.";
            redirectAdmin('parents_category');
          }
          else 
          {
            $_SESSION['error'] = "Xóa không thành công.";
            redirectAdmin('parents_category');
          }
        }
        else
        {
            $_SESSION['error'] = "Danh mục cha đã có danh mục con, Bạn không thể xóa.";
            redirectAdmin('parents_category');
        }
      	if(empty($EditParentsCategory))
      	{
      		$_SESSION['error'] = "Dữ liệu không tồn tại.";
      		redirectAdmin('parents_category');
      	}

    }
?>
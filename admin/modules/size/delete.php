<?php 
 	  $open ="size";
  	require_once __DIR__. "/../../autoload/autoload.php"; 

  	$id = intval(getInput('id'));
    if(isset($_SESSION['admin_id']))
    {
      	$EditSize= $db-> fetchID("size" ,$id);
        //Bắt lổi xóa danh mục đã có sản phẩm
        $id_CtSize= $db -> fetchOne("ct_size" ," id_Size = $id ");
        if($id_CtSize == NULL)
        {
          $num =$db ->delete("size" ,$id);
          if($num > 0)
          {
            $_SESSION['success'] = "Xóa thành công.";
            redirectAdmin('size');
          }
          else 
          {
            $_SESSION['error'] = "Xóa không thành công.";
            redirectAdmin('size');
          }
        }
        else
        {
            $_SESSION['error'] = "Size đã có sản phẩm, Bạn không thể xóa.";
            redirectAdmin('size');
        }
      	if(empty($EditSize))
      	{
      		$_SESSION['error'] = "Dữ liệu không tồn tại.";
      		redirectAdmin('size');
      	}
    }
  	
?>
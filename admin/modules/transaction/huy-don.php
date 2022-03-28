<?php 
  	require_once __DIR__. "/../../autoload/autoload.php"; 
  	$id = intval(getInput('id'));
  	if(isset($_SESSION['admin_id'])){
        if($_SESSION['admin_level'] >= 2) 
        {
          	$EditTransaction= $db-> fetchID("don_hang" ,$id);
        
          	if(empty($EditTransaction))
          	{
          		$_SESSION['error'] = "Dữ liệu không tồn tại.";
          		redirectAdmin('transaction');
          	}
          	if($EditTransaction['TrangThai'] < 3)
            {
                $HuyDon = 1;
              	$update = $db-> update("don_hang", array("HuyDon" => $HuyDon ),array("id" => $id ));
              	
              	if($update > 0)
                {
                  $_SESSION['success'] = "Xóa thành công.";
                  redirectAdmin('transaction');
                }
                else 
                {
                  $_SESSION['error'] = "Xóa không thành công.";
                  redirectAdmin('transaction');
                }
            }
            else
            {
                $_SESSION['error'] = "Đơn hàng hoàn thành, Không thể hủy.";
                redirectAdmin('transaction');
            }
        }
        else
        {
            $_SESSION['error'] = "Bạn không đủ quyền để thực hiện chức năng.";
            redirectAdmin('transaction');
        }
    }

?>

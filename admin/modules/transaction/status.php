<?php 
  	require_once __DIR__. "/../../autoload/autoload.php"; 
  	$id = intval(getInput('id'));

  
    if(isset($_SESSION['admin_id']))
    {
        $EditTransaction= $db-> fetchID("don_hang" ,$id);
      	if(empty($EditTransaction))
      	{
      		$_SESSION['error'] = "Dữ liệu không tồn tại.";
      		redirectAdmin('transaction');
      	}
        if($EditTransaction['TrangThai'] == 3) 
        {
            $_SESSION['error'] = "Đơn hàng đã được xử lý hoàn tất.";
            redirectAdmin('transaction');
        }
        if($EditTransaction['TrangThai'] == 0){
          $TrangThai = 1 ; 
        }
        elseif($EditTransaction['TrangThai'] == 1) {
          $TrangThai = 2 ;
        }
      	else
        {
          $TrangThai = 3 ;
        }
      	$update = $db-> update("don_hang", array("TrangThai" => $TrangThai ),array("id" => $id ));
      	if($update > 0)
        {
            $_SESSION['success'] = "Cập nhật thành công.";
            $sql ="SELECT chi_tiet_dh.*,ct_size.*,ct_size.id as ids,don_hang.TrangThai,san_pham.id as idsp FROM chi_tiet_dh,size,ct_size,san_pham,don_hang WHERE chi_tiet_dh.id_SanPham = san_pham.id and chi_tiet_dh.id_CT_Size = size.id and ct_size.id_SanPham= san_pham.id and ct_size.id_Size =size.id and don_hang.id = chi_tiet_dh.id_DonHang and id_DonHang = $id ";
      	    $Order = $db -> fetchsql($sql);
      		  foreach ($Order as $item) 
                {
      			    $idproduct = intval($item['id_SanPham']);
      			    $San_Pham= $db -> fetchID("san_pham" , $idproduct);
                if($item['TrangThai'] == 3)
                {
                   $up_pro = $db-> update("san_pham", array("LanBan" => $San_Pham['LanBan'] + 1 ),array("id" => $idproduct ));
                }
                if($item['TrangThai'] == 1)
                {
                  $SoLuong =$item['SoLuong'] - $item['SoLuongCT'];
                  $up_pro = $db-> update("ct_size", array("SoLuong" => $SoLuong),array("id" => $item['ids'] ));
                	
      			}
    		}
            redirectAdmin('transaction');
        }
        else 
        {
        		$_SESSION['error'] = "Dữ liệu không thay đổi.";
        		redirectAdmin('transaction');
        }
    }
  	
?>

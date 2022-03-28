<?php 
	require_once __DIR__. "/autoload/autoload.php";
    
    if(!isset($_SESSION['cart']))
    {
        $_SESSION['errorcard'] = "";
        header("location: index.php");   
    }
    
	if(!isset($_SESSION['name_id']))
  	{
        $_SESSION['unlogin']="";  
        header("Location: dang-nhap.php");
  	} 
  	$user = $db -> fetchID("users" , intval($_SESSION['name_id']));

  	if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $data =
    	[
    	    'MaDH' => postInput('MaDH'),
    	    'HoTenNN' =>  postInput('HoTenNN'),
            'DienThoaiNN' =>  postInput('DienThoaiNN'),
            'DiaChiNN' => postInput('DiaChiNN'),
    		'TongDH' => $_SESSION['total'],
    		'id_Users' => $_SESSION['name_id'],
    		'GhiChu' => trim(postInput('GhiChu')),
           
    	];
    	
    	$error=[];
    	
    	if(strlen(postInput('GhiChu'))  > 300 ) 
        {
            $error['GhiChu']="Ghi chú của bạn quá dài."; 
        }
        
        if(empty($error))
  		{
  		    $idtt =$db ->insert("don_hang" ,$data);
        	if ($idtt > 0 ) 
        	{   
        		foreach ($_SESSION['cart'] as $key => $value) 
        		{
        			$data2 =
        			[
        				'id_DonHang' => $idtt,
        				'id_SanPham' => $key,
        				'SoLuongCT' => $value['SoLuong'],
        				'GiaBan' => $value['GiaSP'],
                        'Size_CT' => $value['TenSize'],
                        'id_CT_Size' => $value['idsize']
     			    ];
     			    $id_insert = $db -> insert("chi_tiet_dh",$data2);
        		}
                
        		unset($_SESSION['cart']);
      			unset($_SESSION['total']);
        		header("location: don-hang.php?id=".$_SESSION['name_id']);
                $_SESSION['success'] = "";
        	}

  		}
       
    	
    }
?>
<?php require_once __DIR__. "/layouts/header.php";  ?>	
<?php require_once __DIR__. "/layouts/nav.php";  ?>  
<div class="col-sm-9 padding-right">
   	<h2 class="title text-center">Thanh Toán Đơn Hàng</h2>
    <?php if(isset($_SESSION['error'])) :?>
        <div class="alert alert-danger"><i class="fa fa-times"></i>
        <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
        </div>
    <?php endif; ?>

	<form action="" method="POST" >
	     <div class="form-group">
            <label class="text-primary">Mã hóa đơn</label>
            <input class="form-control" id="MaDH" name="MaDH" type="text" value="<?php echo date("YmdHis") ?>" readonly/>
        </div>
        <div class="form-group">
		    <label class="text-primary">Số Tiền Thanh Toán</label>
		    <input type="text" class="form-control " placeholder="" value="<?php echo formatPrice($_SESSION['total']) ?>" readonly>
	  	</div>
	  	<div class="form-group">
		    <label class="text-primary">Tên Người Nhận(*)</label>
		    <input type="text" class="form-control name-user" name="HoTenNN" aria-describedby="emailHelp" placeholder="Họ Và Tên" value="<?php echo $user['HoTen'] ?>" >
	  	</div>
	  	<div class="form-group">
		    <label class="text-primary">Số Điện Thoại Người Nhận(*)</label>
		    <input type="number" class="form-control" name="DienThoaiNN" placeholder="0364784406" value="<?php echo $user['DienThoai'] ?>" >    
	  	</div>
	  	<div class="form-group">
		    <label class="text-primary">Địa Chỉ Người Nhận (*)</label>
		    <input type="text" class="form-control  name-user" name="DiaChiNN" placeholder="Địa chỉ nơi nhận hàng." value="<?php echo $user['DiaChi']  ?>" >
	  	</div>
	  
	  	<div class="form-group">
            <label class="text-primary" for="GhiChu">Ghi Chú</label>
            <textarea class="form-control" cols="20" id="GhiChu" name="GhiChu" rows="2"></textarea>
        </div>
        <?php if(isset($error['GhiChu'])): ?>
            <p class="text-danger"><i class="fa fa-exclamation"></i> <?php echo $error['GhiChu'] ?></p>
        <?php endif ?>
	  	<button type="submit"  class="btn btn-outline-warning get">Hoàn Tất</button>
	</form>
</div>
</div>
</div>
</section>
	
<?php require_once __DIR__. "/layouts/footer.php";  ?>	
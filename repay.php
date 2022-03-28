<?php 
	require_once __DIR__. "/autoload/autoload.php";
    date_default_timezone_set('Asia/Ho_Chi_Minh');
    $hash_id= getInput('id');
	$id = base64_decode($hash_id);
    
    $repay = $db -> fetchID("don_hang",$id);
	if(!isset($_SESSION['name_id']))
  	{
        $_SESSION['unlogin']="";  
        header("Location: dang-nhap.php");
  	} 
    
    if($repay['id_Users'] == $_SESSION['name_id'])
    {
        if($repay['TrangThaiTT'] == 1)
        {
            $vnp_TmnCode = "L953BKN1"; //Mã website tại VNPAY 
            $vnp_HashSecret = "ESMPRJPSISTFWSBUHLBSDJMRJICGMTML"; //Chuỗi bí mật
            $vnp_Url = "http://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
           
        
          	if($_SERVER["REQUEST_METHOD"] == "POST")
            {
            	$hash_code = base64_encode($id);
            	$vnp_Returnurl = "https://eshopper24h.000webhostapp.com/success.php?id=$hash_code";
            	
                $data = [
            	    "HoTenNN" => postInput('HoTenNN'),
            	    "DienThoaiNN" => postInput('DienThoaiNN'),
            	    "DiaChiNN" => postInput('DiaChiNN'),
            	    "GhiChu" => postInput('GhiChu'),
            	    ];
            	
                $updatepay = $db->update("don_hang",$data,array("id"=>$id));
                
                error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
            
                $vnp_TxnRef = $_POST['order_id']; //Mã đơn hàng. Trong thực tế Merchant cần insert đơn hàng vào DB và gửi mã này sang VNPAY
                
                $vnp_OrderInfo = $_POST['GhiChu'];
                $vnp_OrderType = 'fashion';
                $vnp_Amount = $_POST['amount'] * 100;
                $vnp_Locale = $_POST['language'];
                $vnp_BankCode = $_POST['bank_code'];
                $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];
                
                if (isset($vnp_OrderInfo) && $vnp_OrderInfo == "") {
                     $vnp_OrderInfo =" ";
                }
                
                $inputData = array(
                    "vnp_Version" => "2.0.0",
                    "vnp_TmnCode" => $vnp_TmnCode,
                    "vnp_Amount" => $vnp_Amount,
                    "vnp_Command" => "pay",
                    "vnp_CreateDate" => date('YmdHis'),
                    "vnp_CurrCode" => "VND",
                    "vnp_IpAddr" => $vnp_IpAddr,
                    "vnp_Locale" => $vnp_Locale,
                    "vnp_OrderInfo" => $vnp_OrderInfo,
                    "vnp_OrderType" => $vnp_OrderType,
                    "vnp_ReturnUrl" => $vnp_Returnurl,
                    "vnp_TxnRef" => $vnp_TxnRef,
                );
                
                if (isset($vnp_BankCode) && $vnp_BankCode != "") {
                    $inputData['vnp_BankCode'] = $vnp_BankCode;
                }
                // $inputData['vnp_BankCode'] = "NCB";
                ksort($inputData);
                $query = "";
                $i = 0;
                $hashdata = "";
                foreach ($inputData as $key => $value) {
                    if ($i == 1) {
                        $hashdata .= '&' . $key . "=" . $value;
                    } else {
                        $hashdata .= $key . "=" . $value;
                        $i = 1;
                    }
                    $query .= urlencode($key) . "=" . urlencode($value) . '&';
                }
                
                $vnp_Url = $vnp_Url . "?" . $query;
                if (isset($vnp_HashSecret)) {
                   // $vnpSecureHash = md5($vnp_HashSecret . $hashdata);
                   	$vnpSecureHash = hash('sha256', $vnp_HashSecret . $hashdata);
                    $vnp_Url .= 'vnp_SecureHashType=SHA256&vnp_SecureHash=' . $vnpSecureHash;
                }
                $returnData = array('code' => '00'
                    , 'message' => 'success'
                    , 'data' => $vnp_Url);
                // echo json_encode($returnData);
                header("location: ".$returnData['data']);
        
            }
        }
        else
        {
            $_SESSION['pay']="";  
            header("Location: index.php");   
        }
    }
    else
    {
        header("Location: index.php");
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
    <?php if($repay['id_Users'] == $_SESSION['name_id']): ?>
	<form action="" id="create_form" method="POST" >
	    <div class="form-group">
            <label class="text-primary" for="order_id">Mã Hóa Đơn</label>
            <input class="form-control" id="order_id" name="order_id" type="text" value="<?php echo $repay['MaDH'] ?>"readonly/>
        </div>
        	<div class="form-group">
		    <label class="text-primary" for="amount">Số Tiền</label>
		    <input type="text" class="form-control" id="amount"
name="amount" value="<?php echo round($repay['TongDH'])." VND" ?>" readonly>
	  	</div>
	  	<div class="form-group">
		    <label class="text-primary">Tên Người Nhận</label>
		    <input type="text" class="form-control name-user" name="HoTenNN" aria-describedby="emailHelp" placeholder="Họ Và Tên" value="<?php echo $repay['HoTenNN'] ?>">
	  	</div>
	  	<div class="form-group">
		    <label class="text-primary">Số Điện Thoại Người Nhận</label>
		    <input type="number" class="form-control" name="DienThoaiNN" placeholder="0364784406" value="<?php echo $repay['DienThoaiNN'] ?>">    
	  	</div>
	  	<div class="form-group">
		    <label class="text-primary">Địa Chỉ Người Nhận</label>
		    <input type="text" class="form-control  name-user" name="DiaChiNN" placeholder="Địa chỉ nơi nhận hàng." value="<?php echo $repay['DiaChiNN'] ?>">
	  	</div>
	    <div class="form-group">
            <label class="text-primary" for="language">Ngôn Ngữ</label>
            <select name="language" id="language" class="form-control">
                <option value="vn">Tiếng Việt</option>
                <option value="en">English</option>
            </select>
        </div>
	  	<div class="form-group">
            <label class="text-primary" for="GhiChu">Ghi Chú</label>
            <textarea class="form-control" cols="20" id="GhiChu" name="GhiChu" rows="2"><?php echo $repay['GhiChu'] ?></textarea>
        </div>

	  	<button type="submit"  class="btn btn-outline-warning get">Hoàn Tất</button>
	</form>
	<?php endif; ?>
</div>
</div>
</div>
</section>
	
<?php require_once __DIR__. "/layouts/footer.php";  ?>	
 <link href="https://sandbox.vnpayment.vn/paymentv2/lib/vnpay/vnpay.css" rel="stylesheet"/>
        <script src="https://sandbox.vnpayment.vn/paymentv2/lib/vnpay/vnpay.js"></script>
        <script type="text/javascript">
            $("#btnPopup").click(function () {
                var postData = $("#create_form").serialize();
                var submitUrl = $("#create_form").attr("action");
                $.ajax({
                    type: "POST",
                    url: submitUrl,
                    data: postData,
                    dataType: 'JSON',
                    success: function (x) {
                        if (x.code === '00') {
                            if (window.vnpay) {
                                vnpay.open({width: 768, height: 600, url: x.data});
                            } else {
                                location.href = x.data;
                            }
                            return false;
                        } else {
                            alert(x.Message);
                        }
                    }
                });
                return false;
            });
        </script>   
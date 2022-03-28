<?php 
	require_once __DIR__. "/autoload/autoload.php";
	$vnp_TmnCode = "L953BKN1"; //Mã website tại VNPAY 
    $vnp_HashSecret = "ESMPRJPSISTFWSBUHLBSDJMRJICGMTML"; //Chuỗi bí mật
    $vnp_Url = "http://sandbox.vnpayment.vn/paymentv2/vpcpay.html";

    $vnp_SecureHash = $_GET['vnp_SecureHash'];
    $inputData = array();
    foreach ($_GET as $key => $value) 
    {
        if (substr($key, 0, 4) == "vnp_")
        {
            $inputData[$key] = $value;
        }
    }
    unset($inputData['vnp_SecureHashType']);
    unset($inputData['vnp_SecureHash']);
    ksort($inputData);
    $i = 0;
    $hashData = "";
    foreach ($inputData as $key => $value) {
        if ($i == 1) 
        {
            $hashData = $hashData . '&' . $key . "=" . $value;
        } 
        else 
        {
            $hashData = $hashData . $key . "=" . $value;
            $i = 1;
        }
    }

    //$secureHash = md5($vnp_HashSecret . $hashData);
	$secureHash = hash('sha256',$vnp_HashSecret . $hashData);
	$hash_code= getInput('id');
	$id = base64_decode($hash_code);
	$checkusers= $db -> fetchID("don_hang",$id);
    if ($secureHash == $vnp_SecureHash) {
        if ($_GET['vnp_ResponseCode'] == '00') {
            if(isset($_SESSION['name_id']))
  	        {
        	    if($checkusers['id_Users'] == $_SESSION['name_id'])
        	    {
        	        $updatedh = $db-> update("don_hang", array("TrangThaiTT" => 2),array("id" => $id));
        	    }
        	    
                header("location: index.php");
                $_SESSION['thanhtoan'] = "";
          	}
          	else
          	{
          	    header("location: index.php");    
          	}
        } 
        else 
        {
             $_SESSION['giaodich'] = "";
        }
    } 
    else 
    {
        $_SESSION['chuky'] = "";
    }
    
?>
<?php require_once __DIR__. "/layouts/header.php";  ?>	
<?php require_once __DIR__. "/layouts/nav.php";  ?>  
<div class="col-sm-9 padding-right">
	  <h2 class="title text-center">Thanh Toán Thành Công</h2>
     
</div>
</div>
</div>
</section>
	
<?php require_once __DIR__. "/layouts/footer.php";  ?>	


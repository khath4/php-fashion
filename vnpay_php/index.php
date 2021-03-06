<?php
    require_once __DIR__. "/../autoload/autoload.php";
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
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $now = getdate();
        
        $data =
    	[
    	    'HoTenNN' =>  postInput('HoTenNN'),
            'DienThoaiNN' =>  postInput('DienThoaiNN'),
            'DiaChiNN' => postInput('DiaChiNN'),
    		'TongDH' => $_SESSION['total'],
    		'id_Users' => $_SESSION['name_id'],
    		'GhiChu' => trim(postInput('GhiChu')),
            // 'code' => $date
    	];
       
    	$idtt =$db ->insert("don_hang" ,$data);
    	if ($idtt > 0 ) 
    	{   
            $date = $now["year"] . $now["mon"] . $now["mday"] .$idtt;
            $data3 = ['MaDH' => $date];
            $id_update =$db->update("don_hang",$data3,array("id"=>$idtt));   
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
    		}
            $id_insert = $db -> insert("chi_tiet_dh",$data2);
    		unset($_SESSION['cart']);
  			unset($_SESSION['total']);
    		header("location: don-hang.php?id=".$_SESSION['name_id']);
            $_SESSION['success'] = "";
    	}

    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <meta name="description" content="">
        <meta name="author" content="">
        <title>Thanh To??n ????n H??ng</title>
        <!-- Bootstrap core CSS -->
        <link href="<?php echo base_url() ?>vnpay_php/assets/bootstrap.min.css" rel="stylesheet"/>
        <!-- Custom styles for this template -->
        <link href="<?php echo base_url() ?>vnpay_php/assets/jumbotron-narrow.css" rel="stylesheet">  
        <script src="<?php echo base_url() ?>vnpay_php/assets/jquery-1.11.3.min.js"></script>
    </head>

    <body>

        <div class="container">
            <div class="header clearfix">
                <h3 class="text-muted">THANH TO??N VNPAY</h3>
            </div>
            <h3>Thanh To??n ????n H??ng</h3>
            <div class="table-responsive">
                <form action="<?php echo base_url() ?>vnpay_php/vnpay_create_payment.php" id="create_form" method="post">       

                    <div class="form-group">
                        <label for="language">Lo???i H??ng H??a </label>
                        <select name="order_type" id="order_type" class="form-control">
                            <option value="fashion">Th???i Trang</option>
                            <option value="other">Kh??c - Xem th??m t???i VNPAY</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="order_id">M?? H??a ????n</label>
                        <input class="form-control" id="order_id" name="order_id" type="text" value="<?php echo date("YmdHis") ?>"/>
                    </div>
                    <div class="form-group">
                        <label for="amount">S??? Ti???n</label>
                        <input class="form-control" id="amount"
                               name="amount" type="number" value="<?php echo formatPrice($_SESSION['total']) ?>"/>
                    </div>
                    <div class="form-group">
                        <label for="order_desc">N???i Dung Thanh To??n</label>
                        <textarea class="form-control" cols="20" id="order_desc" name="order_desc" rows="2"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="bank_code">Ng??n H??ng</label>
                        <select name="bank_code" id="bank_code" class="form-control">
                            <option value="">Kh??ng ch???n</option>
                            <option value="NCB"> Ngan hang NCB</option>
                            <option value="AGRIBANK"> Ngan hang Agribank</option>
                            <option value="SCB"> Ngan hang SCB</option>
                            <option value="SACOMBANK">Ngan hang SacomBank</option>
                            <option value="EXIMBANK"> Ngan hang EximBank</option>
                            <option value="MSBANK"> Ngan hang MSBANK</option>
                            <option value="NAMABANK"> Ngan hang NamABank</option>
                            <option value="VNMART"> Vi dien tu VnMart</option>
                            <option value="VIETINBANK">Ngan hang Vietinbank</option>
                            <option value="VIETCOMBANK"> Ngan hang VCB</option>
                            <option value="HDBANK">Ngan hang HDBank</option>
                            <option value="DONGABANK"> Ngan hang Dong A</option>
                            <option value="TPBANK"> Ng??n h??ng TPBank</option>
                            <option value="OJB"> Ng??n h??ng OceanBank</option>
                            <option value="BIDV"> Ng??n h??ng BIDV</option>
                            <option value="TECHCOMBANK"> Ng??n h??ng Techcombank</option>
                            <option value="VPBANK"> Ngan hang VPBank</option>
                            <option value="MBBANK"> Ngan hang MBBank</option>
                            <option value="ACB"> Ngan hang ACB</option>
                            <option value="OCB"> Ngan hang OCB</option>
                            <option value="IVB"> Ngan hang IVB</option>
                            <option value="VISA"> Thanh toan qua VISA/MASTER</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="language">Ng??n Ng???</label>
                        <select name="language" id="language" class="form-control">
                            <option value="vn">Ti???ng Vi???t</option>
                            <option value="en">English</option>
                        </select>
                    </div>

                    <!--<button type="submit" class="btn btn-primary" id="btnPopup">Thanh to??n Popup</button>-->
                    <button type="submit" class="btn btn-primary">Thanh To??n</button>

                </form>
            </div>
            <p>
                &nbsp;
            </p>
            <footer class="footer">
                <p>&copy; VNPAY 2015</p>
            </footer>
        </div>  
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


    </body>
</html>

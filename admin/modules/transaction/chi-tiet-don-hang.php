<?php 
    require_once __DIR__. "/../../autoload/autoload.php"; 
  
	  $id = intval(getInput('id'));

    //$users_id = intval($_SESSION['name_id']);
   	
    $sql="SELECT * FROM don_hang,chi_tiet_dh,users WHERE don_hang.id_Users=users.id AND chi_tiet_dh.id_DonHang=don_hang.id AND don_hang.id = $id ORDER BY chi_tiet_dh.id_DonHang LIMIT 1";

    $transaction =$db -> fetchsql($sql);

    $sql2="SELECT *,san_pham.id as ids FROM don_hang,chi_tiet_dh,san_pham WHERE san_pham.id=chi_tiet_dh.id_SanPham AND chi_tiet_dh.id_DonHang=don_hang.id AND chi_tiet_dh.id_DonHang =$id ORDER BY chi_tiet_dh.id";

    $transaction2 =$db -> fetchsql($sql2);
  
    $sum =0;

    function fetch_data()  
    {  
      $id = intval(getInput('id'));
      $output = '';  
      $connect = mysqli_connect("localhost", "root", "", "thoitrang");
      mysqli_set_charset($connect,"utf8");  
      $sql="SELECT * FROM don_hang,san_pham,chi_tiet_dh,users WHERE don_hang.id_Users=users.id AND chi_tiet_dh.id_SanPham=san_pham.id AND chi_tiet_dh.id_DonHang=don_hang.id AND don_hang.id = $id ORDER BY chi_tiet_dh.id_DonHang LIMIT 1";
      $result = mysqli_query($connect, $sql);
      $sql2="SELECT * FROM don_hang,chi_tiet_dh,san_pham WHERE san_pham.id=chi_tiet_dh.id_SanPham AND chi_tiet_dh.id_DonHang=don_hang.id AND chi_tiet_dh.id_DonHang =$id ORDER BY chi_tiet_dh.id";
      $result2 = mysqli_query($connect, $sql2);
      $sql3="SELECT * FROM don_hang WHERE don_hang.id = $id";
      $result3 = mysqli_query($connect, $sql3);
      while($item = mysqli_fetch_array($result))  
      {       
      $output .= '
        <div class="row">
         <div class="col-xs-12">    
            <p class="text-left">Ngày :'.date('d-m-Y H:i' ,strtotime($item['Created_at'])).'</p>
            <b>Mã Đơn Hàng #'.$item['MaDH'].'</b>
         </div>
           <div class="row invoice-info" > 
               <p class="name-user">Người Nhận :'.$item['HoTen'].'</p>
               <p>Địa Chỉ :'.$item['DiaChi'].'</p>
               <p>Điện Thoại :'.$item['DienThoai'].'</p>
               <p>Email :'.$item['Email'].'</p>                              
            </div>
        </div>
          <table border="0.1" cellspacing="0" cellpadding="3">  
        <tr>  
            <th>Tên Sản Phẩm</th>  
            <th>Size</th>  
            <th>Số Lượng</th>  
            <th>Giá</th> 
            <th>Tổng</th> 
        </tr>
        ';  
      }
      while($item2 = mysqli_fetch_array($result2))  
      {       
      $output .= '
        <tr>  
            <td>'.$item2["TenSP"].'</td>  
            <td>'.$item2["Size_CT"].'</td>  
            <td>'.$item2["SoLuongCT"].'</td>  
            <td>'.formatPrice($item2["GiaBan"]).'</td>
            <td>'.formatPrice($item2['GiaBan'] * $item2['SoLuongCT']).'</td>
        </tr>

      ';  
      }  
      while($item3 = mysqli_fetch_array($result3))  
      {       
      $output .= '
     </table> 
      <div class="row">
         <div class="col-md-12">
            <div class="table-responsive">
              <p>Phí Vận Chuyển: FREE</p>
              <p><b>Thuế VAT:</b> 10%</p>
               <table class="table" >
                  <tbody>
                     <tr>
                        <th style="padding: 12px 0px">Tổng Đơn Hàng:</th>
                        <td><b><i>'.formatPrice($item3['TongDH']).'</i></b></td>
                     </tr>
                  </tbody>
               </table>
            </div>
         </div>
      </div>

      ';  
      }  
      return $output;  
 }  
 if(isset($_POST["generate_pdf"]))  
 {  
      require_once('../TCPDF-main/tcpdf.php');  
      $obj_pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true,'utf-8', false);  
      $obj_pdf->SetCreator(PDF_CREATOR);  
      $obj_pdf->SetTitle("Hóa Đơn Mua Hàng");  
      $obj_pdf->SetHeaderData('', '', PDF_HEADER_TITLE, PDF_HEADER_STRING);  
      $obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));  
      $obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));  
      $obj_pdf->SetDefaultMonospacedFont('helvetica');  
      $obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);  
      $obj_pdf->SetMargins(PDF_MARGIN_LEFT, '10', PDF_MARGIN_RIGHT);  
      $obj_pdf->setPrintHeader(false);  
      $obj_pdf->setPrintFooter(false);  
      $obj_pdf->SetAutoPageBreak(TRUE, 10);  
      $obj_pdf->SetFont('stsongstdlight', '', 11);  
      $obj_pdf->AddPage();  
      $content = '';  
      $content .= '  
      <h1 align="center">Hóa Đơn Mua Hàng E-Shopper24h</h1>
      ';  
      $content .= fetch_data();  
      $obj_pdf->writeHTML($content);  
      $obj_pdf->Output('file.pdf', 'I');  
 }  

?>
<?php require_once __DIR__. "/../../layouts/header.php";  ?>        
    <!-- Begin Page Content -->
    <div class="container-fluid">
        <!-- Page Heading -->
        <h1 class="h3 mb-4 text-gray-800"><p class="text-primary">Hóa Đơn </p></h1>
        <div class="row">
        <div class="col-lg-12">
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo base_url(). 'admin/index.php'?>"><i class="fas fa-fw fa-tachometer-alt"></i>Bảng Điều Khiển</a></li>
                <li class="breadcrumb-item"><a href="<?php echo base_url(). 'admin/modules/transaction/index.php'?>">Danh Sách Đơn Hàng</a></li>
                <li class="breadcrumb-item">Hóa Đơn</li>
              </ol>
            </nav>
            <div class="clearfix">
           <!--  Notification -->
            <?php require_once __DIR__. "/../../../partials/notification.php"; ?>
            </div>
        </div>
     <section class="content content_content" style="width: 70%; margin: auto;">
   	<section class="invoice">
      <div class="col-md-12" align="right">
        <form method="post">  
          <input type="submit" name="generate_pdf" class="btn btn-primary" value="Xuất PDF" />
        </form> 
      </div>
  
      <?php foreach ($transaction as $item): ?>
      <div class="row">
         <div class="col-xs-12">
            <h2 class="page-header">
               <i class="fa fa-globe"></i> E-Shopper24h
            </h2>
            <p class="text-left">Ngày :<?php echo date('d-m-Y H:i' ,strtotime($item['Created_at'])) ?></p>
         </div>
       
      </div>
     
      <div class="row invoice-info" style="border-bottom: 1px solid #85879647">
         <div class="col-sm-4 invoice-col">
            Từ:
            <address>
               <strong>
               	E-Shopper24h
               </strong>
            </address>
         </div>
       
         <div class="col-sm-4 invoice-col">
            Đến : 
            <address>
               <strong class="name-user"><?php echo $item['HoTen'] ?></strong>
               <br>
               <b>Địa Chỉ :</b><?php echo $item['DiaChi'] ?>
               <br>
               <b>Điện Thoại :</b><?php echo $item['DienThoai'] ?>
               <br>
               <b>Email :</b><?php echo $item['Email'] ?>                                
            </address>
         </div>
      
         <div class="col-sm-4 invoice-col">
           
            <b>Mã Đơn Hàng #<?php echo $item['MaDH'] ?></b><br>
         </div>
     
      </div>
  
      <div class="row">
         <div class="col-xs-12 table-responsive">
            <table class="table table-striped">
               <thead>
                  <tr>
                     <th>Tên Sản Phẩm</th>
                     <th>Size</th>
                     <th>Số Lượng</th>
                     <th>Giá</th>
                     <th>Tổng</th>
                  </tr>
               </thead>
               <tbody>
                <?php foreach ($transaction2 as $item): ?>
                  	<tr>
                    	<td><?php echo $item['TenSP'] ?></td>
                        <td><?php echo $item['Size_CT'] ?></td>
                     	<td><?php echo $item['SoLuongCT'] ?></td>
                     	<td><?php echo formatPrice($item['GiaBan']) ?></td>
                     	<td><?php echo formatPrice($item['GiaBan'] * $item['SoLuongCT']) ?></td>
                  </tr>
                  <?php $sum +=  $item['GiaBan'] * $item['SoLuongCT'] ; $_SESSION['tongtien'] = $sum; ?>
                <?php endforeach; ?>
                </tbody>
                <td>
                	<b>Tổng Giá Tiền :</b> <?php echo formatPrice($_SESSION['tongtien']) ?>
                </td>
                <tr>
                  <td><b>Phí Vận Chuyển :</b> FREE</td>
                </tr>
                <tr>
                  <td><b>Thuế VAT :</b> 10%</td>
                </tr>
            </table>
         </div>
      
      </div>
     
      <div class="row">
       
         <div class="col-md-12" style="padding: 12px 0px">
            <p class="lead"></p>
            <div class="table-responsive">
               <table class="table" >
                  <tbody>
                     <tr>
                        <th style="padding: 12px 0px">Tổng Đơn Hàng:</th>
                        <td><b><i><?php echo formatPrice($item['TongDH']) ?></i></b></td>
                     </tr>
                  </tbody>
               </table>
            </div>
         </div>
       
      </div>
      <!-- /.row -->
      <?php endforeach; ?>
      <a href="<?php echo modules('transaction') ?>" class="btn btn-primary btn-sm"><i class="fas fa-angle-double-left"></i></a>
      </section>
    </section>
    </div>
  </div>

<!-- End of Main Content -->
      </div>
<?php require_once __DIR__. "/../..//layouts/footer.php";  ?>

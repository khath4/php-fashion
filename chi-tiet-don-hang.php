<?php 
	  require_once __DIR__. "/autoload/autoload.php"; 
  
	  $id = intval(getInput('id'));

    $transaction= $db -> fetchAll("don_hang");

    $users_id = intval($_SESSION['name_id']);
   	
   $sql="SELECT don_hang.* ,san_pham.TenSP as productname,GiamGia,SoLuongCT,TongDH,san_pham.GiaSP as product_price,chi_tiet_dh.GiaBan as orders_price,don_hang.Created_at as created_at FROM chi_tiet_dh LEFT JOIN don_hang ON chi_tiet_dh.id_DonHang = don_hang.id LEFT JOIN san_pham ON san_pham.id = chi_tiet_dh.id_SanPham LEFT JOIN users ON users.id = don_hang.id_Users WHERE don_hang.id = $id and users.id=$users_id ORDER BY chi_tiet_dh.id_DonHang LIMIT 1";

    $transaction =$db -> fetchsql($sql);

    $sql2="SELECT TenSP,GiamGia,SoLuongCT,TongDH,san_pham.GiaSP as product_price,chi_tiet_dh.id_SanPham,chi_tiet_dh.GiaBan as orders_price,chi_tiet_dh.Size_CT FROM chi_tiet_dh LEFT JOIN don_hang ON chi_tiet_dh.id_DonHang = don_hang.id LEFT JOIN san_pham ON san_pham.id = chi_tiet_dh.id_SanPham WHERE don_hang.id =$id ORDER BY chi_tiet_dh.id";

    $transaction2 =$db -> fetchsql($sql2);

    $sum =0;

?>
<?php require_once __DIR__. "/layouts/header.php";  ?>	
<?php require_once __DIR__. "/layouts/nav.php";  ?>  
<div class="col-sm-9 padding-right">
	  <h2 class="title text-center">Thông Tin Đơn Hàng</h2>
     <?php if(isset($_SESSION['success'])) :?>
        <div class="alert alert-success"><b>Thành Công</b><i class="fa fa-check"></i>
        <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
        </div>
        <a href="index.php" class="btn btn-info get">Tiếp Tục Mua Sắm</a>
    <?php endif; ?>
    <div class="card-header py-3">
          <h4 class="m-0 font-weight-bold text-primary"><i class="fa fa-align-justify"></i><a href="don-hang.php?id=<?php echo $_SESSION['name_id'] ?>"> Đơn hàng của bạn</a></h4>
      </div>
    <section class="content content_content" style="width: 70%; margin: auto;">
   	<section class="invoice">

      <!-- title row -->
      <?php foreach ($transaction as $item): ?>
      <div class="row">
         <div class="col-xs-12">
            <h2 class="page-header">
               <i class="fa fa-globe"></i> E-Shopper
            </h2>
            <p >Ngày : <?php echo date('H:s d-m-Y' ,strtotime($item['created_at'])) ?></p>
         </div>
         <!-- /.col -->
      </div>
      <!-- info row -->
      <div class="row invoice-info">
         <div class="col-sm-4 invoice-col">
            Từ:
            <address>
               <strong>
               	E-Shopper24h
               </strong>
            </address>
         </div>
         <!-- /.col -->
         <div class="col-sm-4 invoice-col">
            Đến:  
            <address>
               <strong class="name-user"><?php echo $item['HoTenNN'] ?></strong>
               <br>
               <b>Địa Chỉ: </b><?php echo $item['DiaChiNN'] ?>
               <br>
               <b>Điện Thoại: </b><?php echo $item['DienThoaiNN'] ?>
               <br>
            </address>
         </div>
         <!-- /.col -->
         <div class="col-sm-4 invoice-col">
            <!-- <b>ID #<?php echo $id ?></b><br> -->
            <b>Mã Đơn Hàng #<?php echo $item['MaDH'] ?></b><br>
         </div>
         <!-- /.col -->
      </div>
      <!-- /.row -->
      <!-- Table row -->
      <div class="row">
         <div class="col-xs-12 table-responsive">
            <table class="table table-striped">
               <thead>
                  <tr>
                      <th>Tên Sản Phẩm</th>
                      <th>ID</th>  
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
                    	<td>#<?php echo $item['id_SanPham'] ?></td>
                        <td><?php echo $item['Size_CT'] ?></td>
                     	<td><?php echo $item['SoLuongCT'] ?></td>           
                     	<td><?php echo formatPrice($item['orders_price']) ?></td>
                     	<td><?php echo formatPrice($item['orders_price'] * $item['SoLuongCT']) ?></td>
                  </tr>
                  <?php $sum +=  $item['orders_price'] * $item['SoLuongCT'] ; $_SESSION['tongtien'] = $sum; ?>
                <?php endforeach; ?>
                </tbody>
                <tr>
                  <td><b>Tổng Giá Tiền:</b> <?php echo formatPrice($_SESSION['tongtien']) ?></td>
                </tr>
                <tr>
                  <td><b>Phí Vận Chuyển:</b> FREE</td>
                </tr>
                <tr>
                  <td><b>Thuế VAT:</b> 10%</td>
                </tr>
            </table>
         </div>
         <!-- /.col -->
      </div>
      <!-- /.row -->
      <div class="row">
         <!-- accepted payments column -->
         <div class="col-md-12">
            <p class="lead"></p>
            <div class="table-responsive">
               <table class="table">
                  <tbody>
                     <tr>
                        <th>Tổng Đơn Hàng:</th>
                        <td><b><?php echo formatPrice($item['TongDH']) ?></b></td>
                     </tr>
                  </tbody>
               </table>
            </div>
         </div>
         <!-- /.col -->
      </div>
      <!-- /.row -->
      <?php endforeach; ?>
   </section>
</section>
</div>
</div>
</div>
</section>
	
<?php require_once __DIR__. "/layouts/footer.php";  ?>	
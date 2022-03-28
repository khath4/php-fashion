<?php 
	require_once __DIR__. "/autoload/autoload.php"; 
    
    $id = intval(getInput('id'));

	$transaction= $db -> fetchAll("don_hang");

    $users_id = intval($_SESSION['name_id']);
    if(isset($_SESSION['name_id']))
    {
        if($id == $users_id){
            $sql="SELECT don_hang.* FROM don_hang LEFT JOIN users ON users.id = don_hang.id_Users WHERE users.id= $users_id ORDER BY id DESC";

            $transaction =$db -> fetchsql($sql);
        }   
        else
        {
          $_SESSION['error'] = "Dữ liệu không tồn tại.";
        }
    }
    else 
    {
        header("location: dang-nhap.php");
    }
?>
<?php require_once __DIR__. "/layouts/header.php";  ?>	
<?php require_once __DIR__. "/layouts/nav.php";  ?>  
				
<div class="col-sm-9 padding-right">
	<h2 class="title text-center">Thông Tin Đơn Hàng</h2>
    <div class="container-fluid">
    <!-- DataTales Example -->
            <?php   if($id == $users_id): ?>
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h4 class="m-0 font-weight-bold text-primary"><i class="fa fa-align-justify"></i><a href="don-hang.php?id=<?php echo $_SESSION['name_id'] ?>"> Đơn hàng của bạn</a></h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th class="text-primary">#</th>
                                    <th class="text-primary">Thông Tin Người Nhận</th>
                                    <th class="text-primary">Tổng</th>
                                    <th class="text-primary">Ghi Chú</th>
                                    <th class="text-primary">Thanh Toán</th>
                                    <th class="text-primary">Trạng Thái</th>
                                    <th class="text-primary">Thao Tác</th>
                                </tr>
                            </thead>
                        
                            <tbody> 
                                <?php foreach ($transaction as $item): ?>
                                <tr>
                                    <td><b><?php echo $item['MaDH'] ?></b></td>
                                    <td class="name-user">
                                        <b>Họ Tên :</b><?php echo $item['HoTenNN'] ?>
                                        <br>
                                        <b>SĐT :</b><?php echo $item['DienThoaiNN'] ?>
                                        <br>
                                        <b>Địa Chỉ :</b><?php echo $item['DiaChiNN'] ?>
                                    </td> 
                                    <td><?php echo formatPrice($item['TongDH']) ?></td> 
                                    <td><?php echo $item['GhiChu'] ?></td>
                                    <td>
                                        <?php if($item['TrangThaiTT'] == 0): ?>
                                            <a class="btn btn-xs btn-success"> Thanh Toán Thường</a>
                                        <?php elseif($item['TrangThaiTT'] == 1 && $item['HuyDon'] == 0): ?>
                                            <a class="btn btn-xs btn-danger" style="margin-bottom:5px"> Thanh Toán Online</a>
                                            <a href="repay.php?id=<?php $hash_id = base64_encode($item['id']);echo $hash_id ?>" class="btn btn-info btn-xs"><i class="fa fa-caret-right"></i> Tiếp Tục</a>
                                        <?php elseif($item['TrangThaiTT'] == 1 && $item['HuyDon'] == 1): ?>
                                            <a class="btn btn-xs btn-danger" style="margin-bottom:5px"> Thanh Toán Online</a> 
                                        <?php else: ?>
                                            <a class="btn btn-xs btn-primary"><i class="fa fa-check"></i> Đã Thanh Toán</a>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                       <?php if($item['TrangThai'] == 0 && $item['HuyDon'] == 0): ?>
                                                <a class="btn btn-xs btn-danger"><i class="fa fa-box-full"></i> <small> Chờ xử lý</small></a>
                                        <?php elseif($item['TrangThai'] == 1 && $item['HuyDon'] == 0):  ?>
                                                <a class="btn btn-xs btn-warning"><i class="fa fa-calendar-check"></i> <small> Đã xử lý</small></a>
                                        <?php elseif($item['TrangThai'] == 2 && $item['HuyDon'] == 0):  ?>
                                                <a class="btn btn-xs btn-primary"><i class="fa fa-shipping-fast"></i><small> Đang giao hàng</small></a>
                                        <?php elseif($item['TrangThai'] == 3 && $item['HuyDon'] == 0):  ?>
                                            <a class="btn btn-xs btn-success"><i class="fa fa-check"></i> <small> Hoàn tất</small></a>
                                        <?php else: ?>
                                            <a class="btn btn-xs btn-danger"><i class="fa fa-times"></i> Đơn Hàng Đã Hủy</a>
                                        <?php endif; ?>
                                    
                                    </td>
                                    <td>
                                        <a href="chi-tiet-don-hang.php?id=<?php echo $item['id'] ?>" class="btn btn-xs btn-info" style="margin-bottom:5px"><i class="fa fa-info"></i> Thông Tin Đơn Hàng</a>
                                        <?php if($item['TrangThai'] == 0 && $item['HuyDon'] == 0 ): ?>
                                            <a onClick="return window.confirm('Bạn có muốn hủy đơn hàng này không?')" href="huy-don-hang.php?id=<?php echo $item['id'] ?>" class="btn btn-xs btn-danger"><small><i class="fa fa-times"></i> Hủy Đơn Hàng</small></a>
                                        <?php endif; ?>
                                    </td>   
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                        <a href="index.php" class="btn btn-info get" style="margin-bottom: 50px">Tiếp Tục Mua Sắm</a> 
                </div>
            </div>
        </div>
    <?php endif; ?>
</section>
	
<?php require_once __DIR__. "/layouts/footer.php";  ?>	
<?php if(isset($_SESSION['success'])) :?>
      <script>
            swal({
              title: "Thông Báo!",
              text: "Lưu thông tin đơn hàng thành công,Chúng tôi sẽ liên hệ với bạn sớm nhất.",
              icon: "success",
            });
      </script>
      <!-- <div class="alert alert-success"><i class="fa fa-check"></i>
      <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
      </div> -->
<?php endif; ?>


<?php if(isset($_SESSION['nodata'])) :?>
      <script>
            swal("Thông Báo!", "Dữ liệu không tồn tại.");
      </script>
      <?php unset($_SESSION['nodata']); ?>
<?php endif; ?>


<?php if(isset($_SESSION['success2'])) :?>
      <script>
            swal("Thông Báo!", "Hủy đơn hàng thành công.");
      </script>
      <?php unset($_SESSION['success2']); ?>
<?php endif; ?>

<?php if(isset($_SESSION['unsuccess'])) :?>
      <script>
            swal("Thông Báo!", "Hủy đơn hàng không thành công.");
      </script>
      <?php unset($_SESSION['unsuccess']); ?>
<?php endif; ?>

<?php if(isset($_SESSION['check'])) :?>
      <script>
            swal("Thông Báo!", "Đơn hàng này đã được hủy.");
      </script>
      <?php unset($_SESSION['check']); ?>
<?php endif; ?>

<?php if(isset($_SESSION['checkpay'])) :?>
      <script>
            swal("Thông Báo!", "Đơn hàng đã thanh toán không thể hủy.");
      </script>
      <?php unset($_SESSION['checkpay']); ?>
<?php endif; ?>

<?php if(isset($_SESSION['checkbox'])) :?>
      <script>
            swal("Thông Báo!", "Đơn hàng đã được xử lý không thể hủy.");
      </script>
      <?php unset($_SESSION['checkbox']); ?>
<?php endif; ?>
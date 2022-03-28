<?php 
    $open = "main";
    require_once __DIR__. "/../../autoload/autoload.php"; 
    
    $year = intval(getInput('year'));
    $month = intval(getInput('month'));
    
    $sqlonline = "SELECT * FROM don_hang WHERE EXTRACT(YEAR FROM Created_at) = $year AND EXTRACT(MONTH FROM Created_at) = $month AND TrangThaiTT = 2 ";
    $online = $db -> fetchsql($sqlonline); 
  
?>
<?php require_once __DIR__. "/../../layouts/header.php";  ?>        
    <!-- Begin Page Content -->
    <div class="container-fluid">
        <!-- Page Heading -->
        <h1 class="h3 mb-4 text-gray-800"><p class="text-primary">Danh Sách Đơn Hàng </p></h1>
        <div class="row">
        <div class="col-lg-12">
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo base_url(). 'admin/index.php'?>"><i class="fas fa-fw fa-tachometer-alt"></i>Bảng Điều Khiển</a></li>
                <li class="breadcrumb-item"><a href="<?php echo base_url(). 'admin/month-online.php?year='.$year.'' ?>">Thu Nhập Năm <?php echo $year ?> (Thanh Toán Online)</a></li>
                <li class="breadcrumb-item">Tháng <?php echo $month ?> (Thanh Toán Online)</li>
              </ol>
            </nav>
            <div class="clearfix">
           <!--  Notification -->
            <?php require_once __DIR__. "/../../../partials/notification.php"; ?>
            </div>
        </div>
        </div>
    </div>

 <div class="container-fluid">
    <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Danh Sách Đơn Hàng</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Mã Đơn Hàng</th>
                                    <th>Thông Tin Người Nhận</th>
                                    <th>Tổng </th>
                                    <th>Ghi Chú</th>
                                    <th>Thanh Toán</th>  
                                    <th>Trạng Thái</th>
                                    <th>Chức Năng</th>
                                </tr>
                            </thead>
                            <tbody> 
                                <?php foreach ($online as $item): ?>
                                <tr>
                                   <td><?php echo $item['id'] ?></td>
                                    <td><b>#<?php echo $item['MaDH'] ?></b></td>
                                    <td class="name-user">
                                        <b> Họ Tên :</b><?php echo $item['HoTenNN'] ?>
                                        <br>
                                        <b> Điện Thoại :</b> <?php echo $item['DienThoaiNN'] ?>
                                        <br>
                                        <b> Địa Chỉ :</b> <?php echo $item['DiaChiNN'] ?>
                                    </td>
                                    <td><?php echo formatPrice($item['TongDH']) ?></td>                        
                                    <td><?php echo $item['GhiChu'] ?></td>
                                    <td>
                                        <?php if($item['TrangThaiTT'] == 0): ?>
                                            <a class="btn btn-xs btn-primary btn-sm text-white"> <small>Thanh Toán Thường</small></a>
                                       <?php elseif($item['TrangThaiTT'] == 1): ?>
                                            <a class="btn btn-xs btn-warning btn-sm text-white"><small> Thanh Toán Online</small></a>
                                       <?php else: ?>
                                            <a class="btn btn-xs btn-success btn-sm text-white"><i class="fas fa-check"></i><small> Đã Thanh Toán</small></a>
                                        <?php endif; ?>	
                                    </td>
                                    <td>
                                    	<?php if($item['TrangThai'] == 0 && $item['HuyDon'] == 0): ?>
												<a href="status.php?id=<?php echo $item['id'] ?>" class="btn btn-danger btn-sm"><i class="fas fa-circle-notch"></i> <small>Chờ xử lý</small></a>
                                    	<?php elseif($item['TrangThai'] == 1 && $item['HuyDon'] == 0):  ?>
												<a href="status.php?id=<?php echo $item['id'] ?>" class="btn btn-warning btn-sm"><i class="fas fa-box-open"></i><small> Đã xử lý</small></a>
                                        <?php elseif($item['TrangThai'] == 2 && $item['HuyDon'] == 0):  ?>
                                                <a href="status.php?id=<?php echo $item['id'] ?>" class="btn btn-primary btn-sm"><small> Đang giao hàng</small></a>
                                        <?php elseif($item['TrangThai'] == 3 && $item['HuyDon'] == 0):  ?>
                                            <a href="status.php?id=<?php echo $item['id'] ?>" class="btn btn-success btn-sm"><i class="fas fa-check"></i> <small>Hoàn tất</small></a>
                                            
                                        <?php else: ?>
                                            <a class="btn btn-xs btn-danger btn-sm text-white"><small><i class="fa fa-times"></i> Đơn Hàng Đã Hủy</small></a>
                                    	<?php endif; ?>
                                    </td>
                                    <td>
                                        <a href="chi-tiet-don-hang.php?id=<?php echo $item['id'] ?>" class="btn btn-primary btn-sm" style="margin-bottom: 5px"><i class="fa fa-align-justify"></i></a>
                                        <a href="chi-tiet.php?id=<?php echo $item['id'] ?>" class="btn btn-info btn-sm" style="margin-bottom: 5px"><i class="fas fa-info-circle"></i></a>
                                        <?php if(isset($_SESSION['admin_id']) && $_SESSION['admin_level'] >= 2): ?> 
                                            <?php if($item['HuyDon'] == 0): ?>
                                                <a onClick="return window.confirm('Bạn có chắc muốn hủy đơn hàng này không?')" href="huy-don.php?id=<?php echo $item['id'] ?>" class="btn btn-danger btn-sm" style="margin-bottom: 5px"><i class="fa fa-times"></i></a>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
<!-- /.container-fluid -->
<?php require_once __DIR__. "/../..//layouts/footer.php";  ?>


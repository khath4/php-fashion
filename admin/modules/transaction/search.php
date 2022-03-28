<?php 
    $open = "transaction";
    require_once __DIR__. "/../../autoload/autoload.php"; 
   
    $search =trim($_GET['search']); 

    $sql="SELECT don_hang.* ,users.HoTen as nameusers ,users.DienThoai as phoneusers, users.DiaChi as addressusers 
    FROM don_hang LEFT JOIN users ON users.id = don_hang.id_USERS WHERE An = 1 AND MaDH LIKE '%$search%' ORDER BY id DESC";

    $transaction =$db -> fetchsql($sql); 
  
?>
<?php require_once __DIR__. "/../../layouts/header.php";  ?>        
    <!-- Begin Page Content -->
    <div class="container-fluid">
        <!-- Page Heading -->
        <h1 class="h3 mb-4 text-gray-800"><p class="text-primary">Đơn Hàng </p></h1>
        <div class="row">
        <div class="col-lg-12">
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo base_url(). 'admin/index.php'?>"><i class="fas fa-fw fa-tachometer-alt"></i>Bảng Điều Khiển</a></li>
                <li class="breadcrumb-item">Đơn Hàng</li>
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
                                    <th>ID</th>
                                    <th>#</th>
                                    <th>Thông Tin Khách Hàng</th>
                                    <th>Tổng Đơn Hàng</th>
                                    <th>Ghi Chú</th>
                                    <th>Thanh Toán</th>  
                                    <th>Trạng Thái</th>
                                    <th>Chức Năng</th>
                                </tr>
                            </thead>
                            <tbody> 
                                <?php foreach ($transaction as $item): ?>
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
                                            <a class="btn btn-xs btn-primary btn-sm text-white"> Thường</a>
                                        <?php elseif($item['TrangThaiTT'] == 1): ?>
                                            <a class="btn btn-xs btn-danger btn-sm text-white"> Đang Thanh Toán</a>
                                        <?php else: ?>
                                                <a class="btn btn-xs btn-success btn-sm text-white"> Hoàn Tất</a>
                                        <?php endif; ?>	
                                    </td>
                                    <td>
                                    	<?php if($item['TrangThai'] == 0): ?>
												<a href="status.php?id=<?php echo $item['id'] ?>" class="btn btn-danger btn-sm"><i class="fas fa-circle-notch"></i> Chờ xử lý</a>
                                    	<?php elseif($item['TrangThai'] == 1):  ?>
												<a href="status.php?id=<?php echo $item['id'] ?>" class="btn btn-warning btn-sm"><i class="fas fa-box-open"></i> Đã xử lý</a>
                                        <?php elseif($item['TrangThai'] == 2):  ?>
                                                <a href="status.php?id=<?php echo $item['id'] ?>" class="btn btn-primary btn-sm"><i class="fas fa-shipping-fast"></i><small> Đang giao hàng</small></a>
                                        <?php else: ?>
                                            <a href="status.php?id=<?php echo $item['id'] ?>" class="btn btn-success btn-sm"><i class="fas fa-check"></i> Hoàn tất</a>
                                    	<?php endif; ?>
                                    	<!-- <a href="status.php?id=<?php echo $item['id'] ?>" class="btn btn-xs <?php echo $item['status'] == 0 ? 'btn-danger' : 'btn-success'  ?>"><?php echo $item['status'] == 0 ? 'Chờ Xử Lý' : '<i class="fas fa-check"></i>' ?></a> -->
                                    </td>
                                    <td>
                                        <a href="chi-tiet-don-hang.php?id=<?php echo $item['id'] ?>" class="btn btn-primary btn-sm" style="margin-bottom: 5px"><i class="fa fa-align-justify"></i></a>
                                        <a href="chi-tiet.php?id=<?php echo $item['id'] ?>" class="btn btn-info btn-sm" style="margin-bottom: 5px"><i class="fas fa-info-circle"></i></a>
                                        <a onClick="return window.confirm('Bạn có chắc muốn xóa đơn hàng này không?')" href="delete.php?id=<?php echo $item['id'] ?>" class="btn btn-danger btn-sm" style="margin-bottom: 5px"><i class="fa fa-times"></i></a>
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

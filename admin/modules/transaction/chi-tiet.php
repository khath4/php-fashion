<?php 
    $open = "transaction";
    require_once __DIR__. "/../../autoload/autoload.php"; 
    $id = intval(getInput('id'));

    $transaction= $db -> fetchAll("don_hang");
   
    $sql="SELECT *,san_pham.id as ids FROM don_hang,chi_tiet_dh,san_pham WHERE san_pham.id=chi_tiet_dh.id_SanPham AND chi_tiet_dh.id_DonHang=don_hang.id AND chi_tiet_dh.id_DonHang =$id ORDER BY chi_tiet_dh.id";

    $transaction =$db -> fetchsql($sql);

?>
<?php require_once __DIR__. "/../../layouts/header.php";  ?>        
    <!-- Begin Page Content -->
    <div class="container-fluid">
        <!-- Page Heading -->
        <h1 class="h3 mb-4 text-gray-800"><p class="text-primary">Chi Tiết Đơn Hàng </p></h1>
        <div class="row">
        <div class="col-lg-12">
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo base_url(). 'admin/index.php'?>"><i class="fas fa-fw fa-tachometer-alt"></i>Bảng Điều Khiển</a></li>
                <li class="breadcrumb-item"><a href="<?php echo base_url(). 'admin/modules/transaction/index.php'?>">Đơn Hàng</a></li>
                <li class="breadcrumb-item">Chi Tiết Đơn Hàng</li>
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
                    <h6 class="m-0 font-weight-bold text-primary">Chi Tiết Đơn Hàng</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Tên Sản Phẩm</th>
                                    <th>Giá</th>
                                    <th>Giảm Giá</th>
                                    <th>Giá Bán</th>
                                    <th>Size</th>
                                    <th>Số Lượng</th>
                                    <th>Thuế VAT</th>
                                    <th>Tổng</th>
                                </tr>
                            </thead>
                            <tbody> 
                                <?php foreach ($transaction as $item): ?>
                                <tr>
                                    <td><?php echo $item['ids'] ?></td>
                                    <td class="name-user"><?php echo $item['TenSP'] ?></td> 
                                    <td><?php echo formatPrice( $item['GiaSP']) ?></td>   
                                    <td><?php echo $item['GiamGia'] ?> %</td> 
                                    <td><?php echo formatPrice( $item['GiaBan']) ?></td>   
                                    <td><?php echo $item['Size_CT'] ?></td>                              
                                    <td><?php echo $item['SoLuongCT'] ?></td>
                                    <td>10%</td>
                                    <td><?php echo formatPrice($item['TongDH']) ?></td> <!-- <?php echo formatPrice($item['orders_price'] * $item['SoLuongCT']) ?>  -->     
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                        
                    </div>
                </div>
            </div>
            <a href="<?php echo modules('transaction') ?>" class="btn btn-primary btn-sm"><i class="fas fa-angle-double-left"></i></a>
        </div>
<!-- /.container-fluid -->
<?php require_once __DIR__. "/../..//layouts/footer.php";  ?>

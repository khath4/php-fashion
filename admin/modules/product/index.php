<?php 
    $open = "product";
    require_once __DIR__. "/../../autoload/autoload.php"; 

    $sqlPro= "SELECT * FROM san_pham ORDER BY id DESC";
    $Pro = $db -> fetchsql($sqlPro);
    
    $data=[];

    foreach ($Pro as $item) {
        $cateID = intval($item['id']); 
        $sql ="SELECT ct_size.*,size.TenSize as TenSize FROM ct_size,size WHERE ct_size.id_Size = size.id AND id_SanPham = $cateID";
        $Product = $db -> fetchsql($sql);
        $data[$item['id']] = $Product;
    }

?>
<?php require_once __DIR__. "/../../layouts/header.php";  ?>        
    <!-- Begin Page Content -->
    <div class="container-fluid">
        <!-- Page Heading -->
        <h1 class="h3 mb-4 text-gray-800"><p class="text-primary">Quản Lý Sản Phẩm <a href="add.php" class="btn btn-success btn-sm">Thêm Mới</a></p></h1>
        <div class="row">
        <div class="col-lg-12">
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo base_url(). 'admin/index.php'?>"><i class="fas fa-fw fa-tachometer-alt"></i>Bảng Điều Khiển</a></li>
                <li class="breadcrumb-item">Quản Lý Sản Phẩm</li>
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
                    <h6 class="m-0 font-weight-bold text-primary">Danh Sách Sản Phẩm</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Danh Mục</th>
                                    <th>Thương Hiệu</th>
                                    <th>Hình Ảnh</th>
                                    <th>Tên Sản Phẩm</th>
                                    <th>Giá Sản Phẩm</th>
                                    <th>Giảm Giá</th>
                                    <th>Thuộc Tính Size & Số Lượng</th>
                                    <th>Chức Năng</th>
                                </tr>
                            </thead>
            
                            <tbody> 
                                <?php foreach ($data as $key => $item): ?>
                                <tr>
                                    
                                    <?php 
                                        $Product = $db -> fetchID("san_pham" , $key);
                                        $Danh_Muc = $db -> fetchID("danh_muc" , $Product['id_DanhMuc']);
                                        $Thuong_Hieu = $db -> fetchID("thuong_hieu" , $Product['id_ThuongHieu'])
                                    ?>
                                    <td><?php echo $key ?></td>
                                    <td><?php echo $Danh_Muc['TenDM'] ?></td>
                                    <td><?php echo $Thuong_Hieu['TenTH'] ?></td>
                                    <td><img src="<?php echo uploads() ?>product/<?php echo $Product['AnhSP'] ?>" width="80px" height="80px" alt=""></td>
                                    <td><?php echo $Product['TenSP'] ?></td>
                                    <td><?php echo formatPrice($Product['GiaSP']) ?></td>
                                    <td><?php echo $Product['GiamGia'] ?> %</td>
                                    <td>
                                    <?php foreach ($item as $value): ?>
                                        <p><small>Size : <?php echo $value['TenSize']." - SL : ".$value['SoLuong'] ?></small>
                                        </p>
                                    <?php endforeach; ?>
                                    </td>
                                    <!-- <td><?php echo $Product['MoTa'] ?></td> -->
                                    <td>
                                        <a href="edit.php?id=<?php echo $Product['id'] ?>" class="btn btn-primary btn-sm" style="margin-top: 5px"><i class="fa fa-edit"></i></a>
                                        <a onClick="return window.confirm('Bạn có muốn xóa sản phẩm này không?')" href="delete.php?id=<?php echo $Product['id'] ?>" class="btn btn-danger btn-sm" style="margin-top: 5px"><i class="fa fa-times"></i> </a>
                                        <a href="comment.php?id=<?php echo $Product['id'] ?>" class="btn btn-success btn-sm" style="margin-top: 5px"><i class="fa fa-comment"></i> Bình Luận</a>
                                        
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

<?php if(isset($_SESSION['errordata'])) :?>
      <script>
            swal("Thông Báo!", "Không có dữ liệu.");
      </script>
      <?php unset($_SESSION['errordata']); ?>
      <!-- <div class="alert alert-success"><i class="fa fa-check"></i>
      <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
      </div> -->
<?php endif; ?>

<?php 
    $open = "banner";
    require_once __DIR__. "/../../autoload/autoload.php"; 

    $sqlbanner= "SELECT * FROM banner ORDER BY id";
    $banner = $db -> fetchsql($sqlbanner);

?>
<?php require_once __DIR__. "/../../layouts/header.php";  ?>        
    <!-- Begin Page Content -->
    <div class="container-fluid">
        <!-- Page Heading -->
        <h1 class="h3 mb-4 text-gray-800"><p class="text-primary">Quản Lý Banner <a href="add.php" class="btn btn-success btn-sm">Thêm Mới</a></p></h1>
        <div class="row">
        <div class="col-lg-12">
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo base_url(). 'admin/index.php'?>"><i class="fas fa-fw fa-tachometer-alt"></i>Bảng Điều Khiển</a></li>
                <li class="breadcrumb-item">Quản Lý Banner</li>
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
                    <h6 class="m-0 font-weight-bold text-primary">Danh Sách Banner</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Hình Ảnh</th>
                                    <th>Tiêu Đề</th>
                                    <th>Nội Dung</th>
                                    <th>Hiển Thị</th>
                                    <th>Chức Năng</th>
                                </tr>
                            </thead>
                         
                            <tbody> 
                                <?php foreach ($banner as $item): ?>
                                <tr>
                                    <td><?php echo $item['id'] ?></td>
                                    <td><img src="<?php echo uploads() ?>banner/<?php echo $item['AnhBanner'] ?>" width="150px" height="80px" alt=""></td>
                                    <td><?php echo $item['TieuDe'] ?></td>
                                    <td><?php echo $item['NoiDung'] ?></td>
                                     <td>
                                        <a href="home.php?id=<?php echo $item['id']?>" class="btn btn-xs btn-sm <?php echo $item['HienThi'] == 1 ? 'btn-primary' : ' btn-danger' ?>" ><?php echo $item['HienThi'] == 1 ? ' <i class="fas fa-eye"></i>' : '<i class="fas fa-eye-slash"></i>' ?> </a>
                                    </td>
                                    <td>
                                        <a href="edit.php?id=<?php echo $item['id'] ?>" class="btn btn-primary btn-sm" style="margin-top: 5px"><i class="fa fa-edit"></i></a>
                                        <a onClick="return window.confirm('Bạn có muốn xóa banner này không?')" href="delete.php?id=<?php echo $item['id'] ?>" class="btn btn-danger btn-sm" style="margin-top: 5px"><i class="fa fa-times"></i> </a>
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



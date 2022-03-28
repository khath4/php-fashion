<?php 
    $open = "lienhe";
    require_once __DIR__. "/../../autoload/autoload.php"; 

    $sqllienhe= "SELECT * FROM lienhe ORDER BY id";
    $lienhe = $db -> fetchsql($sqllienhe);

?>
<?php require_once __DIR__. "/../../layouts/header.php";  ?>        
    <!-- Begin Page Content -->
    <div class="container-fluid">
        <!-- Page Heading -->
        <h1 class="h3 mb-4 text-gray-800"><p class="text-primary">Quản Lý Liên Hệ </p></h1>
        <div class="row">
        <div class="col-lg-12">
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo base_url(). 'admin/index.php'?>"><i class="fas fa-fw fa-tachometer-alt"></i>Bảng Điều Khiển</a></li>
                <li class="breadcrumb-item">Quản Lý Liên Hệ</li>
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
                    <h6 class="m-0 font-weight-bold text-primary">Liên Hệ</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Thông Tin Shop</th>
                                    <th>Kinh Độ</th>
                                    <th>Chức Năng</th>
                                </tr>
                            </thead>
                            <tbody> 
                                <?php foreach ($lienhe as $item): ?>
                                <tr>
                                    <td><?php echo $item['id'] ?></td>
                                    <td>
                                        <b>Email :</b><?php echo $item['Email'] ?>
                                        <br>
                                        <b>Điên Thoại :</b><?php echo $item['DienThoai'] ?>
                                        <br>
                                        <b>Link Facebook :</b><?php echo $item['LinkFace'] ?>
                                        <br>
                                        <b>Địa Chỉ :</b><?php echo $item['DiaChi'] ?>
                                    </td>
                                    <td>
                                        <b>Kinh độ: </b><?php echo $item['KinhDo'] ?>
                                        <br>
                                        <b>Vĩ độ: </b><?php echo $item['ViDo'] ?>
                                    </td>
                                    <td><a href="edit.php?id=<?php echo $item['id'] ?>" class="btn btn-primary btn-sm" style="margin-top: 5px"><i class="fa fa-edit"></i></a></td>
                                </tr>
                            <?php endforeach; ?>    
                            </tbody>
                        </table>
                    </div>
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



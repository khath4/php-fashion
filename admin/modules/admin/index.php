<?php 
    $open = "admin";
    require_once __DIR__. "/../../autoload/autoload.php"; 
    
    $admin= $db -> fetchAll("admin");

    $sql="SELECT * FROM admin ORDER BY CapBat DESC";

    $admin =$db -> fetchsql($sql);
  
?>
<?php require_once __DIR__. "/../../layouts/header.php";  ?>        
    <!-- Begin Page Content -->
    <div class="container-fluid">
        <!-- Page Heading -->
        <h1 class="h3 mb-4 text-gray-800"><p class="text-primary">Quản Lý Admin <a href="add.php" class="btn btn-success btn-sm">Thêm Mới</a></p></h1>
        <div class="row">
        <div class="col-lg-12">
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo base_url(). 'admin/index.php'?>"><i class="fas fa-fw fa-tachometer-alt"></i>Bảng Điều Khiển</a></li>
                <li class="breadcrumb-item">Admin</li>
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
                    <h6 class="m-0 font-weight-bold text-primary">Danh Sách admin</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Họ Và Tên</th>
                                    <th>Email</th>
                                    <th>Số Điện Thoại</th>
                                    <th>Ngày Sinh</th>
                                    <th>Giới Tính</th>
                                    <th>Địa Chỉ</th>
                                    <th>Quyền Hạng</th>
                                    <?php if(isset($_SESSION['admin_id']) && $_SESSION['admin_level'] >= 2): ?>
                                    <th>Chức Năng</th>
                                    <?php endif; ?>
                                </tr>
                            </thead>
                            <tbody> 
                                <?php $stt =1 ; foreach ($admin as $item): ?>
                                <tr>
                                    <td><?php echo $stt ?></td>
                                    <td class="name-user"><?php echo $item['HoTen'] ?></td>
                                    <td><?php echo $item['Email'] ?></td>
                                    <td><?php echo $item['DienThoai'] ?></td>
                                    <td><?php echo date('d-m-Y',strtotime($item['NgaySinh'])) ?></td>
                                    <td><?php echo $item['GioiTinh'] ?></td>                     
                                    <td><?php echo $item['DiaChi'] ?></td>
                                    <td class="<?php echo isset($_SESSION['admin_id']) && $item['CapBat'] >= 2 ? 'text-danger' : 'text-info' ?>  btn-sm"><?php echo isset($_SESSION['admin_id']) && $item['CapBat'] == 2 ? '<b>ADMIN</b>' : '<b>CTV</b>' ; echo isset($_SESSION['admin_id']) && $item['id'] == $_SESSION['admin_id'] ? '(Bạn)' : '' ?></td>
                                    <?php if(isset($_SESSION['admin_id']) && $_SESSION['admin_level'] >= 2): ?>
                                        <td>
                                        <?php if(($_SESSION['admin_id']) && ($item['id'] != $_SESSION['admin_id'])) : ?>
                                           
                                                <a href="edit.php?id=<?php echo $item['id'] ?>" style="margin-top: 5px" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></a>
                                                <!-- <a href="see-pass.php?id=<?php echo $item['id'] ?>" class="btn btn-primary"><i class="fa fa-unlock"></i></a> -->
                                                <a  onClick="return window.confirm('Bạn có chắc muốn xóa tài khoản này không?')" style="margin-top: 5px" href="delete.php?id=<?php echo $item['id'] ?>" class="btn btn-danger btn-sm" ><i class="fa fa-times"></i></a>
                                                <a href="block.php?id=<?php echo $item['id']?>" class="btn btn-xs btn-sm <?php echo $item['TrangThai'] ==1 ? 'btn-success' : ' btn-danger' ?>" style="margin-top: 5px" ><?php echo $item['TrangThai'] == 1 ? '<i class="fas fa-check"> Active</i>' : '<i class="fas fa-ban"> Block</i>'?> </a>
                                        <?php endif; ?>
                                        </td>
                                    <?php endif; ?>
                                </tr>
                            <?php $stt++ ;endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>  
<!-- /.container-fluid -->
<?php require_once __DIR__. "/../..//layouts/footer.php";  ?>

<?php if(isset($_SESSION['errorpass'])) :?>
      <script>
            swal("Thông Báo!", "Đổi mật khẩu thất bại.");
      </script>
      <?php unset($_SESSION['errorpass']); ?>
      <!-- <div class="alert alert-success"><i class="fa fa-check"></i>
      <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
      </div> -->
<?php endif; ?>


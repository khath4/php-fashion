<?php 
    $open = "users";
    require_once __DIR__. "/../../autoload/autoload.php"; 
    $admin= $db -> fetchAll("users");

    $sql="SELECT * FROM users ORDER BY ID DESC";

    $admin =$db -> fetchsql($sql);

?>
<?php require_once __DIR__. "/../../layouts/header.php";  ?>        
    <!-- Begin Page Content -->
    <div class="container-fluid">
        <!-- Page Heading -->
        <h1 class="h3 mb-4 text-gray-800"><p class="text-primary">Thành Viên</h1>
        <div class="row">
        <div class="col-lg-12">
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo base_url(). 'admin/index.php'?>"><i class="fas fa-fw fa-tachometer-alt"></i>Bảng Điều Khiển</a></li>
                <li class="breadcrumb-item">Thành Viên</li>
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
                    <h6 class="m-0 font-weight-bold text-primary">Danh Sách Thành Viên</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Thông Tin</th>
                                    <th>Ngày Sinh</th>
                                    <th>Giới Tính</th>
                                    <th>Địa Chỉ</th>
                                    <th>Trạng Thái</th>
                                    <th>Chức Năng</th>
                                </tr>
                            </thead>
                            <tbody> 
                                <?php $stt =1 ; foreach ($admin as $item): ?>
                                <tr>
                                    <td><?php echo $stt ?></td>
                                    <td>
                                        <b>Họ Tên :</b><x class="name-user"><?php echo $item['HoTen'] ?></x>
                                        <br>
                                        <b>Email :</b><?php echo $item['Email'] ?>
                                        <br>
                                        <b>Điện Thoại :</b><?php echo $item['DienThoai'] ?>
                                    </td>
                                    <td><?php echo date('d-m-Y',strtotime($item['NgaySinh'])) ?></td> 
                                    <td><?php echo $item['GioiTinh'] ?></td>                         
                                    <td><?php echo $item['DiaChi'] ?></td>
                                    <td><a href="block.php?id=<?php echo $item['id']?>" class="btn btn-xs btn-sm <?php echo $item['TrangThai'] ==1 ? 'btn-success' : ' btn-danger' ?>"  style="margin-top: 5px" ><?php echo $item['TrangThai'] == 1 ? '<i class="fas fa-check"> Active</i>' : '<i class="fas fa-ban"> Block</i>'?> </a>
                                    </td>
                                    <td>
                                        <?php if(isset($_SESSION['admin_id']) && $_SESSION['admin_level'] >= 2): ?>
                                        <a href="edit.php?id=<?php echo $item['id'] ?>" class="btn btn-primary btn-sm" style="margin-top: 5px"><i class="fa fa-edit"></i></a> 
                                        <?php endif; ?>
                                        <?php if(isset($_SESSION['admin_id']) && $_SESSION['admin_level'] >= 2): ?>
                                        <a onClick="return window.confirm('Bạn có chắc muốn xóa tài khoản này không?')" href="delete.php?id=<?php echo $item['id'] ?>" class="btn btn-danger btn-sm"  style="margin-top: 5px"><i class="fa fa-times"></i></a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php $stt++ ;endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
<!-- /.container-fluid -->
<?php require_once __DIR__. "/../..//layouts/footer.php";  ?>
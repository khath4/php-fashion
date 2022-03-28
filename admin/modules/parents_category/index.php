<?php 
    $open = "parents_category";
    require_once __DIR__. "/../../autoload/autoload.php"; 
   
    $sql2 ="SELECT * FROM danh_muc_cha ORDER BY SoTT";

    $parents_category = $db -> fetchsql($sql2);
    
?>
<?php require_once __DIR__. "/../../layouts/header.php";  ?>        
    <!-- Begin Page Content -->
    <div class="container-fluid">
        <!-- Page Heading -->
        <h1 class="h3 mb-4 text-gray-800"> <p class="text-primary">Danh Mục Cha <a href="add.php" class="btn btn-success btn-sm"> Thêm Mới</a> </p></h1>
        <div class="row">
        <div class="col-lg-12">
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo base_url(). 'admin/index.php'?>"><i class="fas fa-fw fa-tachometer-alt"></i>Bảng Điều Khiển</a></li>
                <li class="breadcrumb-item">Danh Mục Cha</li>
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
                    <h6 class="m-0 font-weight-bold text-primary">Danh Sách Danh Mục Cha</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Tên Danh Mục Cha</th>            
                                    <th>Chức Năng</th>
                                </tr>
                            </thead>
                            <tbody> 
                                <?php foreach ($parents_category as $item): ?>
                                <tr>
                                    <td><?php echo $item['SoTT'] ?></td>
                                    <td><?php echo $item['TenDMC'] ?></td>
                                    <td>
                                        <a href="edit.php?id=<?php echo $item['id'] ?>" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i> Cập Nhật</a>
                                        <a onClick="return window.confirm('Bạn có muốn xóa danh mục cha này không?')" href="delete.php?id=<?php echo $item['id'] ?>" class="btn btn-danger btn-sm"><i class="fa fa-times"></i></a>
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
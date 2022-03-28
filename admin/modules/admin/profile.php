<?php 
 	  $open ="admin";
 	
  	require_once __DIR__. "/../../autoload/autoload.php";

    $id = intval(getInput('id'));

  	$admin_id = intval($_SESSION['admin_id']);

    if($admin_id == $id) 
    {
    	 $sql="SELECT * FROM admin WHERE id = $admin_id ";
        $admin =$db -> fetchsql($sql);
    }
  	else
    {
        header("Location: ".base_url()."admin/modules/admin/profile.php?id=$admin_id");
    }
?>

<?php require_once __DIR__. "/../../layouts/header.php"; ?>        
 	<div class="row">
 		<div class="col-lg-12">
 			<nav aria-label="breadcrumb">
			  <ol class="breadcrumb">
			    <li class="breadcrumb-item"><a href="<?php echo base_url() ?>/admin"><i class="fas fa-fw fa-tachometer-alt"></i>Bảng Điều Khiển</a></li>
			    <li class="breadcrumb-item"><a href="<?php echo modules('admin') ?>">Quản Lý Admin</a></li>
			    <li class="breadcrumb-item active" aria-current="page">Hồ Sơ</li>
			  </ol>
			</nav>
      <div class="clearfix">
         <!--  Notification -->
        <?php require_once __DIR__. "/../../../partials/notification.php"; ?>
      </div>
 		</div>
 	</div>
  <?php foreach($admin as $value): ?>
 	<div class="container emp-profile">
      <div class="row">
         <div class="col-md-4">
            <div class="profile-img">
              <?php if($value['AnhDD'] == NULL): ?>
                  <img src="<?php echo uploads() ?>admin/avatar-default.png" alt=""/>
              <?php else: ?>  
                  <img src="<?php echo uploads() ?>admin/<?php echo $value['AnhDD'] ?>"alt="">
              <?php endif; ?>
            </div>
         </div>
         <div class="col-md-6">
            <div class="profile-head">
               <h5 class="name-user">
                  <?php echo $value['HoTen'] ?>
               </h5>
               <h6><?php echo $value['CapBat'] == 2 ? 'ADMIN' : 'CTV'?></h6>
               <p class="proile-rating"><span>ID#<?php echo $value['id'] ?></span></p>
               <ul class="nav nav-tabs" id="myTab" role="tablist">
                  <li class="nav-item">
                     <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Thông tin cá nhân</a>
                  </li>
               </ul>
            </div>
         </div>
         <div class="col-md-2">
            <a href="edit-profile.php?id=<?php echo $value['id'] ?>" class="btn btn-outline-primary btn-sm"><i class="fa fa-edit"></i> Cập Nhật</a>
         </div>
      </div>
      <div class="row">
         <div class="col-md-4">
            <div class="profile-work">
              <p><b>Chức Năng</b></p>
              <p> <a href="<?php echo modules('admin').'/doi-password.php?id='?><?php echo $_SESSION['admin_id'] ?>">Đổi mật khẩu</a></p>
              <p><a href="edit-profile.php?id=<?php echo $value['id'] ?>">Cập Nhật thông tin cá nhân</a></p>
            </div>
         </div>
         <div class="col-md-8">
            <div class="tab-content profile-tab" id="myTabContent">
               <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                  <div class="row">
                     <div class="col-md-6">
                        <label>Họ Tên</label>
                     </div>
                     <div class="col-md-6">
                        <p class="name-user"><?php echo $value['HoTen'] ?></p>
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-md-6">
                        <label>Email</label>
                     </div>
                     <div class="col-md-6">
                        <p><?php echo $value['Email'] ?></p>
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-md-6">
                        <label>Điện Thoại</label>
                     </div>
                     <div class="col-md-6">
                        <p><?php echo $value['DienThoai'] ?></p>
                     </div>
                  </div>
                   <div class="row">
                     <div class="col-md-6">
                        <label>Ngày Sinh</label>
                     </div>
                     <div class="col-md-6">
                        <p><?php echo date("d-m-Y", strtotime($value['NgaySinh'])) ?></p>
                     </div>
                  </div>
                   <div class="row">
                     <div class="col-md-6">
                        <label>Giới Tính</label>
                     </div>
                     <div class="col-md-6">
                        <p><?php echo $value['GioiTinh'] ?></p>
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-md-6">
                        <label>Quyền Hạng</label>
                     </div>
                     <div class="col-md-6">
                        <p><?php echo $value['CapBat'] == 2 ? 'ADMIN' : 'CTV'?></p>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
    </div>
    <?php endforeach; ?>
    <!-- /.container-fluid -->
    </div>
    <!-- End of Main Content -->
<?php require_once __DIR__. "/../../layouts/footer.php";  ?>

<?php if(isset($_SESSION['add'])) :?>
      <script>
            swal({
              title: "Thông Báo!",
              text: "Cập nhật thành công.",
              icon: "success",
            });
      </script>
      <?php unset($_SESSION['add']); ?>
<?php endif; ?>

<?php if(isset($_SESSION['empty'])) :?>
      <script>
            swal("Thông Báo!", "Dữ liệu không thay đổi.");
      </script>
      <?php unset($_SESSION['empty']); ?>
<?php endif; ?>

<?php if(isset($_SESSION['dataerror'])) :?>
      <script>
            swal("Thông Báo!", "Dữ liệu không tồn tại.");
      </script>
      <?php unset($_SESSION['dataerror']); ?>    
<?php endif; ?>


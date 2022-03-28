<?php 
    require_once __DIR__. "/autoload/autoload.php";

    $users_id = intval($_SESSION['name_id']);
    if(isset($_SESSION['name_id'])) 
  	{
      $sql="SELECT * FROM users WHERE id = $users_id  ORDER BY ID DESC";

      $users =$db -> fetchsql($sql);
    }
    else
    {
      header("location: index.php");
    }
    
?>

<?php require_once __DIR__. "/layouts/header.php";  ?> 
<?php require_once __DIR__. "/layouts/nav.php";  ?>  
<div class="col-sm-9 padding-right">
    <h2 class="title text-center">Cập Nhật Hồ Sơ</h2>
      <?php if(isset($_SESSION['success'])) :?>
        <div class="alert alert-success"><i class="fa fa-check"></i>
        <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
        </div>
    <?php endif; ?>

    <?php if(isset($_SESSION['error'])) :?>
        <div class="alert alert-danger"><i class="fa fa-times"></i>
        <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
        </div>
    <?php endif; ?>
     
      <div class="row">
         <div class="col-md-4">
            <div class="profile-img">
               <img src="<?php echo base_url() ?>public/fontend/images/home/girl2.jpg" alt=""/>
               
            </div>
         </div>
         <?php foreach($users as $value): ?>
         <div class="col-md-6">
            <div class="profile-head">
               <h5 class="name-user">
                  <?php echo $value['HoTen'] ?>
               </h5>
               <h6>
                  USER
               </h6>
               <p class="proile-rating"><span>ID#<?php echo $value['id'] ?></span></p>
               <ul class="nav nav-tabs" id="myTab" role="tablist">
                  <li class="nav-item">
                     <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Thông tin cá nhân</a>
                  </li>
               </ul>
            </div>
         </div>
         <div class="col-md-2">
            <a href="update-profile.php?id=<?php echo $value['id'] ?>" class="btn btn-primary">Cập Nhật</a>
         </div>
      </div>
      <div class="row">
         <div class="col-md-4">
            <div class="profile-work">
              <p><b>Chức Năng</b></p>
              <p> <a href="doi-mat-khau.php?id=<?php echo $_SESSION['name_id'] ?>">Đổi mật khẩu</a></p>
              <p><a href="update-profile.php?id=<?php echo $value['id'] ?>">Cập Nhật thông tin cá nhân</a></p>
              <p><a href="don-hang.php?id=<?php echo $_SESSION['name_id'] ?>">Xem danh sách đơn hàng</a></p>
            </div>
         </div>
         <div class="col-md-8">
            <div class="tab-content profile-tab" id="myTabContent">
               <div>
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
                        <label>Điện Thoại</label>
                     </div>
                     <div class="col-md-6">
                        <p><?php echo $value['DiaChi'] ?></p>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <?php endforeach; ?>
      </div>

    <!-- /.container-fluid -->
</div>
</div>
</div>
</section>
  
<?php require_once __DIR__. "/layouts/footer.php";  ?>  
<?php if(isset($_SESSION['updatesuccess'])) :?>
      <script>
            swal("Thông Báo!", "Cập nhật thành công.");
      </script>
      <?php unset($_SESSION['updatesuccess']); ?>
      <!-- <div class="alert alert-success"><i class="fa fa-check"></i>
      <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
      </div> -->
<?php endif; ?>
<?php if(isset($_SESSION['updateerror'])) :?>
      <script>
            swal("Thông Báo!", "Dữ Liệu Không Thay Đổi.");
      </script>
      <?php unset($_SESSION['updateerror']); ?>
      <!-- <div class="alert alert-success"><i class="fa fa-check"></i>
      <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
      </div> -->
<?php endif; ?>

<?php 
    $open ="admin";
 	
  	require_once __DIR__. "/../../autoload/autoload.php";

  	$id = intval(getInput('id'));

    $admin_id = intval($_SESSION['admin_id']);

    // $user = $db -> fetchID("users" , intval($_SESSION['name_id']));
    if($admin_id == $id) 
    {
        if($_SERVER["REQUEST_METHOD"] == "POST")
        { 

          $check = ["MatKhau" => postInput('MatKhau')];
          $data = ["MatKhau" => password_hash(postInput('new_password'), PASSWORD_DEFAULT)];

          $error=[];
          if(strlen(postInput('new_password')) < 6 ) 
          {
            $error['new_password']="Mật khẩu tối thiểu là 6 ký tự."; 
          }
          if(strlen(postInput('new_password'))  > 20 ) 
          {
            $error['new_password']="Mật khẩu của bạn quá dài."; 
          }
          if(strlen(postInput('re_password')) < 6 ) 
          {
            $error['re_password']="Mật khẩu tối thiểu là 6 ký tự."; 
          }
          if(strlen(postInput('re_password'))  > 20 ) 
          {
            $error['re_password']="Mật khẩu của bạn quá dài."; 
          }
          if(strlen(postInput('MatKhau')) < 6 ) 
          {
            $error['MatKhau']="Mật khẩu tối thiểu là 6 ký tự."; 
          }
          if(strlen(postInput('MatKhau'))  > 20 ) 
          {
            $error['MatKhau']="Mật khẩu của bạn quá dài."; 
          }
          if(postInput('MatKhau') == '') 
          {
            $error['MatKhau']="Mời bạn nhập mật khẩu."; 
          }
          if(postInput('new_password') == '') 
          {
            $error['new_password']="Mời bạn nhập mật khẩu."; 
          }

          if(postInput('new_password') != NULL  && postInput("re_password") != NULL)
          {
            if(postInput('new_password') != postInput('re_password'))
            {
              $error['new_password']="Mật khẩu không khớp.";
              $error['re_password']="Mật khẩu không khớp."; 
            }
            else
            {
              $data['MatKhau']= password_hash(postInput('new_password'), PASSWORD_DEFAULT);
            }
          }
          $is_check= $db -> fetchOne("admin" ," id ='" .$_SESSION['admin_id']. "'");
          if($is_check != NULL)
          { 
              if(empty($error)) 
              {       
                  if(password_verify($check['MatKhau'], $is_check['MatKhau']))
                  {
                      $id_update =$db->update("admin",$data,array("id"=>$id));
                      if($id_update)
                      { 
                          unset($_SESSION['name_admin']);
                          unset($_SESSION['admin_id']);
                          header("location:".base_url()."login/");
                          $_SESSION['changepass']="";  
                      }
                      else
                      {
                          header("location: index.php");
                          $_SESSION['errorpass']="";  
                      }
                  }
                  else
                  {
                      $_SESSION['erroroldpass'] = "";
                  } 
                    
              } 
          }
      }  
  }
  else
  {
      echo"<script>
      alert('Đây không phải ID của bạn.');
      location.href='profile.php?id=$admin_id'
      </script>";
  }
?>

<?php require_once __DIR__. "/../../layouts/header.php"; ?>        
 	<div class="row">
 		<div class="col-lg-12">
 			<nav aria-label="breadcrumb">
			  <ol class="breadcrumb">
			    <li class="breadcrumb-item"><a href="<?php echo base_url() ?>/admin"><i class="fas fa-fw fa-tachometer-alt"></i>Bảng Điều Khiển</a></li>
			    <li class="breadcrumb-item"><a href="<?php echo modules('admin') ?>">Quản Lý Admin</a></li>
			    <li class="breadcrumb-item active" aria-current="page">Cập Nhật</li>
			  </ol>
			</nav>
      <div class="clearfix">
         <!--  Notification -->
        <?php require_once __DIR__. "/../../../partials/notification.php"; ?>
      </div>
 		</div>
 	</div>
    <!-- Begin Page Content -->
    <div class="container-fluid">
    	<div class="row">
    		<div class="col-md-12">
          <form action="" method="POST" >
    			<label for="exampleInputEmail1"><h1 class="text-primary">Đổi Mật Khẩu</h1></label>  	
					<div class="form-group row">
					    <label for="inputPassword" class="col-sm-4 col-form-label"><b class="text-primary">Mật Khẩu Cũ(*)</b></label>
						<div class="col-sm-12">
						    <input type="password" class="form-control" id="myInput" placeholder="Độ dài tối thiểu là 6 ký tự bao gồm số và chữ." name="MatKhau" >
							   	 <!--  Notification -->
			            	<?php if(isset($error['MatKhau'])): ?>
							   		<p class="text-danger"><i class="fas fa-exclamation"></i> <?php echo $error['MatKhau'] ?></p>
							<?php endif ?>
						</div>
					</div>
          <div class="form-group row">
              <label for="inputPassword" class="col-sm-4 col-form-label"><b class="text-primary">Mật Khẩu Mới(*)</b></label>
            <div class="col-sm-12">
                <input type="password" class="form-control" id="myInput" placeholder="Độ dài tối thiểu là 6 ký tự số và chữ." name="new_password" >
                   <!--  Notification -->
                    <?php if(isset($error['new_password'])): ?>
                    <p class="text-danger"><i class="fas fa-exclamation"></i> <?php echo $error['new_password'] ?></p>
              <?php endif ?>
            </div>
          </div>
          <div class="form-group row">
              <label for="inputPassword" class="col-sm-4 col-form-label"><b class="text-primary">Nhập Lại Mật Khẩu Mới(*)</b></label>
            <div class="col-sm-12">
                <input type="password" class="form-control" id="myInput" placeholder="Độ dài tối thiểu là 6 ký tự số và chữ." name="re_password" required="">
                   <!--  Notification -->
                    <?php if(isset($error['re_password'])): ?>
                    <p class="text-danger"><i class="fas fa-exclamation"></i> <?php echo $error['re_password'] ?></p>
              <?php endif ?>
            </div>
          </div>
          <a href="index.php" class="btn btn-primary btn-sm"><i class="fa fa-angle-double-left"></i></a>
          <button type="submit" class="btn btn-primary btn-sm" onClick="return window.confirm('Bạn có muốn đổi mật khẩu không?')">Lưu</button>		 
        </form>
    		</div>
    	</div>    
    </div>
    <!-- /.container-fluid -->
    </div>
    <!-- End of Main Content -->
<?php require_once __DIR__. "/../../layouts/footer.php";  ?>

<?php if(isset($_SESSION['erroroldpass'])) :?>
      <script>
            swal("Thông Báo!", "Mật khẩu cũ không đúng.");
      </script>
      <?php unset($_SESSION['erroroldpass']); ?>
      <!-- <div class="alert alert-success"><i class="fa fa-check"></i>
      <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
      </div> -->
<?php endif; ?>
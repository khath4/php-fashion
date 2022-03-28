<?php 
 	  $open ="admin";
 	
  	require_once __DIR__. "/../../autoload/autoload.php";

    if(isset($_SESSION['admin_id']) && $_SESSION['admin_level'] == 2) 
    {
    	$id = intval(getInput('id'));

    	$admin= $db-> fetchID("admin" ,$id);
    }
    else
    {
        $_SESSION['error'] = "Bạn không thể thực hiện chức năng này với người cùng cấp bậc hoặc lớn hơn bạn.";
    }  
?>

<?php require_once __DIR__. "/../../layouts/header.php"; ?>        
 	<div class="row">
 		<div class="col-lg-12">
 			<nav aria-label="breadcrumb">
			  <ol class="breadcrumb">
			    <li class="breadcrumb-item"><a href="<?php echo base_url() ?>/admin"><i class="fas fa-fw fa-tachometer-alt"></i>Bảng Điều Khiển</a></li>
			    <li class="breadcrumb-item"><a href="<?php echo modules('admin') ?>">Quản Lý Admin</a></li>
			    <li class="breadcrumb-item active" aria-current="page">Xem Mật Khẩu</li>
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
          <?php if(isset($_SESSION['admin_id']) && $_SESSION['admin_level'] == 2):  ?>
    			<label for="exampleInputEmail1"><h1 class="text-primary">Xem Mật Khẩu</h1></label>  	
					<div class="form-group row">
					    <label for="inputPassword" class="col-sm-4 col-form-label"><b class="text-primary">Mật Khẩu(*)</b></label>
						<div class="col-sm-12">
						    <input type="password" class="form-control" id="myInput<?php echo $id ?>" placeholder="Độ dài tối thiểu là 6 ký tự số và chữ." name="MatKhau" value="<?php echo base64_decode($admin['MatKhau']) ?>" readonly>
						     <input type="checkbox" onclick="myFunction()">Hiển Thị
							   	 <!--  Notification -->
			            	<?php if(isset($error['MatKhau'])): ?>
							   		<p class="text-danger"><i class="fas fa-exclamation"></i> <?php echo $error['MatKhau'] ?></p>
							<?php endif ?>
						</div>
					</div>
          <?php endif; ?>
				  <a href="<?php echo modules('admin') ?>" class="btn btn-primary">Quay Lại</a>
    		</div>
    	</div>    
    </div>
    <!-- /.container-fluid -->
    </div>
    <!-- End of Main Content -->
    <script>
    function myFunction() {
  	var x = document.getElementById("myInput<?php echo $id ?>");
  	if (x.type === "password") {
    	x.type = "text";
    }  
	    else 
	    {
	      x.type = "password";
	    }
  	} 
  	</script>
<?php require_once __DIR__. "/../../layouts/footer.php";  ?>
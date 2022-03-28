<?php  
	session_start();
	require_once __DIR__. "/../libraries/Database.php"; 
	require_once __DIR__."/../libraries/Function.php";
	$db = new Database;
	$data = [
        "Email" => postInput('Email'),
        "MatKhau" => postInput('MatKhau'), 
    ];
    $error=[];
	if($_SERVER["REQUEST_METHOD"] == "POST")
  {
      
      if(postInput('Email') == '')
      {
      	  $error['Email']=""; 
    	}

        if(postInput('MatKhau') == '') 
        {
        	$error['MatKhau']=""; 
        }
     	if(empty($error))
        {
          $is_check= $db -> fetchOne("admin" ," Email = '".$data['Email']."'");
         
          if($is_check != NULL)
          { 
              if(password_verify($data['MatKhau'], $is_check['MatKhau']))
              {
                  if($check= $db -> fetchOne("admin" ," id = '".$is_check['id']."' AND TrangThai = 1 "))
                  { 
                      $_SESSION['name_admin'] = $is_check['HoTen'];
                      $_SESSION['admin_id'] = $is_check['id'];
                      $_SESSION['admin_level'] = $is_check['CapBat'];
                      header("location:".base_url()."admin/");
                      $_SESSION['loginsuccess'] = "";
                  }
                  else
                  {
                      $_SESSION['block'] = "";
                  }
              }
              else
              {
                  $_SESSION['errorlogin'] = "";
              }
          }
      }    
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Đăng Nhập</title>
	<style type="text/css">
	
/* BASIC */



</style>
<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<link href="<?php echo base_url() ?>public/admin/css/style.css" rel="stylesheet" type="text/css">
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<!------ Include the above in your HEAD tag ---------->

</head>
<body>

	<div class="wrapper fadeInDown">
		<div class="col-md-4 text-center" >
	 		<?php if(isset($_SESSION['error'])) :?>
	        <div class="alert alert-danger"><i class="fa fa-times"></i>
	        <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
        </div>
  	<?php endif; ?>
  	</div>	
  	<div id="formContent">
    <!-- Tabs Titles -->

    <!-- Icon -->
    <div class="fadeIn first">
      <img src="<?php echo base_url() ?>public/admin/img/admin2.png" id="icon" alt="User Icon" width="200px" height="220px" />
    </div>

    <!-- Login Form -->
    <form action="" method="POST">
      <input type="email" id="Email" class="fadeIn second" name="Email" placeholder="Tài Khoản" required="">
      <input type="password" id="MatKhau" class="fadeIn third" name="MatKhau" placeholder="Mật Khẩu" required="">
      <input type="submit" class="fadeIn fourth" value="Đăng Nhập">
    </form>

  </div>
</div>
</body>
</html>

<?php if(isset($_SESSION['password'])) :?>
      <script>
            swal("Thông Báo!", "Đổi mật khẩu thành công! Mời bạn đăng nhập lại.");
      </script>
       <?php unset($_SESSION['password']); ?>>
<?php endif; ?>

<?php if(isset($_SESSION['errorlogin'])) :?>
      <script>
            swal("Thông Báo!", "Sai email hoặc mật khẩu! Đăng nhập thất bại");
      </script>
      <?php unset($_SESSION['errorlogin']); ?>
<?php endif; ?>

<?php if(isset($_SESSION['logout'])) :?>
      <script>
            swal({
              title: "Thông Báo!",
              text: "Đăng xuất thành công.",
              icon: "success",
            });
      </script>
      <?php unset($_SESSION['logout']); ?>
<?php endif; ?>

<?php if(isset($_SESSION['changepass'])) :?>
      <script>
            swal({
              title: "Thông Báo!",
              text: "Đổi mật khẩu thành công! Mời bạn đăng nhập lại.",
              icon: "success",
            });
      </script>
      <?php unset($_SESSION['changepass']); ?>
<?php endif; ?>

<?php if(isset($_SESSION['block'])) :?>
      <script>
            swal({
              title: "Thông Báo!",
              text: "Tài khoản của bạn đã bị khóa.",
              icon: "success",
            });
      </script>
      <?php unset($_SESSION['block']); ?>
<?php endif; ?>




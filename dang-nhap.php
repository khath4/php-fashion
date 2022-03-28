<?php
    $open ="login";
    require_once __DIR__. "/autoload/autoload.php"; 
    if(isset($_SESSION['name_user']))
    {
        header("location: index.php");
        $_SESSION['checklogin'] = "";
    }

    $data = [
        "Email" => postInput('Email'),
        "MatKhau" => postInput('MatKhau'),
    ];
    $error=[];

    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
      
      if(postInput('Email') == '')
      {
        $error['Email']="Mời bạn nhập email."; 
      }

      if(postInput('MatKhau') == '') 
      {
        $error['MatKhau']="Mời bạn nhập mật khẩu."; 
      }
      if(empty($error))
        {
          $is_check= $db -> fetchOne("users" ," Email = '".$data['Email']."'");
          if($is_check != NULL)
          { 
              if(password_verify($data['MatKhau'], $is_check['MatKhau']))
              {
                  if($check= $db -> fetchOne("users" ," id = '".$is_check['id']."' AND TrangThai = 1 "))
                  { 
                      $_SESSION['name_user'] = $is_check['HoTen'];
                      $_SESSION['name_id'] = $is_check['id'];
                      $_SESSION['login'] = "";
                      header("location: index.php");
                     
                  }
                  else
                  {
                       $_SESSION['block'] = "";
                  }
              }
              else 
              {                  
                  $_SESSION['wrong'] = "";
              }
      }
      else
      {
          $_SESSION['wrong'] = "";
      }
    }    
  }
?>


<?php require_once __DIR__. "/layouts/header.php";  ?>	
<?php require_once __DIR__. "/layouts/nav.php";  ?>  
<div class="col-sm-9 padding-right">
   	<h2 class="title text-center">Đănng Nhập</h2>
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

	<form action="" method="POST" >
	  	<div class="form-group">
		    <label class="text-primary">Email</label>
		    <input type="email" class="form-control" name="Email" placeholder="Example@gmail.com" required="">
		    <?php if(isset($error['Email'])): ?>
				<p class="text-danger"><i class="fa fa-exclamation"></i> <?php echo $error['Email'] ?></p>
			<?php endif ?>
	  	</div>
	  	<div class="form-group">
		    <label class="text-primary">Mật Khẩu</label>
		    <input type="password" class="form-control" name="MatKhau" id="id" placeholder="Độ dài tối thiểu là 6 ký tự bao gồm số và chữ" required="">
        <input type="checkbox" onclick="myFunction()"> Hiển Thị
		    <?php if(isset($error['MatKhau'])): ?>
				<p class="text-danger"><i class="fa fa-exclamation"></i> <?php echo $error['MatKhau'] ?></p>
			<?php endif ?>
	  	</div>
      <p>Bạn chưa có tài khoản?<a href="dang-ky.php">Đăng Ký</a></p>
	  	<button type="submit" class="btn btn-primary">Đăng Nhập</button>
	</form>
</div>
</div>
</div>
</section>
	
<?php require_once __DIR__. "/layouts/footer.php";  ?>	
<?php if(isset($_SESSION['relogin'])) :?>
      <script>
            swal("Thông Báo!", "Mời bạn đăng nhập để thực hiện chức năng này.");
      </script>
       <?php unset($_SESSION['relogin']); ?>
      <!-- <div class="alert alert-success"><i class="fa fa-check"></i>
      <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
      </div> -->
<?php endif; ?>

<?php if(isset($_SESSION['password'])) :?>
      <script>
            swal("Thông Báo!", "Đổi mật khẩu thành công! Mời bạn đăng nhập lại.");
      </script>
       <?php unset($_SESSION['password']); ?>
      <!-- <div class="alert alert-success"><i class="fa fa-check"></i>
      <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
      </div> -->
<?php endif; ?>

<?php if(isset($_SESSION['errorlogin'])) :?>
      <script>
            swal("Thông Báo!", "Đổi mật khẩu không thành công!");
      </script>
       <?php unset($_SESSION['errorlogin']); ?>
      <!-- <div class="alert alert-success"><i class="fa fa-check"></i>
      <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
      </div> -->
<?php endif; ?>

<?php if(isset($_SESSION['loginsuccess'])) :?>
      <script>
            swal({
              title: "Thông Báo!",
              text: "Đăng Ký thành công! Mời bạn đăng nhập.",
              icon: "success",
            });
      </script>
      <?php unset($_SESSION['loginsuccess']); ?>
      <!-- <div class="alert alert-success"><i class="fa fa-check"></i>
      <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
      </div> -->
<?php endif; ?>

<?php if(isset($_SESSION['unlogin'])) :?>
      <script>
            swal("Thông Báo!", "Bạn phải đăng nhập để thực hiện chức năng này.");
      </script>
      <?php unset($_SESSION['unlogin']); ?>
      <!-- <div class="alert alert-success"><i class="fa fa-check"></i>
      <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
      </div> -->
<?php endif; ?>

<?php if(isset($_SESSION['block'])) :?>
      <script>
            swal("Thông Báo!", "Tài Khoản của bạn đang bị khóa! Vui lòng liên hệ admin để biết thêm chi tiết.");
      </script>
      <?php unset($_SESSION['block']); ?>
      <!-- <div class="alert alert-success"><i class="fa fa-check"></i>
      <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
      </div> -->
<?php endif; ?>

<?php if(isset($_SESSION['wrong'])) :?>
      <script>
            swal("Thông Báo!", "Sai email hoặc mật khẩu! Đăng nhập thất bại.");
      </script>
      <?php unset($_SESSION['wrong']); ?>
      <!-- <div class="alert alert-success"><i class="fa fa-check"></i>
      <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
      </div> -->
<?php endif; ?>

<script>
   function myFunction() {
    var x = document.getElementById("id");
    if (x.type === "password") {
      x.type = "text";
    }  
      else 
      {
        x.type = "password";
      }
    }
</script>
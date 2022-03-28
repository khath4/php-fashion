<?php 
	require_once __DIR__. "/autoload/autoload.php";

	$id = intval(getInput('id'));
	$reid = $_SESSION['name_id'];
	if(!isset($reid))
  	{
      $_SESSION['relogin'] = "";
      header("location: dang-nhap.php"); 
    // echo"<script>
    //         alert('Bạn phải đăng nhập để thực hiện chức năng này.');
    //         location.href='dang-nhap.php'
    //       </script>";
  	} 
  	// $user = $db -> fetchID("users" , intval($_SESSION['name_id']));
    if($id == $_SESSION['name_id']) 
    {
        if($_SERVER["REQUEST_METHOD"] == "POST")
        { 

          $check = ["MatKhau" =>postInput('MatKhau')];
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
          $is_check= $db -> fetchOne("users" ," id ='" .$_SESSION['name_id']. "'");
          if($is_check != NULL)
          { 
              if(empty($error)) 
              {       
                  if(password_verify($check['MatKhau'], $is_check['MatKhau']))
                  {

                      $id_update =$db->update("users",$data,array("id"=>$id));
                      if($id_update)
                      { 
                                            
                        header("location: dang-nhap.php");
                        $_SESSION['password'] = ""; 
                        unset($_SESSION['name_user']);
                        unset($_SESSION['name_id']);
                      }
                      else
                      {
                        $_SESSION['errorlogin'] = "";
                        header("location: dang-nhap.php"); 
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
      header("location: doi-mat-khau.php?id=$reid");
  }

?>
<?php require_once __DIR__. "/layouts/header.php";  ?>	
<?php require_once __DIR__. "/layouts/nav.php";  ?>  
<div class="col-sm-9 padding-right">
   	<h2 class="title text-center">Đổi Mật Khẩu</h2>
    <?php if(isset($_SESSION['error'])) :?>
        <div class="alert alert-danger"><i class="fa fa-times"></i>
        <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
        </div>
    <?php endif; ?>

	<form action="" method="POST" >
	  	<div class="form-group">
		    <label class="text-primary">Mật Khẩu Cũ(*)</label>
		    <input type="password" class="form-control" name="MatKhau" placeholder="Độ dài tối thiểu là 6 ký tự số và chữ." >
	  	</div>
      <?php if(isset($error['MatKhau'])): ?>
          <p class="text-danger"><i class="fa fa-exclamation"></i> <?php echo $error['MatKhau'] ?></p>
      <?php endif ?>
	  	<div class="form-group">
		    <label class="text-primary">Mật Khẩu Mới(*)</label>
		    <input type="password" class="form-control" name="new_password" placeholder="Độ dài tối thiểu là 6 ký tự số và chữ."  >
	  	</div>
      <?php if(isset($error['new_password'])): ?>
          <p class="text-danger"><i class="fa fa-exclamation"></i> <?php echo $error['new_password'] ?></p>
      <?php endif ?>
	  	<div class="form-group">
		    <label class="text-primary">Nhập Lại Mật Khẩu Mới(*)</label>
		    <input type="password" class="form-control" name="re_password" placeholder="Độ dài tối thiểu là 6 ký tự số và chữ."  >    
	  	</div>
      <?php if(isset($error['re_password'])): ?>
          <p class="text-danger"><i class="fa fa-exclamation"></i> <?php echo $error['re_password'] ?></p>
      <?php endif ?>
	  	<button type="submit" onClick="return window.confirm('Bạn có muốn đổi mật khẩu không?')" class="btn btn-outline-warning get">Lưu</button>
	  	
	</form>
</div>
</div>
</div>
</section>
	
<?php require_once __DIR__. "/layouts/footer.php";  ?>	

<?php if(isset($_SESSION['erroroldpass'])) :?>
      <script>
            swal("Thông Báo!", "Mật khẩu cũ không đúng.");
      </script>
      <?php unset($_SESSION['erroroldpass']); ?>
      <!-- <div class="alert alert-success"><i class="fa fa-check"></i>
      <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
      </div> -->
<?php endif; ?>
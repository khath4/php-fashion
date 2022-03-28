<?php 
  $open = "resign";
	require_once __DIR__. "/autoload/autoload.php"; 
    if(isset($_SESSION['name_id']))
    {
        $_SESSION['errorresign']="";  
        header("Location: index.php");
    }
	 $data = [
  			"HoTen" => postInput('HoTen'),
  			"Email" => postInput('Email'),
  			"DienThoai" => postInput('DienThoai'),	
  			"DiaChi" => postInput('DiaChi'),
  			"MatKhau" => password_hash(postInput('MatKhau'), PASSWORD_DEFAULT),
        "NgaySinh" =>postInput('NgaySinh'),
        "GioiTinh" =>postInput('GioiTinh'),
  		
  	];
	$error=[];
  	if($_SERVER["REQUEST_METHOD"] == "POST")
  	{
  		if(isset($_POST['HoTen']) && $_POST['HoTen'] != NULL)
  		{
  			$name =$_POST['HoTen'];
  		}
  		if(postInput('HoTen') == '') 
  		{
  			$error['HoTen']="Mời bạn nhập đầy đủ họ tên."; 
  		}
        if(strlen(postInput('HoTen'))  > 30 ) 
        {
            $error['HoTen']="Tên của bạn quá dài."; 
        }

  		if(isset($_POST['Email']) && $_POST['Email'] != NULL)
  		{
  			$email =$_POST['Email'];
  		}
        if(strlen(postInput('Email'))  > 30 ) 
        {
            $error['Email']="Email của bạn quá dài."; 
        }
  		if(postInput('Email') == '')
  		{
  			$error['Email']="Mời bạn nhập Email."; 
  		}
      else
      {
        $is_check = $db -> fetchOne("users", "Email = '".$data['Email']."' ");
        if($is_check != NULL) 
        {
          $error['Email']="Email đã được sử dụng,Vui lòng dùng Email khác."; 
        }
      }

  		if(isset($_POST['MatKhau']) && $_POST['MatKhau'] != NULL)
  		{
  			$password =$_POST['MatKhau'];
  		}
  		if(postInput('MatKhau') == '') 
  		{
  			$error['MatKhau']="Mời bạn nhập mật khẩu."; 
  		}

        if(strlen(postInput('MatKhau')) < 6 ) 
        {
            $error['MatKhau']="Mật khẩu tối thiểu là 6 ký tự."; 
        }
        if(strlen(postInput('MatKhau'))  > 20 ) 
        {
            $error['MatKhau']="Mật khẩu của bạn quá dài."; 
        }
        if($data['MatKhau'] != password_verify(postInput('re_password'),$data['MatKhau']))
        {
            $error['MatKhau']="Mật khẩu không khớp."; 
        }

  		if(isset($_POST['DienThoai']) && $_POST['DienThoai'] != NULL)
  		{
  			$phone =$_POST['DienThoai'];
  		}
  		
  		if(date("Y", strtotime(postInput('NgaySinh'))) < 1900 )
  		{
  		    $error['NgaySinh']="BẠN KHÔNG SỐNG LÂU THẾ ĐÂU =))."; 
  		}
  		
  		if(date("Y", strtotime(postInput('NgaySinh'))) > 2020 )
  		{
  		    $error['NgaySinh']="Năm sinh Không hợp lệ."; 
  		}
  		
        if(strlen($data['DienThoai']) < 8 || strlen($data['DienThoai']) > 12)
        {
            $error['DienThoai']="Số điện thoại của bạn không hợp lệ."; 
        }
  		if(postInput('DienThoai') == '') 
  		{
  			$error['DienThoai']="Mời bạn nhập số điện thoại."; 
  		}
      else
      {
        $is_check = $db -> fetchOne("users", "DienThoai = '".$data['DienThoai']."' ");
        if($is_check != NULL) 
        {
          $error['DienThoai']="Số điện thoại đã được sử dụng,Vui lòng dùng số điện thoại khác.";
          
        }
      }
  		if(isset($_POST['DiaChi']) && $_POST['DiaChi'] != NULL)
  		{
  			$address =$_POST['DiaChi'];
  		}
  		if(postInput('DiaChi') == '') 
  		{
  			$error['DiaChi']="Mời bạn nhập đia chỉ."; 
  		}
      if(postInput('NgaySinh') == '') 
      {
        $error['NgaySinh']="Mời bạn chọn ngày tháng năm sinh."; 
      }
      if(postInput('GioiTinh') == '') 
      {
        $error['GioiTinh']="Mời bạn chọn giới tính."; 
      }

  		if(empty($error))
  		{
  			$id_insert =$db->insert("users",$data);
	        if($id_insert)
	        {	
	       		
	       		$_SESSION['loginsuccess']="";
            header("Location: dang-nhap.php");

	        }
	        else
	        {
	       		$_SESSION['errorre']="";	
            header("Location: dang-ky.php");
            // echo header("refresh: 0.1; url = http://localhost/WebThoiTrang/dang-ky.php");
	        }
  		}
  	}
  	else 
  	{

  	}
?>
<?php require_once __DIR__. "/layouts/header.php";  ?>	
<?php require_once __DIR__. "/layouts/nav.php";  ?>  		
<div class="col-sm-9 padding-right">
   	<h2 class="title text-center">Đănng Ký Thành Viên</h2>
    <?php if(isset($_SESSION['error'])) :?>
        <div class="alert alert-danger"><i class="fa fa-times"></i>
        <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
        </div>
    <?php endif; ?>

	<form action="" method="POST" >
	  	<div class="form-group">
		    <label class="text-primary">Tên thành viên(*)</label>
		    <input type="text" class="form-control" name="HoTen" aria-describedby="emailHelp" placeholder="Họ và tên" value="<?php echo $data['HoTen'] ?>">
		    <?php if(isset($error['HoTen'])): ?>
				<p class="text-danger"><i class="fa fa-exclamation"></i> <?php echo $error['HoTen'] ?></p>
			<?php endif ?>
	  	</div>

      <div class="form-group">
        <label class="text-primary">Số điện thoại(*)</label>
        <input type="number" class="form-control" name="DienThoai" placeholder="Số điện thoại của bạn" value="<?php echo $data['DienThoai'] ?>">
        <?php if(isset($error['DienThoai'])): ?>
        <p class="text-danger"><i class="fa fa-exclamation"></i> <?php echo $error['DienThoai'] ?></p>
      <?php endif ?>
      </div>

	  	<div class="form-group">
		    <label class="text-primary">Email(*)</label>
		    <input type="email" class="form-control" name="Email" placeholder="Example@gmail.com" value="<?php echo $data['Email']?>">
		    <?php if(isset($error['Email'])): ?>
				<p class="text-danger"><i class="fa fa-exclamation"></i> <?php echo $error['Email'] ?></p>
			  <?php endif ?>
      <?php if(isset($_SESSION['error'])) :?>
        <div class="alert alert-danger"><i class="fa fa-times"></i>
        <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
        </div>
      <?php endif; ?>

	  	</div>
	  	<div class="form-group">
		    <label class="text-primary">Mật khẩu(*)</label>
		    <input type="password" class="form-control" name="MatKhau" placeholder="Tối thiểu 6 ký tự bao gồm cả chữ và số.">
		    <?php if(isset($error['MatKhau'])): ?>
				<p class="text-danger"><i class="fa fa-exclamation"></i> <?php echo $error['MatKhau'] ?></p>
			<?php endif ?>
	  	</div>

      <div class="form-group">
        <label class="text-primary">Nhập Lại Mật Khẩu(*)</label>
        <input type="password" class="form-control" name="re_password" placeholder="Tối thiểu 6 ký tự bao gồm cả chữ và số." required="">
        <?php if(isset($error['MatKhau'])): ?>
        <p class="text-danger"><i class="fa fa-exclamation"></i> <?php echo $error['MatKhau'] ?></p>
      <?php endif ?>
      </div>

      <div class="form-group">
        <label class="text-primary">Ngày tháng năm sinh(*)</label>
        <input type="date" class="form-control" name="NgaySinh" value="<?php echo $data['NgaySinh'] ?>">
        <?php if(isset($error['NgaySinh'])): ?>
        <p class="text-danger"><i class="fa fa-exclamation"></i> <?php echo $error['NgaySinh'] ?></p>
      <?php endif ?>
      </div>

      <div class="form-group">
          <select name="GioiTinh" class="form-control">
            <option value="" class="form-control">Giới tính(*)</option>       
              <option value="Nam">Nam</option>
              <option value="Nữ">Nữ</option>
          </select>
           <!--  Notification -->
          <?php if(isset($error['GioiTinh'])): ?>
            <p class="text-danger"><i class="fa fa-exclamation"></i> <?php echo $error['GioiTinh'] ?></p>
          <?php endif ?>
      </div>

	  	<div class="form-group">
		    <label class="text-primary">Địa chỉ(*)</label>
		    <input type="text" class="form-control" name="DiaChi" placeholder="Nơi bạn sẽ nhận hàng" value="<?php echo $data['DiaChi']  ?>">
		    <?php if(isset($error['DiaChi'])): ?>
				<p class="text-danger"><i class="fa fa-exclamation"></i> <?php echo $error['DiaChi'] ?></p>
			<?php endif ?>
	  	</div>  
	  	<button type="submit" class="btn btn-primary">Đăng Ký</button>
	</form>
</div>
</div>
</div>
</section>
	
<?php require_once __DIR__. "/layouts/footer.php";  ?>	
<?php if(isset($_SESSION['errorre'])) :?>
      <script>
            swal("Thông Báo!", "Đăng ký thất bại.");
      </script>
      <?php unset($_SESSION['errorre']); ?>
      <!-- <div class="alert alert-success"><i class="fa fa-check"></i>
      <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
      </div> -->
<?php endif; ?>
<?php 
 	$open ="users";
 	
  	require_once __DIR__. "/../../autoload/autoload.php";

	$id = intval(getInput('id'));

	$EditUsers= $db-> fetchID("users" ,$id);

	if(empty($EditUsers))
	{
	 	$_SESSION['error'] = "Dữ liệu không tồn tại.";
	  	redirectAdmin('user');
	}
	  	
	if(isset($_SESSION['admin_id']) && $_SESSION['admin_level'] >= 2) 
    {
	  	if($_SERVER["REQUEST_METHOD"] == "POST")
	  	{	

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

	  		if(postInput('HoTen') == '') 
	  		{
	  			$error['HoTen']="Mời bạn nhập đầy đủ họ tên."; 
	  		}
	  		if(strlen(postInput('HoTen'))  > 30 ) 
	      	{
	        	$error['HoTen']="Tên của bạn quá dài."; 
	      	}
	      	if(date("Y", strtotime(postInput('NgaySinh'))) < 1900 )
      		{
      		    $error['NgaySinh']="BẠN KHÔNG SỐNG LÂU THẾ ĐÂU =))."; 
      		}
      		
      		if(date("Y", strtotime(postInput('NgaySinh'))) > 2020 )
      		{
      		    $error['NgaySinh']="Năm sinh Không hợp lệ."; 
      		}

	      	if(strlen(postInput('Email'))  > 30 ) 
	      	{
	        	$error['Email']="Email của bạn quá dài."; 
	      	}
	  		if(postInput('Email') == '') 
	  		{
	  			$error['Email']="Mời bạn nhập email."; 
	  		}
	  		else
	  		{	
	  			if(postInput('Email') != $EditUsers['Email'] )
	  			{
	  				$is_check = $db -> fetchOne("users", " Email = '".$data['Email']."' ");
		  			if($is_check != NULL) 
		  			{
		  				$error['Email']="Email đã được sử dụng,Vui lòng dùng Email thoại khác."; 
		  			}
	  			}
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
		        if(postInput('DienThoai') != $EditUsers['DienThoai'] )
	  			{
	  				$is_check = $db -> fetchOne("users", " DienThoai = '".$data['DienThoai']."' ");
		  			if($is_check != NULL) 
		  			{
		  				$error['DienThoai']="Số điện thoại đã được sử dụng,Vui lòng dùng số điện thoại khác."; 
		  			}
	  			}
		    }

		    
	  		if(postInput('DiaChi') == '') 
	  		{
	  			$error['DiaChi']="Mời bạn nhập địa chỉ."; 
	  		}
	  		if(postInput('NgaySinh') == '') 
	      	{
	        	$error['NgaySinh']="Mời bạn chọn ngày tháng năm sinh."; 
	      	}
	      	if(postInput('GioiTinh') == '') 
	      	{
	       		$error['GioiTinh']="Mời bạn chọn giới tính."; 
	      	}
	  		
	      	if(postInput('MatKhau') == '') 
		  	{
		  			
		  		$data = [

			        "HoTen" => postInput('HoTen'),
		  			"Email" => postInput('Email'),
		  			"DienThoai" => postInput('DienThoai'),
		  			"DiaChi" => postInput('DiaChi'),
		  			"NgaySinh" =>postInput('NgaySinh'),
		        	"GioiTinh" =>postInput('GioiTinh'),

			  	];
			    if(empty($error)){
    			  	$id_update =$db->update("users",$data,array("id"=>$id));
                 	if($id_update)
    			    {
    			       	$_SESSION['success']="Cập Nhật thành công.";
    			       	redirectAdmin('user');
    				}
    			   	else
    			    {
    				   	$_SESSION['error']="Dữ liệu không thay đổi.";
    					redirectAdmin('user');
    			    }
			    }
		  	}
		  	else
		  	{
		  		if(strlen(postInput('MatKhau')) < 6 ) 
		      	{
			       	$error['MatKhau']="Mật khẩu tối thiểu là 6 ký tự."; 
			    }
			    if(strlen(postInput('MatKhau'))  > 20 ) 
			    {
			        $error['MatKhau']="Mật khẩu của bạn quá dài."; 
			    }
			    if(empty($error)) 
	      		{     
			  		$id_update =$db->update("users",$data,array("id"=>$id));
					if($id_update)
					{
					  	$_SESSION['success']="Cập Nhật thành công.";
					    redirectAdmin('user');
				  	}
					else
					{
					  	$_SESSION['error']="Dữ liệu không thay đổi.";
					  	redirectAdmin('user');
				  	}
		  		}
		  	}
		}
	}
   	else
    {
       	$_SESSION['error'] = "Bạn không thể thực hiện chức năng này.";
    }  
?>

<?php require_once __DIR__. "/../../layouts/header.php"; ?>        
 	<div class="row">
 		<div class="col-lg-12">
 			<nav aria-label="breadcrumb">
			  <ol class="breadcrumb">
			    <li class="breadcrumb-item"><a href="<?php echo base_url() ?>/admin"><i class="fas fa-fw fa-tachometer-alt"></i>Bảng Điều Khiển</a></li>
			    <li class="breadcrumb-item"><a href="<?php echo modules('user') ?>">Users</a></li>
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
    			<?php if(isset($_SESSION['admin_id']) && $_SESSION['admin_level'] >= 2): ?>
    			<label for="exampleInputEmail1"><h1 class="text-primary">Cập Nhật Users</h1></label>
	    			<form  action="" method="POST" enctype="multipart/form-data">
					  	<div class="form-group row">
					    <label for="staticEmail" class="col-sm-4 col-form-label"><b class="text-primary">Họ và Tên(*)</b></label>
						    <div class="col-sm-12">
						      	<input type="text" class="form-control" id="input" placeholder="Họ và Tên" name="HoTen" value="<?php echo $EditUsers['HoTen'] ?>">
							   	 <!--  Notification -->
			            		<?php if(isset($error['HoTen'])): ?>
							   		<p class="text-danger"><i class="fas fa-exclamation"></i> <?php echo $error['HoTen'] ?></p>
							    <?php endif ?>
						    </div>
						</div>

					  	<div class="form-group row">
					    <label for="inputPassword" class="col-sm-4 col-form-label"><b class="text-primary">Email(*)</b></label>
						    <div class="col-sm-12">
						        <input type="email" class="form-control" id="input" placeholder="Exemple@gmail.com" name="Email"  value="<?php echo $EditUsers['Email'] ?>">
							   	 <!--  Notification -->
			            		<?php if(isset($error['Email'])): ?>
							   		<p class="text-danger"><i class="fas fa-exclamation"></i> <?php echo $error['Email'] ?></p>
							    <?php endif ?>
						    </div>
					 	</div>
						
						<div class="form-group row">
					    <label for="inputPassword" class="col-sm-4 col-form-label"><b class="text-primary">Số Điện Thoại(*)</b></label>
						    <div class="col-sm-12">
						        <input type="number" class="form-control" id="input" placeholder="Số điện thoại" name="DienThoai"  value="<?php echo $EditUsers['DienThoai'] ?>">
							   	 <!--  Notification -->
			            		<?php if(isset($error['DienThoai'])): ?>
							   		<p class="text-danger"><i class="fas fa-exclamation"></i> <?php echo $error['DienThoai'] ?></p>
							    <?php endif ?>
						    </div>
					 	</div>

					 	<div class="form-group row">
					    <label for="inputPassword" class="col-sm-4 col-form-label"><b class="text-primary">Ngày Sinh(*)</b></label>
						    <div class="col-sm-12">
						        <input type="date" class="form-control" id="input" placeholder="Ngày Sinh" name="NgaySinh"  value="<?php echo $EditUsers['NgaySinh'] ?>">
							   	 <!--  Notification -->
			            		<?php if(isset($error['NgaySinh'])): ?>
							   		<p class="text-danger"><i class="fas fa-exclamation"></i> <?php echo $error['NgaySinh'] ?></p>
							    <?php endif ?>
						    </div>
					 	</div>

					 	<div class="form-group row">
					    <label for="inputPassword" class="col-sm-4 col-form-label"><b class="text-primary">Giới Tính(*)</b></label>
						    <div class="col-sm-12">
						        <select name="GioiTinh" class="form-control item-category">
						            <option value="" class="text-primary">Giới tính</option>  
						              <option value="<?php echo $EditUsers['GioiTinh'] ?>" <?php echo $EditUsers['GioiTinh'] ? "selected  =' selected '" : '' ?>><?php echo $EditUsers['GioiTinh'] ?></option>
							            <?php if($EditUsers['GioiTinh'] == 'Nam'): ?>
							                <option value="Nữ">Nữ</option>
							            <?php else: ?>
							                <option value="Nam">Nam</option>
							            <?php endif; ?>
						        </select>
							   	 <!--  Notification -->
			            		<?php if(isset($error['GioiTinh'])): ?>
							   		<p class="text-danger"><i class="fas fa-exclamation"></i> <?php echo $error['GioiTinh'] ?></p>
							    <?php endif ?>
						    </div>
					 	</div>

					 	<div class="form-group row">
					    <label for="inputPassword" class="col-sm-4 col-form-label"><b class="text-primary">Mật Khẩu(*)</b></label>
						    <div class="col-sm-12">
						        <input type="password" class="form-control" id="id" placeholder="Độ dài tối thiểu là 6 ký tự số và chữ." name="MatKhau">
						        <input type="checkbox" onclick="myFunction()">Hiển Thị
							   	 <!--  Notification -->
			            		<?php if(isset($error['MatKhau'])): ?>
							   		<p class="text-danger"><i class="fas fa-exclamation"></i> <?php echo $error['MatKhau'] ?></p>
							    <?php endif ?>
						    </div>
					 	</div>

						<div class="form-group row">
					    <label for="inputPassword" class="col-sm-4 col-form-label"><b class="text-primary">Địa Chỉ(*)</b></label>
						    <div class="col-sm-12">
						        <input type="text" class="form-control" id="input" placeholder=" 320A, QL61, Vĩnh Hoà Hiệp, Châu Thành, tỉnh Kiên Giang" name="DiaChi"
						         value="<?php echo $EditUsers['DiaChi'] ?>">
							   	 <!--  Notification -->
			            		<?php if(isset($error['DiaChi'])): ?>
							   		<p class="text-danger"><i class="fas fa-exclamation"></i> <?php echo $error['DiaChi'] ?></p>
							    <?php endif ?>
						    </div>
					 	</div>
				  	<?php endif; ?>

				  	<a href="<?php echo  modules('user') ?>" class="btn btn-primary btn-sm"><i class="fas fa-angle-double-left"></i></a>
				  	<button type="submit" class="btn btn-primary btn-sm">Lưu</button>
				</form>

    		</div>
    	</div>    
    </div>
    <!-- /.container-fluid -->
    </div>
    <!-- End of Main Content -->
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

  	$(document).ready(function() {

	    var readURL = function(input) {
	        if (input.files && input.files[0]) {
	            var reader = new FileReader();

	            reader.onload = function (e) {
	                $('.avatar').attr('src', e.target.result);
	            }
	    
	            reader.readAsDataURL(input.files[0]);
	        }
	    }
    
    $(".file-upload").on('change', function(){
        readURL(this);
    });
}); 
  	</script>
<?php require_once __DIR__. "/../../layouts/footer.php";  ?>
<?php 
 	$open ="admin";
 	
  	require_once __DIR__. "/../../autoload/autoload.php";

  	$id = intval(getInput('id'));

  	$EditAdmin= $db-> fetchID("admin" ,$id);
  	
  	$admin_id = intval($_SESSION['admin_id']);

  	if($admin_id == $id) 
  	{
  		$sql="SELECT * FROM admin WHERE id = $admin_id";
	  	$EditAdmin2= $db-> fetchsql($sql);

	  	if(empty($EditAdmin))
	  	{
	  		header("Location: ". base_url() ."admin/modules/admin/profile.php?id=$admin_id");
	  		$_SESSION['dataerror']="";
	  	}
	  	
	  	if($_SERVER["REQUEST_METHOD"] == "POST")
	  	{	

	  		$data = [
	  		"HoTen" => postInput('HoTen'),
  			"Email" => postInput('Email'),
  			"DienThoai" => postInput('DienThoai'),
  			"DiaChi" => postInput('DiaChi'),
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
		  		if(postInput('Email') != $EditAdmin['Email'] )
		  		{
		  			$is_check = $db -> fetchOne("admin", " Email = '".$data['Email']."' ");
			  		if($is_check != NULL) 
			  		{
			  			$error['Email']="Email đã được sử dụng,Vui lòng dùng Email thoại khác."; 
			  		}
		  		}
	  			
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
			    if(postInput('DienThoai') != $EditAdmin['DienThoai'] )
		  		{
		  			$is_check = $db -> fetchOne("admin", " DienThoai = '".$data['DienThoai']."' ");
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
	      	if(isset($_FILES["AnhDD"]) && $_FILES["AnhDD"]["error"] == 0)
	      	{
		        $target_dir    = "uploads/";
		        $target_file   = $target_dir . basename($_FILES["AnhDD"]["name"]);
		        $maxfilesize   =  2048000;
		        $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
		        $allowed    = array('jpg', 'png', 'jpeg');
		        //$allowed = array("jpg" => "image/jpg", "jpeg" => "image/jpeg", "png" => "image/png");
		        if($_FILES["AnhDD"]["size"] > $maxfilesize)
		        {
		            $error['AnhDD'] ="Dung lượng file không được lớn hơn 2MB";
		        }
		        if (!in_array($imageFileType,$allowed))
		        {
		          $error['AnhDD'] = "Chỉ được upload các định dạng JPG, PNG, JPEG";
		        }
	      	}
           
	  		
	  		if(empty($error)) 
	      	{	
	      		if(isset($_FILES['AnhDD']))
	          	{
		            $file_name =$_FILES['AnhDD']['name'];
		            $file_type =$_FILES['AnhDD']['type'];
		            $file_error =$_FILES['AnhDD']['error']; 

		            $extension = pathinfo($file_name,PATHINFO_EXTENSION);
		            $random = rand(0,100000);
		            $rename = date('Ymd').'_'.$random;
		            $newname = $rename.'.'.$extension;

		            $file_tmp =$_FILES['AnhDD']['tmp_name'];
		            if($file_error == 0)
		            {
		              $part =ROOT ."admin/";
		              $data['AnhDD'] =$newname;
		            }
	          	}
		        $id_update =$db->update("admin",$data,array("id"=>$id));
		        if($id_update)
		        {	
		           	if(isset($_FILES["AnhDD"]) && $_FILES["AnhDD"]["error"] == 0)
	      	        {
		            	move_uploaded_file($file_tmp,$part.$newname);
		            }
		       		header("Location: ". base_url() ."admin/modules/admin/profile.php?id=$admin_id");
		       		$_SESSION['add']="";
	  			}
		        else
		        {
		       		header("Location: ". base_url() ."admin/modules/admin/profile.php?id=$admin_id");
		       		$_SESSION['empty']="";
	  			}
	  		} 
	  	}  
  	}
  	else
  	{
  		header("Location: ". base_url() ."admin/modules/admin/profile.php?id=$admin_id");
  		$_SESSION['dataerror']="";
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
    			<label for="exampleInputEmail1"><h1 class="text-primary">Cập Nhật Admin</h1></label>
	    			<form  action="" method="POST" enctype="multipart/form-data">
						<?php foreach ($EditAdmin2 as $value): ?>
					  	<div class="form-group row">
					    <label for="staticEmail" class="col-sm-4 col-form-label"><b class="text-primary">Họ và Tên(*)</b></label>
						    <div class="col-sm-12">
						      	<input type="text" class="form-control" id="input" placeholder="Họ và Tên" name="HoTen" value="<?php echo $value['HoTen'] ?>">
							   	 <!--  Notification -->
			            		<?php if(isset($error['HoTen'])): ?>
							   		<p class="text-danger"><i class="fas fa-exclamation"></i> <?php echo $error['HoTen'] ?></p>
							    <?php endif ?>
						    </div>
						</div>

					  	<div class="form-group row">
					    <label for="inputPassword" class="col-sm-4 col-form-label"><b class="text-primary">Email(*)</b></label>
						    <div class="col-sm-12">
						        <input type="email" class="form-control" id="input" placeholder="Exemple@gmail.com" name="Email"  value="<?php echo $value['Email'] ?>">
							   	 <!--  Notification -->
			            		<?php if(isset($error['Email'])): ?>
							   		<p class="text-danger"><i class="fas fa-exclamation"></i> <?php echo $error['Email'] ?></p>
							    <?php endif ?>
						    </div>
					 	</div>
						
						<div class="form-group row">
					    <label for="inputPassword" class="col-sm-4 col-form-label"><b class="text-primary">Số Điện Thoại(*)</b></label>
						    <div class="col-sm-12">
						        <input type="number" class="form-control" id="input" placeholder="Số điện thoại" name="DienThoai"  value="<?php echo $value['DienThoai'] ?>">
							   	 <!--  Notification -->
			            		<?php if(isset($error['DienThoai'])): ?>
							   		<p class="text-danger"><i class="fas fa-exclamation"></i> <?php echo $error['DienThoai'] ?></p>
							    <?php endif ?>
						    </div>
					 	</div>

					 	<div class="form-group row">
						    <label for="inputPassword" class="col-sm-2 col-form-label"><b class="text-primary">Hình Ảnh(*)</b></label>
						    <div class="col-sm-12">
						        <input type="file" class="form-control" id="input" name="AnhDD">
						       	<?php if(isset($error['AnhDD'])): ?>
							   		<p class="text-danger"> <i class="fas fa-exclamation"></i><?php echo $error['AnhDD'] ?></p>
							    <?php endif ?>
						    </div>
					 	</div>

					 	<div class="form-group row">
					    <label for="inputPassword" class="col-sm-4 col-form-label"><b class="text-primary">Ngày Sinh(*)</b></label>
						    <div class="col-sm-12">
						        <input type="date" class="form-control" id="input" placeholder="Ngày Sinh" name="NgaySinh"  value="<?php echo $value['NgaySinh'] ?>">
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
						              <option value="<?php echo $value['GioiTinh'] ?>" <?php echo $value['GioiTinh'] ? "selected  =' selected '" : '' ?>><?php echo $value['GioiTinh'] ?></option>
							            <?php if($value['GioiTinh'] == 'Nam'): ?>
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
					    <label for="inputPassword" class="col-sm-4 col-form-label"><b class="text-primary">Địa Chỉ(*)</b></label>
						    <div class="col-sm-12">
						        <input type="text" class="form-control" id="input" placeholder=" 320A, QL61, Vĩnh Hoà Hiệp, Châu Thành, tỉnh Kiên Giang" name="DiaChi"
						         value="<?php echo $value['DiaChi'] ?>">
							   	 <!--  Notification -->
			            		<?php if(isset($error['DiaChi'])): ?>
							   		<p class="text-danger"><i class="fas fa-exclamation"></i> <?php echo $error['DiaChi'] ?></p>
							    <?php endif ?>
						    </div>
					 	</div>
					 	<?php endforeach; ?>
				  	<a href="<?php echo modules('admin').'/profile.php?id='?><?php echo $_SESSION['admin_id'] ?>" class="btn btn-primary btn-sm"><i class="fa fa-angle-double-left"></i></a>
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
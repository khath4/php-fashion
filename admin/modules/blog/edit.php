<?php 

    $open ="blog";
    require_once __DIR__. "/../../autoload/autoload.php"; 

    $id = intval(getInput('id'));

    $EditBlog= $db-> fetchID("blog" ,$id);

    if(empty($EditBlog))
    {
      $_SESSION['error'] = "Dữ liệu không tồn tại.";
      redirectAdmin('blog');
    }
    
    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
     	$data = [
  			"TieuDe" => postInput('TieuDe'),
  			"TomTat" => postInput('TomTat'),
  			"NoiDung" => postInput('NoiDung'),
  			'Created_by' => $_SESSION['admin_id'],
  			'Update_by' => $_SESSION['admin_id']
  		];
     	$error=[];

      	if(postInput('TieuDe') == '') 
  		{
  			$error['TieuDe']="Mời bạn nhập tiêu đề."; 
  		}
  		if(strlen(postInput('TieuDe'))  > 200 ) 
      	{
        	$error['TieuDe']="Tiêu đề quá dài."; 
      	}

  		if(postInput('TomTat') == '') 
  		{
  			$error['TomTat']="Mời bạn nhập tóm tắt."; 
  		}
  		if(strlen(postInput('TomTat'))  > 400 ) 
      	{
        	$error['TomTat']="Tóm tắt quá dài."; 
      	}

  		if(postInput('NoiDung') == '') 
  		{
  			$error['NoiDung']="Mời bạn nhập nội dung."; 
  		}

      	if(isset($_FILES["Hinh"]) && $_FILES["Hinh"]["error"] == 0)
      	{
	        $target_dir    = "uploads/";
	        $target_file   = $target_dir . basename($_FILES["Hinh"]["name"]);
	        $maxfilesize   =  2048000;
	        $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
	        $allowed    = array('jpg', 'png', 'jpeg');
	        //$allowed = array("jpg" => "image/jpg", "jpeg" => "image/jpeg", "png" => "image/png");
	        if($_FILES["Hinh"]["size"] > $maxfilesize)
	        {
	            $error['Hinh'] ="Dung lượng file không được lớn hơn 2MB";
	        }
	        if (!in_array($imageFileType,$allowed))
	        {
	          $error['Hinh'] = "Chỉ được upload các định dạng JPG, PNG, JPEG";
	        }
      	}
           
            
      	if(empty($error)) 
        {
          	if(isset($_FILES['Hinh']))
          	{
	            $file_name =$_FILES['Hinh']['name'];
	            $file_type =$_FILES['Hinh']['type'];
	            $file_error =$_FILES['Hinh']['error']; 

	            $extension = pathinfo($file_name,PATHINFO_EXTENSION);
		        $random = rand(0,100000);
		        $rename = date('Ymd').'_'.$random;
		        $newname = $rename.'.'.$extension;

		        $file_tmp =$_FILES['Hinh']['tmp_name'];
	            if($file_error == 0)
	            {
	              $part =ROOT ."blog/";
	              $data['Hinh'] =$newname;
	            }
          	}
          	$update =$db -> update("blog", $data, array("id" => $id));

          	if($update > 0)
          	{
          	    if(isset($_FILES["Hinh"]) && $_FILES["Hinh"]["error"] == 0)
      	        {
	                move_uploaded_file($file_tmp,$part.$newname);
      	        }
	            $_SESSION['success']="Cập nhật thông tin thành công.";
	            redirectAdmin('blog');
          	}
          	else
          	{
	            $_SESSION['error']="Dữ liệu không thay đổi.";
	            redirectAdmin('blog');
          	}
      	}
    }  
?>
<?php require_once __DIR__. "/../../layouts/header.php"; ?>        
  <div class="row">
    <div class="col-lg-12">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?php echo base_url() ?>/admin"><i class="fas fa-fw fa-tachometer-alt"></i>Bảng Điều Khiển</a></li>
          <li class="breadcrumb-item"><a href="<?php echo modules('blog') ?>">Quản Lý Blog</a></li>
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
	          <label for="exampleInputEmail1"><h1 class="text-primary">Cập Nhật Blog</h1></label>
	            <form  action="" method="POST" enctype="multipart/form-data">
              		<div class="form-group row">
					    <label for="staticEmail" class="col-sm-4 col-form-label"><b class="text-primary">Tiêu Đề(*)</b></label>
						    <div class="col-sm-12">
						      	<input type="text" class="form-control" id="input" placeholder="Tiêu đề blog..." name="TieuDe" value="<?php echo $EditBlog['TieuDe'] ?>" >
							   	 <!--  Notification -->
			            		<?php if(isset($error['TieuDe'])): ?>
							   		<p class="text-danger"><i class="fas fa-exclamation"></i> <?php echo $error['TieuDe'] ?></p>
							    <?php endif ?>
						    </div>
						</div>

					  	<div class="form-group row" nowrap="nowrap">
					    <label for="inputPassword" class="col-sm-4 col-form-label"><b class="text-primary">Tóm Tắt(*)</b></label>
						    <div class="col-sm-12">
						       	<textarea name="TomTat" class="form-control" cols="170" rows="4"><?php echo $EditBlog['TomTat'] ?></textarea>
							   	<!--  Notification -->
			            		<?php if(isset($error['TomTat'])): ?>
							   		<p class="text-danger"><i class="fas fa-exclamation"></i> <?php echo $error['TomTat'] ?></p>
							    <?php endif ?>
						    </div>
					 	</div>
						
					  	<div class="form-group row">
						    <label for="inputPassword" class="col-sm-2 col-form-label"><b class="text-primary">Hình Ảnh(*)</b></label>
						    <div class="col-sm-8">
						        <input type="file" class="form-control" id="input" name="Hinh">
						       	<?php if(isset($error['Hinh'])): ?>
							   		<p class="text-danger"> <i class="fas fa-exclamation"></i><?php echo $error['Hinh'] ?></p>
							    <?php endif ?>

						    </div>
						    <img src="<?php echo uploads() ?>blog/<?php echo $EditBlog['Hinh'] ?>" width="150px" height="80px" alt="">
					 	</div>

					  	<div class="form-group row" nowrap="nowrap">
					    <label for="inputPassword" class="col-sm-4 col-form-label"><b class="text-primary">Nội Dung(*)</b></label>
						    <div class="col-sm-12">
						       	<textarea name="NoiDung" id="ckcontent" cols="195" rows="5"><?php echo $EditBlog['NoiDung'] ?></textarea>
							   	<!--  Notification -->
			            		<?php if(isset($error['NoiDung'])): ?>
							   		<p class="text-danger"><i class="fas fa-exclamation"></i> <?php echo $error['NoiDung'] ?></p>
							    <?php endif ?>
						    </div>
					 	  </div>
		          <a href="<?php echo modules('blog') ?>" class="btn btn-primary btn-sm"><i class="fa fa-angle-double-left"></i></a>
              <button type="submit" class="btn btn-primary btn-sm">Lưu</button>
        		</form>
        	</div>
      	</div>    
    </div>
    <!-- /.container-fluid -->
    </div>
    <!-- End of Main Content -->
    <script>
      CKEDITOR.replace( 'ckcontent' );
  </script>

<?php require_once __DIR__. "/../../layouts/footer.php";  ?>

<?php 
 	$open ="banner";
  	require_once __DIR__. "/../../autoload/autoload.php"; 

  	$id = intval(getInput('id'));
  	$EditBanner= $db-> fetchID("banner" ,$id);

	if(empty($EditBanner))
    {
      $_SESSION['error'] = "Dữ liệu không tồn tại.";
      redirectAdmin('banner');
    }

  	$data = [
  			"TieuDe" => postInput('TieuDe'),
  			"NoiDung" => postInput('NoiDung'),
  		];

  	$error=[];

  	if($_SERVER["REQUEST_METHOD"] == "POST")
  	{
  		
  		if(postInput('TieuDe') == '') 
  		{
  			$error['TieuDe']="Mời bạn nhập tiêu đề banner."; 
  		}
  		if(strlen(postInput('TieuDe'))  > 100 ) 
      	{
        	$error['TieuDe']="Tiêu đề banner quá dài."; 
      	}

  		if(postInput('NoiDung') == '') 
  		{
  			$error['NoiDung']="Mời bạn nhập nội dung banner."; 
  		}
  		if(strlen(postInput('NoiDung'))  > 300 ) 
      	{
        	$error['NoiDung']="Nội dung banner quá dài."; 
      	}
  		
  		if(isset($_FILES["AnhBanner"]) && $_FILES["AnhBanner"]["error"] == 0)
      	{
	        $target_dir    = "uploads/";
	        $target_file   = $target_dir . basename($_FILES["AnhBanner"]["name"]);
	        $maxfilesize   =  2048000;
	        $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
	        $allowed    = array('jpg', 'png', 'jpeg');
	        //$allowed = array("jpg" => "image/jpg", "jpeg" => "image/jpeg", "png" => "image/png");
	        if($_FILES["AnhBanner"]["size"] > $maxfilesize)
	        {
	            $error['AnhBanner'] ="Dung lượng file không được lớn hơn 2MB";
	        }
	        if (!in_array($imageFileType,$allowed))
	        {
	          $error['AnhBanner'] = "Chỉ được upload các định dạng JPG, PNG, JPEG";
	        }
      	}
  		if(empty($error)) 
      	{
	       if(isset($_FILES['AnhBanner']))
	        {
	        	$file_name = $_FILES['AnhBanner']['name'];
	        	
	        	$file_type = $_FILES['AnhBanner']['type'];
	        	$file_error = $_FILES['AnhBanner']['error'];

	        	$extension = pathinfo($file_name,PATHINFO_EXTENSION);
	        	$random = rand(0,100000);
	        	$rename = date('Ymd').'_'.$random;
	        	$newname = $rename.'.'.$extension;
	        
	        	$file_tmp = $_FILES['AnhBanner']['tmp_name'];
	        	
	        	if($file_error == 0)
	        	{
	        		$part =ROOT ."banner/";
	        		$data['AnhBanner'] =$newname;
	        	}        	
	        }
	        $update =$db -> update("banner" , $data , array("id" => $id));
	       
	        if($update > 0)
	        {	
	            if(isset($_FILES["AnhBanner"]) && $_FILES["AnhBanner"]["error"] == 0)
      	        {
	       		    move_uploaded_file($file_tmp,$part.$newname);
      	        }
	       		$_SESSION['success']="Cập nhật thành công.";
	       		redirectAdmin('banner');
	        }
	        else
	        {
	       		$_SESSION['error']="Dữ Liệu không thay đổi.";
	       		redirectAdmin('banner');
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
			    <li class="breadcrumb-item"><a href="<?php echo modules('banner') ?>">Quản Lý Banner</a></li>
			    <li class="breadcrumb-item active" aria-current="page">Thêm Mới</li>
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
    			<label for="exampleInputEmail1"><h1 class="text-primary">Thêm Mới Banner</h1></label>
	    			<form  action="" method="POST" enctype="multipart/form-data">

					  	<div class="form-group row">
					    <label for="staticEmail" class="col-sm-4 col-form-label"><b class="text-primary">Tiêu Đề(*)</b></label>
						    <div class="col-sm-12">
						      	<input type="text" class="form-control" id="input" placeholder="Tiêu đề banner" name="TieuDe" value="<?php echo $EditBanner['TieuDe'] ?>" >
							   	 <!--  Notification -->
			            		<?php if(isset($error['TieuDe'])): ?>
							   		<p class="text-danger"><i class="fas fa-exclamation"></i> <?php echo $error['TieuDe'] ?></p>
							    <?php endif ?>
						    </div>
						</div>

					  	<div class="form-group row">
						    <label for="inputPassword" class="col-sm-2 col-form-label"><b class="text-primary">Hình Banner(*)</b></label>
						    <div class="col-sm-8">
						        <input type="file" class="form-control" id="input" name="AnhBanner">
						       	<?php if(isset($error['AnhBanner'])): ?>
							   		<p class="text-danger"> <i class="fas fa-exclamation"></i><?php echo $error['AnhBanner'] ?></p>
							    <?php endif ?>
						    </div>
						    <img src="<?php echo uploads() ?>banner/<?php echo $EditBanner['AnhBanner'] ?>" width="200px" height="150px" alt="">
					 	</div>

					  	<div class="form-group row" nowrap="nowrap">
					    <label for="inputPassword" class="col-sm-4 col-form-label"><b class="text-primary">Nội Dung Banner(*)</b></label>
						    <div class="col-sm-12">
						       	<textarea class="form-control" name="NoiDung" cols="173" rows="3"><?php echo $EditBanner['NoiDung'] ?></textarea>
							   	<!--  Notification -->
			            		<?php if(isset($error['NoiDung'])): ?>
							   		<p class="text-danger"><i class="fas fa-exclamation"></i> <?php echo $error['NoiDung'] ?></p>
							    <?php endif ?>
						    </div>
					 	</div>
					 	<a href="<?php echo modules('banner') ?>" class="btn btn-primary btn-sm"><i class="fa fa-angle-double-left"></i></a>
				  		<button type="submit" id="submit" class="btn btn-primary btn-sm">Lưu</button>
				</form>
    		</div>
    	</div>    
    </div>
    <!-- /.container-fluid -->
    </div>

<?php require_once __DIR__. "/../../layouts/footer.php";  ?>
 
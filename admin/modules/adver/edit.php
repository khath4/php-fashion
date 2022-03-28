<?php 
 	$open ="adver";
  	require_once __DIR__. "/../../autoload/autoload.php"; 

  	$id = intval(getInput('id'));
  	$EiditAdver= $db-> fetchID("adver" ,$id);

	if(empty($EiditAdver))
    {
      $_SESSION['error'] = "Dữ liệu không tồn tại.";
      redirectAdmin('adver');
    }

  	$data = [
  			"DuongDan" => postInput('DuongDan'),
  		];

  	$error=[];

  	if($_SERVER["REQUEST_METHOD"] == "POST")
  	{
  		
  		if(postInput('DuongDan') == '') 
  		{
  			$error['DuongDan']="Mời bạn nhập đường dẫn cho quảng cáo."; 
  		}
  		if(strlen(postInput('DuongDan'))  > 200 ) 
      	{
        	$error['DuongDan']="Đương Dẫn quá dài quá dài."; 
      	}
  		
  		if(isset($_FILES["AnhAdver"]) && $_FILES["AnhAdver"]["error"] == 0)
      	{
	        $target_dir    = "uploads/";
	        $target_file   = $target_dir . basename($_FILES["AnhAdver"]["name"]);
	        $maxfilesize   =  2048000;
	        $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
	        $allowed    = array('jpg', 'png', 'jpeg');
	        //$allowed = array("jpg" => "image/jpg", "jpeg" => "image/jpeg", "png" => "image/png");
	        if($_FILES["AnhAdver"]["size"] > $maxfilesize)
	        {
	            $error['AnhAdver'] ="Dung lượng file không được lớn hơn 2MB";
	        }
	        if (!in_array($imageFileType,$allowed))
	        {
	          $error['AnhAdver'] = "Chỉ được upload các định dạng JPG, PNG, JPEG";
	        }
      	}
  		if(empty($error)) 
      	{
	       if(isset($_FILES['AnhAdver']))
	        {
	        	$file_name = $_FILES['AnhAdver']['name'];
	        	
	        	$file_type = $_FILES['AnhAdver']['type'];
	        	$file_error = $_FILES['AnhAdver']['error'];

	        	$extension = pathinfo($file_name,PATHINFO_EXTENSION);
	        	$random = rand(0,100000);
	        	$rename = date('Ymd').'_'.$random;
	        	$newname = $rename.'.'.$extension;
	        
	        	$file_tmp = $_FILES['AnhAdver']['tmp_name'];
	        	
	        	if($file_error == 0)
	        	{
	        		$part =ROOT ."adver/";
	        		$data['AnhAdver'] =$newname;
	        	}        	
	        }
	        $update =$db -> update("adver" , $data , array("id" => $id));
	       
	        if($update > 0)
	        {	
	            if(isset($_FILES["AnhAdver"]) && $_FILES["AnhAdver"]["error"] == 0)
      	        {
	       		    move_uploaded_file($file_tmp,$part.$newname);
      	        }
	       		$_SESSION['success']="Cập nhật thành công.";
	       		redirectAdmin('adver');
	        }
	        else
	        {
	       		$_SESSION['error']="Dữ Liệu không thay đổi.";
	       		redirectAdmin('adver');
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
			    <li class="breadcrumb-item"><a href="<?php echo modules('adver') ?>">Quản Lý Quảng Cáo</a></li>
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
    			<label for="exampleInputEmail1"><h1 class="text-primary">Thêm Mới Quảng Cáo</h1></label>
	    			<form  action="" method="POST" enctype="multipart/form-data">

					  	<div class="form-group row">
					    <label for="staticEmail" class="col-sm-4 col-form-label"><b class="text-primary">Đường Dẫn(*)</b></label>
						    <div class="col-sm-12">
						      	<input type="text" class="form-control" id="input" placeholder="Đường Dẫn Quảng Cáo" name="DuongDan" value="<?php echo $EiditAdver['DuongDan'] ?>" >
							   	 <!--  Notification -->
			            		<?php if(isset($error['DuongDan'])): ?>
							   		<p class="text-danger"><i class="fas fa-exclamation"></i> <?php echo $error['DuongDan'] ?></p>
							    <?php endif ?>
						    </div>
						</div>

					  	<div class="form-group row">
						    <label for="inputPassword" class="col-sm-2 col-form-label"><b class="text-primary">Hình Quảng Cáo(*)</b></label>
						    <div class="col-sm-8">
						        <input type="file" class="form-control" id="input" name="AnhAdver">
						       	<?php if(isset($error['AnhAdver'])): ?>
							   		<p class="text-danger"> <i class="fas fa-exclamation"></i><?php echo $error['AnhAdver'] ?></p>
							    <?php endif ?>
						    </div>
						    <img src="<?php echo uploads() ?>adver/<?php echo $EiditAdver['AnhAdver'] ?>" width="200px" height="150px" alt="">
					 	</div>

					 	<a href="<?php echo modules('adver') ?>" class="btn btn-primary btn-sm"><i class="fa fa-angle-double-left"></i></a>
				  		<button type="submit" id="submit" class="btn btn-primary btn-sm">Lưu</button>
				</form>
    		</div>
    	</div>    
    </div>
    <!-- /.container-fluid -->
    </div>
    <!-- End of Main Content -->
<?php require_once __DIR__. "/../../layouts/footer.php";  ?>
 
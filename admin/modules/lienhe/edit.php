<?php 
 	$open ="lienhe";
  	require_once __DIR__. "/../../autoload/autoload.php"; 

  	$id = intval(getInput('id'));
  	$Editlienhe= $db-> fetchID("lienhe" ,$id);

	if(empty($Editlienhe))
    {
      $_SESSION['error'] = "Dữ liệu không tồn tại.";
      redirectAdmin('adver');
    }

  	$data = [
  			"Email" => postInput('Email'),
  			"DienThoai" => postInput('DienThoai'),
  			"LinkFace" => postInput('LinkFace'),
  			"KinhDo" => postInput('KinhDo'),
  			"ViDo" => postInput('ViDo'),
  			"DiaChi" => postInput('DiaChi'),
  		];

  	$error=[];

  	if($_SERVER["REQUEST_METHOD"] == "POST")
  	{
  		
  		if(postInput('Email') == '') 
  		{
  			$error['Email']="Mời bạn nhập email."; 
  		}
  		if(strlen(postInput('Email'))  > 100 ) 
      	{
        	$error['Email']="Email quá dài quá dài."; 
      	}
  		
  		if(postInput('DienThoai') == '') 
  		{
  			$error['DienThoai']="Mời bạn nhập số điện thoại."; 
  		}
  		if(strlen(postInput('DienThoai'))  > 12 ) 
      	{
        	$error['DienThoai']="Số điện thoại quá dài quá dài."; 
      	}
      	
      	if(postInput('LinkFace') == '') 
  		{
  			$error['LinkFace']="Mời bạn nhập link facebook."; 
  		}
  		if(strlen(postInput('LinkFace'))  > 50 ) 
      	{
        	$error['LinkFace']="Link facebook quá dài quá dài."; 
      	}
  	    
  	    if(postInput('KinhDo') == '') 
  		{
  			$error['KinhDo']="Mời bạn nhập kinh độ."; 
  		}
  		if(strlen(postInput('KinhDo'))  > 15 ) 
      	{
        	$error['KinhDo']="Kinh độ quá dài quá dài."; 
      	}
      	
      	if(postInput('ViDo') == '') 
  		{
  			$error['ViDo']="Mời bạn nhập vĩ độ."; 
  		}
  		if(strlen(postInput('ViDo'))  > 15 ) 
      	{
        	$error['ViDo']="Vĩ độ quá dài quá dài."; 
      	}
      	
      	if(postInput('ViDo') == '') 
  		{
  			$error['ViDo']="Mời bạn nhập địa chỉ."; 
  		}
  		if(strlen(postInput('ViDo'))  > 100 ) 
      	{
        	$error['ViDo']="Địa chỉ quá dài quá dài."; 
      	}
  			
    
  		if(empty($error)) 
      	{
	        $update =$db -> update("lienhe" , $data , array("id" => $id));
	       
	        if($update > 0)
	        {	
	       		$_SESSION['success']="Cập nhật thành công.";
	       		redirectAdmin('lienhe');
	        }
	        else
	        {
	       		$_SESSION['error']="Dữ Liệu không thay đổi.";
	       		redirectAdmin('lienhe');
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
					    <label for="staticEmail" class="col-sm-4 col-form-label"><b class="text-primary">Địa Chỉ Email</b></label>
						    <div class="col-sm-12">
						      	<input type="text" class="form-control" id="input" placeholder="Email shop" name="Email" value="<?php echo $Editlienhe['Email'] ?>" >
							   	 <!--  Notification -->
			            		<?php if(isset($error['Email'])): ?>
							   		<p class="text-danger"><i class="fas fa-exclamation"></i> <?php echo $error['Email'] ?></p>
							    <?php endif ?>
						    </div>
						</div>
						
						  	<div class="form-group row">
					    <label for="staticEmail" class="col-sm-4 col-form-label"><b class="text-primary">Số Điện Thoại </b></label>
						    <div class="col-sm-12">
						      	<input type="text" class="form-control" id="input" placeholder="Số điện thoại shop" name="DienThoai" value="<?php echo $Editlienhe['DienThoai'] ?>" >
							   	 <!--  Notification -->
			            		<?php if(isset($error['DienThoai'])): ?>
							   		<p class="text-danger"><i class="fas fa-exclamation"></i> <?php echo $error['DienThoai'] ?></p>
							    <?php endif ?>
						    </div>
						</div>
                
                        <div class="form-group row">
					    <label for="staticEmail" class="col-sm-4 col-form-label"><b class="text-primary">Link Facebook</b></label>
						    <div class="col-sm-12">
						      	<input type="text" class="form-control" id="input" placeholder="Đường Dẫn Quảng Cáo" name="LinkFace" value="<?php echo $Editlienhe['LinkFace'] ?>" >
							   	 <!--  Notification -->
			            		<?php if(isset($error['LinkFace'])): ?>
							   		<p class="text-danger"><i class="fas fa-exclamation"></i> <?php echo $error['LinkFace'] ?></p>
							    <?php endif ?>
						    </div>
						</div>
						
						 <div class="form-group row">
					    <label for="staticEmail" class="col-sm-4 col-form-label"><b class="text-primary">Kinh Độ</b></label>
						    <div class="col-sm-12">
						      	<input type="text" class="form-control" id="input" placeholder="Đường Dẫn Quảng Cáo" name="KinhDo" value="<?php echo $Editlienhe['KinhDo'] ?>" >
							   	 <!--  Notification -->
			            		<?php if(isset($error['KinhDo'])): ?>
							   		<p class="text-danger"><i class="fas fa-exclamation"></i> <?php echo $error['KinhDo'] ?></p>
							    <?php endif ?>
						    </div>
						</div>
						
						 <div class="form-group row">
					    <label for="staticEmail" class="col-sm-4 col-form-label"><b class="text-primary">Vĩ Độ</b></label>
						    <div class="col-sm-12">
						      	<input type="text" class="form-control" id="input" placeholder="Đường Dẫn Quảng Cáo" name="ViDo" value="<?php echo $Editlienhe['ViDo'] ?>" >
							   	 <!--  Notification -->
			            		<?php if(isset($error['ViDo'])): ?>
							   		<p class="text-danger"><i class="fas fa-exclamation"></i> <?php echo $error['ViDo'] ?></p>
							    <?php endif ?>
						    </div>
						</div>
                
                        <div class="form-group row" nowrap="nowrap">
					    <label for="inputPassword" class="col-sm-4 col-form-label"><b class="text-primary">Địa Chỉ Shop</b></label>
						    <div class="col-sm-12">
						       	<textarea name="DiaChi" class="form-control" cols="170" rows="3"><?php echo $Editlienhe['DiaChi'] ?></textarea>
							   	<!--  Notification -->
			            		<?php if(isset($error['DiaChi'])): ?>
							   		<p class="text-danger"><i class="fas fa-exclamation"></i> <?php echo $error['DiaChi'] ?></p>
							    <?php endif ?>
						    </div>
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
 
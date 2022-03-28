<?php 

 	$open ="product";
 
  	require_once __DIR__. "/../../autoload/autoload.php"; 
  	// DS danh mục sản phẩm
  	$category = $db -> fetchAll("danh_muc");

  	$brands = $db -> fetchAll("thuong_hieu");

  	$admin_id = intval(getInput('admin_id'));

  	$sqlallsize = "SELECT * FROM size ORDER BY SoTT";

  	$Size= $db -> fetchsql($sqlallsize);

  	$data = [
  			"TenSP" => postInput('TenSP'),
  			"id_DanhMuc" => postInput('id_DanhMuc'),
  			"id_ThuongHieu" => postInput('id_ThuongHieu'),
  			"GiaSP" => postInput('GiaSP'),
  			"GiamGia" => postInput('GiamGia'),
  			"MoTa" => postInput('MoTa'),
  			'Created_by' => $_SESSION['admin_id'],
  			'Update_by' => $_SESSION['admin_id']
  		];

  	$error=[];

  	if($_SERVER["REQUEST_METHOD"] == "POST")
  	{
  		
  		if(postInput('TenSP') == '') 
  		{
  			$error['TenSP']="Mời bạn nhập tên sản phẩm."; 
  		}
  		if(strlen(postInput('TenSP'))  > 50 ) 
      	{
        	$error['TenSP']="Tên sản phẩm quá dài."; 
      	}

  		if(postInput('id_DanhMuc') == '') 
  		{
  			$error['id_DanhMuc']="Mời bạn chọn danh mục sản phẩm."; 
  		}

  		if(postInput('id_ThuongHieu') == '') 
  		{
  			$error['id_ThuongHieu']="Mời bạn chọn thương hiệu sản phẩm."; 
  		}

  		if(postInput('GiaSP') == '') 
  		{
  			$error['GiaSP']="Mời bạn nhập giá sản phẩm."; 
  		}
        if(postInput('GiamGia') > 99) 
  		{
  			$error['GiamGia']="Giảm giá không được quá 99%."; 
  		}
  		if(postInput('MoTa') == '') 
  		{
  			$error['MoTa']="Mời bạn nhập nội dung sản phẩm."; 
  		}
  		
  		$target_dir = "uploads/";
		$target_file = $target_dir . basename($_FILES["AnhSP"]["name"]);
		$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
		if( $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") 
		{
			$error['AnhSP']= " Bạn chưa chọn file hoặc Định dạng file không phù hợp ,chỉ có JPG, JPEG & PNG là hợp lệ.";
		}
		$file_size = $_FILES['AnhSP']['size'];	
		if( $file_size > 2048000)
	    {
	        $error['AnhSP']= " Dung lượng file không được lớn hơn 2MB.";	 	
	    }      	
  		if(empty($error)) 
      	{
	       if(isset($_FILES['AnhSP']))
	        {
	        	$file_name = $_FILES['AnhSP']['name'];
	        	
	        	$file_type = $_FILES['AnhSP']['type'];
	        	$file_error = $_FILES['AnhSP']['error'];

	        	$extension = pathinfo($file_name,PATHINFO_EXTENSION);
	        	$random = rand(0,100000);
	        	$rename = date('Ymd').'_'.$random;
	        	$newname = $rename.'.'.$extension;
	        
	        	$file_tmp = $_FILES['AnhSP']['tmp_name'];
	        	
	        	if($file_error == 0)
	        	{
	        		$part =ROOT ."product/";
	        		$data['AnhSP'] =$newname;
	        	}        	
	        }
	        $id_insert =$db->insert("san_pham",$data);

	        if ($id_insert > 0 ) 
    		{   
	            $txtSoLuong = $_POST['txtSoLuong'];
				$id_Size = $_POST['id_Size'];
				foreach ($txtSoLuong as $key => $value) 
				{
				   	$sqlsize = "INSERT INTO ct_size(SoLuong,id_Size,id_SanPham) VALUES('".$value."','".$id_Size[$key]."','".$id_insert."')";
			  		$query = mysqli_query($connect ,$sqlsize);		
				}
    		}
	        if($id_insert)
	        {	
	       		move_uploaded_file($file_tmp,$part.$newname);
	       		$_SESSION['success']="Thêm mới thành công.";
	       		redirectAdmin('product');
	        }
	        else
	        {
	       		$_SESSION['error']="Thêm mới thất bại.";
	       		redirectAdmin('product');
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
			    <li class="breadcrumb-item"><a href="<?php echo modules('product') ?>">Quản Lý Sản Phẩm</a></li>
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
    			<label for="exampleInputEmail1"><h1 class="text-primary">Thêm Mới Sản Phẩm</h1></label>
	    			<form  action="" method="POST" enctype="multipart/form-data">
						<div class="form-group row">
					    <label for="staticEmail" class="col-sm-12 col-form-label"><b class="text-primary">Danh Mục(*)</b></label>
						    <div class="col-sm-6">
						      	<select name="id_DanhMuc"  class="form-control item-category">
						      		<option value="">Mời Bạn Chọn Danh Mục</option>
									<?php foreach ($category as $item): ?>
									<?php $catepar = $db -> fetchID("danh_muc_cha",$item['id_DanhMC']) ?>
										<option value="<?php echo $item['id'] ?>" class="form-control item-category"><?php echo $catepar['TenDMC'] .' :'. $item['TenDM'] ?></option>
									<?php endforeach ?>			      		
						      	</select>
							   	 <!--  Notification -->
			            		<?php if(isset($error['id_DanhMuc'])): ?>
							   		<p class="text-danger"><i class="fas fa-exclamation"></i> <?php echo $error['id_DanhMuc'] ?></p>
							    <?php endif ?>
						    </div>
					 	</div>

					 	<div class="form-group row">
					    <label for="staticEmail" class="col-sm-12 col-form-label"><b class="text-primary">Thương Hiệu(*)</b></label>
						    <div class="col-sm-6">
						      	<select name="id_ThuongHieu"  class="form-control item-category">
						      		<option value="">Mời Bạn Chọn Thương Hiệu</option>
									<?php foreach ($brands as $item): ?>
										<option value="<?php echo $item['id'] ?>" class="form-control item-category"><?php echo $item['TenTH'] ?></option>
									 <?php endforeach ?>			      		
						      	</select>
							   	 <!--  Notification -->
			            		<?php if(isset($error['id_ThuongHieu'])): ?>
							   		<p class="text-danger"><i class="fas fa-exclamation"></i> <?php echo $error['id_ThuongHieu'] ?></p>
							    <?php endif ?>
						    </div>
					 	</div>

					  	<div class="form-group row">
					    <label for="staticEmail" class="col-sm-4 col-form-label"><b class="text-primary">Tên Sản Phẩm(*)</b></label>
						    <div class="col-sm-12">
						      	<input type="text" class="form-control" id="input" placeholder="Tên sản phẩm" name="TenSP" value="<?php echo $data['TenSP'] ?>" >
							   	 <!--  Notification -->
			            		<?php if(isset($error['TenSP'])): ?>
							   		<p class="text-danger"><i class="fas fa-exclamation"></i> <?php echo $error['TenSP'] ?></p>
							    <?php endif ?>
						    </div>
						</div>

					  	<div class="form-group row">
					    <label for="inputPassword" class="col-sm-4 col-form-label"><b class="text-primary">Giá Sản Phẩm(*)</b></label>
						    <div class="col-sm-12">
						        <input type="number" class="form-control" id="input" placeholder="Giá sản phẩm cần bán " name="GiaSP" value="<?php echo $data['GiaSP'] ?>">
							   	 <!--  Notification -->
			            		<?php if(isset($error['GiaSP'])): ?>
							   		<p class="text-danger"><i class="fas fa-exclamation"></i> <?php echo $error['GiaSP'] ?></p>
							    <?php endif ?>
						    </div>
					 	</div>

					  	<div class="form-group row">
					    <label for="inputPassword" class="col-sm-2 col-form-label"><b class="text-primary">Giảm Giá %</b></label>
						    <div class="col-sm-4">
						        <input type="number" class="form-control" id="input" placeholder="%" name="GiamGia" value="0" min="0">
						        <?php if(isset($error['GiamGia'])): ?>
							   		<p class="text-danger"><i class="fas fa-exclamation"></i> <?php echo $error['GiamGia'] ?></p>
							    <?php endif ?>
						    </div>

						    <label for="inputPassword" class="col-sm-2 col-form-label"><b class="text-primary">Hình Ảnh(*)</b></label>
						    <div class="col-sm-4 ">
						        <input type="file" class="form-control" id="input" name="AnhSP">
						       	<?php if(isset($error['AnhSP'])): ?>
							   		<p class="text-danger"> <i class="fas fa-exclamation"></i><?php echo $error['AnhSP'] ?></p>
							    <?php endif ?>
						    </div>
					 	</div>

					 	<div class="form-group">
					 		<label for="inputPassword"><b class="text-primary">Thuộc Tính(*)</b></label>  
	                          	<div class="table-responsive">  
	                               <table class="table table-bordered" id="table_field">
	                                    <tr>	  
	                                        <td>
	                                        	<select name="id_Size[]" class="form-control item-category" required=""> 
							      				<option value="">Chọn Loại Size</option>
													<?php foreach ($Size as $item): ?>
													<option value="<?php echo $item['id'] ?>" class="form-control item-category"><?php echo $item['TenSize'] ?></option>
										 			<?php endforeach; ?>  	
							      				</select>
	                                        </td>   
	                                        <td><input type="number" name="txtSoLuong[]" placeholder="Nhập Số Lượng" class="form-control name_list" required=""/></td>   
	                                          
	                                    </tr>

                               		</table> 
                               		<button type="button" name="add" id="add" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i></button>
	                          	</div>  
	                    </div>

					  	<div class="form-group row" nowrap="nowrap">
					    <label for="inputPassword" class="col-sm-4 col-form-label"><b class="text-primary">Mô Tả Sản Phẩm(*)</b></label>
						    <div class="col-sm-12">
						       	<textarea name="MoTa" id="ckcontent" cols="195" rows="5"><?php echo $data['MoTa'] ?></textarea>
							   	<!--  Notification -->
			            		<?php if(isset($error['MoTa'])): ?>
							   		<p class="text-danger"><i class="fas fa-exclamation"></i> <?php echo $error['MoTa'] ?></p>
							    <?php endif ?>
						    </div>
					 	</div>
					 	<a href="<?php echo modules('product') ?>" class="btn btn-primary btn-sm"><i class="fa fa-angle-double-left"></i></a>
				  		<button type="submit" id="submit" class="btn btn-primary btn-sm">Thêm</button>
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
 <script>  
 	$(document).ready(function(){  
     	var html ='<tr><td><select name="id_Size[]" class="form-control item-category" required=""><option value="">Chọn Loại Size</option><?php foreach ($Size as $value): ?><option value="<?php echo $value['id'] ?>" class="form-control item-category"><?php echo $value['TenSize'] ?></option><?php endforeach; ?></select></td><td><input type="number" name="txtSoLuong[]" placeholder="Nhập Số Lượng" class="form-control name_list" required/></td><td><button type="button" name="remove" id="remove" value="remove" class="btn btn-danger">X</button></td></tr>';
     	var x =1;
     	var max = 7;

      	$("#add").click(function(){
      		if(x <=  max){
      			$("#table_field").append(html);
      			x++;
      		}
      		
      	});
      	$("#table_field").on('click', '#remove' , function(){
      		$(this).closest('tr').remove();
      		x--;
      	});


 	});  
 </script>
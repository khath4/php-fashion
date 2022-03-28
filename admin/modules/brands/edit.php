<?php 
 	$open ="brands";
  	require_once __DIR__. "/../../autoload/autoload.php"; 

  	$id = intval(getInput('id'));

  	$EditBrands= $db-> fetchID("thuong_hieu" ,$id);

  	if(empty($EditBrands))
  	{
  		$_SESSION['error'] = "Dữ liệu không tồn tại.";
  		redirectAdmin('brands');
  	}

  	if($_SERVER["REQUEST_METHOD"] == "POST")
  	{
  		$data = [
  		"TenTH" => postInput('TenTH'),
      "SoTT" => postInput('SoTT'),

  		];

  		$error=[];

  		if(postInput('TenTH') == '') 
  		{
  			$error['TenTH']="Mời bạn nhập đầy đủ tên thương hiệu."; 
  		}
      	if(strlen(postInput('TenTH'))  > 30 ) 
      	{
        	$error['TenTH']="Tên thương hiệu quá dài."; 
      	}

      	if(postInput('SoTT') == '') 
      	{
       		$error['SoTT']="Mời bạn nhập số thứ tự thương hiệu."; 
      	}
      // else
      // {
      //   $is_check = $db -> fetchOne("category", "numerical = '".$data['numerical']."' ");
      //   if($is_check != NULL) 
      //   {
      //     $error['numerical']="Số thứ tự đã tồn tại."; 
      //   }
      // }

  		if(empty($error)) 
      	{
	        if($EditBrands['TenTH'] != $data['TenTH'])
	        {
	          	$isset= $db -> fetchOne("thuong_hieu" , "TenTH = '" .$data['TenTH']."' " );
	          	if($isset > 0) 
	          	{
	            	$_SESSION['error'] = "Tên danh mục này đã tồn tại.";
	          	}
	          	else
	          	{
		            $id_update =$db -> update("thuong_hieu" , $data , array("id" => $id));
		            if($id_update > 0)
		            {
		              $_SESSION['success'] = "Cập nhật thành công.";
		              redirectAdmin('brands');
		            }
		            else 
		            {
		              $_SESSION['error'] = "Dữ liệu không thay đổi.";
		              redirectAdmin('brands');
		            }
	          	}
        	}
        else 
        {
            $id_update =$db -> update("thuong_hieu" , $data , array("id" => $id));
            if($id_update > 0)
            {
             	$_SESSION['success'] = "Cập nhật thành công.";
              	redirectAdmin('brands');
            }
            else 
            {
              	$_SESSION['error'] = "Dữ liệu không thay đổi.";
              	redirectAdmin('brands');
            }
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
			    <li class="breadcrumb-item"><a href="<?php echo modules('brands') ?>">Thương Hiệu</a></li>
			    <li class="breadcrumb-item active" aria-current="page">Cập Nhật</li>
			  </ol>
			</nav>
      <!--  Notification -->
        <?php require_once __DIR__. "/../../../partials/notification.php"; ?>
 		</div>
 	</div>
    <!-- Begin Page Content -->
    <div class="container-fluid">
    	<div class="row">
    		<div class="col-md-12">
          <label for="exampleInputEmail1"><h1 class="text-primary">Cập Nhật Thương Hiệu</h1></label>
    			<form action="" method="POST">

            <div class="form-group row">
              <label for="staticEmail" class="col-sm-4 col-form-label"><b class="text-primary">Số Thứ Tự(*)</b></label>
              <div class="col-sm-12">
                  <input type="number" class="form-control" id="input" placeholder="Thứ tự xắp xếp thương hiệu" name="SoTT" value="<?php echo $EditBrands['SoTT'] ?>">
                 <!--  Notification -->
                    <?php if(isset($error['SoTT'])): ?>
                  <p class="text-danger"><i class="fas fa-exclamation"></i> <?php echo $error['SoTT'] ?></p>
                <?php endif ?>
              </div>
            </div>

            <div class="form-group row">
              <label for="staticEmail" class="col-sm-4 col-form-label"><b class="text-primary">Thương Hiệu(*)</b></label>
              <div class="col-sm-12">
                  <input type="text" class="form-control" id="input" placeholder="Tên thương hiệu" name="TenTH" value="<?php echo $EditBrands['TenTH'] ?>">
                 <!--  Notification -->
                    <?php if(isset($error['TenTH'])): ?>
                  <p class="text-danger"><i class="fas fa-exclamation"></i> <?php echo $error['TenTH'] ?></p>
                <?php endif ?>
              </div>
            </div>
            <a href="<?php echo modules('brands') ?>" class="btn btn-primary btn-sm"><i class="fa fa-angle-double-left"></i></a>
			     <button type="submit" class="btn btn-primary btn-sm">Lưu</button>
				</form>
    		</div>
    	</div>    
    </div>
    <!-- /.container-fluid -->
    </div>
    <!-- End of Main Content -->
<?php require_once __DIR__. "/../../layouts/footer.php";  ?>
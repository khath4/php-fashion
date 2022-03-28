<?php 
 	  $open ="size";
  	require_once __DIR__. "/../../autoload/autoload.php"; 

  	$id = intval(getInput('id'));

  	$EditParentsCategory= $db-> fetchID("size" ,$id);

  	if(empty($EditParentsCategory))
  	{
  		$_SESSION['error'] = "Dữ liệu không tồn tại.";
  		redirectAdmin('Size');
  	}

  	if($_SERVER["REQUEST_METHOD"] == "POST")
  	{
  		$data = [
  		  "TenSize" => postInput('TenSize'),
      	"SoTT" => postInput('SoTT'),
  		];

  		$error=[];

  		if(postInput('TenSize') == '') 
  		{
  			$error['TenSize']="Mời bạn nhập đầy đủ tên size."; 
  		}
      	if(strlen(postInput('TenSize'))  > 15 ) 
      	{	
      		$error['TenSize']="Tên size quá dài."; 
      	}
      	if(postInput('SoTT') == '') 
      	{
        	$error['SoTT']="Mời bạn nhập số thứ tự size."; 
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
	        if($EditParentsCategory['TenSize'] != $data['TenSize'])
	        {
	          	$isset= $db -> fetchOne("size" , "TenSize = '" .$data['TenSize']."' " );
	          	if($isset > 0) 
	          	{
	            	$_SESSION['error'] = "Tên size này đã tồn tại.";
	          	}
	          	else
	          	{
	            	$id_update =$db -> update("size" , $data , array("id" => $id));
	            if($id_update > 0)
	            {
	              	$_SESSION['success'] = "Cập nhật thành công.";
	              	redirectAdmin('size');
	            }
	            else 
	            {
	              	$_SESSION['error'] = "Dữ liệu không thay đổi.";
	              	redirectAdmin('size');
	            }
	        }
        }
        else 
        {
            $id_update =$db -> update("size" , $data , array("id" => $id));
            if($id_update > 0)
            {
              	$_SESSION['success'] = "Cập nhật thành công.";
              	redirectAdmin('size');
            }
            else 
            {
              	$_SESSION['error'] = "Dữ liệu không thay đổi.";
              	redirectAdmin('size');
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
			    <li class="breadcrumb-item"><a href="<?php echo modules('size') ?>">Quản Lý Size</a></li>
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
          <label for="exampleInputEmail1"><h1 class="text-primary">Cập Nhật Size</h1></label>
    			<form action="" method="POST">
            <div class="form-group row">
              <label for="staticEmail" class="col-sm-4 col-form-label"><b class="text-primary">Số Thứ Tự(*)</b></label>
              <div class="col-sm-12">
                  <input type="number" class="form-control" id="input" placeholder="Thứ tự xắp xếp danh mục cha" name="SoTT" value="<?php echo $EditParentsCategory['SoTT'] ?>">
                 <!--  Notification -->
                    <?php if(isset($error['SoTT'])): ?>
                  <p class="text-danger"><i class="fas fa-exclamation"></i> <?php echo $error['SoTT'] ?></p>
                <?php endif ?>
              </div>
            </div>

            <div class="form-group row">
              <label for="staticEmail" class="col-sm-4 col-form-label"><b class="text-primary">Danh mục Cha(*)</b></label>
              <div class="col-sm-12">
                  <input type="text" class="form-control" id="input" placeholder="Tên danh mục cha" name="TenSize" value="<?php echo $EditParentsCategory['TenSize'] ?>">
                 <!--  Notification -->
                    <?php if(isset($error['TenSize'])): ?>
                  <p class="text-danger"><i class="fas fa-exclamation"></i> <?php echo $error['TenSize'] ?></p>
                <?php endif ?>
              </div>
            </div>
            <a href="<?php echo modules('size') ?>" class="btn btn-primary btn-sm"><i class="fa fa-angle-double-left"></i></a>
				    <button type="submit" class="btn btn-primary btn-sm">Lưu</button>        	
				</form>
    		</div>
    	</div>    
    </div>
    <!-- /.container-fluid -->
    </div>
    <!-- End of Main Content -->
<?php require_once __DIR__. "/../../layouts/footer.php";  ?>
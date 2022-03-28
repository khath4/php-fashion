<?php 
 	  $open ="parents_category";
  	require_once __DIR__. "/../../autoload/autoload.php"; 
    $data = [
      "TenDMC" => postInput('TenDMC'),
      "SoTT" => postInput('SoTT'),
      ];

  	if($_SERVER["REQUEST_METHOD"] == "POST")
  	{
  		
  		$error=[];
  		if(postInput('TenDMC') == '') 
  		{
  			$error['TenDMC']="Mời bạn nhập tên danh mục cha."; 
  		}
      if(strlen(postInput('TenDMC'))  >= 50 ) 
      {
        $error['TenDMC']="Tên danh mục cha quá dài."; 
      }
      if(postInput('SoTT') == '') 
      {
        $error['SoTT']="Mời bạn nhập số thứ tự danh mục cha."; 
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
        $isset= $db -> fetchOne("danh_muc_cha" , "TenDMC = '" .$data['TenDMC']."' " );
        if($isset > 0) 
        {
          $_SESSION['error'] = "Tên danh mục cha này đã tồn tại.";
        }
        else
        {
          $id_insert =$db -> insert("danh_muc_cha" , $data);
          if($id_insert > 0)
          {
            $_SESSION['success'] = "Thêm mới thành công.";
            redirectAdmin('parents_category');
          }
          else 
          {
            $_SESSION['error'] = "Thêm mới không thành công.";
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
			    <li class="breadcrumb-item"><a href="<?php echo modules('parents_category') ?>">Danh Mục Cha</a></li>
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
          <label for="exampleInputEmail1"><h1 class="text-primary">Thêm Mới Danh Mục Cha</h1></label>
    			<form  action="" method="POST">
            <div class="form-group row">
              <label for="staticEmail" class="col-sm-4 col-form-label"><b class="text-primary">Số Thứ Tự(*)</b></label>
              <div class="col-sm-12">
                  <input type="number" class="form-control" id="input" placeholder="Thứ tự xắp xếp danh mục cha" name="SoTT"  value="<?php echo $data['SoTT'] ?>">
                 <!--  Notification -->
                    <?php if(isset($error['SoTT'])): ?>
                  <p class="text-danger"><i class="fas fa-exclamation"></i> <?php echo $error['SoTT'] ?></p>
                <?php endif ?>
              </div>
            </div>

            <div class="form-group row">
              <label for="staticEmail" class="col-sm-4 col-form-label"><b class="text-primary">Danh mục cha(*)</b></label>
              <div class="col-sm-12">
                  <input type="text" class="form-control" id="input" placeholder="Tên danh mục cha" name="TenDMC"  value="<?php echo $data['TenDMC'] ?>">
                 <!--  Notification -->
                    <?php if(isset($error['TenDMC'])): ?>
                  <p class="text-danger"><i class="fas fa-exclamation"></i> <?php echo $error['TenDMC'] ?></p>
                <?php endif ?>
              </div>
            </div>
            <a href="<?php echo modules('parents_category') ?>" class="btn btn-primary btn-sm"><i class="fa fa-angle-double-left"></i></a>
				    <button type="submit" class="btn btn-primary btn-sm">Thêm</button>
				</form>
    		</div>
    	</div>    
    </div>
    <!-- /.container-fluid -->
    </div>
    <!-- End of Main Content -->
<?php require_once __DIR__. "/../../layouts/footer.php";  ?>
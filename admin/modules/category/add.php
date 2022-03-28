<?php
 	$open ="category";
  	require_once __DIR__. "/../../autoload/autoload.php";

    $parents_category = $db -> fetchAll("danh_muc_cha");
    
    $data = [
        "TenDM" => postInput('TenDM'),
        "SoTT" => postInput('SoTT'),
        "id_DanhMC" => postInput('id_DanhMC'),
      ];
  	if($_SERVER["REQUEST_METHOD"] == "POST")
  	{
  		
  		$error=[];
  		if(postInput('TenDM') == '') 
  		{
  			$error['TenDM']="Mời bạn nhập tên danh mục."; 
  		}
      if(strlen(postInput('TenDM'))  >= 50 ) 
      {
        $error['TenDM']="Tên danh mục quá dài."; 
      }
      if(postInput('SoTT') == '') 
      {
        $error['SoTT']="Mời bạn nhập số thứ tự danh mục."; 
      }
      if(postInput('id_DanhMC') == '') 
      {
        $error['id_DanhMC']="Mời bạn chọn danh mục cha."; 
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
            foreach ($parents_category as $item)
            {
                $isset= $db -> fetchOne("danh_muc" , "TenDM = '" .$data['TenDM']."'AND id_DanhMC = '".$data['id_DanhMC']."' " );
            }
        if ($isset > 0) 
        {
          $_SESSION['error'] = "Tên danh mục này đã tồn tại.";
        }
        else
        {
          $id_insert =$db -> insert("danh_muc" , $data);
          if($id_insert > 0)
          {
            $_SESSION['success'] = "Thêm mới thành công.";
            redirectAdmin('category');
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
			    <li class="breadcrumb-item"><a href="<?php echo modules('category') ?>">Danh Mục Con</a></li>
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
          <label for="exampleInputEmail1"><h1 class="text-primary">Thêm Mới Danh Mục Con</h1></label>
    			<form  action="" method="POST">

           <div class="form-group row">
              <label for="staticEmail" class="col-sm-12 col-form-label"><b class="text-primary">Danh Mục Cha(*)</b></label>
                <div class="col-sm-4  ">
                    <select name="id_DanhMC"  class="form-control item-category">
                      <option value="">Mời Bạn Chọn Danh Mục Cha</option>
                  <?php foreach ($parents_category as $item): ?>
                    <option value="<?php echo $item['id'] ?>"><?php echo $item['TenDMC'] ?></option>
                   <?php endforeach ?>                
                    </select>
                   <!--  Notification -->
                      <?php if(isset($error['id_DanhMC'])): ?>
                    <p class="text-danger"><i class="fas fa-exclamation"></i> <?php echo $error['id_DanhMC'] ?></p>
                  <?php endif ?>
                </div>
            </div>

            <div class="form-group row">
              <label for="staticEmail" class="col-sm-4 col-form-label"><b class="text-primary">Số Thứ Tự(*)</b></label>
              <div class="col-sm-12">
                  <input type="number" class="form-control" id="input" placeholder="Thứ tự xắp xếp danh mục" name="SoTT" value="<?php echo $data['SoTT'] ?>">
                 <!--  Notification -->
                    <?php if(isset($error['SoTT'])): ?>
                  <p class="text-danger"><i class="fas fa-exclamation"></i> <?php echo $error['SoTT'] ?></p>
                <?php endif ?>
              </div>
            </div>

            <div class="form-group row">
              <label for="staticEmail" class="col-sm-4 col-form-label"><b class="text-primary">Danh Mục Con(*)</b></label>
              <div class="col-sm-12">
                  <input type="text" class="form-control" id="input" placeholder="Tên danh mục" name="TenDM"  value="<?php echo $data['TenDM'] ?>">
                 <!--  Notification -->
                    <?php if(isset($error['TenDM'])): ?>
                  <p class="text-danger"><i class="fas fa-exclamation"></i> <?php echo $error['TenDM'] ?></p>
                <?php endif ?>
              </div>
            </div>
            <a href="<?php echo modules('category') ?>" class="btn btn-primary btn-sm"><i class="fa fa-angle-double-left"></i></a>
				    <button type="submit" class="btn btn-primary btn-sm">Thêm</button>
				</form>
    		</div>
    	</div>    
    </div>
    <!-- /.container-fluid -->
    </div>
    <!-- End of Main Content -->
<?php require_once __DIR__. "/../../layouts/footer.php";  ?>
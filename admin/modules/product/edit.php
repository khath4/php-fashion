<?php 

    $open ="product";
    require_once __DIR__. "/../../autoload/autoload.php"; 

    $id = intval(getInput('id'));

    $sqlEditSize = "SELECT ct_size.*,size.TenSize as TenSize,size.id as ids FROM ct_size,size WHERE ct_size.id_Size = size.id and id_Sanpham = $id ";

    $EditSize =  $db -> fetchsql($sqlEditSize);

    // Count table rows 
    $count =Count($EditSize);

    $Editproduct= $db-> fetchID("san_pham" ,$id);

    $EditSize2 = $db -> fetchIDSize("ct_size" ,$id);

    $sqlallsize = "SELECT * FROM size ORDER BY SoTT ASC";

    $Size= $db -> fetchsql($sqlallsize);

    $sqlallsize2 = "SELECT * FROM size WHERE id NOT IN (SELECT id_size FROM ct_size WHERE id_SanPham = $id ORDER BY SoTT ) ORDER BY SoTT ASC";

    $Size2= $db -> fetchsql($sqlallsize2);

    if(empty($Editproduct))
    {
      $_SESSION['error'] = "Dữ liệu không tồn tại.";
      redirectAdmin('product');
    }

    // DS danh mục sản phẩm
    
    $category = $db -> fetchAll("size");

    $category = $db -> fetchAll("danh_muc");

    $brands = $db -> fetchAll("thuong_hieu");
    
    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
      $data = [
        "TenSP" => postInput('TenSP'),
        "id_DanhMuc" => postInput('id_DanhMuc'),
        "id_ThuongHieu" => postInput('id_ThuongHieu'),
        "GiaSP" => postInput('GiaSP'),
        "GiamGia" => postInput('GiamGia'),
        "MoTa" => postInput('MoTa'),
        'Update_by' => $_SESSION['admin_id']

      ];
      $error=[];

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
        $error['id_ThuongHieu']="Mời bạn chọn danh mục sản phẩm."; 
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

      if(isset($_FILES["AnhSP"]) && $_FILES["AnhSP"]["error"] == 0)
      {
        $target_dir    = "uploads/";
        $target_file   = $target_dir . basename($_FILES["AnhSP"]["name"]);
        $maxfilesize   =  2048000;
        $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
        $allowed    = array('jpg', 'png', 'jpeg');
        //$allowed = array("jpg" => "image/jpg", "jpeg" => "image/jpeg", "png" => "image/png");
        if($_FILES["AnhSP"]["size"] > $maxfilesize)
        {
            $error['AnhSP'] ="Dung lượng file không được lớn hơn 2MB";
        }
        if (!in_array($imageFileType,$allowed))
        {
          $error['AnhSP'] = "Chỉ được upload các định dạng JPG, PNG, JPEG";
        }
      }
           
            
      if(empty($error)) 
        {
          if(isset($_FILES['AnhSP']))
          {
            $file_name =$_FILES['AnhSP']['name'];
            $file_type =$_FILES['AnhSP']['type'];
            $file_error =$_FILES['AnhSP']['error']; 

            $extension = pathinfo($file_name,PATHINFO_EXTENSION);
            $random = rand(0,100000);
            $rename = date('Ymd').'_'.$random;
            $newname = $rename.'.'.$extension;

            $file_tmp =$_FILES['AnhSP']['tmp_name'];
            if($file_error == 0)
            {
              $part =ROOT ."product/";
              $data['AnhSP'] =$newname;
            }
          }
          $update =$db -> update("san_pham" , $data , array("id" => $id));
          $add = 0;
          if(isset($_POST['SoLuong_add'])){ 
              $SoLuong_add = $_POST['SoLuong_add'];
              $id_Size_add = $_POST['id_Size_add'];
             
              foreach ($SoLuong_add as $key => $value) 
              {
                  $sqlsize = "INSERT INTO ct_size(SoLuong,id_Size,id_SanPham) VALUES('".$value."','".$id_Size_add[$key]."','".$id."')";
                  $query = mysqli_query($connect ,$sqlsize);
                  $add  = 1;    
              }
          }
          
          $update_size  = 0;
          if(isset($_POST['SoLuong_update'])){ 
              $SoLuong_update = $_POST['SoLuong_update'];
              $id_Size_update = $_POST['id_Size_update'];
             
              foreach($EditSize as $key => $item) 
              {              
                  $sqlsizeupdate = "UPDATE ct_size SET SoLuong='".$SoLuong_update[$key]."',id_Size='".$id_Size_update[$key]."' WHERE id = '".$item['id']."'";
                  $queryupdate = mysqli_query($connect ,$sqlsizeupdate);
                  $update_size  = 1;    
              } 
           }

          if($update > 0 || $add == 1 || $update_size == 1)
          {
            if(isset($_FILES["AnhSP"]) && $_FILES["AnhSP"]["error"] == 0)
            {
                move_uploaded_file($file_tmp,$part.$newname);
            }
              $_SESSION['success']="Cập nhật thông tin thành công.";
              redirectAdmin('product');
          }
          else
          {
              $_SESSION['error']="Dữ liệu không thay đổi.";
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
          <label for="exampleInputEmail1"><h1 class="text-primary">Cập Nhật Sản Phẩm</h1></label>
            <form  action="" method="POST" enctype="multipart/form-data">

              <div class="form-group row">
              <label for="staticEmail" class="col-sm-12 col-form-label"><b class="text-primary">Danh Mục(*)</b></label>
                <div class="col-sm-6">
                    <select name="id_DanhMuc" class="form-control item-category">
                      <option value="">Mời Bạn Chọn Danh Mục</option>
                    <?php foreach ($category as $item): ?>
                        <?php $catepar = $db -> fetchID("danh_muc_cha",$item['id_DanhMC']) ?>
									
                        <option value="<?php echo $item['id'] ?>" <?php echo $Editproduct['id_DanhMuc'] == $item['id'] ? "selected  =' selected '" : '' ?>><?php echo $catepar['TenDMC'] .' :'. $item['TenDM'] ?></option>
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
                    <select name="id_ThuongHieu" class="form-control item-category">
                      <option value="">Mời Bạn Chọn Thương Hiệu</option>
                  <?php foreach ($brands as $item): ?>
                    <option value="<?php echo $item['id'] ?>" <?php echo $Editproduct['id_ThuongHieu'] == $item['id'] ? "selected  =' selected '" : '' ?>><?php echo $item['TenTH'] ?></option>
                   <?php endforeach ?>                
                    </select>
                   <!--  Notification -->
                      <?php if(isset($error['id_ThuongHieu'])): ?>
                    <p class="text-danger"><i class="fas fa-exclamation"></i> <?php echo $error['id_ThuongHieu'] ?></p>
                  <?php endif ?>
                </div>
              </div>

              <div class="form-group row">
              <label for="staticEmail" class="col-sm-4 col-form-label"><b class="text-primary">Sản Phẩm(*)</b></label>
                <div class="col-sm-12">
                    <input type="text" class="form-control" id="input" placeholder="Tên sản phẩm" name="TenSP" value="<?php echo $Editproduct['TenSP'] ?>">
                   <!--  Notification -->
                      <?php if(isset($error['TenSP'])): ?>
                    <p class="text-danger"><i class="fas fa-exclamation"></i> <?php echo $error['TenSP'] ?></p>
                  <?php endif ?>
                </div>
            </div>

              <div class="form-group row">
              <label for="inputPassword" class="col-sm-4 col-form-label"><b class="text-primary">Giá Sản Phẩm(*)</b></label>
                <div class="col-sm-12">
                    <input type="number" class="form-control" id="input" placeholder="Giá " name="GiaSP" value="<?php echo $Editproduct['GiaSP'] ?>">
                   <!--  Notification -->
                    <?php if(isset($error['GiaSP'])): ?>
                        <p class="text-danger"><i class="fas fa-exclamation"></i> <?php echo $error['GiaSP'] ?></p>
                    <?php endif ?>
                </div>
              </div>

              <div class="form-group row">
              <label for="inputPassword" class="col-sm-2 col-form-label"><b class="text-primary">Giảm Giá %</b></label>
                  <div class="col-sm-3">
                      <input type="number" class="form-control" id="input" placeholder="%" name="GiamGia" value="<?php echo $Editproduct['GiamGia'] ?>" min="0">
                      <?php if(isset($error['GiamGia'])): ?>
                        <p class="text-danger"><i class="fas fa-exclamation"></i> <?php echo $error['GiamGia'] ?></p>
                    <?php endif ?>
                  </div>

                <label for="inputPassword" class="col-sm-2 col-form-label"><b class="text-primary">Hình Ảnh(*)</b></label>
                  <div class="col-sm-4">
                      <input type="file" class="form-control" id="input" name="AnhSP">
                      <?php if(isset($error['AnhSP'])): ?>
                      <p class="text-danger"> <i class="fas fa-exclamation"></i><?php echo $error['AnhSP'] ?></p>
                    <?php endif ?>
                  </div>
                <img src="<?php echo uploads() ?>product/<?php echo $Editproduct['AnhSP'] ?>" width="90px" height="80px" alt="">
              </div>

              <div class="form-group">
              <label for="inputPassword"><b class="text-primary">Thuộc Tính(*)</b></label>  
                  <div class="table-responsive">  
                      <table class="table table-bordered" id="table_field">
                          <?php foreach ($EditSize as $item): ?>
                              <tr>    
                                  <td>
                                      <select name="id_Size_update[]" class="form-control item-category" required=""> 
                                          <option value="">Chọn Loại Size</option>
                                          <?php  foreach ($Size as $value): ?>
                                          <option value="<?php echo $value['id'] ?>" <?php echo $item['id_Size'] == $value['id'] ? "selected  =' selected '" : '' ?>  class="form-control item-category"><?php echo $value['TenSize'] ?></option>
                                           <?php endforeach; ?>
                                      </select>
                                  </td>
                                      <td><input type="number" name="SoLuong_update[]" placeholder="Nhập Số Lượng" class="form-control name_list" required="" value="<?php echo $item['SoLuong'] ?>" /></td>
                                      <td><a onClick="return window.confirm('Bạn có chắc muốn xóa thuộc tính này không?')" href="delete_size.php?id=<?php echo $item['id'] ?>" class="btn btn-danger btn-sm">X</a></td>
                                </tr>  
                          <?php endforeach; ?>
                      </table> 
                          <button type="button" name="add" id="add" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i></button>    
                  </div>  
              </div>
                
              <div class="form-group row">
              <label for="inputPassword" class="col-sm-4 col-form-label"><b class="text-primary">Mô Tả Sản Phẩm(*)</b></label>
                <div class="col-sm-12">
                    <textarea name="MoTa" id="ckcontent" cols="170" rows="5"><?php echo $Editproduct['MoTa'] ?></textarea>
                  <!--  Notification -->
                      <?php if(isset($error['MoTa'])): ?>
                    <p class="text-danger"><i class="fas fa-exclamation"></i> <?php echo $error['MoTa'] ?></p>
                  <?php endif ?>
                </div>
            </div>
            <a href="<?php echo modules('product') ?>" class="btn btn-primary btn-sm"><i class="fa fa-angle-double-left"></i></a>
            <button type="submit" name="submit" class="btn btn-primary btn-sm">Lưu</button>
          
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
      var html ='<tr><td><select name="id_Size_add[]" class="form-control item-category" required=""><option value="">Chọn Loại Size</option><?php foreach ($Size2 as $value): ?><option value="<?php echo $value['id'] ?>" class="form-control item-category"><?php echo $value['TenSize'] ?></option><?php endforeach; ?></select></td><td><input type="number" name="SoLuong_add[]" placeholder="Nhập Số Lượng" class="form-control name_list" required/></td><td><button type="button" name="remove" id="remove" value="remove" class="btn btn-danger btn-sm">X</button></td></tr>';
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
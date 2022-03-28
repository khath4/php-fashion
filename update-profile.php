<?php 
    require_once __DIR__. "/autoload/autoload.php";

    $id = intval(getInput('id'));
    $EditUsers= $db-> fetchID("users" ,$id);

    if(empty($EditUsers))
    {
       header("Location: profile.php?id=".$_SESSION['name_id']);
    }
    if(!isset($_SESSION['name_id']))
    {
        $_SESSION['unlogin']="";
        header("Location: dang-nhap.php");
    } 
    $user = $db -> fetchID("users" , intval($_SESSION['name_id']));
    if($id == $_SESSION['name_id'])
    {
        if($_SERVER["REQUEST_METHOD"] == "POST")
        { 

          $data = [
            "HoTen" => postInput('HoTen'),
            // "Email" => postInput('Email'),
            "DienThoai" => postInput('DienThoai'),  
            "DiaChi" => postInput('DiaChi'),
            "NgaySinh" =>postInput('NgaySinh'),
            "GioiTinh" =>postInput('GioiTinh'),
          ];

          $error=[];

          if(postInput('HoTen') == '') 
          {
            $error['HoTen']="Mời bạn nhập đầy đủ họ tên."; 
          }
          if(strlen(postInput('HoTen'))  > 30 ) 
          {
            $error['HoTen']="Tên của bạn quá dài."; 
          }
          
          if(date("Y", strtotime(postInput('NgaySinh'))) < 1900 )
  		  {
  		     $error['NgaySinh']="BẠN KHÔNG SỐNG LÂU THẾ ĐÂU =))."; 
  		  }
  		
  		  if(date("Y", strtotime(postInput('NgaySinh'))) > 2020 )
  		  {
  		     $error['NgaySinh']="Năm sinh Không hợp lệ."; 
  		  }

          // if(strlen(postInput('Email'))  > 30 ) 
          // {
          //   $error['Email']="Email của bạn quá dài."; 
          // }
          // if(postInput('Email') == '') 
          // {
          //   $error['Email']="Mời bạn nhập Email."; 
          // }
          // else
          // { 
          //   if(postInput('Email') != $EditUsers['Email'] )
          //   {
          //     $is_check = $db -> fetchOne("users", " Email = '".$data['Email']."' ");
          //     if($is_check != NULL) 
          //     {
          //       $error['Email']="Email đã tồn tại,Vui lòng sử dụng Email khác."; 
          //     }
          //   }
          // }

          if(strlen($data['DienThoai']) < 8 || strlen($data['DienThoai']) > 12)
          {
            $error['DienThoai']="Số điện thoại của bạn không hợp lệ."; 
          }
          if(postInput('DienThoai') == '') 
          {
            $error['DienThoai']="Mời bạn nhập số điện thoại."; 
          }
          else
          { 
            if(postInput('DienThoai') != $EditUsers['DienThoai'] )
            {
              $is_check = $db -> fetchOne("users", " DienThoai = '".$data['DienThoai']."' ");
              if($is_check != NULL) 
              {
                $error['DienThoai']="Số điện thoại đã tồn tại, Vui lòng sử dụng số điện thoại khác."; 
              }
            }
          }
          if(postInput('DiaChi') == '') 
          {
            $error['DiaChi']="Mời bạn nhập địa chỉ."; 
          }
          if(postInput('NgaySinh') == '') 
          {
            $error['NgaySinh']="Mời bạn chọn ngày tháng năm sinh."; 
          }
          if(postInput('GioiTinh') == '') 
          {
            $error['GioiTinh']="Mời bạn chọn giới tính."; 
          }
          
          if(empty($error)) 
            {       
              $id_update =$db->update("users",$data,array("id"=>$id));
              if($id_update)
              { 
                $is_check= $db -> fetchOne("users" ," HoTen = '".$data['HoTen']."'");
                $_SESSION['name_user'] = $is_check['HoTen'];
                
                $_SESSION['updatesuccess']="";
                header("Location: profile.php?id=".$_SESSION['name_id']);
              
              }
              else
              {
                $_SESSION['updateerror']="";
                header("Location: profile.php?id=".$_SESSION['name_id']);
              }
          } 
        } 
    }
    else
    {
        header("Location: profile.php?id=".$_SESSION['name_id']);
    }
 
?>

<?php require_once __DIR__. "/layouts/header.php";  ?>  
<?php require_once __DIR__. "/layouts/nav.php";  ?>  
<div class="col-sm-9 padding-right">
    <h2 class="title text-center">Cập Nhật Hồ Sơ</h2>
      <?php if(isset($_SESSION['success'])) :?>
        <div class="alert alert-success"><i class="fa fa-check"></i>
        <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
        </div>
    <?php endif; ?>

    <?php if(isset($_SESSION['error'])) :?>
        <div class="alert alert-danger"><i class="fa fa-times"></i>
        <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
        </div>
    <?php endif; ?>

  <form action="" method="POST" >
      <div class="form-group">
        <label class="text-primary">Họ và tên(*)</label>
        <input type="text" class="form-control name-user" name="HoTen" aria-describedby="emailHelp" placeholder="Họ Và Tên" value="<?php echo $user['HoTen'] ?>" >
      </div>
      <?php if(isset($error['HoTen'])): ?>
        <p class="text-danger"><i class="fa fa-exclamation"></i> <?php echo $error['HoTen'] ?></p>
      <?php endif ?>

     <!--  <div class="form-group">
        <label class="text-primary">Email(*)</label>
        <input type="email" class="form-control" name="Email" placeholder="Example@gmail.com" value="<?php echo $user['Email']?>" readonly="">
      </div>
      <?php if(isset($error['Email'])): ?>
        <p class="text-danger"><i class="fa fa-exclamation"></i> <?php echo $error['Email'] ?></p>
      <?php endif ?> -->

      <div class="form-group">
        <label class="text-primary">Số điện thoại(*)</label>
        <input type="number" class="form-control" name="DienThoai" placeholder="0364784406" value="<?php echo $user['DienThoai'] ?>" >    
      </div>
      <?php if(isset($error['DienThoai'])): ?>
        <p class="text-danger"><i class="fa fa-exclamation"></i> <?php echo $error['DienThoai'] ?></p>
      <?php endif ?>

      <div class="form-group">
        <label class="text-primary">Ngày tháng năm sinh(*)</label>
        <input type="date" class="form-control" name="NgaySinh" value="<?php echo $user['NgaySinh'] ?>">
        <?php if(isset($error['NgaySinh'])): ?>
        <p class="text-danger"><i class="fa fa-exclamation"></i> <?php echo $error['NgaySinh'] ?></p>
      <?php endif ?>
      </div>

      <div class="form-group">
          <select name="GioiTinh" class="form-control">
            <option value="" class="text-primary">Giới tính(*)</option>  
              <option value="<?php echo $user['GioiTinh'] ?>" <?php echo $user['GioiTinh'] ? "selected  =' selected '" : '' ?>><?php echo $user['GioiTinh'] ?></option>
              <?php if($user['GioiTinh'] == 'Nam'): ?>
                <option value="Nữ">Nữ</option>
              <?php else: ?>
                <option value="Nam">Nam</option>
              <?php endif; ?>
          </select>
           <!--  Notification -->
          <?php if(isset($error['GioiTinh'])): ?>
            <p class="text-danger"><i class="fa fa-exclamation"></i> <?php echo $error['GioiTinh'] ?></p>
          <?php endif ?>
      </div>

      <div class="form-group">
        <label class="text-primary">Địa chỉ(*)</label>
        <input type="text" class="form-control  name-user" name="DiaChi" placeholder="320A, QL61, Vĩnh Hoà Hiệp, Châu Thành, tỉnh Kiên Giang." value="<?php echo $user['DiaChi']  ?>">
      </div>
      <?php if(isset($error['DiaChi'])): ?>
        <p class="text-danger"><i class="fa fa-exclamation"></i> <?php echo $error['DiaChi'] ?></p>
      <?php endif ?>
      <button type="submit" class="btn btn-outline-warning get">Cập Nhật</button>
      <a href="profile.php?id=<?php echo $_SESSION['name_id'] ?>" class="btn btn-outline-warning get">Quay Lại</a>
  </form>
 
  
</div>
</div>
</div>
</section>
  
<?php require_once __DIR__. "/layouts/footer.php";  ?>  
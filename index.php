<?php 
    $open ="index";
	require_once __DIR__. "/autoload/autoload.php"; 
   // unset($_SESSION['cart']);
	$sqlHomeCategory= "SELECT id , TenDM FROM danh_muc WHERE HienThi = 1 ORDER BY Update_at";
	$CategoryHome = $db -> fetchsql($sqlHomeCategory);
	
	$data=[];
	foreach ($CategoryHome as $item) {
		$cateID = intval($item['id']); 
		$sql ="SELECT * FROM san_pham WHERE id_DanhMuc = $cateID LIMIT 8";
		$ProductHome = $db -> fetchsql($sql);
		$data[$item['TenDM']] = $ProductHome;
	}

   $tab_query = "SELECT * FROM thuong_hieu WHERE HienThi = 1  ORDER BY Update_at";
   $tab_result = mysqli_query($connect, $tab_query);
   $tab_menu = '';
   $tab_content = '';
   $i = 0;
   while($row = mysqli_fetch_array($tab_result))
   {
    if($i == 0)
    {
     $tab_menu .= '
      <li class="active"><a href="#'.$row["id"].'" data-toggle="tab">'.$row["TenTH"].'</a></li>
     ';
     $tab_content .= '
         <div id="'.$row["id"].'" class="tab-pane fade in active">
     ';
    }
    else
    {
     $tab_menu .= '
      <li><a href="#'.$row["id"].'" data-toggle="tab">'.$row["TenTH"].'</a></li>
     ';
     $tab_content .= '
         <div id="'.$row["id"].'" class="tab-pane fade">
     ';
    }
    $product_query = "SELECT * FROM san_pham WHERE id_ThuongHieu = '".$row['id']."' LIMIT 4";
    $product_result = mysqli_query($connect, $product_query);
    while($sub_row = mysqli_fetch_array($product_result))
    {
     $tab_content .= '
            <div class="col-sm-3 box">
               <div class="product-image-wrapper product_box">
                  <div class="single-products">
                     <div class="productinfo text-center">
                        <a href="chi-tiet-san-pham.php?id='.$sub_row['id'].'"><img src="'.uploads().'product/'.$sub_row["AnhSP"].'" alt="" /></a>
                        <a href="chi-tiet-san-pham.php?id='.$sub_row['id'].'"><p class="name">'.$sub_row['TenSP'].'</p></a>
                        <p class="sale">
                           <h5>'.formatPriceSale($sub_row['GiaSP'],$sub_row['GiamGia']).'</h5>
                           <small><del class="sale_price">'.formatPrice($sub_row['GiaSP']).'</del></small>
                        </p>
                        <a href="addcart.php?id='.$sub_row['id'] .'" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Th??m v??o gi??? h??ng</a>                 
                     </div>
                  </div>
               </div>
            </div>
     ';
    }
    $tab_content .= '<div style="clear:both"></div></div>';
    $i++;
   }
  
?>
<?php require_once __DIR__. "/layouts/header.php";  ?>	
<?php require_once __DIR__. "/layouts/nav.php";  ?>   
<!-- <?php foreach ($data as $key => $value): ?> <?php endforeach; ?>  <?php foreach ($value as $item): ?>  <?php endforeach; ?>   -->


<div class="col-sm-9 padding-right">
	<?php foreach ($data as $key => $value): ?>
   <div class="features_items">
      <!--features_items-->
      <h2 class="title text-center "><?php echo $key ?></h2>
     	<?php foreach ($value as $item): ?>
         <?php 
            $sqlallsize ="SELECT ct_size.*,size.id as ids,size.TenSize as TenSize FROM ct_size,size WHERE ct_size.id_Size= size.id AND id_SanPham = ". $item['id'];
            $allsize = $db -> fetchsql($sqlallsize); 
         ?>
      	<div class="col-sm-3 box"> 
         	<div class="product-image-wrapper product_box">
            <div class="single-products">
               <div class="productinfo text-center">
                  <a href="chi-tiet-san-pham.php?id=<?php echo $item['id'] ?>"><img src="<?php echo uploads() ?>product/<?php echo $item['AnhSP'] ?>" alt="" /></a>
                  <a href="chi-tiet-san-pham.php?id=<?php echo $item['id'] ?>"><p class="name"><?php echo $item['TenSP']?></p></a>
                  <p class="sale">
                     <h5><?php echo formatPriceSale($item['GiaSP'],$item['GiamGia']) ?></h5>
                     <small><del class="sale_price"><?php echo $item['GiamGia'] > 0 ? formatPrice($item['GiaSP']) : ''  ?></del>&nbsp;<?php echo $item['GiamGia'] > 0 ? " -".$item['GiamGia']."%" : ''  ?></small>
                  </p>
                  <a href="addcart.php?id=<?php echo $item['id'] ?>" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Th??m v??o gi??? h??ng</a>
               </div>
               <?php if($item['GiamGia'] > 0): ?>
                  <img src="<?php echo base_url() ?>public/fontend/images/home/sale.png" class="new" alt="" />
               <?php endif; ?>
            </div>
         	</div>
        </div>
       <?php endforeach; ?> 
   </div>
    <?php endforeach; ?>
   <!--features_items-->
   <div class="category-tab">
      <!--category-tab-->
      <div class="col-sm-12">
         <ul class="nav nav-tabs">
            <?php echo $tab_menu ?>
         </ul>
      </div>
      <div class="tab-content">
         <?php echo $tab_content;?>
      </div>
   </div>
   <?php require_once __DIR__. "/layouts/pay_product.php";  ?>
</div>



</div>
</div>
</div>
</section>
	
<?php require_once __DIR__. "/layouts/footer.php";  ?>
<?php if(isset($_SESSION['success'])) :?>
      <script>
            swal({
              title: "Th??ng B??o!",
              text: "Th??m v??o gi??? h??ng th??nh c??ng.",
              icon: "success",
            });
      </script>
      <?php unset($_SESSION['success']); ?>
      <!-- <div class="alert alert-success"><i class="fa fa-check"></i>
      <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
      </div> -->
<?php endif; ?>

<?php if(isset($_SESSION['thanhtoan'])) :?>
      <script>
            swal({
              title: "Th??ng B??o!",
              text: "Thanh To??n ????n H??ng Th??nh C??ng! Shop S??? Ph???n H???i B???n S???m Nh???t.",
              icon: "success",
            });
      </script>
      <?php unset($_SESSION['thanhtoan']); ?>
<?php endif; ?>
<?php if(isset($_SESSION['login'])) :?>
      <script>
            swal({
              title: "Th??ng B??o!",
              text: "????ng nh???p th??nh c??ng.",
              icon: "success",
            });
      </script>
      <?php unset($_SESSION['login']); ?>
<?php endif; ?>

<?php if(isset($_SESSION['logout'])) :?>
      <script>
            swal({
              title: "Th??ng B??o!",
              text: "????ng xu???t th??nh c??ng.",
              icon: "success",
            });
      </script>
      <?php unset($_SESSION['logout']); ?>
<?php endif; ?>

<?php if(isset($_SESSION['errorcard'])) :?>
      <script>
            swal("Th??ng B??o!", "Gi??? h??ng ch??a c?? s???n ph???m.");
      </script>
      <?php unset($_SESSION['errorcard']); ?>
<?php endif; ?>

<?php if(isset($_SESSION['errorcart2'])) :?>
      <script>
            swal("Th??ng B??o!", "Xin l???i! Size n??y trong kho ???? h???t.");
      </script>
      <?php unset($_SESSION['errorcart2']); ?>
<?php endif; ?>

<?php if(isset($_SESSION['errorresign'])) :?>
      <script>
            swal("Th??ng B??o!", "B???n ??ang ????ng nh???p n??n kh??ng th??? ????ng k??.");
      </script>
      <?php unset($_SESSION['errorresign']); ?>
<?php endif; ?>
<?php if(isset($_SESSION['giaodich'])) :?>
      <script>
            swal("Th??ng B??o!", "Giao d???ch kh??ng th??nh c??ng.");
      </script>
      <?php unset($_SESSION['giaodich']); ?>
<?php endif; ?>

<?php if(isset($_SESSION['chuky'])) :?>
      <script>
            swal("Th??ng B??o!", "Ch??? k?? kh??ng h???p l???.");
      </script>
      <?php unset($_SESSION['chuky']); ?>
<?php endif; ?>

<?php if(isset($_SESSION['pay'])) :?>
      <script>
            swal("Th??ng B??o!", "????n h??ng ???? thanh to??n.");
      </script>
      <?php unset($_SESSION['pay']); ?>
<?php endif; ?>

<?php if(isset($_SESSION['checklogin'])) :?>
      <script>
            swal("Th??ng B??o!", "B???n ???? ????ng nh???p.");
      </script>
      <?php unset($_SESSION['checklogin']); ?>
<?php endif; ?>
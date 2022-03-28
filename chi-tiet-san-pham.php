<?php 
   require_once __DIR__. "/autoload/autoload.php"; 
   $id = intval(getInput('id'));
	
   $product= $db-> fetchID("san_pham" ,$id);

   $category =$db->  fetchAll("danh_muc");

   $brands = $db-> fetchAll("thuong_hieu");

   $sqlavg =" SELECT *,AVG(Sao) as avg FROM danhgia WHERE id_SanPham= $id ";
   $avg = $db -> fetchsql($sqlavg);
   $cuontrate = count($db -> fetchsql($sqlavg));

   $sqlcountsize ="SELECT SUM(ct_size.SoLuong) as sl FROM ct_size WHERE ct_size.id_SanPham = $id";
   $countsize = $db -> fetchsql($sqlcountsize); 

   $sqlallsize ="SELECT ct_size.*,size.id as ids,size.TenSize as TenSize FROM ct_size,size WHERE ct_size.id_Size= size.id AND id_SanPham = $id";
   $allsize = $db -> fetchsql($sqlallsize);
    
   $cateid = intval($product['id_DanhMuc']);

   $sql ="SELECT * FROM san_pham WHERE id_DanhMuc = $cateid ORDER BY id DESC LIMIT 4";
   $sanphamlienquan= $db-> fetchsql($sql);

   $sql ="SELECT * FROM san_pham WHERE id_DanhMuc = $cateid ORDER BY id DESC LIMIT 4,4";
   $sanphamlienquan2= $db-> fetchsql($sql);

   $pagesize = 20;

   $pagenumber = isset($_GET['page']) ? $_GET['page'] :"1";
   
   $sqlcomment ="SELECT binhluan.*,users.HoTen as HoTen FROM users,binhluan WHERE binhluan.id_User = users.id AND binhluan.TrangThai =1 AND id_SanPham = $id ORDER BY binhluan.id DESC LIMIT " .($pagenumber - 1) * $pagesize." , $pagesize";
   $sqltotal ="SELECT binhluan.*,users.HoTen as HoTen FROM users,binhluan WHERE binhluan.id_User = users.id AND binhluan.TrangThai =1 AND id_SanPham = $id ORDER BY binhluan.id DESC";

   $total = count($db-> fetchsql($sqltotal));

   $comment = $db -> fetchsql($sqlcomment);

   $totalpage = ceil($total/$pagesize);

   if(isset($_SESSION['name_id']))
   {
      $sqlpaid = "SELECT don_hang.id,id_SanPham,TrangThai,id_Users FROM don_hang,chi_tiet_dh WHERE chi_tiet_dh.id_DonHang=don_hang.id AND don_hang.id_Users = '".$_SESSION['name_id']."' and id_SanPham = $id ORDER BY TrangThai DESC LIMIT 1";
      
      $paid = $db -> fetchsql($sqlpaid);

      $count_paid = count($db-> fetchsql($sqlpaid));

      $sqlrate = " SELECT * FROM danhgia WHERE id_User= " .$_SESSION['name_id'] . " AND id_SanPham = $id LIMIT 1" ;
      $rating = $db ->fetchsql($sqlrate);
   }

   if($_SERVER["REQUEST_METHOD"] == "POST")
   {
      if(isset($_SESSION['name_id']))
      {
         
         $data = [
            "NoiDung" => postInput('NoiDung'),
            "id_User" => $_SESSION['name_id'],
            "id_SanPham" => $id
         ];
         $error=[];
        if(postInput('NoiDung') == '') 
        {
            $error['NoiDung']=""; 
        }
        if(strlen(postInput('NoiDung'))  > 100 ) 
	    {
	        	$error['NoiDung']="";
	        	$_SESSION['NoiDung100'] ="";
	    }
        if(isset($_POST['submit']))
        {
            if(empty($error))
            {
               $id_insert =$db -> insert("binhluan" , $data);
               if($id_insert)
               {
                    $_SESSION['addcomment'] ="";
                    header("Refresh:2");
               }
               else 
               {
                  $_SESSION['fail'] ="";
               }
            }
        }
      }
      else
      {
         $_SESSION['unlogin']="";
      }
   }

?>
<?php require_once __DIR__. "/layouts/header.php";  ?>	
<?php require_once __DIR__. "/layouts/nav.php";  ?>   	
<div class="col-sm-9 padding-right">
<div class="product-details">
   <!--product-details-->
   <div class="col-sm-5">
      <div class="view-product">
         <img src="<?php echo uploads() ?>product/<?php echo $product['AnhSP'] ?>" alt="" />
      </div>
     <!--  <div id="similar-product" class="carousel slide" data-ride="carousel">
       
         <div class="carousel-inner">
            <div class="item active">
               <a href=""><img src="<?php echo base_url() ?>public/fontend/images/product-details/similar1.jpg" alt=""></a>
               <a href=""><img src="<?php echo base_url() ?>public/fontend/images/product-details/similar2.jpg" alt=""></a>
               <a href=""><img src="<?php echo base_url() ?>public/fontend/images/product-details/similar3.jpg" alt=""></a>
            </div>
            <div class="item">
               <a href=""><img src="<?php echo base_url() ?>public/fontend/images/product-details/similar1.jpg" alt=""></a>
               <a href=""><img src="<?php echo base_url() ?>public/fontend/images/product-details/similar2.jpg" alt=""></a>
               <a href=""><img src="<?php echo base_url() ?>public/fontend/images/product-details/similar3.jpg" alt=""></a>
            </div>
            <div class="item">
               <a href=""><img src="<?php echo base_url() ?>public/fontend/images/product-details/similar1.jpg" alt=""></a>
               <a href=""><img src="<?php echo base_url() ?>public/fontend/images/product-details/similar2.jpg" alt=""></a>
               <a href=""><img src="<?php echo base_url() ?>public/fontend/images/product-details/similar3.jpg" alt=""></a>
            </div>
         </div>
        
         <a class="left item-control" href="#similar-product" data-slide="prev">
         <i class="fa fa-angle-left"></i>
         </a>
         <a class="right item-control" href="#similar-product" data-slide="next">
         <i class="fa fa-angle-right"></i>
         </a>
      </div> -->
   </div>
   <div class="col-sm-7">
      	<div class="product-information">
         <!--/product-information-->
            <?php  ?>
	         <?php if($product['GiamGia'] > 0): ?> 
	              <img src="<?php echo base_url() ?>public/fontend/images/product-details/sale3.png" class="newarrival" alt="" />
	         <?php endif; ?>
	         <h2 class="text-secondary"><?php echo $product['TenSP'] ?></h2>
	         <p>ID #<?php echo $product['id'] ?></p>
	         <h3 class="saleoff"><?php echo $product['GiamGia'] > 0 ? 'Sale '. $product['GiamGia'] . " % :" : ''  ?> <del><i><?php echo $product['GiamGia'] > 0 ? formatPrice($product['GiaSP']) : ''  ?></i></del></h3>
	         
	         <span>
	         <span><?php echo formatPriceSale($product['GiaSP'],$product['GiamGia']) ?></span>
	         </span>
            <?php foreach ($countsize as $value): ?>
            <div class="clearfix">
               <label ><p><b><b>Trong Kho: <?php echo $value['sl'] ?></b></b></p></label>
            </div>
	         <p><b>Trạng Thái:</b> <?php echo $value['sl'] > 1 ? 'Còn Hàng' : 'Hết Hàng' ?></p>
             <?php endforeach; ?>
	         <p><b>Danh Mục:</b> 
            <?php foreach ($category as $value): ?>
               <?php if($product['id_DanhMuc'] == $value['id']): ?>
                  <a href="danh-muc-san-pham.php?id=<?php echo $value['id'] ?>"><?php  echo $value['TenDM'] ?></a>
               <?php endif; ?>
            <?php endforeach; ?>
            </p>
	         <p><b>Thương Hiệu:</b> 
            <?php foreach ($brands as $value): ?>
               <?php if($product['id_ThuongHieu'] == $value['id']): ?>
                  <a href="thuong-hieu.php?id=<?php echo $value['id'] ?>"><?php  echo $value['TenTH']  ?></a>
               <?php endif; ?>
            <?php endforeach; ?>
            </p>
            <p><b>Size: </b> 
            <?php foreach ($allsize as $value): ?>
               <a href="size.php?id=<?php echo $value['ids'] ?>"><?php  echo $value['TenSize']  ?> </a>
            <?php endforeach; ?>
            </p>
            <p><b>Đã Bán: </b> <?php echo $product['LanBan'] ?> Đơn Hàng</p>
            <?php foreach ($avg as $value): ?>
               <?php if($value['Sao'] != NULL): ?>
                    <p> 
                        <div class="avgratings" data-rating="<?php echo number_format($value['avg']) ?>"><b> Đánh Giá :  <?php number_format($value['avg']) ?></b> 
                        </div>
                    </p>
               <?php endif; ?>
            <?php endforeach ?>
            <button type="button" class="btn btn-fefault cart">
               <a href="addcart.php?id=<?php echo $id ?>" style="color: white"><i class="fa fa-shopping-cart"></i> Thêm vào giỏ hàng</a>
            </button>
	        <?php if($product['GiamGia'] > 0): ?>
	                  <img src="<?php echo base_url() ?>public/fontend/images/home/sale.png" class="new" alt="" />
	        <?php endif; ?>
      </div>
      <!--/product-information-->
   	</div>
	</div>
<!--/product-details-->
	<div class="category-tab shop-details-tab">
   <!--category-tab-->
   <div class="col-sm-12">
      <ul class="nav nav-tabs">
         <li class="active"><a href="#details" data-toggle="tab">Thông Tin Chi Tiết</a></li>
         <li><a href="#reviews" data-toggle="tab"> Bình Luận</a></li>
         <li><a href="#rate" data-toggle="tab"> Đánh Giá</a></li>
      </ul>
   </div>
   <div class="tab-content">
      <div class="tab-pane fade" id="reviews" >
         <?php if(isset($error['id_DanhMuc'])): ?>
            <p class="text-danger"><i class="fas fa-exclamation"></i> <?php echo $error['id_DanhMuc'] ?></p>
         <?php endif ?>
         <?php  if(isset($_SESSION['name_id'])): ?>
         <?php foreach ($paid as $value): ?>
            <?php if($count_paid >= 1): ?>
               <?php if($value['TrangThai'] == 3): ?>
                  <div class="col-sm-12">
                     <form action="" method="POST" >
                        <textarea name="NoiDung" id="NoiDung" placeholder="Viết bình luận của bạn về sản phẩm..." required=""></textarea>
                        <button type="submit" name="submit" class="btn btn-default pull-right" >Đăng</button>
                     </form>
                  </div>
               <?php endif; ?>
            <?php endif; ?>
         <?php endforeach; ?>
         <?php endif; ?>
         <div class="col-sm-12 comment_box">
            <h5 class="count_comment"><?php echo $total ?> Bình Luận</h5>
            <?php foreach ($comment as $value): ?>
               <div class="comment">
                  <div>
                      <?php if($_SESSION['name_id'] == $value['id_User']):?>
                        <i>Bạn đã bình luận </i>
                      <?php endif; ?>
                  <b class="name-user"><?php echo $value['HoTen'] ?> </b><small class="timecomment"><?php echo date("H:i m-d-Y", strtotime($value['created_at'])) ?></small></div>
                  <div class="UserComment"><?php echo $value['NoiDung'] ?></div>
                  <div class="reply">
                  <?php 
                     $sqlreply = "SELECT traloibl.*,admin.HoTen as HoTen,admin.CapBat as CapBat,traloibl.Created_at as created_at FROM traloibl,admin WHERE traloibl.id_admin= admin.id AND id_BinhLuan = ".$value['id'] ." ORDER BY traloibl.Created_at";
                     $reply = $db -> fetchsql($sqlreply);
                  ?>
                  <?php foreach ($reply as $value): ?>
                     <div class="reply_user">
                        <div>
                           <?php if($value['CapBat'] == 2): ?>
                           <b class="admin"><?php echo $value['HoTen'] ?>
                              <i class="fa fa-check"></i>
                           </b>
                           <?php else: ?>
                              <b class="ctv"><?php echo $value['HoTen'] ?>
                              <i class="fa fa-check"></i>
                           </b>
                           <?php endif; ?>
                           <small class="time_reply"> <?php echo date("H:i m-d-Y", strtotime($value['created_at'])) ?></small>
                        </div>
                        <div class="admin_reply"><?php echo $value['NoiDung'] ?></div>
                     </div>
                  <?php endforeach; ?>
                  </div>
               </div>
               <?php endforeach; ?>
         </div>

         <div class="text-center">
            <nav aria-label="Page navigation example">
            <ul class="pagination">
                  <li class="page-item <?php if($pagenumber == 1) echo 'disabled' ?>">
                     <?php if($pagenumber >= 2): ?>
                        <a class="page-link" href="?id=<?php echo $id ?>&page=<?php if($pagenumber ==1)echo $pagenumber; else echo $pagenumber - 1 ?>"><?php if($totalpage >= 2) echo "Previous"; ?></a>
                     <?php endif; ?>
                  </li>
                  <?php if($totalpage > 1): ?>
                     <?php for($i =1 ; $i <= $totalpage ; $i++): ?>
                           <?php if(abs($pagenumber - $i <= 2)): ?>
                              <li class="page-item <?php if($pagenumber == $i) echo 'active' ?>"><a class="page-link" href="?id=<?php echo $id ?>&page=<?php echo $i ?>"><?php echo $i ?></a></li>
                         <?php endif; ?>
                     <?php endfor; ?>
                  <?php endif; ?>
                  <li class="page-item <?php if($pagenumber == $totalpage)  echo 'disabled' ?>">
                     <?php  if($pagenumber != $totalpage && $totalpage >=2): ?>
                        <a class="page-link" href="?id=<?php echo $id ?>&page=<?php if($pagenumber != $totalpage) echo $pagenumber + 1; else echo $pagenumber ?>"><?php if($totalpage >= 2 ) echo "Next";  ?></a>
                     <?php endif; ?>
                  </li>
            </ul>
            </nav> 
      </div>
      </div>
      <div class="tab-pane fade active in" id="details" >
         <div class="col-sm-12 c1">
           <p><?php echo $product['MoTa'] ?></p>
         </div>
      </div>
      <div class="tab-pane fade" id="rate" >
         <div class="col-sm-12">
            <?php  if(isset($_SESSION['name_id'])): ?>
            <?php foreach ($paid as $value): ?>
               <?php if($count_paid >= 1): ?>
                  <?php if($value['TrangThai'] == 3): ?>
                     <div class="col-sm-12">
                        <?php foreach ($rating as $value): ?>
                        <p><div class="ratings" data-rating="<?php echo $value['Sao'] ?>"><b>Bạn Đã Đánh Giá :</b></div></p> 
                        <?php endforeach ?>
                        <form action="" method="POST" onsubmit="return saveRatings(this);">
                          <input type="hidden" name="product_id" value="<?php echo $id; ?>">
                           <div class="starrr">Đánh Giá :</div>
                           <button type="submit" name="submit" class="btn btn-default btn-sm pull-center" ><i class="fa fa-spinner"></i> Lưu</button>
                        </form>
                     </div>
                     <?php endif; ?>
                  <?php endif; ?>
               <?php endforeach; ?>
            <?php endif; ?>
         </div>
      </div>
   </div>
</div>
<!--/category-tab-->
   <!--features_items-->
   <div class="category-tab">
     
   <!--/category-tab-->
   <?php require_once __DIR__. "/layouts/new_product.php";  ?>
   <!--/recommended_items-->
</div>
</div>
</div>
</section>
	
<?php require_once __DIR__. "/layouts/footer.php";  ?>	
<script>
   var ratings = 0;
   $(function () {
         $(".starrr").starrr().on("starrr:change", function (event, value) {
              ratings = value;
         });
         var rating = document.getElementsByClassName("ratings");
         for (var a = 0; a < rating.length; a++)
         {
            $(rating[a]).starrr({
               readOnly: true,
               rating: rating[a].getAttribute("data-rating")
            });
         }

         var rating = document.getElementsByClassName("avgratings");
         for (var b = 0; b < rating.length; b++)
         {
            $(rating[b]).starrr({
               readOnly: true,
               rating: rating[b].getAttribute("data-rating")
            });
         }
   });
    
   function saveRatings(form) {
      var product_id = form.product_id.value;
      
      $.ajax({
           url: "ratings.php",
           method: "POST",
           data: {
               "product_id": product_id,
               "ratings": ratings
           },
           success: function (response) {
               // whatever server echo, that will be displayed here in alert
               <?php if(isset($_SESSION['addrate'])) :?>
                  swal("Thông Báo!", "Lưu đánh giá thành công.");
                  <?php unset($_SESSION['addrate']); ?>
               <?php else: ?>
                  swal("Thông Báo!", "Lưu đánh giá thành công.");
                  <?php unset($_SESSION['addrate']); ?>
               <?php endif; ?>
           }
       });
    
       return false;
   }
   
</script>

<?php if(isset($_SESSION['unlogin'])) :?>
      <script>
            swal("Thông Báo!", "Bạn chưa đăng nhập không thể bình luận.");
      </script>
      <?php unset($_SESSION['unlogin']); ?>
<?php endif; ?>

<?php if(isset($_SESSION['addcomment'])) :?>
        <script>
            swal("Thông Báo!", "Đăng bình luận thành công.");
        </script>
        <?php unset($_SESSION['addcomment']); ?>
<?php endif; ?>

<?php if(isset($_SESSION['fail'])) :?>
      <script>
            swal("Thông Báo!", "Bình luận không được đăng.");
      </script>
      <?php unset($_SESSION['fail']); ?>
<?php endif; ?>
<?php if(isset($_SESSION['NoiDung100'])) :?>
      <script>
            swal("Thông Báo!", "Bình luận của bạn quá dài.");
      </script>
      <?php unset($_SESSION['NoiDung100']); ?>
<?php endif; ?>

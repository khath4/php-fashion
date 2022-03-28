<?php 
	require_once __DIR__. "/autoload/autoload.php"; 
	
	$id = intval(getInput('id'));
	
  	$sizect2= $db-> fetchID("size" ,$id);
  	
    $pagesize = 12;

    $pagenumber = isset($_GET['page']) ? $_GET['page'] :"1";

    $search =isset($_GET['search']) ? $_GET['search'] : "";

    $sql ="SELECT * FROM san_pham,ct_size WHERE ct_size.id_Size = $id AND ct_size.id_SanPham = san_pham.id ORDER BY san_pham.id DESC LIMIT " .($pagenumber - 1) * $pagesize." , $pagesize";
   
    $sqltotal ="SELECT * FROM san_pham,ct_size WHERE ct_size.id_Size = $id  AND ct_size.id_SanPham = san_pham.id ORDER BY san_pham.id DESC";

    $total = count($db-> fetchsql($sqltotal));

    $product = $db -> fetchsql($sql);

    $totalpage = ceil($total/$pagesize);

?>
<?php require_once __DIR__. "/layouts/header.php"; ?>
<?php require_once __DIR__. "/layouts/nav.php";  ?>  	
<div class="col-sm-9 padding-right">
   <div class="features_items">
      <!--features_items-->
      	<h2 class="title text-center">Size <?php echo $sizect2['TenSize'] ?></h2>
      	<?php foreach ($product as $item): ?> 
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
                  <a href="addcart.php?id=<?php echo $item['id'] ?>" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Thêm vào giỏ hàng</a>
               </div>
               <?php if($item['GiamGia'] > 0): ?>
                  <img src="<?php echo base_url() ?>public/fontend/images/home/sale.png" class="new" alt="" />
               <?php endif; ?>
            </div>
          </div>
        </div>
  	<?php endforeach; ?> 
   	</div>
   <div class="text-center">
          <nav aria-label="Page navigation example">
            <ul class="pagination">
                <li class="page-item <?php if($pagenumber == 1) echo 'disabled' ?>">
                  <?php if($pagenumber != 1): ?>
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
   <!--features_items-->
   <div class="category-tab"> 
   <?php require_once __DIR__. "/layouts/pay_product.php";  ?>
</div>
</div>
</div>
</section>
	
<?php require_once __DIR__. "/layouts/footer.php";  ?>	
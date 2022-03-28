   <!--/category-tab-->
   <div class="recommended_items">
      <!--recommended_items-->
      <h2 class="title text-center">Sản Phẩm Mới</h2>
      <div id="recommended-item-carousel" class="carousel slide" data-ride="carousel">
         <div class="carousel-inner">
            <div class="item active">
            	<?php foreach ($productNew as $item) :?>
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
			   <div class="item">
            	<?php foreach ($productNew2 as $item) :?>
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
         </div>
         <a class="left recommended-item-control" href="#recommended-item-carousel" data-slide="prev">
         <i class="fa fa-angle-left"></i>
         </a>
         <a class="right recommended-item-control" href="#recommended-item-carousel" data-slide="next">
         <i class="fa fa-angle-right"></i>
         </a>			
      </div>
   </div>
   <!--/recommended_items-->
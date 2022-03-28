<?php 
    $open ="cart";
	require_once __DIR__. "/autoload/autoload.php"; 
	$id = intval(getInput('id'));

	if(!isset($_SESSION['cart']))
 	{
		$_SESSION['errorcard'] = "";
        header("location: index.php");   
 	}
  	$sum = 0;
  	
?>
<?php require_once __DIR__. "/layouts/header.php";  ?>  
	
	<section id="cart_items">
		<div class="container">
			<div class="breadcrumbs">
				<ol class="breadcrumb" style="margin-bottom: 40px;">
				  <li><a href="index.php">Trang Chủ</a></li>
				  <li class="active">Giỏ Hàng</li>
				</ol>
			</div>
			<?php if(isset($_SESSION['success'])) :?>
	        <div class="alert alert-success"><i class="fa fa-check"></i>
	        <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
	        </div>
	    	<?php endif; ?>
	    	<?php if(isset($_SESSION['error2'])) :?>
        <div class="alert alert-danger"><i class="fa fa-times"></i>
        <?php echo $_SESSION['error2']; unset($_SESSION['error2']); ?>
        </div>
    <?php endif; ?>
			<div class="table-responsive cart_info">
				<table class="table table-condensed">
					<thead>
						<tr class="cart_menu">
							<td class="total">STT</td>
							<td class="image">Sản Phẩm</td>
							<td class="description">Thông Tin</td>
							<td class="price">Giá Bán</td>
							<td class="size">Size</td>
							<td class="quantity">Số Lượng</td>
							<td class="total">Tổng Tiền</td>
							<td>Thao Tác</td>
						</tr>
					</thead>
					<tbody>
						<?php $stt =1 ;foreach ($_SESSION['cart'] as $key => $value): ?>
						<?php 
							$sqlallsize ="SELECT ct_size.*,size.id as ids,size.TenSize as TenSize FROM ct_size,size WHERE ct_size.id_Size= size.id AND id_SanPham = $key ";
  							$allsize = $db -> fetchsql($sqlallsize); 
  						?>
						<tr>
							<td class="cart_total_price"><?php echo $stt ?></td>
							<td class="cart_product">
								<a href="chi-tiet-san-pham.php?id=<?php echo $key ?>"><img src="<?php echo uploads() ?>product/<?php echo $value['AnhSP'] ?>" width='110' height='110' alt=""></a>
							</td>
							<td class="cart_description">
								<h4><a href="chi-tiet-san-pham.php?id=<?php echo $key ?>"><?php echo $value['TenSP'] ?></a></h4>
								<p>ID#<?php echo $key ?></p>
							</td>
							<td class="cart_price">
								<p><?php echo formatPrice($value['GiaSP'])?></p>
							</td>
							<td>
								<select name="id_Size" class="form-control item-category id_Size" name="id_Size" required>
									<?php foreach ($allsize as $item): ?>
										<option value="<?php echo $item['ids'] ?>" <?php echo $value['id_Size'] == $item['ids'] ? "selected  =' selected '" : '' ?>><?php echo $item['TenSize'] ?></option>
										<p class="id"><?php $item['id'] ?></p>
									<?php endforeach ?>			      		
						      	</select>
							</td>
							<td class="cart_quantity">
								<div class="cart_quantity_button">
									<input class="form-control cart_quantity_input SoLuong" type="number" name="SoLuong" value="<?php echo $value['SoLuong'] ?>" autocomplete="off" Size="1" id="SoLuong" min="1">
								</div>
							</td>
							<td class="cart_total">
								<p class="cart_total_price"><?php echo formatPrice($value['GiaSP'] * $value['SoLuong'])?></p>
							</td>
							<td class="cart_delete">
								<a class="cart_quantity_delete updatecart" type="submit" style="background-color:#0000ffb3;" href="cap-nhat-gio-hang.php?key=<?php echo $key ?>" data-key=<?php echo $key ?>><i class="fa fa-refresh"></i></a>
								<a data-toggle="modal" data-target="#myModal" class="cart_quantity_delete" style="background-color: #ff0000b8" ><i class="fa fa-times"></i></a>
								
							</td>
						</tr>
							<?php $sum +=  $value['GiaSP'] * $value['SoLuong'] ; $_SESSION['tongtien'] = $sum; ?>
						<?php $stt ++ ; endforeach; ?>
					</tbody>
				</table>
			</div>
		</div>
	</section> <!--/#cart_items-->

	<section id="do_action">
		<div class="container">
			<div class="heading">
				<h2 class="text-primary">Thông Tin Đơn Hàng</h2>
			</div>
			<div class="row">
				
				<div class="col-sm-6">
					<div class="total_area">
						<ul>
							<li>Số Tiền <span><?php echo formatPrice($_SESSION['tongtien']) ?></span></li>
							<!-- <li>Giảm Giá <span><?php echo sale($_SESSION['tongtien']) ?> %</span></li>  -->
							<li>Phí Vận Chuyển<span>Free</span></li>
							<li>Thuế VAT<span>10 %</span></li>
							<li>Tổng Tiền Thanh Toán<span><?php $_SESSION['total'] = ($_SESSION['tongtien'] * 110/100) ; echo formatPrice($_SESSION['total']) ?></span></li>
						</ul>
							<a class="btn btn-default check_out" href="thanh-toan.php" style="margin-left: 40px" >Thanh Toán Khi Nhận Hàng</a>
							<a class="btn btn-default check_out" href="pay_online.php" style="margin-left: 40px" >Thanh Toán Online</a>
					</div>
				</div>
				
				<div class="col-sm-6">
					<!--<div class="heading">-->
					<!--	<h2 class="text-primary">Phương Thức Thanh Toán</h2>-->
					<!--</div>-->
					<!--<div class="chose_area">-->
						
					<!--	<ul class="user_option">-->
  			<!--				<li><input type="radio" name="joke" value="1" /> ATM</li>-->
  			<!--				<li><input type="radio" name="joke" value="2" /> Visa Card</li>-->
 				<!--			<li> <input type="radio" name="joke" value="3" /> Giao Tiền Khi Nhận Hàng</li>-->
					<!--	</ul>-->
						<!-- <ul class="user_info">
							<li class="single_field">
								<label>Country:</label>
								<select>
									<option>United States</option>
									<option>Bangladesh</option>
									<option>UK</option>
									<option>India</option>
									<option>Pakistan</option>
									<option>Ucrane</option>
									<option>Canada</option>
									<option>Dubai</option>
								</select>
								
							</li>
							<li class="single_field">
								<label>Region / State:</label>
								<select>
									<option>Select</option>
									<option>Dhaka</option>
									<option>London</option>
									<option>Dillih</option>
									<option>Lahore</option>
									<option>Alaska</option>
									<option>Canada</option>
									<option>Dubai</option>
								</select>
							
							</li>
							<li class="single_field zip-field">
								<label>Zip Code:</label>
								<input type="text">
							</li>
						</ul>
						<a class="btn btn-default update" href="">Get Quotes</a>
						<a class="btn btn-default check_out" href="">Continue</a> -->
					</div>
				</div>
			</div>
		</div>
	</section><!--/#do_action-->

<?php require_once __DIR__. "/layouts/footer.php";  ?>		
  	
<?php if(isset($_SESSION['updatecart'])) :?>
      <script>
            swal("Thông Báo!", "Cập Nhật Thành Công.");
      </script>
      <?php unset($_SESSION['updatecart']); ?>
      <!-- <div class="alert alert-success"><i class="fa fa-check"></i>
      <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
      </div> -->
<?php endif; ?>
<?php if(isset($_SESSION['removecart'])) :?>
      <script>
            swal("Thông Báo!", "Xóa Sản Phẩm Thành Công.");
      </script>
      <?php unset($_SESSION['removecart']); ?>
      <!-- <div class="alert alert-success"><i class="fa fa-check"></i>
      <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
      </div> -->
<?php endif; ?>
<?php if(isset($_SESSION['errorcart'])) :?>
      <script>
            swal("Thông Báo!", "Xin lỗi! Size bạn chọn trong kho đã hết.");
      </script>
      <?php unset($_SESSION['errorcart']); ?>
      <!-- <div class="alert alert-success"><i class="fa fa-check"></i>
      <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
      </div> -->
<?php endif; ?>


 <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Xác Nhận !</h4>
        </div>
        <div class="modal-body">
          <p>Bạn Có Muốn Xóa Sản Phẩm Này Khỏi Giỏ Hàng?</p>
        </div>
        <div class="modal-footer">
          <a type="button" class="btn btn-success" href="remove.php?key=<?php echo $key ?>">OK</a>
          <button type="button" class="btn btn-danger" data-dismiss="modal">X</button>
        </div>
      </div>

    </div>
  </div>
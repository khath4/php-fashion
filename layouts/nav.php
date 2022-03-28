<section id="slider"><!--slider-->
		<div class="container">
			<div class="row">
				<div class="col-sm-12">
					<?php if(isset($open) && $open == 'blog'): ?>

					<?php else: ?>
					<?php 
						$sqlbanner1 = "SELECT * FROM banner WHERE HienThi = 1 ORDER BY Update_at LIMIT 1";
						$banner1 = $db -> fetchsql($sqlbanner1);
						$sqlbanner2 = "SELECT * FROM banner WHERE HienThi = 1 ORDER BY Update_at LIMIT 1,2";
						$banner2 = $db -> fetchsql($sqlbanner2);
					?>	
					<div id="slider-carousel" class="carousel slide" data-ride="carousel">
						<ol class="carousel-indicators">
							<li data-target="#slider-carousel" data-slide-to="0" class="active"></li>
							<li data-target="#slider-carousel" data-slide-to="1"></li>
							<li data-target="#slider-carousel" data-slide-to="2"></li>
						</ol>
						<div class="carousel-inner">
							<?php foreach ($banner1 as $value): ?>
							<div class="item active">
								<div class="col-sm-6">
									<h1><span>E</span>-SHOPPER</h1>
									<h2><?php echo $value['TieuDe'] ?></h2>
									<p><?php echo $value['NoiDung'] ?></p>
									<button type="button" class="btn btn-default get"><a href="sale.php" class="text-white">Xem ngay</a></button>
								</div>
								<div class="col-sm-6">
									<img src="<?php echo uploads() ?>banner/<?php echo $value['AnhBanner'] ?>" class="girl img-responsive" alt="" />
								</div>
							</div>
							<?php endforeach; ?>
							<?php foreach ($banner2 as $value): ?>
							<div class="item">
								<div class="col-sm-6">
									<h1><span>E</span>-SHOPPER</h1>
									<h2><?php echo $value['TieuDe'] ?></h2>
									<p><?php echo $value['NoiDung'] ?></p>
									<button type="button" class="btn btn-default get"><a href="sale.php" class="text-white">Xem ngay</a></button>
								</div>
								<div class="col-sm-6">
									<img src="<?php echo uploads() ?>banner/<?php echo $value['AnhBanner'] ?>" class="girl img-responsive" alt="" />
									<!-- <img src="<?php echo base_url() ?>public/fontend/images/home/pricing.png"  class="pricing" alt="" /> -->
								</div>
							</div>
							<?php endforeach; ?>
						</div>
						
						<a href="#slider-carousel" class="left control-carousel hidden-xs" data-slide="prev">
							<i class="fa fa-angle-left"></i>
						</a>
						<a href="#slider-carousel" class="right control-carousel hidden-xs" data-slide="next">
							<i class="fa fa-angle-right"></i>
						</a>
					</div>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</section><!--/slider-->
	<?php
		$sqlparentcategory = "SELECT danh_muc_cha.id,danh_muc_cha.TenDMC FROM danh_muc_cha,danh_muc,san_pham WHERE danh_muc_cha.id = danh_muc.id_DanhMC AND san_pham.id_DanhMuc = danh_muc.id ORDER BY danh_muc_cha.SoTT"; 
		$parentscategory = $db -> fetchsql($sqlparentcategory);
			
		$Parentsdata=[];
		foreach ($parentscategory as $item) {
			$parentscateID = intval($item['id']);  
			$sqlparents ="SELECT id_DanhMuc,danh_muc.id,danh_muc.TenDM,COUNT(san_pham.id) as count_category FROM  san_pham,danh_muc WHERE id_DanhMC = $parentscateID AND san_pham.id_DanhMuc= danh_muc.id GROUP BY id_DanhMuc ORDER BY SoTT";
			$pCategory = $db -> fetchsql($sqlparents);
			$Parentsdata[$item['id']]= $pCategory;
		}

		$sqlbrands ="SELECT *,id_ThuongHieu,COUNT(san_pham.id) as count_brands FROM san_pham,thuong_hieu WHERE san_pham.id_ThuongHieu= thuong_hieu.id GROUP BY id_ThuongHieu ORDER BY SoTT";
   		$menuBrands = $db -> fetchsql($sqlbrands);
	?>
	<section>
		<div class="container">
			<div class="row">
				<div class="col-sm-3">
					<div class="left-sidebar">
						<h2>Danh Mục</h2>
						<div class="panel-group category-products" id="accordian"><!--category-productsr-->
							<?php foreach ($Parentsdata as $key => $value): ?>
							<div class="panel panel-default">
								<div class="panel-heading">
									<h4 class="panel-title">
										<a data-toggle="collapse" data-parent="#accordian" href="#<?php echo $key ?>">
											<span class="badge pull-right"><i class="fa fa-plus"></i></span>
											<?php $parentscategory2 = $db -> fetchID("danh_muc_cha" , $key) ?>
											<?php echo $parentscategory2['TenDMC'] ?>
										</a>
									</h4>
								</div>				
								<div id="<?php echo $key ?>" class="panel-collapse collapse">
									<div class="panel-body">
										<?php foreach ($value as $item): ?>
										<ul>
											<li><a href="danh-muc-san-pham.php?id=<?php echo $item['id'] ?>"><?php echo $item['TenDM'] ?> <span class="pull-right"></span> (<?php echo $item['count_category'] ?>) </a></li>
										</ul>
										<?php endforeach; ?>
									</div>
									
								</div>
							</div>
							<?php endforeach; ?>
						</div>

						<div class="brands_products"><!--brands_products-->
							<h2>Thương Hiệu</h2>
							<div class="brands-name">
								<?php foreach($menuBrands as $item) : ?>
								<ul class="nav nav-pills nav-stacked">
									<li><a href="thuong-hieu.php?id=<?php echo $item['id'] ?>"><b><span class="pull-right">(<?php echo $item['count_brands'] ?>)</span><?php echo $item['TenTH'] ?></b></a></li>
								</ul>
								<?php endforeach; ?>
							</div>
							
						</div><!--/brands_products-->

						<div class="price-range"><!--price-range-->
							<h2>Lọc Giá</h2>
								<div class="list-group">
								<form action="all.php" name="search_box" method="GET">
									<div class="row">
										<div class="col-md-5">
											<input type="text" placeholder="VND" name="minimum_range" id="minimum_range" class="form-control" value="<?php if(isset($minimum_range)): echo $minimum_range; else: echo ''; endif; ?>" required />
										</div>
										<div class="col-md-1">_</div>
										<div class="col-md-5"> 
											<input type="text" placeholder="VND" name="maximum_range" id="maximum_range" class="form-control" value="<?php if(isset($maximum_range)): echo $maximum_range; else: echo ''; endif; ?>" required />
										</div>
										<div class="text-center" >
											<button type="submit" style="margin-top: 15px;" class="btn btn-success" value="filter" name="query">Áp Dụng</button>
										</div>
									</div>
								</form>
								</div>
						</div><!--/price-range-->

						<?php 
							$sqladver = "SELECT * FROM adver WHERE HienThi = 1 LIMIT 5";
							$adver = $db -> fetchsql($sqladver);
						?>
						<?php foreach ($adver as $value): ?>
							<div class="shipping text-center"><!--shipping-->
								<a href="<?php echo $value['DuongDan'] ?>"><img src="<?php echo uploads() ?>adver/<?php echo $value['AnhAdver'] ?>" alt="" /></a>
							</div>
						<?php endforeach; ?>
					</div>
				</div>
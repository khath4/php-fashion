<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>E-Shopper</title>
    <link href="<?php echo base_url() ?>public/fontend/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url() ?>public/fontend/css/font-awesome.min.css" rel="stylesheet">
    <link href="<?php echo base_url() ?>public/fontend/css/prettyPhoto.css" rel="stylesheet">
    <link href="<?php echo base_url() ?>public/fontend/css/price-range.css" rel="stylesheet">
    <link href="<?php echo base_url() ?>public/fontend/css/animate.css" rel="stylesheet">
	<link href="<?php echo base_url() ?>public/fontend/css/main.css" rel="stylesheet">
	<link href="<?php echo base_url() ?>public/fontend/css/responsive.css" rel="stylesheet">
	<link href="<?php echo base_url() ?>public/fontend/css/starrr.css" rel="stylesheet">
	
    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->       
    <link rel="shortcut icon" href="<?php echo base_url() ?>public/fontend/images/ico/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo base_url() ?>public/fontend/images/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo base_url() ?>public/fontend/images/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo base_url() ?>public/fontend/images/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="<?php echo base_url() ?>public/fontend/images/ico/apple-touch-icon-57-precomposed.png">

    <script src="<?php echo base_url() ?>public/ckeditor/ckeditor.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.css">
	
</head><!--/head-->

<body>
	<header id="header"><!--header-->
		<div class="header_top"><!--header_top-->
			<div class="container">
			    <?php foreach ($contact as $value): ?> 
				<div class="row">
					<div class="col-sm-6">
						<div class="contactinfo">
							<ul class="nav nav-pills">
								<li><a href="contact.php"><i class="fa fa-phone"></i> <?php echo $value['DienThoai'] ?></a></li>
								<li><a href="contact.php"><i class="fa fa-envelope"></i> <?php echo $value['Email'] ?></a></li>
							</ul>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="social-icons pull-right">
							<ul class="nav navbar-nav">
								<li><a href="<?php echo $value['LinkFace'] ?>"><i class="fa fa-facebook"></i></a></li>
								<li><a href="contact.php"><i class="fa fa-skype"></i></a></li>
							</ul>
						</div>
					</div>
				</div>
				<?php endforeach; ?>
			</div>
		</div><!--/header_top-->
		
		<div class="header-middle"><!--header-middle-->
			<div class="container">
				<div class="row">
					<div class="col-md-4 clearfix">
						<div class="logo pull-left">
							<a href="index.php"><img src="<?php echo base_url() ?>public/fontend/images/home/logo.png" alt="" /></a>
						</div>
					</div>
					<div class="col-md-8 clearfix">
						<div class="shop-menu clearfix pull-right shop-menu2">
							<ul class="nav navbar-nav">
								<li><a class="<?php echo isset($open) && $open == 'cart' ? 'active' : '' ?>" href="cart.php"><i class="fa fa-shopping-cart"></i> Giỏ Hàng 
								<?php
	                        		if (isset($_SESSION['cart']))
	                        		{
	                            		$count = count($_SESSION['cart']);
	                            		echo "<span class='badge_red'>$count</span>";
	                        		}
	                        		else
	                        		{
	                            		echo "<span class='badge_red'>0</span>";
	                        		}
                        		?>
								</a></li>
								<?php if(isset($_SESSION['name_user'])): ?>
								<li><a href="" class="name-user">Xin Chào : <?php echo $_SESSION['name_user'] ?></a></li>
								<div class="btn-group pull-right clearfix">
									<div class="btn-group">
									<button type="button" class="btn btn-default dropdown-toggle usa" data-toggle="dropdown">
										Tài Khoản
									<span class="caret"></span>
									</button>
									<ul class="dropdown-menu">
										<li><a href="profile.php?id=<?php echo $_SESSION['name_id'] ?>"><i class="fa fa-user"></i> Hồ sơ</a></li>
										<li><a href="don-hang.php?id=<?php echo $_SESSION['name_id'] ?>"><i class="fa fa-align-justify"></i> Đơn hàng</a></li>
										<li><a href="doi-mat-khau.php?id=<?php echo $_SESSION['name_id'] ?>"><i class="fa fa-unlock"></i> Đổi Mật Khẩu</a></li>
										<hr style="margin: 10px">
										<li><a onClick="return window.confirm('Bạn có chắc muốn đăng xuất không?')" href="thoat.php"><i class="fa fa-sign-out"></i> Đăng Xuất</a></li>
									</ul>
									</div>
								</div>
								<?php else:  ?>
									<li><a class="<?php echo isset($open) && $open == 'login' ? 'active' : '' ?>" href="dang-nhap.php"><i class="fa fa-lock"></i> Đăng Nhập</a></li>
									<li><a class="<?php echo isset($open) && $open == 'resign' ? 'active' : '' ?>" href="dang-ky.php"><i class="fa fa-sign-in"></i> Đăng Ký</a></li> 
								<?php endif; ?>
                            </ul>
                        </div> 	
					</div>
				</div>
			</div>
		</div><!--/header-middle-->
	
		<div class="header-bottom"><!--header-bottom-->
			<div class="container">
				<div class="row">
					<div class="col-sm-8">
						<div class="navbar-header">
							<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
								<span class="sr-only"></span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
							</button>
						</div>
						<div class="mainmenu pull-left">
							<ul class="nav navbar-nav collapse navbar-collapse">
								<li><a href="index.php" class="<?php echo isset($open) && $open == 'index' ? 'active' : '' ?>"><i class="fa fa-home"></i> Trang Chủ</a></li>
								<li class="dropdown"><a class="<?php echo isset($open) && $open == 'sale' || $open == 'cart' ? 'active' : '' ?>" href="">Cửa Hàng<i class="fa fa-angle-down"></i></a>
                                    <ul role="menu" class="sub-menu">
                                        <li><a class="<?php echo isset($open) && $open == 'sale' ? 'active' : '' ?>" href="sale.php">Giảm Giá</a></li>
										<li><a class="<?php echo isset($open) && $open == 'cart' ? 'active' : '' ?>" href="cart.php">Giỏ Hàng</a></li> 
										<li><a class="<?php echo isset($open) && $open == 'allpro' ? 'active' : '' ?>" href="all.php">Tất Cả Sản Phẩm</a></li> 
                                    </ul>
                                </li> 
								<li class="dropdown"><a class="<?php echo isset($open) && $open == 'blog' ? 'active' : '' ?>" href="blog.php"> Blog</a>
                                    <!-- <ul role="menu" class="sub-menu">
                                        <li><a href="blog.html">Blog List</a></li>
										<li><a href="blog-single.html">Blog Single</a></li>
                                    </ul> -->
                                </li> 
								<li><a class="<?php echo isset($open) && $open == 'contact' ? 'active' : '' ?>" href="contact.php">Liên Hệ</a></li>
							</ul>
						</div>
					</div>
					<div class="col-sm-3 col-sm-offset-1">
						<div class="single-widget search_box pull-right">
							<form action="search.php" name="search_box" method="GET">
								<input type="text" placeholder="Tên sản phẩm..." name="search" value="<?php if(isset($search)): echo $search; else: echo ''; endif; ?>" />
								<button type="submit" class="btn btn-success" value="Search" name="query"><i class="fa fa-search"></i></button>
							</form>
						</div>
					</div>
					<!-- <form action="search.php" name="search_box" method="GET">
					<div class="col-sm-3">
						<div class="search_box pull-right">
							<input type="text" placeholder="Tìm Kiếm" name="search"/><input type="submit" class="btn btn-primary"  value="Search"  name="query" style="margin-top: 0px; margin-left: 15px">
						</div>
					</div>
					
					</form> -->
				</div>
			</div>
		</div><!--/header-bottom-->
	</header><!--/header-->
	
	
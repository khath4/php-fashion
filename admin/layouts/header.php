
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Trang Quản Trị</title>
  <!-- Custom fonts for this template-->
  <link href="<?php echo base_url() ?>public/admin/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  
  <!-- Custom styles for this template-->
  <link href="<?php echo base_url() ?>public/admin/css/sb-admin-2.min.css" rel="stylesheet">
  <link href="<?php echo base_url() ?>public/admin/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
  <script src="<?php echo base_url() ?>public/ckeditor/ckeditor.js"></script>
  <script src="<?php echo base_url() ?>public/ckfinder/ckfinder.js"></script>
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  
</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
        <div class="sidebar-brand-icon rotate-n-15">
          <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3"><?php echo $_SESSION['admin_level'] == 2 ? 'ADMIN' : 'CTV' ?></div>
      </a>

      <!-- Divider -->
      <hr class="sidebar-divider my-0">

      <!-- Nav Item - Dashboard -->
      <li class="nav-item <?php echo isset($open) && $open == 'main' ? 'active' : '' ?>">
        <a class="nav-link" href="<?php echo base_url() ?>/admin">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Bảng Điều Khiển</span></a>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider">

      <!-- Heading -->
      <div class="sidebar-heading">
        Chức năng
      </div>

      <!-- Nav Item - Pages Collapse Menu -->
      <li class="nav-item <?php echo isset($open) && $open == 'category' || isset($open) && $open == 'parents_category' || isset($open) && $open == 'brands' ? 'active' : '' ?>">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#category" aria-expanded="true" aria-controls="category">
          <i class="fas fa-fw fa-cog"></i>
          <span>Quản Lý Danh Mục</span>
        </a>
        <div id="category" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item <?php echo isset($open) && $open == 'parents_category' ? 'active' : '' ?>" href="<?php echo modules('parents_category') ?>"><i class="fas fa-bars"></i> Danh Mục Cha</a>
            <a class="collapse-item <?php echo isset($open) && $open == 'category' ? 'active' : '' ?>" href="<?php echo modules('category') ?>"><i class="fas fa-stream"></i> Danh Mục Con</a>
            <a class="collapse-item <?php echo isset($open) && $open == 'brands' ? 'active' : '' ?>" href="<?php echo modules('brands') ?>"><i class="fas fa-trademark"></i> Thương Hiệu</a>
          </div>
        </div>
      </li>
        <!-- 
       <li class="nav-item <?php echo isset($open) && $open == 'parents_category' ? 'active' : '' ?>">
        <a class="nav-link collapsed" href="<?php echo modules('parents_category') ?>">
          <i class="fas fa-list"></i>
          <span>Danh Mục Cha</span>
        </a>
      </li>

      <li class="nav-item <?php echo isset($open) && $open == 'category' ? 'active' : '' ?>">
        <a class="nav-link collapsed" href="<?php echo modules('category') ?>">
          <i class="fas fa-list"></i>
          <span>Danh Mục</span>
        </a>
      </li> -->
       <li class="nav-item <?php echo isset($open) && $open == 'product' || isset($open) && $open == 'size' ? 'active' : '' ?>">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#product" aria-expanded="true" aria-controls="product">
           <i class="fas fa-database"></i>
          <span>Quản Lý Sản Phẩm</span>
        </a>
        <div id="product" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item <?php echo isset($open) && $open == 'size' ? 'active' : '' ?>" href="<?php echo modules('size') ?>"><i class="fas fa-tasks"></i> Quản Lý Size</a>
            <a class="collapse-item <?php echo isset($open) && $open == 'product' ? 'active' : '' ?>" href="<?php echo modules('product') ?>"><i class="fas fa-database"></i> Quản Lý Sản Phẩm</a>
          </div>
        </div>
      </li>

     <!--  <li class="nav-item <?php echo isset($open) && $open == 'product' ? 'active' : '' ?>">
        <a class="nav-link collapsed" href="<?php echo modules('product') ?>">
          <i class="fas fa-database"></i>
          <span>Quản Lý Sản Phẩm</span>
        </a>
      </li> -->

      <!-- Nav Item - Utilities Collapse Menu -->
      <li class="nav-item <?php echo isset($open) && $open == 'transaction' ? 'active' : '' ?>">
        <a class="nav-link collapsed" href="<?php echo modules('transaction') ?>">
          <i class="fas fa-inbox"></i>
          <span>Quản Lý Đơn Hàng</span>
        </a>
      </li>

      <li class="nav-item <?php echo isset($open) && $open == 'blog' ? 'active' : '' ?>">
        <a class="nav-link collapsed" href="<?php echo modules('blog') ?>">
          <i class="fas fa-newspaper"></i>
          <span>Quản Lý Blog</span>
        </a>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider">
      <!-- Heading -->
      <div class="sidebar-heading">
        Thành Viên
      </div>
      <!-- Nav Item - Pages Collapse Menu -->
      <li class="nav-item <?php echo isset($open) && $open == 'admin' ? 'active' : '' ?>">
        <a class="nav-link" href="<?php echo modules('admin') ?>">
          <i class="fas fa-user-tie"></i>
          <span>Quản Lý Admin</span>
        </a>
      </li>

      <!-- Nav Item - Charts -->
      <li class="nav-item <?php echo isset($open) && $open == 'users' ? 'active' : '' ?>">
        <a class="nav-link" href="<?php echo modules('user')?>">
          <i class="fas fa-user"></i>
          <span>Quản Lý User</span></a>
      </li>
      
      <!-- Divider -->
      <hr class="sidebar-divider">
      <!-- Heading -->
      <div class="sidebar-heading">
        Khác
      </div>
       <li class="nav-item <?php echo isset($open) && $open == 'lienhe' ? 'active' : '' ?>">
        <a class="nav-link" href="<?php echo modules('lienhe') ?>">
         <i class="fas fa-phone"></i>
          <span>Quản Lý Liên Hệ</span>
        </a>
      </li>
      <li class="nav-item <?php echo isset($open) && $open == 'banner' ? 'active' : '' ?>">
        <a class="nav-link" href="<?php echo modules('banner') ?>">
          <i class="fas fa-tools"></i>
          <span>Quản Lý Banner</span>
        </a>
      </li>
      <li class="nav-item <?php echo isset($open) && $open == 'adver' ? 'active' : '' ?>">
        <a class="nav-link" href="<?php echo modules('adver') ?>">
          <i class="fas fa-ad"></i>
          <span>Quản Lý Quảng Cáo</span>
        </a>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider d-none d-md-block">

      <!-- Sidebar Toggler (Sidebar) -->
      <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
      </div>

    </ul>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">
       <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

          <!-- Sidebar Toggle (Topbar) -->
          <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
            <i class="fa fa-bars"></i>
          </button>

          <!-- Topbar Search -->
          <?php if(isset($open) && $open == 'product'): ?>
            <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search" method="GET" name="search_box" action="<?php echo modules('product').'/search.php'?>">
              <div class="input-group">
                <input type="text" class="form-control bg-light border-0 small" placeholder="Tên sản phẩm..." name="search" aria-label="Search" aria-describedby="basic-addon2">
                <div class="input-group-append">
                  <button class="btn btn-primary" type="button">
                    <i class="fas fa-search fa-sm"></i>
                  </button>
                </div>
              </div>
            </form>
          <?php else: ?>
            <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search" method="GET" name="search_box" action="<?php echo modules('transaction').'/search.php'?>">
              <div class="input-group">
                <input type="text" class="form-control bg-light border-0 small" placeholder="Mã đơn hàng..."  name="search" aria-label="Search" aria-describedby="basic-addon2">
                <div class="input-group-append">
                  <button class="btn btn-primary" type="button">
                    <i class="fas fa-search fa-sm"></i>
                  </button>
                </div>
              </div>
            </form>
          <?php endif; ?>

          <!-- Topbar Navbar -->
          <ul class="navbar-nav ml-auto">

            <!-- Nav Item - Search Dropdown (Visible Only XS) -->
            <li class="nav-item dropdown no-arrow d-sm-none">
              <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-search fa-fw"></i>
              </a>
              <!-- Dropdown - Messages -->
              <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
                <form class="form-inline mr-auto w-100 navbar-search">
                  <div class="input-group">
                    <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                    <div class="input-group-append">
                      <button class="btn btn-primary" type="button">
                        <i class="fas fa-search fa-sm"></i>
                      </button>
                    </div>
                  </div>
                </form>
              </div>
            </li>
                        <!-- Nav Item - Alerts -->
            <!--<li class="nav-item dropdown no-arrow mx-1">-->
            <!--  <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">-->
            <!--    <i class="fas fa-bell fa-fw"></i>-->
                <!-- Counter - Alerts -->
            <!--    <span class="badge badge-danger badge-counter">3+</span>-->
            <!--  </a>-->
              <!-- Dropdown - Alerts -->
            <!--  <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown">-->
            <!--    <h6 class="dropdown-header">-->
            <!--      Alerts Center-->
            <!--    </h6>-->
            <!--    <a class="dropdown-item d-flex align-items-center" href="#">-->
            <!--      <div class="mr-3">-->
            <!--        <div class="icon-circle bg-primary">-->
            <!--          <i class="fas fa-file-alt text-white"></i>-->
            <!--        </div>-->
            <!--      </div>-->
            <!--      <div>-->
            <!--        <div class="small text-gray-500">December 12, 2019</div>-->
            <!--        <span class="font-weight-bold">A new monthly report is ready to download!</span>-->
            <!--      </div>-->
            <!--    </a>-->
            <!--    <a class="dropdown-item d-flex align-items-center" href="#">-->
            <!--      <div class="mr-3">-->
            <!--        <div class="icon-circle bg-success">-->
            <!--          <i class="fas fa-donate text-white"></i>-->
            <!--        </div>-->
            <!--      </div>-->
            <!--      <div>-->
            <!--        <div class="small text-gray-500">December 7, 2019</div>-->
            <!--        $290.29 has been deposited into your account!-->
            <!--      </div>-->
            <!--    </a>-->
            <!--    <a class="dropdown-item d-flex align-items-center" href="#">-->
            <!--      <div class="mr-3">-->
            <!--        <div class="icon-circle bg-warning">-->
            <!--          <i class="fas fa-exclamation-triangle text-white"></i>-->
            <!--        </div>-->
            <!--      </div>-->
            <!--      <div>-->
            <!--        <div class="small text-gray-500">December 2, 2019</div>-->
            <!--        Spending Alert: We've noticed unusually high spending for your account.-->
            <!--      </div>-->
            <!--    </a>-->
            <!--    <a class="dropdown-item text-center small text-gray-500" href="#">Show All Alerts</a>-->
            <!--  </div>-->
            <!--</li>-->

            <!-- Nav Item - Messages -->
            <!--<li class="nav-item dropdown no-arrow mx-1">-->
            <!--  <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">-->
            <!--    <i class="fas fa-envelope fa-fw"></i>-->
                <!-- Counter - Messages -->
            <!--    <span class="badge badge-danger badge-counter">7</span>-->
            <!--  </a>-->
              <!-- Dropdown - Messages -->
            <!--  <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="messagesDropdown">-->
            <!--    <h6 class="dropdown-header">-->
            <!--      Message Center-->
            <!--    </h6>-->
            <!--    <a class="dropdown-item d-flex align-items-center" href="#">-->
            <!--      <div class="dropdown-list-image mr-3">-->
            <!--        <img class="rounded-circle" src="https://source.unsplash.com/fn_BT9fwg_E/60x60" alt="">-->
            <!--        <div class="status-indicator bg-success"></div>-->
            <!--      </div>-->
            <!--      <div class="font-weight-bold">-->
            <!--        <div class="text-truncate">Hi there! I am wondering if you can help me with a problem I've been having.</div>-->
            <!--        <div class="small text-gray-500">Emily Fowler · 58m</div>-->
            <!--      </div>-->
            <!--    </a>-->
            <!--    <a class="dropdown-item d-flex align-items-center" href="#">-->
            <!--      <div class="dropdown-list-image mr-3">-->
            <!--        <img class="rounded-circle" src="https://source.unsplash.com/AU4VPcFN4LE/60x60" alt="">-->
            <!--        <div class="status-indicator"></div>-->
            <!--      </div>-->
            <!--      <div>-->
            <!--        <div class="text-truncate">I have the photos that you ordered last month, how would you like them sent to you?</div>-->
            <!--        <div class="small text-gray-500">Jae Chun · 1d</div>-->
            <!--      </div>-->
            <!--    </a>-->
            <!--    <a class="dropdown-item d-flex align-items-center" href="#">-->
            <!--      <div class="dropdown-list-image mr-3">-->
            <!--        <img class="rounded-circle" src="https://source.unsplash.com/CS2uCrpNzJY/60x60" alt="">-->
            <!--        <div class="status-indicator bg-warning"></div>-->
            <!--      </div>-->
            <!--      <div>-->
            <!--        <div class="text-truncate">Last month's report looks great, I am very happy with the progress so far, keep up the good work!</div>-->
            <!--        <div class="small text-gray-500">Morgan Alvarez · 2d</div>-->
            <!--      </div>-->
            <!--    </a>-->
            <!--    <a class="dropdown-item d-flex align-items-center" href="#">-->
            <!--      <div class="dropdown-list-image mr-3">-->
            <!--        <img class="rounded-circle" src="https://source.unsplash.com/Mv9hjnEUHR4/60x60" alt="">-->
            <!--        <div class="status-indicator bg-success"></div>-->
            <!--      </div>-->
            <!--      <div>-->
            <!--        <div class="text-truncate">Am I a good boy? The reason I ask is because someone told me that people say this to all dogs, even if they aren't good...</div>-->
            <!--        <div class="small text-gray-500">Chicken the Dog · 2w</div>-->
            <!--      </div>-->
            <!--    </a>-->
            <!--    <a class="dropdown-item text-center small text-gray-500" href="#">Read More Messages</a>-->
            <!--  </div>-->
            <!--</li>-->

            <div class="topbar-divider d-none d-sm-block"></div>
            <!-- Nav Item - User Information -->
            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small name-user"><?php echo $_SESSION['name_admin'] ?></span>
                <?php $checkadmin = $db -> fetchID("admin" ,$_SESSION['admin_id']); ?>
                <?php if($checkadmin['AnhDD'] == NULL): ?>
                  <img class="img-profile rounded-circle" src="<?php echo uploads() ?>admin/avatar-default.png" alt="">
                <?php else: ?>  
                  <img class="img-profile rounded-circle" src="<?php echo uploads() ?>admin/<?php echo $checkadmin['AnhDD'] ?>"alt="">
                <?php endif; ?>
              </a>
              <!-- Dropdown - User Information -->
              <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="<?php echo modules('admin').'/profile.php?id='?><?php echo $_SESSION['admin_id'] ?>">
                  <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                  Hồ sơ
                </a>
                <a class="dropdown-item" href="<?php echo modules('admin').'/doi-password.php?id='?><?php echo $_SESSION['admin_id'] ?>">
                  <i class="fa fa-unlock fa-sm fa-fw mr-2 text-gray-400"></i>
                  Đổi Mật Khẩu
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="/WebThoiTrang/login/logout.php" data-toggle="modal" data-target="#logoutModal">
                  <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                 Đăng Xuất
                </a>
              </div>
            </li>
          </ul>
        </nav>
        <!-- End of Topbar -->

      
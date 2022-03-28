<?php 
    $open = "main";
    require_once __DIR__. "/autoload/autoload.php";
    date_default_timezone_set('Asia/Ho_Chi_Minh');
    //$month = date("m");
    //$year = date("Y");
    $sqltongdh = "SELECT id FROM don_hang";
    $tongdh= count( $db -> fetchsql($sqltongdh));
    
    $sqlyear = "SELECT SUM(TongDH) as datayear ,EXTRACT(YEAR FROM Created_at) as year FROM don_hang WHERE TrangThai = 3 AND TrangThaiTT = 0 GROUP BY EXTRACT(YEAR FROM Created_at)";
    $yeardata = $db -> fetchsql($sqlyear);
    
    $sqlyearonline = "SELECT SUM(TongDH) as datayear ,EXTRACT(YEAR FROM Created_at) as year FROM don_hang WHERE TrangThaiTT = 2 GROUP BY EXTRACT(YEAR FROM Created_at)";
    $yeardataonline = $db -> fetchsql($sqlyearonline);
    
    $sqldhcxl = "SELECT COUNT(TrangThai) as dhcxl ,TrangThai FROM don_hang WHERE TrangThai = 0 AND HuyDon = 0 ";
    $dhcxl = $db -> fetchsql($sqldhcxl);
    
    $sqldhdxl = "SELECT COUNT(TrangThai) as dhdxl,TrangThai FROM don_hang WHERE TrangThai = 1 AND HuyDon = 0 ";
    $dhdxl = $db -> fetchsql($sqldhdxl);
    
    $sqldhdvc = "SELECT COUNT(TrangThai) as dhdvc,TrangThai FROM don_hang WHERE TrangThai = 2 AND HuyDon = 0 ";
    $dhdvc = $db -> fetchsql($sqldhdvc);
    
    $sqldhht = "SELECT COUNT(TrangThai) as dhht,TrangThai FROM don_hang WHERE TrangThai = 3 AND HuyDon = 0 ";
    $dhht = $db -> fetchsql($sqldhht);
    
    $sqlhd = "SELECT COUNT(TrangThai) as dhht,HuyDon FROM don_hang WHERE HuyDon = 1 ";
    $hd = $db -> fetchsql($sqlhd);
    
    $sqlproducthot = "SELECT EXTRACT(YEAR FROM Created_at) as proyear FROM chi_tiet_dh GROUP BY EXTRACT(YEAR FROM Created_at)";
    $producthot = $db -> fetchsql($sqlproducthot);
    
?>
<?php require_once __DIR__. "/layouts/header.php";  ?>        
        <!-- Begin Page Content -->
    <div class="container-fluid">
          <!-- Page Heading -->
        <h1 class="h1 mb-4 text-gray-800 text-center">BẢNG ĐIỀU KHIỂN</h1>  
            <h5 class="text-primary">THU NHẬP (THANH TOÁN THƯỜNG)</h5>
            <div class="row">

            <?php foreach ($yeardata as $item): ?>
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-success text-uppercase mb-1"><a href="month.php?year=<?php echo $item['year'] ?>">THU NHẬP (NĂM <?php echo $item['year'] ?>)</a></div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo formatPrice($item['datayear']) ?></div>
                    </div>
                    <div class="col-auto">
                       <i class="fas fa-dollar-sign fa-2x text-success"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <?php endforeach; ?>
          </div>
          
        <h5 class="text-primary">THU NHẬP (THANH TOÁN ONLINE)</h5>
        <div class="row">
            <?php foreach ($yeardataonline as $item): ?>
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-success text-uppercase mb-1"><a href="month-online.php?year=<?php echo $item['year'] ?>">THU NHẬP (NĂM <?php echo $item['year'] ?>)</a></div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo formatPrice($item['datayear']) ?></div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-dollar-sign fa-2x text-success"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <?php endforeach; ?>
   
          </div>
          
        <h5 class="text-primary">TỔNG ĐƠN HÀNG (<?php echo $tongdh ?>)</h5>
        <div class="row">
            <?php foreach ($dhcxl as $item): ?>
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-info text-uppercase mb-1"><a href="<?php echo modules('transaction').'/don-hang.php?status='.$item['TrangThai'].''?>">ĐƠN HÀNG CHỜ XỬ LÝ</a></div>
                      <div class="row no-gutters align-items-center">
                        <div class="col-auto">
                          <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $item['dhcxl'].'/'.$tongdh ?></div>
                        </div>
                      </div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-clipboard-list fa-2x text-info"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <?php endforeach; ?>
            
            <?php foreach ($dhdxl as $item): ?>
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-info text-uppercase mb-1"><a href="<?php echo modules('transaction').'/don-hang.php?status='.$item['TrangThai'].''?>">ĐƠN HÀNG ĐÃ XỬ LÝ</a></div>
                      <div class="row no-gutters align-items-center">
                        <div class="col-auto">
                          <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $item['dhdxl'].'/'.$tongdh ?></div>
                        </div>
                      </div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-clipboard-list fa-2x text-info"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <?php endforeach; ?>
            
            <?php foreach ($dhdvc as $item): ?>
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-info text-uppercase mb-1"><a href="<?php echo modules('transaction').'/don-hang.php?status='.$item['TrangThai'].''?>">ĐƠN HÀNG ĐANG VẬN CHUYỂN</a></div>
                      <div class="row no-gutters align-items-center">
                        <div class="col-auto">
                          <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $item['dhdvc'].'/'.$tongdh ?></div>
                        </div>
                      </div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-clipboard-list fa-2x text-info"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <?php endforeach; ?>
            
            <?php foreach ($dhht as $item): ?>
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-info text-uppercase mb-1"><a href="<?php echo modules('transaction').'/don-hang.php?status='.$item['TrangThai'].''?>">ĐƠN HÀNG HOÀN THÀNH</a></div>
                      <div class="row no-gutters align-items-center">
                        <div class="col-auto">
                          <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $item['dhht'].'/'.$tongdh ?></div>
                        </div>
                      </div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-clipboard-list fa-2x text-info"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <?php endforeach; ?>
            
            <?php foreach ($hd as $item): ?>
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-info text-uppercase mb-1"><a href="<?php echo modules('transaction').'/show-huy-don.php?status='.$item['HuyDon'].''?>">ĐƠN HÀNG BỊ HỦY</a></div>
                      <div class="row no-gutters align-items-center">
                        <div class="col-auto">
                          <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $item['dhht'].'/'.$tongdh ?></div>
                        </div>
                      </div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-clipboard-list fa-2x text-info"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <?php endforeach; ?>
          </div>
         
        <h5 class="text-primary">Sản Phẩm HOT</h5>
        <div class="row">
            <?php foreach($producthot as $item): ?>
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-danger text-uppercase mb-1"> <div class="text-xs font-weight-bold text-info text-uppercase mb-1"></div>HOT NĂM <?php echo $item['proyear'] ?> (10)</div>
                        <?php 
                            $hash_code_year = base64_encode($item['proyear']);
                            $hash_code_quy1 = base64_encode(2);
                            $hash_code_quy2 = base64_encode(5);
                            $hash_code_quy3 = base64_encode(8);
                            $hash_code_quy4 = base64_encode(11);
                        ?>
                        <div class="mb-0 font-weight-bold text-gray"><a href="<?php echo modules('product').'/hot-quy.php?year='.$hash_code_year.'&month='.$hash_code_quy1.'' ?>">Quý 1 - Năm <?php echo $item['proyear'] ?></a></div>
                        <div class="mb-0 font-weight-bold text-gray"><a href="<?php echo modules('product').'/hot-quy.php?year='.$hash_code_year.'&month='.$hash_code_quy2.'' ?>">Quý 2 - Năm <?php echo $item['proyear'] ?></a></div>
                        <div class="mb-0 font-weight-bold text-gray"><a href="<?php echo modules('product').'/hot-quy.php?year='.$hash_code_year.'&month='.$hash_code_quy3.'' ?>">Quý 3 - Năm <?php echo $item['proyear'] ?></a></div>
                        <div class="mb-0 font-weight-bold text-gray"><a href="<?php echo modules('product').'/hot-quy.php?year='.$hash_code_year.'&month='.$hash_code_quy4.'' ?>">Quý 4 - Năm <?php echo $item['proyear'] ?></a></div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-fire fa-2x text-danger"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
             <?php endforeach; ?>
        </div>
       </div>
      </div>
<?php require_once __DIR__. "/layouts/footer.php";  ?>

<?php if(isset($_SESSION['loginsuccess'])) :?>
      <script>
            swal({
              title: "Thông Báo!",
              text: "Đăng nhập thành công.",
              icon: "success",
            });
      </script>
      <?php unset($_SESSION['loginsuccess']); ?>
      <!-- <div class="alert alert-success"><i class="fa fa-check"></i>
      <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
      </div> -->
<?php endif; ?>

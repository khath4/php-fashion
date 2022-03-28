<?php 
    $open = "main";
    require_once __DIR__. "/autoload/autoload.php";
    date_default_timezone_set('Asia/Ho_Chi_Minh');
    //$month = date("m");
    //$year = date("Y");
    $year = intval(getInput('year'));
    $sqlmonth = "SELECT SUM(TongDH) as datamonth ,EXTRACT(MONTH FROM Created_at) as month FROM don_hang WHERE EXTRACT(YEAR FROM Created_at) = $year AND TrangThaiTT =2 GROUP BY EXTRACT(MONTH FROM Created_at)";
    $monthdata = $db -> fetchsql($sqlmonth);
?>
<?php require_once __DIR__. "/layouts/header.php";  ?>        
        <!-- Begin Page Content -->
        <div class="container-fluid">
          <div class="row">
            <div class="col-lg-12">
                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo base_url(). 'admin/index.php'?>"><i class="fas fa-fw fa-tachometer-alt"></i>Bảng Điều Khiển</a></li>
                    <li class="breadcrumb-item">Thu Nhập Năm <?php echo $year ?> (Thanh Toán Online)</li>
                  </ol>
                </nav>
            </div>
        </div>

        <div class="row">
            
            <?php foreach ($monthdata as $item): ?>
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-primary text-uppercase mb-1"><a href="<?php echo modules('transaction').'/detail-month-online.php?year='.$year.'&month='.$item['month'].''?>">THU NHẬP (THÁNG <?php echo $item['month'] ?>)</a>
                      </div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo formatPrice($item['datamonth']) ?></div>
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
        </div>
        
        <!-- /.container-fluid -->
      </div>
      <!-- End of Main Content -->
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

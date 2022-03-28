<?php 

    $open ="blog";
    require_once __DIR__. "/../../autoload/autoload.php"; 

    $id = intval(getInput('id'));

    $sqlblog = "SELECT blog.*,admin.HoTen FROM blog,admin WHERE blog.Created_by = admin.id AND blog.id = $id";
    $Blog= $db-> fetchsql	($sqlblog);

    if(empty($Blog))
    {
      $_SESSION['error'] = "Dữ liệu không tồn tại.";
      redirectAdmin('blog');
    }
?>
<?php require_once __DIR__. "/../../layouts/header.php"; ?>        
  <div class="row">
    <div class="col-lg-12">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?php echo base_url() ?>/admin"><i class="fas fa-fw fa-tachometer-alt"></i>Bảng Điều Khiển</a></li>
          <li class="breadcrumb-item"><a href="<?php echo modules('blog') ?>">Quản Lý Blog</a></li>
          <li class="breadcrumb-item active" aria-current="page">Xem Chi Tiết</li>
        </ol>
      </nav>
      	<div class="clearfix">
         <!--  Notification -->
        <?php require_once __DIR__. "/../../../partials/notification.php"; ?>
      </div>
    </div>
  </div>
    <!-- Begin Page Content -->
	    <div class="container-fluid">
	      <div class="row">
	        <div class="col-md-12">
	        	<?php foreach ($Blog as $value): ?>
		        	<blockquote class="blockquote text-center">
					  <p class="mb-0"><h3 class="text-danger"><?php echo $value['TieuDe'] ?></h3></p>
					  <footer class="blockquote-footer"><?php echo $value['TomTat'] ?><cite title="Source Title"></cite></footer>
					</blockquote>
		           	<p class="text-center"><img src="<?php echo uploads() ?>blog/<?php echo $value['Hinh'] ?>" alt=""></p>
		           	<p><?php echo $value['NoiDung']; ?></p>
		           	 <div class="text-right">
                      <p><i class="text-capitalize"><?php echo $value['TieuDe'] ?> / <?php echo $value['HoTen'] ?> / <?php echo date('H:i d-m-Y' ,strtotime($value['Created_at'])) ?>/<span class="align-middle"> <i class="fas fa-eye"></i></span> <?php echo $value['LuotXem'] ?></i></p>
                	</div>
	           <?php endforeach; ?>
        	</div>
      	</div>
      	<a href="<?php echo modules('blog') ?>" class="btn btn-primary btn-sm"><i class="fas fa-angle-double-left"></i></a>
    </div>

    <!-- /.container-fluid -->
    </div>
    <!-- End of Main Content -->

<?php require_once __DIR__. "/../../layouts/footer.php";  ?>
<?php
  $open ="blog";
  require_once __DIR__. "/autoload/autoload.php";
  
  $pagesize = 3;

  $pagenumber = isset($_GET['page']) ? $_GET['page'] :"1";

  $sqlblog ="SELECT blog.*,admin.HoTen FROM blog,admin WHERE blog.Created_by = admin.id ORDER BY id DESC LIMIT " .($pagenumber - 1) * $pagesize." , $pagesize";
   
  $sqlblogtotal ="SELECT blog.*,admin.HoTen FROM blog,admin WHERE blog.Created_by = admin.id ORDER BY id DESC";

  $total = count($db-> fetchsql($sqlblogtotal));

  $blog = $db -> fetchsql($sqlblog);

  $totalpage = ceil($total/$pagesize);
?>


<?php require_once __DIR__. "/layouts/header.php";  ?>	
<?php require_once __DIR__. "/layouts/nav.php";  ?>  
        <div class="col-sm-9">
          <div class="blog-post-area">
            <h2 class="title text-center">Danh Sách Blog</h2>
            <?php foreach ($blog as $value): ?>
              <div class="single-blog-post">
                <h3> <?php echo $value['TieuDe'] ?></h3>
                <div class="post-meta">
                  <ul>
                    <li><i class="fa fa-user"></i> <?php echo $value['HoTen'] ?></li>
                    <li><i class="fa fa-clock-o"></i> <?php echo date("H:i", strtotime($value['Created_at'])) ?></li>
                    <li><i class="fa fa-calendar"></i> <?php echo date("d-m-Y", strtotime($value['Created_at'])) ?></li>
                  </ul>
                  <span>
                      <i class="fa fa-star"></i>
                      <i class="fa fa-star"></i>
                      <i class="fa fa-star"></i>
                      <i class="fa fa-star"></i>
                      <i class="fa fa-star-half-o"></i>
                  </span>
                </div>
                <a href="details-blog.php?id=<?php echo $value['id'] ?>">
                  <img src="<?php echo uploads() ?>blog/<?php echo $value['Hinh'] ?>" alt="">
                </a>
                <p><?php echo $value['TomTat'] ?></p>
                <a  class="btn btn-primary" href="details-blog.php?id=<?php echo $value['id'] ?>">Xem Thêm</a>
              </div>
            <?php endforeach; ?>
            <div class="text-right">
              <nav aria-label="Page navigation example">
              <ul class="pagination">
                  <li class="page-item <?php if($pagenumber == 1) echo 'disabled' ?>">
                    <?php if($pagenumber != 1): ?>
                      <a class="page-link" href="?page=<?php if($pagenumber ==1)echo $pagenumber; else echo $pagenumber - 1 ?>"><?php if($totalpage >= 2) echo "Previous"; ?></a>
                    <?php endif; ?>
                  </li>
                  <?php if($totalpage > 1): ?>
                    <?php for($i =1 ; $i <= $totalpage ; $i++): ?>
                        <?php if(abs($pagenumber - $i <= 2)): ?>
                            <li class="page-item <?php if($pagenumber == $i) echo 'active' ?>"><a class="page-link" href="?page=<?php echo $i ?>"><?php echo $i ?></a></li>
                         <?php endif; ?>
                    <?php endfor; ?>
                  <?php endif; ?>
                  <li class="page-item <?php if($pagenumber == $totalpage)  echo 'disabled' ?>">
                    <?php  if($pagenumber != $totalpage && $totalpage >=2): ?>
                      <a class="page-link" href="?page=<?php if($pagenumber != $totalpage) echo $pagenumber + 1; else echo $pagenumber ?>"><?php if($totalpage >= 2 ) echo "Next";  ?></a>
                    <?php endif; ?>
                  </li>
              </ul>
            </nav> 
          </div>
          </div>
        </div>
      </div>
    </div>
  </section>
	
<?php require_once __DIR__. "/layouts/footer.php";  ?>	

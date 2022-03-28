<?php
  $open ="blog";
  require_once __DIR__. "/autoload/autoload.php";
  $id = intval(getInput('id'));

  $sqlblog ="SELECT blog.*,admin.HoTen FROM blog,admin WHERE blog.Created_by = admin.id and blog.id= $id ";

  $blog = $db -> fetchsql($sqlblog);
  if($blog > 0) {
      $item = $db -> fetchID("blog" ,$id);
      $update = $db-> update("blog", array("LuotXem" => $item['LuotXem']+1),array("id" => $id ));
    }

?>


<?php require_once __DIR__. "/layouts/header.php";  ?>	
<?php require_once __DIR__. "/layouts/nav.php";  ?>  
          <div class="col-sm-9">
          <div class="blog-post-area">
            <h2 class="title text-center">Chi Tiết Blog</h2>
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
              <a><img src="<?php echo uploads() ?>blog/<?php echo $value['Hinh'] ?>" alt=""></a>
              <div class="quote-wrapper">
                  <div class="quotes"><?php echo $value['TomTat'] ?></div>
              </div>
              <p><?php echo $value['NoiDung'] ?></p>
            </div>
            <div class="pager-area">
                <ul class="pager pull-left">
                  <li><a href="blog.php"><i class="fa fa-angle-double-left"></i></a></li>
                </ul>
              </div>
          <?php endforeach; ?>
          </div>
        </div>  
      </div>
    </div>
  </section>
	
<?php require_once __DIR__. "/layouts/footer.php";  ?>	

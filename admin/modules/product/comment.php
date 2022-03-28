<?php 
    $open = "product";
    require_once __DIR__. "/../../autoload/autoload.php"; 	
    $id = intval(getInput('id'));	

    $product= $db -> fetchID("san_pham" , $id);

    if($product['id'] != $id) 
    {
    	$_SESSION['errordata']="";
    	redirectAdmin('product');
    }
    $pagesize = 10;

    $pagenumber = isset($_GET['page']) ? $_GET['page'] :"1";
    
    $sqlcomment ="SELECT binhluan.*,users.HoTen as HoTen FROM users,binhluan WHERE binhluan.id_User = users.id AND binhluan.TrangThai =1 AND id_SanPham = $id ORDER BY binhluan.id DESC LIMIT " .($pagenumber - 1) * $pagesize." , $pagesize";
    $sqltotal ="SELECT binhluan.*,users.HoTen as HoTen FROM users,binhluan WHERE binhluan.id_User = users.id AND binhluan.TrangThai =1 AND id_SanPham = $id ORDER BY binhluan.id DESC";

    $total = count($db-> fetchsql($sqltotal));

    $comment = $db -> fetchsql($sqlcomment);

    $totalpage = ceil($total/$pagesize);

  	if($_SERVER["REQUEST_METHOD"] == "POST")
  	{
  		// $commentID = postInput('commentID');
  		$NoiDung = postInput('NoiDung');
  		$commentID = postInput('commentID');
  		$admin_id = $_SESSION['admin_id'];
  		$data = [
	      "NoiDung" => $NoiDung,
	      "id_BinhLuan" => $commentID,
	      "id_Admin" => $admin_id
	      ];
      	$error=[];
      	if(postInput('NoiDung') == '') 
    		{
    			$error['NoiDung']=""; 
    		}
    		if(postInput('commentID') == '') 
    		{
    			$error['commentID']=""; 
    		}
    		if(empty($error)) 
        	{
    			$id_insert =$db -> insert("traloibl" , $data);
    			if($id_insert){
    				$_SESSION['replysuccess']="";
    			}
    			else
      	  		{
      	  			$_SESSION['replyerror']="";
      	  		}
    		}	
  	 }
?>
<?php require_once __DIR__. "/../../layouts/header.php";  ?>        
    <!-- Begin Page Content -->
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="row">
        <div class="col-lg-12">
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo base_url(). 'admin/index.php'?>"><i class="fas fa-fw fa-tachometer-alt"></i>Bảng Điều Khiển</a></li>
                <li class="breadcrumb-item"><a href="<?php echo modules('product') ?>">Quản Lý Sản Phẩm</a></li>
                <li class="breadcrumb-item">Bình Luận</li>
              </ol>
            </nav>
            <div class="clearfix">
           <!--  Notification -->
            <?php require_once __DIR__. "/../../../partials/notification.php"; ?>
            </div>
        </div>
        </div>
    </div>
        <div class="container-fluid">
    <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Danh Sách Bình Luận</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <div class="col-sm-12 comment_box">
            				<h5 class="count_comment text-danger"><b><?php echo $total ?> Bình Luận</b></h5>
            				<?php foreach ($comment as $value): ?>
					        <div class="comment">
					            <div>
					            	<b class="name-user"><?php echo $value['HoTen'] ?> </b><small class="timecomment"><?php echo date("H:i m-d-Y", strtotime($value['created_at'])) ?> </small> 
					            	<p><?php echo $value['NoiDung'] ?></p>
					            </div>
					            <?php 
                     				$sqlreply = "SELECT traloibl.*,traloibl.id_admin as id_admin,admin.HoTen as HoTen,admin.CapBat as CapBat,traloibl.Created_at as created_at FROM traloibl,admin WHERE traloibl.id_admin= admin.id AND id_BinhLuan = ".$value['id'] ." ORDER BY traloibl.Created_at";
                     				$reply = $db -> fetchsql($sqlreply);
                 				 ?>
                 				<div class="replies">
                 					
                 					<a href="hide.php?id=<?php echo $value['id'] ?>" onClick="return window.confirm('Bạn có chắc muốn xóa đánh giá này không?')" class="btn btn-danger btn-sm"> Xóa</a>
                 					<a href="javascript:void(0)" data-commentID="<?php echo $value['id'] ?>" onclick="reply(this)" class="btn btn-primary btn-sm">Trả Lời</a>
                 				</div>
					            <div class="reply">
					                <?php foreach ($reply as $value): ?>
				                     	<div class="reply_user">
					                        <div>
					                           <?php if($_SESSION['admin_id'] == $value['id_admin']): ?>
					                                <i>Bạn đã trả lời </i>
					                           <?php endif; ?>
					                           <?php if($value['CapBat'] == 2): ?>
					                           
					                           <b class="admin"><?php echo $value['HoTen'] ?>
					                              <i class="fa fa-check"></i>
					                           </b>
					                           <?php else: ?>
					                              <b class="ctv"><?php echo $value['HoTen'] ?>
					                              <i class="fa fa-check"></i>
					                           </b>
					                           <?php endif; ?>
					                           <small class="time_reply"> <?php echo date("H:i m-d-Y", strtotime($value['created_at'])) ?></small>
					                        </div>
				                        <div class="admin_reply"><?php echo $value['NoiDung'] ?></div>
				                        <?php if($_SESSION['admin_level'] >= 2 || $value['id_admin'] == $_SESSION['admin_id'] ): ?>
				                        	<a href="delete_reply.php?id=<?php echo $value['id'] ?>" onClick="return window.confirm('Bạn có chắc muốn xóa phản hồi này không?')" class="btn btn-danger btn-sm"> Xóa</a>
				                    	<?php endif; ?>
				                     	</div>
                  					<?php endforeach; ?>
					            </div>
					            
					        </div>
					        <?php endforeach; ?>
					        <div class="replyRow" style="display: none;" id="reviews">
					            <form action="" method="POST">
					                <textarea id="NoiDung" placeholder="Viết phản hồi về đánh giá..." required=""></textarea>
					                <button type="button" name="close" class="btn btn-danger btn-sm pull-right" onclick="$('.replyRow').hide();" >Đóng</button>
					                <button type="submit" name="reply" id="reply" class="btn btn-primary btn-sm pull-right" >OK</button>
					            </form>
					        </div>
					    </div> 
                    </div>
                </div>
            </div>
            <div class="text-center">
      		<nav aria-label="Page navigation example">
        		<ul class="pagination">
		          	<li class="page-item <?php if($pagenumber == 1) echo 'disabled' ?>">
		          		<?php if($pagenumber != 1): ?>
		            		<a class="page-link" href="?id=<?php echo $id ?>&page=<?php if($pagenumber ==1)echo $pagenumber; else echo $pagenumber - 1 ?>"><?php if($totalpage >= 2) echo "Previous"; ?></a>
		            	<?php endif; ?>
		          	</li>
          			<?php if($totalpage > 1): ?>
            			<?php for($i =1 ; $i <= $totalpage ; $i++): ?>
               				<?php if(abs($pagenumber - $i <= 2)): ?>
                  				<li class="page-item <?php if($pagenumber == $i) echo 'active' ?>"><a class="page-link" href="?id=<?php echo $id ?>&page=<?php echo $i ?>"><?php echo $i ?></a></li>
              				 <?php endif; ?>
            			<?php endfor; ?>
         			<?php endif; ?>
          			<li class="page-item <?php if($pagenumber == $totalpage)  echo 'disabled' ?>">
          				<?php  if($pagenumber != $totalpage && $totalpage >=2): ?>
           			 		<a class="page-link" href="?id=<?php echo $id ?>&page=<?php if($pagenumber != $totalpage) echo $pagenumber + 1; else echo $pagenumber ?>"><?php if($totalpage >= 2 ) echo "Next";  ?></a>
           			 	<?php endif; ?>
          			</li>
        		</ul>
      		</nav> 
    	</div>
    </div>

        
<!-- /.container-fluid -->
<?php require_once __DIR__. "/../..//layouts/footer.php";  ?>

<script>
	var commentID = 0;
	$(document).ready(function() {
		$("#reply").on('click' ,function (){
			var NoiDung = $("#NoiDung").val();
			$.ajax({
				url: 'comment.php',
				method: 'POST',
				dataType: 'text',
				data: {
					NoiDung : NoiDung,
					commentID: commentID
				},
                success:function(data)
                {
                   $('replyRow').parent().next().append(response);
                }
			});
		});
	});
	
	function reply(caller){
		commentID = $(caller).attr('data-commentID');
		$(".replyRow").insertAfter($(caller));
		$(".replyRow").show();
	}
</script>

<?php if(isset($_SESSION['replyerror'])) :?>
      <script>
            swal("Thông Báo!", "Phản hồi không thành công.");
      </script>
      <?php unset($_SESSION['replyerror']); ?>
<?php endif; ?>

<?php if(isset($_SESSION['empty'])) :?>
      <script>
            swal("Thông Báo!", "Không có dữ liệu.");
      </script>
      <?php unset($_SESSION['empty']); ?>
<?php endif; ?>

<?php if(isset($_SESSION['replysuccess'])) :?>
      <script>
            swal({
              title: "Thông Báo!",
              text: "Phản hồi thành công.",
              icon: "success",
            });
      </script>
      <?php unset($_SESSION['replysuccess']); ?>
<?php endif; ?>

<?php if(isset($_SESSION['hide'])) :?>
      <script>
            swal({
              title: "Thông Báo!",
              text: "Xóa bình luận thành công.",
              icon: "success",
            });
      </script>
      <?php unset($_SESSION['hide']); ?>
<?php endif; ?>

<?php if(isset($_SESSION['undelete'])) :?>
      <script>
            swal("Thông Báo!", "Bạn không thể xóa câu trả lời của quản trị viên khác.");
      </script>
      <?php unset($_SESSION['undelete']); ?>
<?php endif; ?>



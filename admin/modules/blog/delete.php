<?php 
 	$open ="blog";
  	require_once __DIR__. "/../../autoload/autoload.php"; 

  	$id = intval(getInput('id'));
    if(isset($_SESSION['admin_id']))
    {
      	$dateleblog= $db-> fetchID("blog" ,$id);
       
        $num =$db ->delete("blog" ,$id);
        if($num > 0)
        {
            $_SESSION['success'] = "Xóa thành công.";
            redirectAdmin('blog');
        }
        else 
        {
            $_SESSION['error'] = "Xóa không thành công.";
            redirectAdmin('blog');
        }
      
      	if(empty($dateleblog))
      	{
      		$_SESSION['error'] = "Dữ liệu không tồn tại.";
      		redirectAdmin('blog');
      	}
    }
?>s
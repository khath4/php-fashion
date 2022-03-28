<?php 
	$open ="product";
  	require_once __DIR__. "/../../autoload/autoload.php"; 

  	$id = intval(getInput('id'));
    if(isset($_SESSION['admin_id']))
    {
      	$comment= $db-> fetchID("binhluan" ,$id);
      	if(empty($comment))
      	{
      		redirectAdmin('product');
      	}
      	$home =$comment['TrangThai'] == 0 ? 1 : 0;
    
      	$update = $db-> update("binhluan", array("TrangThai" => $home ),array("id" => $id ));
      	if($update > 0)
        {
            header("location: comment.php?id=".$comment['id_SanPham']);
      		$_SESSION['hide'] = "";
        }
        else 
        {
    		header("location: comment.php?id=".$comment['id_SanPham']);
      		$_SESSION['empty'] = "";
        }
    }
?>
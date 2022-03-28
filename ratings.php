<?php 
	require_once __DIR__. "/autoload/autoload.php"; 
	
	if(isset($_SESSION['name_id']))
    {
    	$product_id = $_POST["product_id"];
		$ratings = $_POST["ratings"];
		$id_User = $_SESSION['name_id']; 
    	$rating= $db -> fetchOne("danhgia" ," id_User = $id_User AND id_SanPham = $product_id ");

       	if($rating == NULL)
       	{
       		$data = [
	           "Sao" => $ratings,
	           "id_User" => $id_User,
	           "id_SanPham" =>$product_id
	        ];
	        
	        $id_insert =$db -> insert("danhgia" , $data);
	        $_SESSION['addrate'] = "";            
	        
       	}
       	else
       	{
       		$sqlup = "UPDATE danhgia SET Sao = $ratings WHERE id_SanPham = $product_id and id_User = $id_User ";
       		$id_update = mysqli_query($connect,$sqlup);
	        $_SESSION['addrate'] = "";  
	        
	        
       	}


	}	
?>
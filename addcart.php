<?php 
	require_once __DIR__. "/autoload/autoload.php"; 
	
  	$id = intval(getInput('id'));

  	if($id){
  			
  		$sqlproductsize ="SELECT san_pham.*,ct_size.*,size.TenSize as TenSize ,size.id as idsize,ct_size.SoLuong as sl FROM san_pham,ct_size,size WHERE san_pham.id=ct_size.id_SanPham AND ct_size.id_Size= size.id AND id_SanPham = $id ORDER BY ct_size.SoLuong DESC LIMIT 1 ";	

		$productsize = $db-> fetchsql($sqlproductsize);

		// $Size = $db-> fetchIDSize("CT_Size" ,$id);
		foreach ($productsize as $value) 
		{
			if(!isset($_SESSION['cart'][$id]))
			{
				if($value['sl'] > 0)
				{
					$_SESSION['cart'][$id]['TenSP'] = $value['TenSP'];
					$_SESSION['cart'][$id]['AnhSP'] = $value['AnhSP'];
					$_SESSION['cart'][$id]['GiaSP'] = ((100 - $value['GiamGia']) * $value['GiaSP']) / 100;
					$_SESSION['cart'][$id]['SoLuong'] = 1;
					$_SESSION['cart'][$id]['id_Size'] = $value['id_Size'];
					$_SESSION['cart'][$id]['TenSize'] = $value['TenSize'];
					$_SESSION['cart'][$id]['idsize'] = $value['idsize'];
					$_SESSION['success']="";
				}
				else
				{
					$_SESSION['errorcart2'] ="";
				}			
			}
			else
			{
				if($value['sl'] > $_SESSION['cart'][$id]['SoLuong'])
				{
				    if($_SESSION['cart'][$id]['SoLuong'] < 1000)
				    {
					    $_SESSION['cart'][$id]['SoLuong'] += 1;
					    $_SESSION['success']="";
				    }
				}
				else
				{
					$_SESSION['errorcart2'] ="";
				}
			}
		}
		header("location: index.php");
  	}	
?>


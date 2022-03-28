<?php 
	require_once __DIR__. "/autoload/autoload.php"; 
	
	$key = intval(getInput("key"));

	$number = intval(getInput("SoLuong"));

	$id_Size = intval(getInput("id_Size"));

	$id = intval(getInput("id"));
	
	$sql= "SELECT ct_size.*,size.TenSize, size.id as idsize FROM ct_size,size WHERE ct_size.id_Size=size.id AND id_SanPham = $key AND id_Size = $id_Size ";
	$CT_Size = $db -> fetchsql($sql);
	foreach ($CT_Size as $value) {
		if($value['SoLuong'] < $number) 
		{
			$_SESSION['errorcart'] = "";
			if($value['SoLuong'] != 0) 
			{
				$_SESSION['cart'][$key]['id_Size'] = $id_Size;
				$_SESSION['cart'][$key]['TenSize'] = $value['TenSize'];
				$_SESSION['cart'][$key]['idsize'] = $value['idsize'];
			}
			if($value['SoLuong'] < $number) 
			{
				$_SESSION['cart'][$key]['SoLuong'] = 1;
			}
		}
		else if($value['SoLuong'] == 0)
		{
			$_SESSION['errorcart'] = "";
		}
		else
		{
			if($_SESSION['cart'][$key]['id_Size'] == $id_Size)
			{
				if($value['SoLuong'] >= $number){
					$_SESSION['cart'][$key]['SoLuong'] = $number;
					$_SESSION['cart'][$key]['id_Size'] = $id_Size;
					$_SESSION['cart'][$key]['TenSize'] = $value['TenSize'];
					$_SESSION['cart'][$key]['idsize'] = $value['idsize'];
					$_SESSION['updatecart'] = "";	
				}
				else {
					$_SESSION['cart'][$key]['id_Size'] = $id_Size;
					$_SESSION['cart'][$key]['TenSize'] = $value['TenSize'];
					$_SESSION['cart'][$key]['idsize'] = $value['idsize'];
					$_SESSION['cart'][$key]['SoLuong'] = 1;
					$_SESSION['errorcart'] = "";
				}
				
			}
			else
			{
				if($value['SoLuong'] >= $number){
					$_SESSION['cart'][$key]['SoLuong'] = $number;
					$_SESSION['cart'][$key]['id_Size'] = $id_Size;
					$_SESSION['cart'][$key]['TenSize'] = $value['TenSize'];
					$_SESSION['cart'][$key]['idsize'] = $value['idsize'];
					$_SESSION['updatecart'] = "";
				}
				else
				{
					$_SESSION['cart'][$key]['id_Size'] = $id_Size;
					$_SESSION['cart'][$key]['TenSize'] = $value['TenSize'];
					$_SESSION['cart'][$key]['idsize'] = $value['idsize'];
					$_SESSION['cart'][$key]['SoLuong'] = 1;
					$_SESSION['errorcart'] = "";
				}
			}
		}
	}
	
?>
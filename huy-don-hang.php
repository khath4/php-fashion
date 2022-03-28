<?php 
  	require_once __DIR__. "/autoload/autoload.php"; 
  	$id = intval(getInput('id'));
  	$EditTransaction= $db-> fetchID("don_hang" ,$id);
  	if(empty($EditTransaction))
    {
        $_SESSION['nodata'] = "";
        header("location: don-hang.php?id=".$_SESSION['name_id']);
    }
  	if(isset($_SESSION['name_id']))
  	{
        if($_SESSION['name_id'] == $EditTransaction['id_Users']) 
        {
          	if($EditTransaction['HuyDon'] == 0)
          	{
          	    if($EditTransaction['TrangThaiTT'] <= 1)
                {
                    if($EditTransaction['TrangThai'] == 0)
                    {
                        $HuyDon = 1;
                      	$update = $db-> update("don_hang", array("HuyDon" => $HuyDon ),array("id" => $id ));
                      	
                      	if($update > 0)
                        {
                            $_SESSION['success2'] = "";
                            header("location: don-hang.php?id=".$_SESSION['name_id']);
                        }
                        else 
                        {
                            $_SESSION['unsuccess'] = "";
                            header("location: don-hang.php?id=".$_SESSION['name_id']);
                        }
                    }
                    else
                    {
                        $_SESSION['checkbox'] = "";
                        header("location: don-hang.php?id=".$_SESSION['name_id']);
                    }
                }
                else
                {
                    $_SESSION['checkpay'] = "";
                    header("location: don-hang.php?id=".$_SESSION['name_id']);
                }
                
          	}
          	else
          	{
          	    $_SESSION['check'] = "";
                header("location: don-hang.php?id=".$_SESSION['name_id']);
          	}
        }
        else
        {
            $_SESSION['nodata'] = "";
            header("location: don-hang.php?id=".$_SESSION['name_id']);
        }
  	}
  	else
  	{
  	    $_SESSION['unlogin']="";  
        header("Location: dang-nhap.php");
  	} 
?>

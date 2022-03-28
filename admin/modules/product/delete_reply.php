<?php 
    $open ="product";
    require_once __DIR__. "/../../autoload/autoload.php"; 

    $id = intval(getInput('id'));
    if(isset($_SESSION['admin_id']))
    {
        $reply= $db-> fetchID("traloibl" ,$id);
        if(empty($reply)){
          redirectAdmin('product');
        }
        $sqlidsp = "SELECT traloibl.*,binhluan.id_SanPham as id_SanPham FROM traloibl,binhluan WHERE traloibl.id_BinhLuan = binhluan.id AND traloibl.id = $id";
        $idsp = $db -> fetchsql($sqlidsp);
    
        foreach ($idsp as $value)
        {
            $_SESSION['idsp'] = $value['id_SanPham'];
            if($_SESSION['admin_level'] >= 2 || $value['id_admin'] == $_SESSION['admin_id'] )
            {
                
                $num =$db ->delete("traloibl" ,$id);
           
               if($num > 0)
               {
                  header("location: comment.php?id=".$_SESSION['idsp']);
                  $_SESSION['hide'] = "";
                  unset($_SESSION['idsp']);
               }
               else 
               {
                  header("location: comment.php?id=".$_SESSION['idsp']);
                  $_SESSION['hide'] = "";
                  unset($_SESSION['idsp']);
               }
            }
            else
            {
                header("location: comment.php?id=".$_SESSION['idsp']);
                $_SESSION['undelete'] = "";
                unset($_SESSION['idsp']);
            }
        }
    }
?>
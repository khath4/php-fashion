<?php 
 	$open ="admin";
  	require_once __DIR__. "/../../autoload/autoload.php"; 

    if(isset($_SESSION['admin_id']) && $_SESSION['admin_level'] >= 2) 
    {
    	$id = intval(getInput('id'));

    	$DeleteAdmin= $db-> fetchID("admin" ,$id);

        if(($_SESSION['admin_id']) && ($id != $_SESSION['admin_id'])) 
        {
            if ($DeleteAdmin['CapBat'] != $_SESSION['admin_level']) 
            {
               if(empty($DeleteAdmin))
                {
                    $_SESSION['error'] = "Dữ liệu không tồn tại.";
                    redirectAdmin('admin');
                }

                $num =$db ->delete("admin" ,$id);
                if($num > 0)
                {
                    $_SESSION['success'] = "Xóa thành công.";
                    redirectAdmin('admin');
                }
                else 
                {
                    $_SESSION['error'] = "Xóa không thành công.";
                    redirectAdmin('admin');
                }
            }
            else
            {
                $_SESSION['error'] = "Bạn không thể thực hiện chức năng này với người cùng cấp bậc.";
                redirectAdmin('admin');
            }
        }
        else 
        {
            $_SESSION['error'] = "Bạn không thể thực hiện chức năng này.";
            redirectAdmin('admin');
        }
    }
    else
    {
        $_SESSION['error'] = "Bạn không thể thực hiện chức năng này với người cùng cấp bậc hoặc lớn hơn bạn.";
        redirectAdmin('admin');
    } 
?>
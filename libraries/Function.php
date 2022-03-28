<?php 
	/**
	*post Input
	*/
	function postInput($string) 
	{	
		return isset($_POST[$string]) ? $_POST[$string] : '';
	}
	function getInput($string) 
	{	
		return isset($_GET[$string]) ? $_GET[$string] : '';
	}
	function base_url()
	{
		return $url= "http://localhost/public_html/";
	}
	function modules($url) 
	{
		return base_url() . "admin/modules/" .$url;
	}
	function public_frontend()
	{
		return base_url() . "public/fontend/";
	}
	function public_admin()
	{
		return base_url() . "public/admin/";
	}
	function uploads()
	{
		return base_url() . "public/uploads/";
	}

	if(! function_exists('redirectStyle'))
	{
		function redirectStyle($url= " ")
		{
			header("location :" .base_url(). "$url");exit();
		}
	}

	if(! function_exists('redirectAdmin'))
	{
		function redirectAdmin($url ="")
		{
			header("Location: ". base_url() ."admin/modules/$url");exit();
		}
	}
	if( ! function_exists('str_slug'))
	{
    	function str_slug($str,$default = '-') 
    	{
	        $str = trim(mb_strtolower($str));
	        $str = preg_replace('/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/', 'a', $str);
	        $str = preg_replace('/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/', 'e', $str);
	        $str = preg_replace('/(ì|í|ị|ỉ|ĩ)/', 'i', $str);
	        $str = preg_replace('/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/', 'o', $str);
	        $str = preg_replace('/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/', 'u', $str);
	        $str = preg_replace('/(ỳ|ý|ỵ|ỷ|ỹ)/', 'y', $str);
	        $str = preg_replace('/(đ)/', 'd', $str);
	        $str = preg_replace('/[^a-z0-9-\s]/', '', $str);
	        $str = preg_replace('/([\s]+)/',$default, $str);
        return $str;
    }
  }

  if (!function_exists('redirect'))
  {
    function redirect($url = '')
    {
        header("location: ".base_url(). $url);exit();
    }
  }

  function formatPrice($number)
  {
      $number = intval($number);
      return $number = number_format($number,0,',','.') . " VND";
  }

  function formatPriceSale($number,$sale)
  {
      $number= intval($number);
      $sale =intval($sale);
      $price = $sale != 0 ? $price = $number*(100 - $sale)/100  : $number;
      return formatPrice($price);
  }
  function sale($number) 
  {
      $number = intval($number);
      if($number < 1000000) 
      {
         return  0;
      }
      else if($number < 5000000) 
      {
         return  5;
      }
      else
      {
         return  10;
      } 

  }

?>

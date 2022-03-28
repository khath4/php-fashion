<?php
require_once __DIR__. "/autoload/autoload.php"; 

function parseToXML($htmlStr)
{
$xmlStr=str_replace('<','&lt;',$htmlStr);
$xmlStr=str_replace('>','&gt;',$xmlStr);
$xmlStr=str_replace('"','&quot;',$xmlStr);
$xmlStr=str_replace("'",'&#39;',$xmlStr);
$xmlStr=str_replace("&",'&amp;',$xmlStr);
return $xmlStr;
}

// Select all the rows in the markers table
$query = "SELECT * FROM lienhe";
$result = mysqli_query($connect,$query);
if (!$result) {
  die('Invalid query: ' . mysqli_error());
}

header("Content-type: text/xml");

// Start XML file, echo parent node
echo "<?xml version='1.0' ?>";
echo '<markers>';
$ind=0;
// Iterate through the rows, printing XML nodes for each
while ($row = @mysqli_fetch_assoc($result)){
  // Add to XML document node
 
  echo '<marker ';
  echo 'id="' . $row['id'] . '" ';
  echo 'DienThoai="' . $row['DienThoai'] . '" ';
  echo 'Email="' . $row['Email'] . '" ';
  echo 'DiaChi="' . $row['DiaChi'] . '" ';
  echo 'KinhDo="' . $row['KinhDo'] . '" ';
  echo 'ViDo="' . $row['ViDo'] . '" ';
  echo '/>';
  $ind = $ind + 1;
}

// End XML file
echo '</markers>';

?>


<?php
//這是用來檢驗輸入的NCKU ID正確與否的後端處理
$id = $_GET['id'];
$pwd = $_GET['password'];
header("Content-Type:text/html; charset=big5");
$httphandle = fopen("http://140.116.165.72:8888/ncku/qrys05.asp","r");
$meta = stream_get_meta_data($httphandle);
for ($j = 0; isset($meta['wrapper_data'][$j]); $j++)
{
  $httpline = $meta['wrapper_data'][$j];
  @list($header,$parameters) = explode(";",$httpline,2);
  @list($attr,$value) = explode(":",$header,2);
  if (strtolower(trim($attr)) == "set-cookie")
  {
    $cookie = trim($value);
    break;
   }
}
fclose($httphandle);
//要做cookie處理否則會返回錯誤
$opts = array('http' => array('header'=> 'Cookie: ' . $cookie."\r\n"));
$context = stream_context_create($opts);
$page=file_get_contents('http://140.116.165.72:8888/ncku/qrys05.asp?ID='.$id.'&PWD='.$pwd.'&submit1=0102上',false, $context);
$page=strip_tags($page);
//echo $page;
$n1=strpos(" ".$page,"qrys05"); 
if($n1!=0)
{
  echo "true"; 
}
else
{
  echo "false";
}
?>

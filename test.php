<?php
function getMacAddress()
{
  //首先获得手机连接路由器的ip地址
  $mobileIp;
  if (getenv('HTTP_CLIENT_IP')) 
    $mobileIp = getenv('HTTP_CLIENT_IP'); 
  else if (getenv('HTTP_X_FORWARDED_FOR')) 
    $mobileIp = getenv('HTTP_X_FORWARDED_FOR'); 
  else if (getenv('HTTP_X_FORWARDED')) 
    $mobileIp = getenv('HTTP_X_FORWARDED'); 
  else if (getenv('HTTP_FORWARDED_FOR')) 
    $mobileIp = getenv('HTTP_FORWARDED_FOR'); 
  else if (getenv('HTTP_FORWARDED')) 
    $mobileIp = getenv('HTTP_FORWARDED'); 
  else 
    $mobileIp = $_SERVER['REMOTE_ADDR']; 
  //临时的
  $mobileIp="192.168.0.157";

  //通过读文件获取里面ip和mac的数组存在ipArray和macAarray里，一一对应的
  $mapFilePath= "./newmac.txt";
  if(file_exists($mapFilePath))
  {
    $ipArray=array();
    $macArray=array();
    $fp = fopen($mapFilePath,"r");
    $content = fread($fp,filesize($mapFilePath));//指定读取大小，这里把整个文件内容读取出来
    $content = str_replace("\r\n","<br />",$content);
    $ipStr="/(?:(?:25[0-5]|2[0-4]\d|((1\d{2})|([1-9]?\d)))\.){3}(?:25[0-5]|2[0-4]\d|((1\d{2})|([1-9]?\d)))/i";
    $macStr="/[A-Fa-f0-9][A-Fa-f0-9]:[A-Fa-f0-9][A-Fa-f0-9]:[A-Fa-f0-9][A-Fa-f0-9]:[A-Fa-f0-9][A-Fa-f0-9]:[A-Fa-f0-9][A-Fa-f0-9]:[A-Fa-f0-9][A-Fa-f0-9]/i";
    preg_match_all($ipStr,$content,$ipArrays);
    preg_match_all($macStr,$content,$macArrays);
    $ipArray=$ipArrays[0];//[0]存的是一个数组，里面存放所有匹配到的字符串
    $macAarray=$macArrays[0];
  }
  else
    return -100;

  //在ip数组里找到当前ip的index，对应mac数组里就是当前手机的mac地址
  $myIndex=-1;
  foreach($ipArray as $index => $value)
  {
    if($mobileIp==$value)
    {
      $myIndex=$index;
      break;
    }
  }
  //返回对应的mac地址
  if($myIndex>=0)
    return $macAarray[$myIndex];
  else
    return -100;
}

echo getMacAddress();

?>
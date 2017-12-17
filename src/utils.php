<?php

//注册时，获取了本机IP地址后，在生成的txt文件中查询对应的mac地址，同时将提交的用户名同时插入user表中。
//每次登陆时，用mac地址查询用户名，再将登陆信息插入sign表中。
//登陆后评论时，获取提交信息的ip地址，查找相应mac地址，再查找user表中的用户名。
//获取ip地址，匹配mac地址。（preg_match_all()匹配ip地址正则表达式，存入数组1；匹配mac地址正则表达式，存入数组2；每对ip地址和mac地址对，数组下标相同）
//

//判断是否为移动设备
function isMobile()
{ 
  // 如果有HTTP_X_WAP_PROFILE则一定是移动设备
  if (isset ($_SERVER['HTTP_X_WAP_PROFILE']))
    return true;
  // 如果via信息含有wap则一定是移动设备,部分服务商会屏蔽该信息
  if (isset ($_SERVER['HTTP_VIA']))
  // 找不到为flase,否则为true
    return stristr($_SERVER['HTTP_VIA'], "wap") ? true : false;
  // 脑残法，判断手机发送的客户端标志,兼容性有待提高
  if (isset ($_SERVER['HTTP_USER_AGENT']))
  {
    $clientkeywords = array ('nokia',
    'sony',
    'ericsson',
    'mot',
    'samsung',
    'htc',
    'sgh',
    'lg',
    'sharp',
    'sie-',
    'philips',
    'panasonic',
    'alcatel',
    'lenovo',
    'iphone',
    'blackberry',
    'meizu',
    'android',
    'netfront',
    'symbian',
    'ucweb',
    'windowsce',
    'palm',
    'operamini',
    'operamobi',
    'openwave',
    'nexusone',
    'cldc',
    'midp',
    'wap',
    'mobile'
    ); 
    // 从HTTP_USER_AGENT中查找手机浏览器的关键字
    if (preg_match("/(" . implode('|', $clientkeywords) . ")/i", strtolower($_SERVER['HTTP_USER_AGENT'])))
      return true;
  } 
  // 协议法，因为有可能不准确，放到最后判断
  if (isset ($_SERVER['HTTP_ACCEPT']))
  { 
  // 如果只支持wml并且不支持html那一定是移动设备
  // 如果支持wml和html但是wml在html之前则是移动设备
    if ((strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') !== false) && (strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false || (strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') < strpos($_SERVER['HTTP_ACCEPT'], 'text/html'))))
    return true;
  } 
  return false;
} 

//php无法直接获得mac地址，需要根据连接的ip地址查找路由器保存的连接信息文件得到mac地址
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

  //在电脑上测试的
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
    return false;

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
    return false;
}


?>

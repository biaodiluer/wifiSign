<!DOCTYPE>
<html>
  <head>
    <meta http-equiv="Content-Type" content="width=device-width,initial-scale=1,text/html; charset=utf-8" />
    <script type="text/javascript" src="../js/jquery-3.2.1.min.js"></script>
    <script type="text/javascript" src="../js/utils.js"></script>
    <script type='text/javascript' src='../js/index.js'></script>
  </head>
  <body>
    <?php
      include_once "../src/utils.php";
      //session_start();
      $_SESSION['userId']="123";
      $canLoadDOM=false;
      $isMobile=isMobile();
      $isMobile=true;
      if($isMobile)
      {
        if(isset($_SESSION['userId']))
          $canLoadDOM=true;
        else
        {
          //这里要获取mac地址，放在div里方便jq获取，后台查询后要seesion存一下，让register用
          $myMacAddress=getMacAddress();
          //没有登录，要看是否注册
          //$isRegistered=isRegistered($myMacAddress);
          $isRegistered=false;
          if($isRegistered)
            //登录，并跳转到当前页面(就是增加一个session)
            echo "<script type='text/javascript'>window.location='../front/index.php';</script>";
          else
            //跳转到register.php去注册，注册完了也自动登录
            echo "<script type='text/javascript'>window.location='../front/register.php';</script>";
        }
      }
      else
        echo "必须用手机登录";

      if($canLoadDOM)
      {
    ?>
      <div class="menu">
        <span class="submenu view" _url="../front/view.php">查看签到</span>
        <span class="submenu discuss" _url="../front/discuss.php">题目与评论</span>
      </div>

      <div id="stage" style="background:#eee;border:2px solid black;">

      </div>
    <?php
      }
    ?>

  </body>
</html>

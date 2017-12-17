<!DOCTYPE>
<html>
  <head>
    <meta http-equiv="Content-Type" content="width=device-width,initial-scale=1,text/html; charset=utf-8" />
    <script type="text/javascript" src="../js/jquery-3.2.1.min.js"></script>
    <script type="text/javascript" src="../js/utils.js"></script>
    <script type="text/javascript" src="../js/register.js"></script>
  </head>
  <body>
    <input type="text" placeholder="请输入学号" value="id" class="userId"/>
    <input type="text" placeholder="请输入姓名" value="name" class="userName"/>
    <?php
      $_SESSION['macAddress']="12:12:12";
      if(isset($_SESSION['macAddress']))
      {
    ?>
      <div class="macAddress"><?php echo $_SESSION['macAddress'];?></div>
    <?php
      }
    ?>
    <button class="register">注册</button>
  </body>
</html>

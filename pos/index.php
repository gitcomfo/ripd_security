<?php
error_reporting(0);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link rel="icon" type="image/png" href="images/favicon.png" />
<title>রিপড সেলিং সিস্টেম</title>
<link rel="stylesheet" type="text/css" href="css/style.css" />
</head>
<body>

<div id="maindiv" style="width: 960px !important; ">
<div id="header" style="width:960px;height:100px;background-image: url(images/background.gif);background-repeat: no-repeat;background-size:100% 100%;margin:0 auto;"></div>
  
<div id="login">
    <div id="errormsg" align="center" style="color: red;font-size: 26px;text-decoration: blink;"><?php if(isset($_GET['msg'])) echo $_GET['msg'];?></div>  
    <form style="margin:40px;" id="form1" name="form1" method="post" action="mainloginexec.php">
      <label><b>ইউজারনেম</b>:<input type="text" name="username" size="25px;" /></label>
      <p>
        <label><b>পাসওয়ার্ড&nbsp;&nbsp;</b>:<input type="password" name="password" size="25px;" /></label>
      </p>
      <p>
        <label><input type="submit" name="Submit" value="লগইন করুন" style="margin-left:37%;cursor:pointer;font-family: SolaimanLipi !important;" /></label>
      </p>
    </form>
    </div>
<div style="background-color:#f2efef;border-top:#009 dashed 2px;padding:3px;">
     <a href="http://www.comfosys.com" target="_blank"><img src="images/footer_logo.png"/></a> 
         RIPD Universal &copy; All Rights Reserved 2013 - Designed and Developed By <a href="http://www.comfosys.com" target="_blank" style="color:#772c17;">comfosys Limited</a>
</div>
</div>
</body>
</html>

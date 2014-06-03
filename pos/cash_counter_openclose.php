<?php
error_reporting(0);
session_start();
include_once 'includes/connectionPDO.php';
include_once 'includes/MiscFunctions.php';

$storeName= $_SESSION['loggedInOfficeName'];
$cfsID = $_SESSION['userIDUser'];
$storeID = $_SESSION['loggedInOfficeID'];
$scatagory =$_SESSION['loggedInOfficeType'];

$sel_counter_info = $conn->prepare("SELECT * FROM ons_counter WHERE counter_onsid = ? AND counter_onstype= ?");
$up_counter_open = $conn->prepare("UPDATE ons_counter SET counter_status = 'open', temp_strt_amount= ? ,last_update= NOW() WHERE idonscounter=?");
$up_counter_close = $conn->prepare("UPDATE ons_counter SET counter_status = 'closed', temp_strt_amount= ?,last_update= NOW() WHERE idonscounter=?");
function getCounters($sql,$id,$type) {
    $sql->execute(array($id,$type));
    $arr_counter = $sql->fetchAll();
    foreach ($arr_counter as $catrow) {
        echo "<option value=" . $catrow['idonscounter'] . ">" . $catrow['counter_name'] . "</option>";
    }
}

// ********************* counter open হওয়ার জন্য*******************************************
if(isset($_POST['open']))
{
    $p_counterID=$_POST['countername'];
    $p_opencash=$_POST['day_cash'];

    $sqlreslt = $up_counter_open->execute(array($p_opencash, $p_counterID));
    if($sqlreslt)
    {
        echo "<script>alert('কাউন্টার খোলা হল');</script>";
    }
    else {
        echo "<script>alert('দুঃখিত, কাউন্টার খোলা হয়নি');</script>";
    }
}

// ********************* counter close হওয়ার জন্য*******************************************
if(isset($_POST['close']))
{
    $p_counterID=$_POST['countername'];
    $p_closecash=$_POST['day_cash'];

    $sqlreslt = $up_counter_close->execute(array($p_closecash, $p_counterID));
    if($sqlreslt)
    {
        echo "<script>alert('কাউন্টার বন্ধ হল');</script>";
    }
    else {
        echo "<script>alert('দুঃখিত, কাউন্টার বন্ধ হয়নি');</script>";
    }
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html;" charset="utf-8" />
<link rel="icon" type="image/png" href="images/favicon.png" />
<title>কাউন্টার খোলা / বন্ধ</title>
<link rel="stylesheet" href="css/style.css" type="text/css" media="screen" charset="utf-8"/>
<script language="JavaScript" type="text/javascript" src="scripts/suggest.js"></script>
<script language="JavaScript" type="text/javascript" src="scripts/productsearch.js"></script>
<link rel="stylesheet" href="css/css.css" type="text/css" media="screen" />

<script LANGUAGE="JavaScript">
function checkIt(evt) {
        evt = (evt) ? evt : window.event
        var charCode = (evt.which) ? evt.which : evt.keyCode
        if (charCode ==8 || (charCode >47 && charCode <58) || charCode==46) {
            return true
        }
        else{ return false;}
    }
    
function getCounterStatus(id) // check if counter is open or not*******************
{
       var xmlhttp;  
        if (window.XMLHttpRequest)
        {// code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp=new XMLHttpRequest();
        }
        else
        {// code for IE6, IE5
            xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange=function()
        {
            if (xmlhttp.readyState==4 && xmlhttp.status==200)
            {
                document.getElementById('submitdiv').innerHTML=xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET","includes/counter_includes.php?id="+id,true);
        xmlhttp.send();    
}
</script>
</head>
    
<body>
<div id="maindiv">
<div id="header" style="width:100%;height:100px;background-image: url(../images/sara_bangla_banner_1.png);background-repeat: no-repeat;background-size:100% 100%;margin:0 auto;"></div></br>
<div style="width: 90%;height: 70px;margin: 0 5% 0 5%;float: none;">
    <div style="width: 33%;height: 100%; float: left;"><a href="../pos_management.php"><img src="images/back.png" style="width: 70px;height: 70px;"/></a></div>
    <div style="width: 33%;height: 100%; float: left;font-family: SolaimanLipi !important;text-align: center;font-size: 36px;"><?php echo $storeName;?></div>
</div>
<br/>
<div align="center" style="color: green;font-size: 26px; font-weight: bold; width: 90%;height: 20px;margin: 0 5% 0 5%;float: none;"><?php if($msg != "") echo $msg;?></div></br>

<form action="" method="post">
          <fieldset style="width:70%;border-width: 3px;margin:0 20px 0 200px;font-family: SolaimanLipi !important;">
              <legend style="color: brown;">কাউন্টার খোলা / বন্ধ</legend>
              <div style="width: 100%;">
                  <table cellpadding="2" cellspacing="0" border="1">
                      <tr>
                          <td width="50%" align="right">তারিখ</td>
                          <td><?php echo english2bangla(date('d/m/Y')) ?></td>
                      </tr>
                      <tr>
                          <td align="right">সময়</td>
                          <td><?php date_default_timezone_set('Asia/Dhaka'); echo english2bangla(date('h:i a'),  time())?></td>
                      </tr>
                      <tr>
                          <td align="right">কাউন্টার</td>
                          <td>
                              <select name="countername" onchange="getCounterStatus(this.value)">
                                  <option value="0">-সিলেক্ট করুন-</option>
                                  <?php getCounters($sel_counter_info,$storeID,$scatagory);?>
                              </select>
                          </td>
                      </tr>
                      <tr>
                          <td align="right">ক্যাশ প্রদান</td>
                          <td><input type="text" name="day_cash" onkeypress='return checkIt(event)' /> TK</td>
                      </tr>
                  </table>
              </div><br/>
              <div id="submitdiv">  
              </div>
           </fieldset>
        </br></br></br></br></br>
</form>
</div>
<div style="background-color:#f2efef;border-top:1px #eeabbd dashed;padding:3px 50px;width: 82%; margin: 0 auto;" >
     <a href="http://www.comfosys.com" target="_blank"><img src="images/footer_logo.png"/></a> 
         RIPD Universal &copy; All Rights Reserved 2013 - Designed and Developed By <a href="http://www.comfosys.com" target="_blank" style="color:#772c17;">comfosys Limited<img src="images/comfosys_logo.png" style="width: 50px;height: 40px;"/></a>
</div>
</body>
</html>
<?php
error_reporting(0);
session_start();
include_once 'includes/connectionPDO.php';
include_once 'includes/MiscFunctions.php';

$storeName= $_SESSION['loggedInOfficeName'];
$cfsID = $_SESSION['userIDUser'];
$storeID = $_SESSION['loggedInOfficeID'];
$scatagory =$_SESSION['loggedInOfficeType'];

$infostmt = $conn->prepare("INSERT INTO ons_counter(counter_name ,counter_onsid ,counter_onstype ,created_date ,fk_creater_id,last_update) 
                                                VALUES (?, ?, ?, NOW(), ?, NOW())");
$sel_counter_info = $conn->prepare("SELECT * FROM ons_counter WHERE counter_onsid = ? AND counter_onstype= ?");


// ********************* counter entry হওয়ার জন্য*******************************************
if(isset($_POST['ok']))
{
    $sel_counter_info->execute(array($storeID,$scatagory));
    $counterrow = $sel_counter_info->fetchAll();
    
    if(count($counterrow) < 1)
    {
        $countername = "c1";
    }
    else
    {
        foreach ($counterrow as $value) {
            $db_str_countername = $value['counter_name'];
        }
        $code = substr($db_str_countername,1);
        $temp = (int)$code;
        $temp = $temp+1;
        $str_temp= (string)$temp;
        $countername = "c".$str_temp;
    }

    $sqlreslt = $infostmt->execute(array($countername, $storeID,$scatagory,$cfsID));
    if($sqlreslt)
    {
        echo "<script>alert('নতুন একটি কাউন্টার তৈরি হয়েছে');</script>";
    }
 else {
        echo "<script>alert('দুঃখিত, নতুন কাউন্টার তৈরি হয়নি');</script>";
    }
}

// *********************** counter info select *********************************
$sel_counter_info->execute(array($storeID,$scatagory));
$counterrow1 = $sel_counter_info->fetchAll();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html;" charset="utf-8" />
        <link rel="icon" type="image/png" href="images/favicon.png" />
        <title>কাউন্টার তৈরি</title>
        <link rel="stylesheet" href="css/style.css" type="text/css" media="screen" charset="utf-8"/>
        <link rel="stylesheet" href="css/css.css" type="text/css" media="screen" />
</head>
    
<body>
<div id="maindiv">
<div id="header" style="width:100%;height:100px;background-image: url(../images/sara_bangla_banner_1.png);background-repeat: no-repeat;background-size:100% 100%;margin:0 auto;"></div></br>
<div style="width: 90%;height: 70px;margin: 0 5% 0 5%;float: none;">
    <div style="width: 33%;height: 100%; float: left;"><a href="../pos_management.php"><img src="images/back.png" style="width: 70px;height: 70px;"/></a></div>
    <div style="width: 33%;height: 100%; float: left;font-family: SolaimanLipi !important;text-align: center;font-size: 36px;"><?php echo $storeName;?></div>
</div>
<br/>

<form action="" method="post">
          <fieldset style="width:70%;border-width: 3px;margin:0 20px 0 200px;font-family: SolaimanLipi !important;">
              <legend style="color: brown;">কাউন্টার তৈরি</legend>
              <div style="width: 100%;">
                  <table cellpadding="2" cellspacing="0" border="1">
                      <tr>
                          <td width="50%" align="right">বর্তমান কাউন্টার সংখ্যা</td>
                          <td><?php echo english2bangla(count($counterrow1));?></td>
                      </tr>
                      <tr>
                          <td colspan="2" align="center" style="color: darkblue">কাউন্টার লিস্ট</td>
                      </tr>
                      <?php
                            $count = 1;
                            foreach ($counterrow1 as $value) {
                                    echo "<tr>
                                                <td align='right'>কাউন্টার-".english2bangla($count)."</td>
                                                <td>".$value['counter_name']."</td>
                                            </tr>";
                                    $count++;
                                }
                      ?>
                  </table>
              </div><br/>
              <input name="ok" id="ok" type="submit" value="নতুন কাউন্টার তৈরি" style="cursor:pointer;margin-left:40%;width:150px;height: 25px;font-family: SolaimanLipi !important;" /></br>
           </fieldset>
        </br></br></br></br></br>
    </form>
    </div>
<div style="background-color:#f2efef;border-top:1px #eeabbd dashed;padding:3px 50px;width: 82%; margin: 0 auto;" >
     <a href="http://www.comfosys.com" target="_blank"><img src="images/footer_logo.png"/></a> 
         RIPD Universal &copy; All Rights Reserved 2013 - Designed and Developed By <a href="http://www.comfosys.com" target="_blank" style="color:#772c17;">comfosys Limited
             <img src="images/comfosys_logo.png" style="width: 50px;height: 40px;"/></a>
</div>
</body>
</html>
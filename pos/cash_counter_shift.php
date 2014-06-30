<?php
error_reporting(0);
session_start();
include_once 'includes/connectionPDO.php';
include_once 'includes/MiscFunctions.php';

$storeName= $_SESSION['loggedInOfficeName'];
$cfsID = $_SESSION['userIDUser'];
$storeID = $_SESSION['loggedInOfficeID'];
$scatagory =$_SESSION['loggedInOfficeType'];

$sel_counter = $conn->prepare("SELECT * FROM ons_counter WHERE counter_onsid = ? AND counter_onstype= ?
                                                            AND counter_status='open' AND  counter_login = 'N'");
$ins_counter_shifting = $conn->prepare("INSERT INTO ons_shifting(fk_counterid ,starting_cash ,cfs_userid ,shifting_date ,shift_start) 
                                                VALUES (?, ?, ?, NOW(), NOW())");

$up_counter_login = $conn->prepare("UPDATE ons_counter SET counter_login = 'Y' WHERE idonscounter=? ");
$up_counter_logout = $conn->prepare("UPDATE ons_counter SET counter_login = 'N', temp_strt_amount= ?,last_update= NOW() 
                                                                WHERE idonscounter=?");
$up_counter_shifting = $conn->prepare("UPDATE ons_shifting SET ending_cash = ?,shift_end= NOW() 
                                                                WHERE  idonsshifting=?");
$sel_counter_info = $conn->prepare("SELECT * FROM ons_counter WHERE idonscounter =?");
$sel_counter_now = $conn->prepare("SELECT * FROM ons_counter JOIN ons_shifting ON idonscounter =  fk_counterid
                                                            WHERE cfs_userid = ? AND counter_login= 'Y' AND shifting_date = CURDATE() AND shift_end IS NULL");
$sel_salesum = $conn->prepare("SELECT SUM(sal_cash_paid) FROM sales_summary 
                                        WHERE cfs_userid = ? AND sal_salesdate = CURDATE() AND sal_salestime > ?");

function getCounters($sql,$id,$type) {
    $sql->execute(array($id,$type));
    $arr_counter = $sql->fetchAll();
    foreach ($arr_counter as $catrow) {
        echo "<option value=" . $catrow['idonscounter'] . ">" . $catrow['counter_name'] . "</option>";
    }
}

// ********************* counter login*******************************************
if(isset($_POST['login']))
{
    $p_counterID=$_POST['counter'];

    $sel_counter_info->execute(array($p_counterID));
    $counterrow = $sel_counter_info->fetchAll();
    foreach ($counterrow as $value) {
            $db_tempamount = $value['temp_strt_amount'];
        }
   $conn->beginTransaction();
   
   $sqlreslt = $ins_counter_shifting->execute(array($p_counterID,$db_tempamount,$cfsID));
   $sqlreslt2 = $up_counter_login->execute(array($p_counterID));
   if($sqlreslt && $sqlreslt2)
    {
       $conn->commit();
        echo "<script>alert('কাউন্টার লগইন হল');</script>";
    }
    else {
        $conn->rollBack();
        echo "<script>alert('দুঃখিত, কাউন্টার লগইন হয়নি');</script>";
    }
}

// ********************* counter logout*******************************************
if(isset($_POST['logout']))
{
    $p_counter= $_POST['counterID'];
    $p_totalcash = $_POST['day_cash'];
    $p_shiftingID = $_POST['shiftingID'];
    
    $conn->beginTransaction();
   
   $sqlreslt = $up_counter_logout->execute(array($p_totalcash,$p_counter));
   $sqlreslt2 = $up_counter_shifting->execute(array($p_totalcash,$p_shiftingID));
   if($sqlreslt && $sqlreslt2)
    {
       $conn->commit();
        echo "<script>alert('শিফট শেষ হল');</script>";
    }
    else {
        $conn->rollBack();
        echo "<script>alert('দুঃখিত, শিফট শেষ হয়নি');</script>";
    }
}

// ********************* check current shifting ************************
$sel_counter_now->execute(array($cfsID));
$rowall = $sel_counter_now->fetchAll();
$countrow = count($rowall);
foreach ($rowall as $value) {
    $db_countername = $value['counter_name'];
    $db_starting_amount = $value['starting_cash'];
    $db_counterID =$value['fk_counterid'];
    $db_shiftingID = $value['idonsshifting'];
    $db_shiftstart = $value['shift_start'];
}
$shift_starting_time = $tme = date('H:m:s',  strtotime($db_shiftstart));

    $sel_salesum->execute(array($cfsID,$shift_starting_time));
    $salerow = $sel_salesum->fetchAll();
    foreach ($salerow as $row) {
        $db_totalsale = $row['SUM(sal_cash_paid)'];
    }   

$now_cash = $db_starting_amount + $db_totalsale;

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html;" charset="utf-8" />
<link rel="icon" type="image/png" href="images/favicon.png" />
<title>কাউন্টার</title>
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
<?php
    if($countrow < 1)
    {
?>
<form method="post" action="" >
          <fieldset style="width:40%;border-width: 3px;margin:0 2% 0 30%;font-family: SolaimanLipi !important;">
              <legend style="color: brown;">কাউন্টার লগইন</legend>
              <div style="width: 100%;">
                  <b>কাউন্টার : </b>
                  <select name="counter">
                       <option value="0">-সিলেক্ট করুন-</option>
                       <?php getCounters($sel_counter,$storeID,$scatagory);?>
                  </select></br>
             </div><br/>
              <input name="login" type="submit" value="লগইন" style="cursor:pointer;margin-left:42%;width:80px;height: 25px;font-family: SolaimanLipi !important;" /></br>
           </fieldset>
        </br></br></br></br></br></br></br></br>
    </form>
    <?php }
    else
    { ?>
    <form action="" method="post" name="abc">
     <fieldset style="border-width: 3px;margin:0 20px 0 20px;font-family: SolaimanLipi !important;">
         <legend style="color: brown;">কাউন্টার</legend>
         <div style="width: 100%;">
                  <table cellpadding="2" cellspacing="0" border="1">
                      <tr>
                          <td width="50%" align="right">তারিখ</td>
                          <td><?php echo english2bangla(date('d/m/Y')) ?><input type="hidden" name="shiftingID" value="<?php echo $db_shiftingID;?>" /></td>
                      </tr>
                      <tr>
                          <td align="right">সময়</td>
                          <td><?php date_default_timezone_set('Asia/Dhaka'); echo english2bangla(date('h:i a'),  time())?></td>
                      </tr>
                      <tr>
                          <td align="right">কাউন্টার</td>
                          <td><?php echo $db_countername;?><input type="hidden" name="counterID" value="<?php echo $db_counterID;?>" /></td>
                      </tr>
                      <tr>
                          <td align="right">বর্তমান ক্যাশ</td>
                          <td><input type="text" id="day_cash" name="day_cash" readonly value="<?php echo round($now_cash,3)?>" /> TK</td>
                      </tr>
                  </table><br/>
                  <input  name="logout" type="submit" value="লগআউট" style="cursor:pointer;margin-left:45%;width:80px;height: 25px;font-family: SolaimanLipi !important;" /></br></br>
        </div>
     </fieldset>
</form>
    <?php }?>
</div>
<div style="background-color:#f2efef;border-top:1px #eeabbd dashed;padding:3px 50px;width: 82%; margin: 0 auto;" >
     <a href="http://www.comfosys.com" target="_blank"><img src="images/footer_logo.png"/></a> 
         RIPD Universal &copy; All Rights Reserved 2013 - Designed and Developed By <a href="http://www.comfosys.com" target="_blank" style="color:#772c17;">comfosys Limited<img src="images/comfosys_logo.png" style="width: 50px;height: 40px;"/></a>
</div>
</body>
</html>
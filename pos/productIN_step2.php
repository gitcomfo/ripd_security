<?php
error_reporting(0);
session_start();
include_once 'includes/ConnectDB.inc';
include_once 'includes/connectionPDO.php';
include_once 'includes/MiscFunctions.php';
	
$storeName= $_SESSION['loggedInOfficeName'];
$cfsID = $_SESSION['userIDUser'];
$storeID = $_SESSION['loggedInOfficeID'];
$scatagory =$_SESSION['loggedInOfficeType'];
//$msg = "";
$sel_command = $conn->prepare("SELECT * FROM running_command");
$sel_command->execute();
$arr_rslt = $sel_command->fetchAll();
foreach ($arr_rslt as $value) {
    $db_pv = $value['pv_value'];
}
$ins_purchase_sum = $conn->prepare("INSERT INTO product_purchase_summary(chalan_no, total_chalan_cost, transport_cost ,others_cost ,chalan_comment , chalan_date , cfs_user_idUser ,chalan_scan_copy) VALUES (?, ?, ?, ?, ?, NOW(), ?, ?)");
$ins_purchase = $conn->prepare("INSERT INTO product_purchase(in_ons_type, in_onsid, in_input_date ,input_type ,in_howmany , in_pv , in_extra_profit ,in_profit, in_buying_price, in_sellingprice, cfs_user_idUser, Product_chart_idproductchart) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
$sel_purchase_sum = $conn->prepare("SELECT * FROM product_purchase_summary WHERE chalan_no= ? ");
if(isset($_POST['next']))
{
    $p_totalBuyingPrice = $_POST['totalBuyingPrice'];
    $p_totalTransportCost = $_POST['transportCost'];
    $p_comment = $_POST['transportComment'];
    echo $p_totalotherCost = $_POST['otherCost'];
    $p_calanCopy = $_POST['calanCopy'];
    if(!isset($_SESSION['calanArray']))
    {
           array_push($_SESSION['calanArray'],$p_totalBuyingPrice);
    array_push($_SESSION['calanArray'],$p_totalTransportCost);
    array_push($_SESSION['calanArray'],$p_comment);
    array_push($_SESSION['calanArray'],$p_totalotherCost);
    array_push($_SESSION['calanArray'],$p_calanCopy);
    }
    print_r($_SESSION['calanArray']);

}

if(isset($_POST['entry']))
{
    $forwhileLoop = 1;
    $arr_chalan = $sel_purchase_sum->execute(array($_SESSION['chalanNO']));
    while ($forwhileLoop == 1)
    {
        if(count($arr_chalan) > 1)
        {
            $_SESSION['chalanNO'] = get_time_random_no(10);
        }
        else { $forwhileLoop = 0 ; $chalanNo = $_SESSION['chalanNO'];}
    }
    foreach ($_SESSION['calanArray'] as $chalan) {
        $ins_purchase_sum->execute(array($chalanNo,$chalan[0],$chalan[1],$chalan[3],$chalan[2],$cfsID,$chalan[4]));
    }
    
    //$noRows = count($_SESSION['arrProductTemp']);

//    $selectstmt->execute(array($storeID,$scatagory));
//    $all = $selectstmt->fetchAll();
//    foreach($all as $row)
//    {
//        $db_proname=$row['pro_name'];
//        $db_buy=$row['buying_price'];
//        $db_sell=$row['selling_price'];
//        $db_profit=$row['profit'];
//        $db_xtraprofit=$row['xtra_profit'];
//        $db_pv=$row['pv'];
//        $db_qty=$row['qty'];
//        $db_chartid=$row['product_chart_id'];
//        $intype = 'in';
//        $timestamp=time(); //current timestamp
//        $date=date("Y/m/d", $timestamp);
//       $yes = $stmt->execute(array($scatagory, $storeID, $date, $intype, $db_qty, $db_pv,  $db_xtraprofit, $db_profit, $db_buy, $db_sell, $cfsID, $db_chartid));
//       if($yes == 1)
//       {
//           $msg = "প্রোডাক্ট সফলভাবে এন্ট্রি হয়েছে";
//       }
//       else { $msg = "দুঃখিত প্রোডাক্ট এন্ট্রি হয়নি";}
//      }
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html;" charset="utf-8" />
<link rel="icon" type="image/png" href="images/favicon.png" />
<title>প্রোডাক্ট এন্ট্রি</title>
<link rel="stylesheet" href="css/style.css" type="text/css" media="screen" charset="utf-8"/>
<script language="JavaScript" type="text/javascript" src="suggest.js"></script>
<script language="JavaScript" type="text/javascript" src="productsearch.js"></script>
<link rel="stylesheet" href="css/css.css" type="text/css" media="screen" />
<!--===========================================================================================================================-->
<script LANGUAGE="JavaScript">
function checkIt(evt) {
    evt = (evt) ? evt : window.event
    var charCode = (evt.which) ? evt.which : evt.keyCode
    if (charCode ==8 || (charCode >47 && charCode <58) || charCode==46) {
        status = ""
        return true
    }
    status = "This field accepts numbers only."
    return false
}
function numbersonly(e)
{
        var unicode=e.charCode? e.charCode : e.keyCode
            if (unicode!=8)
            { //if the key isn't the backspace key (which we should allow)
                if (unicode<48||unicode>57) //if not a number
                return false //disable key press
            }
}

function calculate(val,i)
{ 
    var xprofit = Number(val);
    var buying = Number(document.getElementById("proBuyingPrice["+i+"]").value);
   var selling = Number(document.getElementById("proSellingPrice["+i+"]").value);
    var currentpv = Number(document.getElementById("currentPv").value);
    var profit = selling - (buying + xprofit);
    var pv = profit * currentpv;
    document.getElementById("proProfit["+i+"]").value = profit;
    document.getElementById("proPV["+i+"]").value = pv;
}
</script>
</head>
    
<body>
<div id="maindiv">
<div id="header" style="width:100%;height:100px;background-image: url(../images/sara_bangla_banner_1.png);background-repeat: no-repeat;background-size:100% 100%;margin:0 auto;"></div></br>
<div style="width: 90%;height: 70px;margin: 0 5% 0 5%;float: none;">
    <div style="width: 33%;height: 100%; float: left;"><a href="productIN_step1.php"><img src="images/back.png" style="width: 70px;height: 70px;"/></a></div>
    <div style="width: 33%;height: 100%; float: left;font-family: SolaimanLipi !important;text-align: center;font-size: 36px;"><?php echo $storeName;?></div>
    <div style="width: 33%;height: 100%;float: left;text-align: right;font-family: SolaimanLipi !important;"><a href="" onclick="javasrcipt:window.open('product_list.php');return false;" style="float: right;text-align: center;padding-left: 20px;"><img src="images/productList.png" style="width: 100px;height: 70px;"/></br>সেলসস্টোর প্রোডাক্ট লিস্ট</a>
        <a href="" onclick="javasrcipt:window.open('all_ripd_product_list.php');return false;" style="float: right"><img src="images/allproductlist.png" style="width: 100px;height: 70px;"/></br>অল প্রোডাক্ট লিস্ট</a></div>
</div>
</br>
<div align="center" style="color: green;font-size: 26px; font-weight: bold; width: 90%;height: 20px;margin: 0 5% 0 5%;float: none;"><?php if($msg != "") echo $msg;?></div></br>
<form action="productIN_step2.php" method="post" >  
<fieldset style="border-width: 3px;margin:0 20px 0 20px;font-family: SolaimanLipi !important;">
<legend style="color: brown;">প্রবেশকৃত পণ্যের তালিকা</legend>
    <table width="100%" border="1" cellspacing="0" cellpadding="0" style="border-color:#000000; border-width:thin; font-size:18px;">
      <tr>
        <td width="3%" style="color: #0000cc;text-align: center;"><strong>ক্রম</strong></td>
         <td width="14%" style="color: #0000cc;text-align: center;"><strong>প্রোডাক্ট কোড</strong></td>
        <td width="27%" style="color: #0000cc;text-align: center;"><strong>প্রোডাক্টের নাম</strong></td>
        <td width="8%" style="color: #0000cc;text-align: center;"><strong>পরিমান</strong></td>
        <td width="11%" style="color: #0000cc;text-align: center;"><strong>প্রতি একক ক্রয়মূল্য (টাকা)</strong></td>
        <td width="11%" style="color: #0000cc;text-align: center;"><strong>প্রতি একক বিক্রয়মূল্য (টাকা)</strong></td>
        <td width="9%" style="color: #0000cc;text-align: center;"><strong>এক্সট্রা প্রফিট (টাকা)</strong></td>
        <td width="7%" style="color: #0000cc;text-align: center;"><strong>প্রফিট (টাকা)</strong></td>
        <td width="10%" style="color: #0000cc;text-align: center;"><strong>পিভি</strong><input type="hidden" id="currentPv" value="<?php echo $db_pv;?>" /></td>
      </tr>
    <?php
            $sl = 1;
            foreach($_SESSION['arrProductTemp'] as $key => $proinfo) {
                $buyingprice =  $proinfo['4'] + (($proinfo['3'] * $p_totalTransportCost) / ($p_totalBuyingPrice * $proinfo['2']));
                echo "<tr>
                        <td style='text-align: center;'>".english2bangla($sl)."</td>
                        <td style='text-align: left;padding-left:2px;'>$proinfo[1]</td>
                        <td style='text-align: left;'><input type='hidden' name='chartID[$sl]' value='$key' />$proinfo[0]</td>
                        <td style='text-align: center;'><input type='text' name='porQty[$sl]' value= '$proinfo[2]' readonly style='width:90%;height=100%;' /></td>
                        <td style='text-align: center;padding-right:2px;'><input type='text' name='proBuyingPrice[$sl]' id='proBuyingPrice[$sl]' value='$buyingprice' readonly style='width:95%;height=100%;text-align:right' /></td>
                        <td style='text-align: center;padding-right:2px;'><input type='text' name='proSellingPrice[$sl]' id='proSellingPrice[$sl]' style='width:95%;height=100%;text-align:right' onkeypress='return checkIt(event)' /></td>
                        <td style='text-align: center;'><input type='text' name='proXprofit[$sl]' id='proXprofit[$sl]' style='width:92%;height=100%;text-align:right' onkeypress='return checkIt(event)' onkeyup='calculate(this.value,$sl)' /></td>
                        <td style='text-align: center;'><input type='text' name='proProfit[$sl]' id='proProfit[$sl]' readonly style='width:90%;height=100%;text-align:right' /></td>
                        <td style='text-align: center;'><input type='text' name='proPV[$sl]' id='proPV[$sl]' readonly style='width:90%;height=100%;' /></td>
                        </tr>";
                $sl ++;
            }
?>
</table>
</fieldset>
    <input class="btn" name="entry" id="entry" type="submit" value="এন্ট্রি করুন" style="cursor:pointer;margin-left:45%;font-family: SolaimanLipi !important;" /></br></br>
</form>
<div style="background-color:#f2efef;border-top:1px #eeabbd dashed;padding:3px 50px;">
     <a href="http://www.comfosys.com" target="_blank"><img src="images/footer_logo.png"/></a> 
         RIPD Universal &copy; All Rights Reserved 2013 - Designed and Developed By <a href="http://www.comfosys.com" target="_blank" style="color:#772c17;">comfosys Limited<img src="images/comfosys_logo.png" style="width: 50px;height: 40px;"/></a>
</div>
  </div>
</body>
</html>
<?php
error_reporting(0);
session_start();
include_once 'includes/connectionPDO.php';
include_once 'includes/MiscFunctions.php';

$storeID = $_SESSION['loggedInOfficeID'];
$scatagory =$_SESSION['loggedInOfficeType'];
$check = 0; $msg ="";
$arr_left_qty= array();
$arr_ri8_qty = array();

$sql_runningpv = $conn->prepare("SELECT * FROM running_command ;");
$sql_runningpv->execute();
$pvrow = $sql_runningpv->fetchAll();
foreach ($pvrow as $value) {
    $current_pv = $value['pv_value'];
}
$inventstmt = $conn->prepare("SELECT * FROM inventory WHERE ins_productid= ? AND ins_ons_type=? AND ins_ons_id =? AND ins_product_type = ? ");
$up_invetory = $conn->prepare("UPDATE inventory SET ins_extra_profit= ?,ins_sellingprice=?, ins_buying_price=? ,ins_profit=? ,ins_pv=? , ins_lastupdate= NOW()
                                                    WHERE ins_product_type='package' AND ins_productid=? AND ins_ons_type=? AND ins_ons_id = ? ");
$stmtsel = $conn ->prepare( "SELECT * FROM package_info WHERE idpckginfo= ?");
$selectstmt2 = $conn ->prepare("SELECT * FROM package_details WHERE pckg_infoid = ?");
$selectstmt3 = $conn ->prepare("SELECT * FROM product_chart WHERE idproductchart= ? ");

if(isset($_POST['update']))
{
    $P_updatedpckgbuy = $_POST['updatebuy'];
    $P_updatedpckgsell = $_POST['updatesellprz'];
    $P_updatedpckgprofit = $_POST['updateprofit'];
    $P_updatedpckgxprofit = $_POST['updatexprofit'];
    $P_pckgid = $_POST['pckgID'];
    $P_pv = $_POST['updatepv'];  
    $yes= $up_invetory->execute(array($P_updatedpckgxprofit,$P_updatedpckgsell,$P_updatedpckgbuy,$P_updatedpckgprofit,$P_pv,$P_pckgid,$scatagory,$storeID));
    if($yes ==1)
    {$msg = "প্যাকেজটি সফলভাবে আপডেট হয়েছে";}
    else { $msg = "দুঃখিত প্যাকেজটি আপডেট হয়নি";}

}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html;" charset="utf-8" />
<link rel="stylesheet" href="css/style.css" type="text/css" media="screen" charset="utf-8"/>
<link rel="stylesheet" href="css/css.css" type="text/css" media="screen" />
<script type="text/javascript">
function numbersonly(e)
   {
        var unicode=e.charCode? e.charCode : e.keyCode
            if (unicode!=8)
            { //if the key isn't the backspace key (which we should allow)
                if (unicode<48||unicode>57) //if not a number
                return false //disable key press
            }
}
function checkIt(evt) // float value-er jonno***********************
    {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode ==8 || (charCode >47 && charCode <58) || charCode==46) {
        status = "";
        return true;
    }
    status = "This field accepts numbers only.";
    return false;
}
function beforeUpdate()
{
    var pv = document.getElementById('updatepv').value;
    if(pv <= 0)
        {
            return false;
        }
        else { return true; }
}
function getUpdate(xprofit) // after update pckg prices
{
   var run_pv = <?php echo $current_pv?>;
   var updatedbuy = Number(document.getElementById('updatebuy').value);
   var updatedsell = Number(document.getElementById('updatesellprz').value);
   var profit = updatedsell - (updatedbuy + xprofit);
   var pv = run_pv * profit;
   pv = (pv).toFixed(2);
   document.getElementById('updateprofit').value = profit;
   document.getElementById('updatepv').value = pv;
}
</script>
</head>
    
<body>
 <div id="maindiv">
     <?php if($msg != "") { ?>
        <div align="center" style="color: green;font-size: 26px; font-weight: bold; width: 90%;height: 100px;margin: 0 5% 0 5%;float: none;"><?php echo $msg;?></div></br>
    <?php } else {?>
  <div id="bush" style="width: 99.9%;font-family: SolaimanLipi !important;float: none;border: solid 1px #000;font-size: 14px;">
      <form method="post" action="" onsubmit="return beforeUpdate();">
        <div style="width: 100%;height: auto;float: none;">
            <table>
                <tr>
                    <td>
                        <table style="padding: 0px !important;">
                            <tr>
                                <td width="60%">
                                    <fieldset style="border-width: 2px;width: 95%;">
                                         <legend style="color: brown;">প্যাকেজ বিবরণ</legend>
                                         <?php
                                                    if(isset($_GET['pckgid']))
                                                    {
                                                        $pckgid = $_GET['pckgid'];
                                                        $stmtsel->execute(array($pckgid));
                                                        $all = $stmtsel->fetchAll();
                                                        foreach($all as $row)
                                                        {
                                                            $db_pckgname= $row['pckg_name'];
                                                            $db_pckgcode = $row['pckg_code'];
                                                        }
                                                        $arr_pro_chartid = array();
                                                        $arr_pro_qty = array();
                                                        $selectstmt2->execute(array($pckgid));
                                                        $getall = $selectstmt2->fetchAll();
                                                        foreach($getall as $row2)
                                                        {
                                                            array_push($arr_pro_chartid, $row2['product_chartid']);
                                                            array_push($arr_pro_qty, $row2['product_quantity']);
                                                        }
                                                    }
                                         ?>
                                         <b>প্যাকেজের নাম : </b><input type="text" id="pckgName" name="pckgName" readonly value="<?php echo $db_pckgname;?>"  style="width: 300px;"/><input type="hidden" name="pckgID"  value="<?php echo $pckgid;?>"/></br>
                                         <b>প্যাকেজ কোড &nbsp;: </b> <input type="text" id="pckgCode" name="pckgCode" readonly value="<?php echo $db_pckgcode;?>" style="width: 300px;"/></br></br>
                                         <table border="1" cellpadding="0" cellspacing="0" style="padding: 0px !important;font-size: 16px;">
                                             <thead style="background-color: #ffcccc">
                                                 <th width="21%">পণ্যের নাম</th>
                                                 <th width="9%">পরিমাণ</th>
                                                  <th width="12%">বর্তমান ক্রয়মূল্য</th>
                                                 <th width="14%">বর্তমান বিক্রয়মূল্য</th>
                                                 <th width="10%">বর্তমান প্রফিট</th>
                                                  <th width="10%">বর্তমান এক্সট্রা প্রফিট</th>
                                                 <th width="12%">বর্তমান পিভি</th>
                                             </thead>
                                             <tbody style="font-size: 16px;">
                                             <?php
                                                     $rowcount = count($arr_pro_chartid);
                                                            for($i = 0 ; $i< $rowcount; $i++)
                                                            {
                                                                $prochartid = $arr_pro_chartid[$i];
                                                                $proqty = $arr_pro_qty[$i];
                                                                $type = 'general';
                                                                $inventstmt->execute(array($prochartid,$scatagory,$storeID,$type));
                                                                $all = $inventstmt->fetchAll();
                                                                    foreach($all as $row)
                                                                    {
                                                                        $procode = $row['ins_product_code'];
                                                                        $proname = $row['ins_productname'];
                                                                        $probuy = $row['ins_buying_price'] * $proqty;
                                                                        $prosell = $row['ins_sellingprice'] * $proqty;
                                                                        $proprofit = $row['ins_profit'] * $proqty;
                                                                        $proxprofit = $row['ins_extra_profit'] * $proqty;
                                                                        $propv = $row['ins_pv'];
                                                                        $buysum = $buysum+$probuy;
                                                                        $sellsum = $sellsum+$prosell;
                                                                        $profitsum = $profitsum+$proprofit;
                                                                        $xprofitsum = $xprofitsum+$proxprofit;
                                                                        $pvsum = $pvsum+$propv;
                                                                      }
                                                                   echo "<tr>
                                                                      <td>$proname</td>
                                                                      <td align='center'>$proqty</td>
                                                                      <td>$probuy </td>
                                                                      <td>$prosell</td>
                                                                      <td>$proprofit</td>
                                                                      <td align='center'>$proxprofit </td>
                                                                      <td >$propv</td>
                                                                      </tr>";
                                                                   array_push($arr_left_qty,$proqty);
                                                            }                                         
             ?>
                                             </tbdoy></table></br>         
                                    </fieldset>
                                </td>
                                <td width="40%">
                                    <fieldset style="border-width: 3px;width: 96%;height: auto;">
                                         <legend style="color: brown;">ব্যবহারযোগ্য পণ্যের পরিমাণ</legend>
                                         <table width="100%" border="1" cellpadding="0" cellspacing="0" style="padding: 0px !important;font-size: 16px;">
                                             <thead style="background-color: #ffcccc">
                                                 <th width="28%">পণ্যের কোড</th>
                                                 <th width="44%">পণ্যের নাম</th>
                                                 <th width="28%">ব্যবহারযোগ্য পরিমাণ</th>
                                             </thead>
                                             <tbody style="font-size: 16px;">
                                             <?php
                                                        $rowNumber = count($arr_pro_chartid);
                                                            for($i = 0 ; $i< $rowNumber; $i++)
                                                            {
                                                                $prochartid = $arr_pro_chartid[$i];
                                                                $proqty = $arr_pro_qty[$i];
                                                                $type='general';
                                                                $inventstmt->execute(array($prochartid,$scatagory,$storeID,$type));
                                                                $all4 = $inventstmt->fetchAll();
                                                                    if(count($all4) !=0)
                                                                    {
                                                                    foreach($all4 as $row4)
                                                                    {
                                                                        $procode = $row4['ins_product_code'];
                                                                        $proname = $row4['ins_productname'];
                                                                        $qty = $row4['ins_how_many'];
                                                                    }
                                                                   echo "<tr><td>$procode </td>
                                                                             <td>$proname</td>
                                                                             <td align='center'>$qty</td></tr>";
                                                                   
                                                                   array_push($arr_ri8_qty,$qty);
                                                                    }
                                                                else
                                                               {
                                                                    $selectstmt3->execute(array($prochartid));
                                                                    $all3 = $selectstmt3->fetchAll();
                                                                    foreach($all3 as $row3)
                                                                    {
                                                                        $procode = $row3['pro_code'];
                                                                        $proname = $row3['pro_productname'];
                                                                    }
                                                                    echo "<tr><td>$procode </td>
                                                                             <td>$proname</td>
                                                                             <td align='center'>পণ্যটি নেই</td></tr>";
                                                                    $check = 1;
                                                                    array_push($arr_ri8_qty,0);
                                                                    }
                                                               }
                                                               $count = count($arr_left_qty);
                                                                for($j=0; $j<$count; $j++)
                                                                {
                                                                   if( $arr_ri8_qty[$j] < $arr_left_qty[$j])
                                                                   {
                                                                       $check =1;
                                                                   }
                                                                }
                                                             $str_left = implode("/", $arr_left_qty);
                                                             $str_ri8 = implode("/", $arr_ri8_qty);                                     
                                                  ?>
                                             </tbody>
                                         </table>
                                     </fieldset>
                                </td>
                            </tr>
                            <tr>
                                <td align="center" colspan="2">
                                    <fieldset style="border-width: 3px;width: 90%;">
                                    <legend style="color: brown;">বর্তমানে পণ্যসমূহের মোট মূল্য</legend>
                                         <b>বর্তমান মোট ক্রয়মূল্য &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: </b><input name="buyingprz" type="text" readonly style="text-align: right;" value="<?php echo $buysum;?>" /> টাকা</br>
                                         <b>বর্তমান মোট বিক্রয়মূল্য &nbsp;&nbsp;&nbsp;: </b><input type="text" readonly style="text-align: right;" value="<?php echo $sellsum;?>" /> টাকা</br>
                                         <b>বর্তমান মোট প্রফিট&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: </b><input type="text" readonly style="text-align: right;" value="<?php echo $profitsum;?>"/> টাকা</br>
                                         <b>বর্তমান মোট এক্সট্রা প্রফিট : </b><input type="text" readonly style="text-align: right;" value="<?php echo $xprofitsum;?>" /> টাকা</br>
                                         <b>বর্তমান মোট পিভি&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: </b><input type="text" readonly style="text-align: right;" value="<?php echo $pvsum;?>" /> টাকা
                                    </fieldset>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <?php
                                                $type='package';
                                                        $inventstmt->execute(array($pckgid,$scatagory,$storeID,$type));
                                                        $pckgall = $inventstmt->fetchAll();
                                                        foreach($pckgall as $pckgrow)
                                                        {
                                                           $db_pckgsell = $pckgrow['ins_sellingprice'];
                                                            $db_pckgpv= $pckgrow['ins_pv'];
                                                            $db_pckgxprofit = $pckgrow['ins_extra_profit'];
                                                            $db_pckgprofit= $pckgrow['ins_profit'];
                                                            $db_pckgbuy = $pckgrow['ins_buying_price'];
                                                        }
                                    ?>
                                    <fieldset style="border-width: 3px;width: 90%;">
                                    <legend style="color: brown;">বর্তমান প্যাকেজ মূল্য</legend>
                                    <b>বর্তমান প্যাকেজ ক্রয়মূল্য&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: </b><input id="currentpckgbuy" name="currentpckgbuy" type="text" readonly style="text-align: right;" value="<?php echo $db_pckgbuy;?>" /> টাকা</br>
                                        <b>বর্তমান প্যাকেজ বিক্রয়মূল্য&nbsp;&nbsp;&nbsp;&nbsp;: </b><input id="currentpckgprz" type="text" readonly style="text-align: right;" value="<?php echo $db_pckgsell;?>" /> টাকা</br>
                                        <b>বর্তমান প্যাকেজ এক্সট্রা প্রফিট : </b><input id="currentpckgxprft" type="text" readonly style="text-align: right;" value="<?php echo $db_pckgxprofit;?>" /> টাকা</br>
                                        <b>বর্তমান প্যাকেজ প্রফিট&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: </b><input id="currentpckgprft" type="text" readonly style="text-align: right;" value="<?php echo $db_pckgprofit;?>" /> টাকা</br>                                 
                                        <b>বর্তমান প্যাকেজ পিভি&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: </b><input id="currentpckgpv" type="text" readonly style="text-align: right;" value="<?php echo $db_pckgpv;?>" /></br>
                                    </fieldset>
                                </td>
                                <td>
                                    <fieldset style="border-width: 3px;width: 97%;">
                                    <legend style="color: brown;">আপডেট প্যাকেজ মূল্য</legend>
                                         <b>আপডেট প্যাকেজ ক্রয়মূল্য&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: </b><input id="updatebuy" name="updatebuy" onkeypress="return checkIt(event)" type="text" style="text-align: right;width: 100px;" value="<?php echo $db_pckgbuy;?>"  /> টাকা</br>
                                         <b>আপডেট প্যাকেজ বিক্রয়মূল্য&nbsp;&nbsp;&nbsp;&nbsp;: </b><input id="updatesellprz" name="updatesellprz" type="text" onkeypress="return checkIt(event)" style="text-align: right;width: 100px;" value="<?php echo $db_pckgsell;?>"/> টাকা</br>
                                         <b>আপডেট প্যাকেজ এক্সট্রা প্রফিট : </b><input id="updatexprofit" name="updatexprofit" type="text" style="text-align: right;width: 100px;" onkeypress="return checkIt(event)" onblur="getUpdate(this.value)" value="<?php echo $db_pckgxprofit;?>"/> টাকা</br>
                                         <b>আপডেটেট প্যাকেজ প্রফিট&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: </b><input id="updateprofit" name="updateprofit" readonly type="text" style="text-align: right;width: 100px;" value="<?php echo $db_pckgprofit;?>"  /> টাকা</br>
                                         <b>আপডেটেট প্যাকেজ পিভি&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: </b><input id="updatepv" name="updatepv" type="text" readonly style="text-align: right;width: 100px;" value="<?php echo $db_pckgpv;?>"/></br>
                                    </fieldset>
                                </td>
                            </tr>
                            <tr>
                                <td align="center" colspan="2"><input name="update" id="update" type="submit" value="মূল্য আপডেট করুন" style="cursor:pointer;width:120px;height: 25px;font-family: SolaimanLipi !important;" /></td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </div>
</form>
</div>
    <?php }?>
 </div>
</body>
</html>
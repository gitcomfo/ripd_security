<?php
error_reporting(0);
include 'includes/ConnectDB.inc';
include 'includes/connectionPDO.php';
include 'session.php';
include_once 'includes/MiscFunctions.php';
$storeName= $_SESSION['offname'];
$cfsID = $_SESSION['cfsid'];
$storeID = $_SESSION['offid'];
$scatagory = $_SESSION['catagory'];
$msg ="";
$sql_runningpv = mysql_query("SELECT * FROM running_pv ;"); 
$pvrow = mysql_fetch_assoc($sql_runningpv);
$current_pv = $pvrow['value_in_pv'];

 $selsql ="SELECT * FROM package_details WHERE pckg_infoid=?";
 $selstmt = $conn->prepare($selsql);

 $sqlins = "INSERT INTO package_inventory(pckg_infoid ,pckg_quantity ,pckg_pv, pckg_selling_price ,pckg_buying_price, pckg_profit, pckg_extraprofit, making_date, pckg_makerid, pckg_type, ons_type, ons_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ? ,?, ?, ?)";
 $insstmt = $conn ->prepare($sqlins);
    
if(isset($_POST['ok']))
{
    $P_pckgqty = $_POST['pckgQty'];
    $P_pckgName = $_POST['pckgName'];
    $P_pckgCode = $_POST['pckgCode'];
    $P_pckgID = $_POST['pckgID'];
    $str_chart = $_POST['pckgproid'];
    $str_qty = $_POST['pckgqty'];
    $arr_chart = explode(',', $str_chart);
    $arr_qty = explode(',', $str_qty);
  
}
if(isset($_POST['entry']))
{
    $P_pckgqty = $_POST['pckgQty'];
    $P_pckgName = $_POST['pckgName'];
    $P_pckgCode = $_POST['pckgCode'];
    $P_pckgID = $_POST['pckgID'];
    $P_pckgbuying = $_POST['pckgBuy'];
    $P_totalsell = $_POST['totalsellprz'];
    $P_totalprofit = $_POST['totalprofit'];
    $P_totalxprofit = $_POST['totalxprofit'];
    $P_profitless = $_POST['pckgprofitless'];
    $P_xprofitless = $_POST['pckgxprofitless'];
    $P_pckgselling = $_POST['pckgsellprz'];
    $P_pckgpv = $_POST['pckgpv'];
    $pckgprofit = $P_totalprofit - $P_profitless;
    $pckgxprofit = $P_totalxprofit - $P_xprofitless;
     $timestamp=time(); //current timestamp
     $date=date("Y/m/d", $timestamp);  
     $pckgtype = "making";
     $x = $insstmt->execute(array($P_pckgID, $P_pckgqty,$P_pckgpv, $P_pckgselling, $P_pckgbuying, $pckgprofit, $pckgxprofit, $date, $cfsID, $pckgtype, $scatagory, $storeID));
     
    if($x == 1)
       {
           $msg = "প্যাকেজটি সফলভাবে এন্ট্রি হয়েছে";
                    }
                    else { $msg = "দুঃখিত প্যাকেজটি এন্ট্রি হয়নি";}
         
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html;" charset="utf-8" />
<link rel="icon" type="image/png" href="images/favicon.png" />
<title>প্যাকেজের দাম নির্ধারণ</title>
<link rel="stylesheet" href="css/style.css" type="text/css" media="screen" charset="utf-8"/>
<script language="JavaScript" type="text/javascript" src="productsearch.js"></script>
<link rel="stylesheet" href="css/css.css" type="text/css" media="screen" />
 <script src="scripts/tinybox.js" type="text/javascript"></script>
<script type="text/javascript">
function ShowTime()
{
      var time=new Date()
      var h=time.getHours()
      var m=time.getMinutes()
      var s=time.getSeconds()
  
      m=checkTime(m)
      s=checkTime(s)
      document.getElementById('txt').value=h+" : "+m+" : "+s
      t=setTimeout('ShowTime()',1000)
      if(document.getElementById('pname').value !="")
          { document.getElementById("QTY").disabled = false;}
     else {document.getElementById("QTY").disabled = true;}
     
     if(document.getElementById('tretail').value !="")
          { document.getElementById("cash").disabled = false;}
     else {document.getElementById("cash").disabled = true;}
          
      a=Number(document.abc.QTY.value);
if (a!=0) {document.getElementById("addtoCart").disabled = false;}
  else {document.getElementById("addtoCart").disabled = true;}
  payable = Number(document.getElementById('gtotal').value);
  cash = Number(document.getElementById('cash').value);
  if(cash<payable)
  {document.getElementById("print").disabled = true;}
  else {document.getElementById("print").disabled =false ;}

}

function getPrice(xprofitless)
{
   
    var sell = document.getElementById('totalsellprz').value;
    var profitless = document.getElementById('pckgprofitless').value;
    var totalless = profitless + xprofitless;
    var pckgprice = sell - totalless;
    document.getElementById('pckgsellprz').value = pckgprice;
    var cur_pv = <?php echo $current_pv?>;
    var prev_profit = document.getElementById('totalprofit').value;
    var cur_profit = prev_profit -  profitless;
    var pv = ((cur_pv)/100) * cur_profit;
    pv = (pv).toFixed(2);
     document.getElementById('pckgpv').value = pv;
}
    function checkTime(i)
    {
      if (i<10)
      {
        i="0" + i
      }
      return i
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
    </script>
</head>
    
<body onLoad="ShowTime()">
    <div id="maindiv">
        <div id="header" style="width:100%;height:100px;background-image: url(images/background.gif);background-repeat: no-repeat;background-size:100% 100%;margin:0 auto;"></div></br>
        <div style="width: 90%;height: 70px;margin: 0 5% 0 5%;float: none;">
    <div style="width: 33%;height: 100%; float: left;"><a href="packageWelcome.php"><img src="images/back.png" style="width: 70px;height: 70px;"/></a></div>
    <div style="width: 33%;height: 100%; float: left;font-family: SolaimanLipi !important;text-align: center;font-size: 36px;"><?php echo $storeName;?></div>
    <div style="width: 33%;height: 100%;float: left;text-align: right;font-family: SolaimanLipi !important;"><a href="" onclick="javasrcipt:window.open('package_list.php');return false;"><img src="images/packagelist.png" style="width: 100px;height: 70px;"/></br>প্যাকেজ লিস্ট</a></div>
</div></br>
<?php
    if($msg != "")
    {
?>
<div align="center" style="color: green;font-size: 26px; font-weight: bold; width: 90%;height: 20px;margin: 0 5% 0 5%;float: none;"><?php if($msg != "") echo $msg;?></div></br>
    <?php } 
    else { ?>
    
    <form method="post" action="package_price_entry.php">
    <div style="width: 100%;float: none;font-family: SolaimanLipi !important;">
        <fieldset style="border-width: 3px;width: 97%;">
         <legend style="color: brown;">প্যাকেজের দাম নির্ধারণ</legend>
         <b>প্যাকেজের নাম&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: </b><input type="text" id="pckgName" name="pckgName" readonly value="<?php echo $P_pckgName;?>" style="width: 300px;"/></br>
         <b>প্যাকেজ কোড&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: </b><input type="text" id="pckgCode" name="pckgCode" readonly value="<?php echo $P_pckgCode;?>" style="width: 300px;"/></br>
         <b>প্যাকেজের পরিমাণ : </b><input type="text" id="pckgQty" name="pckgQty" readonly value="<?php echo $P_pckgqty;?>" style="width: 300px;"/>
         <input type="hidden" name="pckgID" readonly value="<?php echo $P_pckgID;?>"/></br></br>
         <table border="1">
             <thead style="background-color: #ffcccc">
                 <th>পণ্যের কোড</th>
                 <th>পণ্যের নাম</th>
                 <th>পরিমাণ</th>
                 <th>ক্রয় মূল্য</th>
                 <th>বিক্রয় মূল্য</th>
                 <th>প্রফিট</th>
                 <th>এক্সট্রা প্রফিট</th>
                 <th>পিভি</th>
             </thead>
             <?php
                         $rowcount = count($arr_chart);
                                                            for($i = 0 ; $i< $rowcount; $i++)
                                                            {
                                                                $prochartid = $arr_chart[$i];
                                                                $proqty = $arr_qty[$i];
                                                                $sql = "SELECT * FROM inventory WHERE ins_productid= ? AND ins_ons_type=? AND ins_ons_id =? AND ins_product_type = 'general'";
                                                                $selectstmt = $conn ->prepare($sql);
                                                                $selectstmt->execute(array($prochartid,$scatagory,$storeID));
                                                                $all = $selectstmt->fetchAll();
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
                                                                   echo "<tbody>
                                                                      <td>$procode </td>
                                                                      <td>$proname</td>
                                                                      <td align='center'>$proqty</td>
                                                                      <td>$probuy </td>
                                                                      <td>$prosell</td>
                                                                      <td align='center'>$proprofit</td>
                                                                      <td align='center'>$proxprofit </td>
                                                                      <td align='center'>$propv</td>
                                                                      </tbody>";
                                                            }                                         
             ?>
    </table>
         <div align="right" style="margin-top:10px;margin-right:100px;font-family: SolaimanLipi !important;">
             <b>মোট বিক্রয় মূল্য :</b><input name="totalsellprz" type="hidden" id="totalsellprz" size="20" style="text-align:right;" value="<?php echo $sellsum;?>" readonly/> <?php echo english2bangla($sellsum);?> টাকা</br>
            <b>মোট প্রফিট&nbsp;:</b> <input name="totalprofit" type="hidden" id="totalprofit" size="20" readonly style="text-align:right;" value="<?php echo $profitsum;?>"/> <?php echo english2bangla($profitsum);?> টাকা</br>
            <b>মোট এক্সট্রা প্রফিট :</b><input name="totalxprofit" type="hidden" id="totalxprofit" size="20" style="text-align:right;" value="<?php echo $xprofitsum;?>" readonly/> <?php echo english2bangla($xprofitsum);?> টাকা</br>
            <b>মোট পিভি&nbsp;:</b> <input name="totalpv" type="hidden" id="totalpv" size="20" readonly style="text-align:right;" value="<?php echo $pvsum;?>"/> <?php echo english2bangla($pvsum);?> টাকা
            <input type="hidden" name="pckgBuy" readonly value="<?php echo $probuy;?>"/>
</div>
         <hr></hr>
         <div align="left" style="margin-top:10px;margin-right:100px;font-family: SolaimanLipi !important;">
             <b>প্যাকেজ প্রফিট হ্রাস &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: </b><input name="pckgprofitless" type="text" id="pckgprofitless" onkeypress="return checkIt(event)" size="20" style="text-align:right;" /> টাকা</br>
            <b>প্যাকেজ এক্সট্রা প্রফিট হ্রাস : </b><input name="pckgxprofitless" type="text" id="pckgxprofitless" onkeypress="return checkIt(event)" onblur="getPrice(this.value)" size="20" style="text-align:right;" /> টাকা</br>
            <b>প্যাকেজ বিক্রয় মূল্য &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</b><input name="pckgsellprz" type="text" id="pckgsellprz" size="20" style="text-align:right;" readonly/> টাকা</br>
            <b>প্যাকেজ পিভি &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</b> <input name="pckgpv" type="text" id="pckgpv" size="20" readonly style="text-align:right;" /> টাকা
</div>
    </fieldset>
 </div>
    <input name="entry" id="entry" type="submit" value="সেভ করুন"style="cursor:pointer;margin-left:45%;font-family: SolaimanLipi !important;" /></br></br>
    </from> <?php }?>
</div>
<div style="background-color:#f2efef;border-top:#009 dashed 2px;padding:3px 50px;">
     <a href="http://www.comfosys.com" target="_blank"><img src="images/footer_logo.png"/></a> 
         RIPD Universal &copy; All Rights Reserved 2013 - Designed and Developed By <a href="http://www.comfosys.com" target="_blank" style="color:#772c17;">comfosys Limited<img src="images/comfosys_logo.png" style="width: 50px;height: 40px;"/></a>
</div>
   
</body>
</html>

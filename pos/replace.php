<?php
error_reporting(0);
include 'includes/ConnectDB.inc';
include 'session.php';
include_once 'includes/MiscFunctions.php';
if(isset($_GET['edit']))
{
    $recitid= $_GET['edit'];
    mysql_query("DELETE FROM replace_temp WHERE reciptID = '$recitid';") or exit ("ha ha ha");
}
$storeName= $_SESSION['offname'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html;" charset="utf-8" />
<link rel="icon" type="image/png" href="images/favicon.png" />
<title>ক্রয়কৃত পণ্য পরিবর্তন</title>
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
    function checkTime(i)
    {
      if (i<10)
      {
        i="0" + i
      }
      return i
    }
    </script>
	
<!--===========================================================================================================================-->
<script>
function searchRecipt(str_key) // for sold recipt no. search box
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
            if(str_key.length ==0)
                {
                   document.getElementById('searchResult').style.display = "none";
               }
                else
                    {document.getElementById('searchResult').style.visibility = "visible";
                document.getElementById('searchResult').setAttribute('style','position:absolute;top:36%;left:28%;width:290px;z-index:10;padding:5px;border: 1px inset black; overflow:auto; height:105px; background-color:#F5F5FF;');
                    }
                document.getElementById('searchResult').innerHTML=xmlhttp.responseText;
        }
        xmlhttp.open("GET","includes/searchProcessForReplace.php?searchKey="+str_key,true);
        xmlhttp.send();	
}

</script>  
</head>
    
<body onLoad="ShowTime()">

    <div id="maindiv">
<div id="header" style="width:100%;height:100px;background-image: url(images/background.gif);background-repeat: no-repeat;background-size:100% 100%;margin:0 auto;"></div></br>
    <div style="width: 90%;height: 70px;margin: 0 5% 0 5%;float: none;">
    <div style="width: 33%;height: 100%; float: left;"><a href="welcome.php?back=1"><img src="images/back.png" style="width: 70px;height: 70px;"/></a></div>
    <div style="width: 33%;height: 100%; float: left;font-family: SolaimanLipi !important;text-align: center;font-size: 36px;"><?php echo $storeName;?></div>
    <div style="width: 33%;height: 100%;float: left;text-align: right;font-family: SolaimanLipi !important;"><a href="" style="text-decoration: none;" onclick="javasrcipt:window.open('product_list.php');return false;"><img src="images/productList.png" style="width: 100px;height: 70px;"/></br>প্রোডাক্ট লিস্ট</a></div>
</div>
</br>
<div class="wraper" style="width: 80%;font-family: SolaimanLipi !important;">
<fieldset style="border-width: 3px;width: 100%;">
         <legend style="color: brown;">চালান নং খুঁজুন</legend>
    <div class="top" style="width: 100%;height: auto;">
        <div class="topleft" style="width: 60%;float: left;"><b>চালান নং&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b>
            : <input type="text" id="searchRecipt" name="searchRecipt" onKeyUp="searchRecipt(this.value);" autocomplete="off" style="width: 300px;"/></br>
        <div id="searchResult"></div>
    </div>
        <div style="width: 40%;float: left;text-align: right;"><b> তারিখ ও সময় : </b><input name="date" style="width:75px;"type="text" value="<?php echo date("d/m/Y"); ?>" readonly/>
    <input name="time" type="text" id="txt" size="7" readonly/></div>
    
    </div>
</fieldset></div>

  <fieldset   style="border-width: 3px;margin:0 20px 50px 20px;font-family: SolaimanLipi !important;">
<legend style="color: brown;">ক্রয়কৃত পণ্যের তালিকা</legend>
  
    <?php
if (isset($_GET['id']))
    {
        $G_sales_sum_id = $_GET['id'];
                    $result = mysql_query("SELECT * FROM sales_summery WHERE idsalessummery= '$G_sales_sum_id';");
                        $row = mysql_fetch_assoc($result);
                        $db_storeType=$row["sal_store_type"];
                        $db_storeID=$row["sal_storeid"];
                        $db_sellDate=strtotime($row["sal_salesdate"]);
                        $db_sellTime=$row["sal_salestime"];
                        $db_selltotalbuy = $row['sal_total_buying_price'];
                        $db_sellTotalAmount=$row["sal_totalamount"];
                        $db_sellTotalPV=$row["sal_totalpv"];
                        $db_givenTaka=$row["sal_givenamount"];
                        $db_invoiceno=$row['sal_invoiceno'];
                        $db_buyerid= $row['sal_buyerid'];
                        $db_buyertype= $row['sal_buyer_type'];
                        if($db_storeType=='s_store')
                        {
                            $storereslt = mysql_query("SELECT * FROM sales_store WHERE idSales_store= '$db_storeID';");
                            $storerow = mysql_fetch_assoc($storereslt);
                            $db_storename = $storerow['salesStore_name'];
                            $db_storeacc = $storerow['account_number'];
                        }
                        elseif($db_storeType=='office')
                        {
                            $storereslt = mysql_query("SELECT * FROM office WHERE idOffice= '$db_storeID';");
                            $storerow = mysql_fetch_assoc($storereslt);
                            $db_storename = $storerow['office_name'];
                            $db_storeacc = $storerow['account_number'];
                        }
                        
                        if($db_buyertype == 'employee' || $db_buyertype == 'customer')
                        {
                            $selcetresult = mysql_query("SELECT * FROM cfs_user WHERE idUser= '$db_buyerid';");
                            $selectrow = mysql_fetch_assoc($selcetresult);
                            $db_custname = $selectrow['account_name'];
                            $db_custacc = $selectrow['account_number'];
                        
                        }
                        elseif($db_buyertype == 'unregcustomer' )
                        {
                            $selcetresult = mysql_query("SELECT * FROM unregistered_customer WHERE idunregcustomer= '$db_buyerid';");
                            $selectrow = mysql_fetch_assoc($selcetresult);
                            $db_custname = $selectrow['unregcust_name'];
                            $db_custacc = $selectrow['unregcust_mobile'];
                        
                        }
                        elseif($db_buyertype == 'office' )
                        {
                            $storereslt = mysql_query("SELECT * FROM office WHERE idOffice= '$db_buyerid';");
                            $storerow = mysql_fetch_assoc($storereslt);
                            $db_custname = $storerow['office_name'];
                            $db_custacc = $storerow['account_number'];
                        }
                        
                        elseif($db_buyertype == 's_store' )
                        {
                            $storereslt = mysql_query("SELECT * FROM sales_store WHERE idSales_store= '$db_buyerid';");
                            $storerow = mysql_fetch_assoc($storereslt);
                            $db_custname = $storerow['salesStore_name'];
                            $db_custacc = $storerow['account_number'];
                        }
                        
                        $timestamp=time(); //current timestamp
                        $timestamp_start= strtotime( date("Y/m/d",$db_sellDate));
                        $timestamp_end =strtotime(date("Y/m/d", $timestamp));
                        $difference = abs($timestamp_end - $timestamp_start); 
                        $numberDays = $difference/86400;  // 86400 seconds in one day
                        if($numberDays > 31)
                        {
                            $errmsg= "দুঃখিত, আপনার রিপ্লেস সময়সীমা অতিক্রান্ত হয়েছে।";
                            echo "<div align='center' id='errordiv' style='color:red; background-color: antiquewhite;padding: 2px;'>$errmsg</div>";
                        }
            else
            {
                        $showDate = english2bangla(date("d/m/Y",$db_sellDate));
                        $showTime = english2bangla(date('h:i A', strtotime($db_sellTime)));
                        
                         echo "<div id='resultTable' style='background-color: antiquewhite;padding: 2px;'>
                                <form name='replaceForm' action='showReplace.php?ssumid=$G_sales_sum_id' method='post'>";
                        echo "<div style='width: 65%;float: left;'><b>চালান নং:</b><input type='hidden' name='reciptID' value= '$db_invoiceno' /> $db_invoiceno</br>
                        <b>ক্রেতার নাম: <input type='hidden' name='buyname' value='$db_custname' /><input type='hidden' name='buytype' value='$db_buyertype' />$db_custname</b> </br><b>ক্রেতার অ্যাকাউন্ট নং : <input type='hidden' name='buyacc' value='$db_custacc' /><input type='hidden' name='buyid' value='$db_buyerid' />$db_custacc</b></div>
                        <div style='width: 35%;float: left;'><b>তারিখঃ</b> $showDate  &nbsp;&nbsp;&nbsp;<b>সময়ঃ</b> $showTime</br>
                        <b>সেলস স্টোরের নাম: $db_storename</b> </br><b>সেলস স্টোরের অ্যাকাউন্ট নং : $db_storeacc</b></div></br>";
    
                            echo "<table width='100%' border='1' cellspacing='0' cellpadding='0' style='border-color:#000000; border-width:thin; font-size:18px;'>
                          <tr>
                            <td width='23%'><div align='center'><strong>প্রোডাক্ট কোড</strong></div></td>
                            <td width='30%'><div align='center'><strong>প্রোডাক্ট-এর নাম</strong></div></td>
                            <td width='11%'><div align='center'><strong>ক্রয়কৃত পরিমাণ</strong></div></td>
                            <td width='12%'><div align='center'><strong>মোট</strong></div></td>
                            <td width='6%'><div align='center'><strong>পি.ভি.</strong></div></td>
                            <td width='20%'><div align='center'><strong>ফেরত দিন</strong></div></td>
                          </tr>";
                                           
                        $productReslt = mysql_query("SELECT * FROM sales WHERE sales_summery_idsalessummery='$G_sales_sum_id';");
                        while($rowSales = mysql_fetch_assoc($productReslt))
                        {
                            $db_itemqty=$rowSales["quantity"];
                            $db_itemprice=$rowSales["sales_amount"];
                            $db_itemTotalPV=$rowSales["sales_pv"];
                            $db_inventID=$rowSales["inventory_idinventory"];
                            $db_itembuy= $rowSales['sales_buying_price'];
                                                        
                            $itemReslt = mysql_query("SELECT * FROM inventory WHERE idinventory='$db_inventID';");
                            $rowInventory = mysql_fetch_assoc($itemReslt);
                            $db_proCode=$rowInventory["ins_product_code"];
                            $db_proName=$rowInventory["ins_productname"];
                                 echo '<tr>';
                                echo "<td><div align='left'><input type='hidden' name='proCode[]' value=$db_proCode />$db_proCode</div></td>";
                                echo "<td><div align='left'><input type='hidden' name='proname[]' value= '$db_proName' />&nbsp;&nbsp;&nbsp;$db_proName</div></td>";
                                echo '<td><div align="center"><input type="hidden" name="soldqty[]" value='.$db_itemqty.'/>'.english2bangla($db_itemqty).'</div></td>';
                                echo '<td><div align="center"><input type="hidden" name="soldprice[]" value='.$db_itemprice.'/>'.english2bangla($db_itemprice).'<input type="hidden" name="inventSumID[]" value='.$db_inventID.'/></div></td>';
                                echo '<td><div align="center">'.english2bangla($db_itemTotalPV).'</div></td>';
                                 echo '<td><input type="text" id="replaceUnit" name="replaceUnit[]" style="width: 94%;text-align:right"/></td>';
                                echo '</tr>';
                        }
                        echo "<td colspan='5' ><div align='right'><strong>সর্বমোট:</strong>&nbsp;</div></td>
                        <td colspan='2' width='13%'><div align='right'>".english2bangla($db_sellTotalAmount)."</div></td>
                        </tr>
                        <tr>
                            <td colspan='5' ><div align='right'><strong>মোট পি.ভি.</strong>&nbsp;</div></td>
                            <td colspan='2' width='13%'><div align='right'>".english2bangla($db_sellTotalPV)."</div></td>
                        </tr>
                        <tr>
                            <td colspan='5' ><div align='right'><strong>টাকা গ্রহন:</strong>&nbsp;</div></td>
                            <td colspan='2' width='13%'><div align='right'>".english2bangla($db_givenTaka)."</div></td>
                        </tr></table>";   
                        echo "</br><div align='center' style='width: 100%;float: left;'><input type='submit' name='replace' value='রিপ্লেস করুন' style='font-family: SolaimanLipi !important;' /></div>";
                        echo "</form></div>";
              }
    }
?>
   
</fieldset>

<div style="background-color:#f2efef;border-top:#009 dashed 2px;padding:3px 50px;">
     <a href="http://www.comfosys.com" target="_blank"><img src="images/footer_logo.png"/></a> 
         RIPD Universal &copy; All Rights Reserved 2013 - Designed and Developed By <a href="http://www.comfosys.com" target="_blank" style="color:#772c17;">comfosys Limited<img src="images/comfosys_logo.png" style="width: 50px;height: 40px;"/></a>
</div>
  </div>
</body>
</html>

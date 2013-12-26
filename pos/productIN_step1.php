<?php
error_reporting(0);
session_start();
include_once 'includes/ConnectDB.inc';
include_once 'includes/connectionPDO.php';
include_once 'includes/MiscFunctions.php';
$sel_product_chart =$conn->prepare("SELECT pro_code FROM product_chart");
$sel_product_chart->execute();
$result = $sel_product_chart->fetchAll();
echo $result[0][0];
$searched = array();
$input = "VG";
foreach($result as $value) {
       if (strpos($input, $value[0]) != false){
		$searched[] = $value[0];
       }
}
print_r($searched);

$timestamp=time(); //current timestamp
$da=date("d/m/Y", $timestamp);
	
$storeName= $_SESSION['loggedInOfficeName'];
$cfsID = $_SESSION['userIDUser'];
$storeID = $_SESSION['loggedInOfficeID'];
$scatagory =$_SESSION['loggedInOfficeType'];
$msg = "";
$sql2 = "SELECT * FROM product_temp WHERE store_id = ? AND store_type= ?";
$selectstmt = $conn->prepare($sql2);

$sql = "INSERT INTO product_purchase(in_ons_type, in_onsid, in_input_date ,input_type ,in_howmany , in_pv , in_extra_profit ,in_profit, in_buying_price, in_sellingprice, cfs_user_idUser, Product_chart_idproductchart) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);

if(isset($_POST['entry']))
{
    $selectstmt->execute(array($storeID,$scatagory));
    $all = $selectstmt->fetchAll();
    foreach($all as $row)
    {
//       $db_storetype=$row['store_type'];
//        $db_proCode=$row['pro_code'];
        $db_proname=$row['pro_name'];
        $db_buy=$row['buying_price'];
        $db_sell=$row['selling_price'];
        $db_profit=$row['profit'];
        $db_xtraprofit=$row['xtra_profit'];
        $db_pv=$row['pv'];
        $db_qty=$row['qty'];
        $db_chartid=$row['product_chart_id'];
        $intype = 'in';
        $timestamp=time(); //current timestamp
        $date=date("Y/m/d", $timestamp);
       $yes = $stmt->execute(array($scatagory, $storeID, $date, $intype, $db_qty, $db_pv,  $db_xtraprofit, $db_profit, $db_buy, $db_sell, $cfsID, $db_chartid));
       if($yes == 1)
       {
           $msg = "প্রোডাক্ট সফলভাবে এন্ট্রি হয়েছে";
       }
       else { $msg = "দুঃখিত প্রোডাক্ট এন্ট্রি হয়নি";}
      }
     $sql3 = "DELETE FROM product_temp WHERE store_id = ? AND store_type= ? ";
$delstmt = $conn ->prepare($sql3);
$delstmt->execute(array($storeID,$scatagory));
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
 <script src="scripts/tinybox.js" type="text/javascript"></script>
<style type="text/css">
.prolinks:focus{
    background-color: cadetblue;
    color: yellow !important;
}
.prolinks:hover{
    background-color: cadetblue;
    color: yellow !important;
}
</style>
<script type="text/javascript">
function beforeSave()
{
      a=Number(document.abc.QTY.value);
      b=Number(document.abc.profit.value);
    if ((a != 0) && (b != 0)) 
    {
        document.getElementById("addtoCart").readonly = false; return true;}
    else {
        alert("প্রফিট অথবা পরিমান ০ হতে পারবে না");
            document.getElementById("addtoCart").readonly = true; return false;}
 }
    </script>
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
function calculateProfit(val)
{
    var xprofit = Number(val);
    var buying = Number(document.getElementById('buyPrice').value);
    var selling = Number(document.getElementById('sellPrice').value);
    var profit = selling - (buying + xprofit);
    document.getElementById('profit').value = profit;
}
</script>
<script>
function searchCode(where) // productlist-er code search box
{
   var xmlhttp;
   var str_key = document.getElementById('amots').value;
   
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
                if(str_key.length ==0)
                {
                   document.getElementById('layer2').style.display = "none";
               }
                else
                    {document.getElementById('layer2').style.display = "inline"; }
                document.getElementById('layer2').innerHTML=xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET","searchsuggest2.php?searchcode="+str_key+"&where="+where,true);
        xmlhttp.send();
    
}
function searchName(where) // productlist-er name search box
{
   var xmlhttp;
   var str_key = document.getElementById('allsearch').value;
   
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
                if(str_key.length ==0)
                {
                   document.getElementById('searchResult').style.display = "none";
               }
                else
                    {document.getElementById('searchResult').style.display = "inline"; }
                document.getElementById('searchResult').innerHTML=xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET","searchsuggest2.php?searchname="+str_key+"&where="+where,true);
        xmlhttp.send();
    
}
</script>  

 <script type="text/javascript">
 function pinGenerate()
	{ TINY.box.show({url:'pinGenerator.php',animate:true,close:true,boxid:'error',top:100,width:400,height:100}); }
 </script>   
</head>
    
<body>

    <div id="maindiv">
<div id="header" style="width:100%;height:100px;background-image: url(../images/sara_bangla_banner_1.png);background-repeat: no-repeat;background-size:100% 100%;margin:0 auto;"></div></br>
<div style="width: 90%;height: 70px;margin: 0 5% 0 5%;float: none;">
    <div style="width: 33%;height: 100%; float: left;"><a href="../pos_management.php"><img src="images/back.png" style="width: 70px;height: 70px;"/></a></div>
    <div style="width: 33%;height: 100%; float: left;font-family: SolaimanLipi !important;text-align: center;font-size: 36px;"><?php echo $storeName;?></div>
    <div style="width: 33%;height: 100%;float: left;text-align: right;font-family: SolaimanLipi !important;"><a href="" onclick="javasrcipt:window.open('product_list.php');return false;" style="float: right;text-align: center;padding-left: 20px;"><img src="images/productList.png" style="width: 100px;height: 70px;"/></br>সেলসস্টোর প্রোডাক্ট লিস্ট</a>
        <a href="" onclick="javasrcipt:window.open('all_ripd_product_list.php');return false;" style="float: right"><img src="images/allproductlist.png" style="width: 100px;height: 70px;"/></br>অল প্রোডাক্ট লিস্ট</a></div>
</div>
</br>
<div align="center" style="color: green;font-size: 26px; font-weight: bold; width: 90%;height: 20px;margin: 0 5% 0 5%;float: none;"><?php if($msg != "") echo $msg;?></div></br>
    <form action="addProduct.php" method="post" name="abc">
     <fieldset style="border-width: 3px;margin:0 20px 0 20px;font-family: SolaimanLipi !important;">
         <legend style="color: brown;">পণ্য প্রবেশ</legend>
    <div class="top" style="width: 100%;">
        <div class="topleft" style="float: left;width: 30%;"><b>প্রোডাক্ট কোড :</b>
      <input type="text" id="amots" name="amots" onKeyUp="searchCode('productIN_step1.php');" autocomplete="off" style="width: 300px;"/>
      <div id="layer2"style="width:400px;position:absolute;top:52%;left:8%;z-index:1;padding:5px;border: 1px solid #000000; overflow:auto; height:105px; background-color:#F5F5FF;display: none;" ></div></br></br>
      <b>প্রোডাক্ট নাম&nbsp;&nbsp; : </b><input type="text" id="allsearch" name="allsearch" onKeyUp="searchName('productIN_step1.php');" autocomplete="off" style="width: 300px;"/>
      <div  id="searchResult"style="position:absolute;top:64%;left:8%;width:400px;z-index:10;padding:5px;border: 1px inset black; overflow:auto; height:105px; background-color:#F5F5FF;display: none;" ></div>
    </div>
    <div class="topright" style="float:left; width: 70%;">
    <?php
            if (isset($_GET['code']))
            {
                        $G_proChartID = $_GET['code'];
                        $result = mysql_query("SELECT * FROM product_chart WHERE idproductchart = '$G_proChartID'");
                            $row = mysql_fetch_assoc($result);
                            $db_proname=$row["pro_productname"];
                           $db_procode=$row["pro_code"];
                           $db_prounit=$row["pro_unit"];
                     }
    ?>
<table width="100%" cellspacing="0"  cellpadding="0" style="border: #000000 inset 1px; font-size:20px;">
  <tr>
      <td><span style="color: #03C;"> প্রোডাক্ট-এর কোড: </span><input name="pcode" id="pcode" type="text" value="<?php echo $db_procode; ?>" style="border:0px;font-size: 18px;width: 250px;" readonly/>
          <input name="proChartID" type="hidden" value="<?php echo $G_proChartID; ?>"/></td>
      <td colspan="2"><span style="color: #03C;">চালান নং </span> <input name="chalanNo" id="chalanNo" type="text" style="width:200px;" readonly value="<?php echo  get_time_random_no(10);?>" /></td>
      
  </tr>
  <tr>
      <td ><span style="color: #03C;"> প্রোডাক্ট-এর নাম: </span><input name="pname" id="pname" type="text" value="<?php echo $db_proname; ?>" style="border:0px;font-size: 18px;width: 310px;" readonly/></td>
          <td  colspan="2"><span style="color: #03C;">মোট ক্রয়মূল্য</span> <input name="buyPrice" id="buyPrice" type="text" onkeypress="return checkIt(event)" style="width:100px;"/> টাকা</td>
      
  </tr>
  <tr>
    <td><span style="color: #03C;"> প্রোডাক্ট-এর একক:</span> <input name="unit" id="unit" type="text" readonly="readonly" style="border:0px;font-size: 18px;width: 250px;" value="<?php echo $db_prounit;?>"/></td>
      <td><span style="color: #03C;"> পরিমাণ</span> <input name="QTY" id="QTY" type="text" onkeypress=' return numbersonly(event)'  style="width:100px;" value="0"/></td>
    <td><input type="submit" onclick="return beforeSave();" name="addButton" id="addtoCart" style="height:100px; width: 100px;background-image: url('images/addToInventory.jpeg');background-repeat: no-repeat;background-size:100% 100%;cursor:pointer;"  value="" readonly /></td>
    </tr>
</table>
</div>
</div>
</fieldset></form>

  <fieldset style="border-width: 3px;margin:0 20px 0 20px;font-family: SolaimanLipi !important;">
<legend style="color: brown;">প্রবেশকৃত পণ্যের তালিকা</legend>
    <table width="100%" border="1" cellspacing="0" cellpadding="0" style="border-color:#000000; border-width:thin; font-size:18px;">
      <tr>
        <td width="15%"><div align="center"><strong>প্রোডাক্ট কোড</strong></div></td>
        <td width="20%"><div align="center"><strong>প্রোডাক্ট-এর নাম</strong></div></td>
        <td width="10%"><div align="center"><strong>ক্রয় মূল্য</strong></div></td>
        <td width="11%"><div align="center"><strong>বিক্রয় মূল্য</strong></div></td>
        <td width="8%"><div align="center"><strong>প্রফিট</strong></div></td>
        <td width="11%"><div align="center"><strong>এক্সট্রা প্রফিট</strong></div></td>
        <td width="7%"><div align="center"><strong>পি.ভি.</strong></div></td>
         <td width="9%"><div align="center"><strong>পরিমাণ</strong></div></td>
        <td width="9%">&nbsp;</td>
      </tr>
    <?php
$getresult = mysql_query("SELECT * FROM product_temp where store_id = $storeID AND store_type='$scatagory' ") or exit ('query failed');
while($row = mysql_fetch_array($getresult))
  {
      echo '<tr>';
      echo '<td><div align="left">'.$row['pro_code'].'</div></td>';
        echo '<td><div align="left">&nbsp;&nbsp;&nbsp;'.$row['pro_name'].'</div></td>';
        echo '<td><div align="center">'.english2bangla($row['buying_price']).'</div></td>';
        echo '<td><div align="center">'.english2bangla($row['selling_price']).'</div></td>';
        echo '<td><div align="center">'.english2bangla($row['profit']).'</div></td>';
        echo '<td><div align="center">'.english2bangla($row['xtra_profit']).'</div></td>';
        echo '<td><div align="center">'.english2bangla($row['pv']).'</div></td>';
        echo '<td><div align="center">'.english2bangla($row['qty']).'</div></td>';
        echo "<td><a style='text-decoration:none;display:block' href=delete.php?storeID=".$storeID."&code=".$row['pro_code']."&storeCat=".$scatagory.">Remove</a></td>";
        echo '</tr>';
}
?>
</table>
</fieldset>
<form action="productIN.php" method="post" >
    <input class="btn" name="entry" id="entry" type="submit" value="এন্ট্রি করুন" style="cursor:pointer;margin-left:45%;font-family: SolaimanLipi !important;" /></br></br>
</form>
<div style="background-color:#f2efef;border-top:1px #eeabbd dashed;padding:3px 50px;">
     <a href="http://www.comfosys.com" target="_blank"><img src="images/footer_logo.png"/></a> 
         RIPD Universal &copy; All Rights Reserved 2013 - Designed and Developed By <a href="http://www.comfosys.com" target="_blank" style="color:#772c17;">comfosys Limited<img src="images/comfosys_logo.png" style="width: 50px;height: 40px;"/></a>
</div>
  </div>
</body>
</html>
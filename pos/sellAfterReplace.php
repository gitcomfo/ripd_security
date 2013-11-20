<?php
error_reporting(0);
include 'includes/ConnectDB.inc';
include_once 'includes/MiscFunctions.php';
include 'session.php';
$G_replaceRecipt= $_SESSION['recipt'];
$storeName= $_SESSION['offname'];
$cfsID = $_SESSION['cfsid'];
$storeID = $_SESSION['offid'];
$scatagory = $_SESSION['catagory'];
$timestamp=time(); //current timestamp
$da=date("m/d/Y", $timestamp);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html;" charset="utf-8" />
<link rel="icon" type="image/png" href="images/favicon.png" />
<title>বিক্রয় কার্যক্রম</title>
<link rel="stylesheet" href="css/style.css" type="text/css" media="screen" charset="utf-8"/>
<script language="JavaScript" type="text/javascript" src="suggest.js"></script>
<script language="JavaScript" type="text/javascript" src="productsearch.js"></script>
<link rel="stylesheet" href="css/css.css" type="text/css" media="screen" />
 <script src="scripts/tinybox.js" type="text/javascript"></script>
<style type="text/css">
a:link {
	text-decoration: none;
}
a:visited {
	text-decoration: none;
}
a:hover {
	text-decoration: none;
}
a:active {
	text-decoration: none;
}
</style>
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
  if(cash < payable)
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
<script language="javascript" type="text/javascript">

function multiply(){

a=Number(document.abc.QTY.value);
b=Number(document.abc.PPRICE.value);
c=a*b;
document.abc.TOTAL.value=c;
z=Number(document.abc.ProPV.value);
pv=a*z;
document.abc.SubTotalPV.value=pv;

if (a!=0) // some logic to determine if it is ok to go
    {document.getElementById("addtoCart").disabled = false;}
  else // in case it was enabled and the user changed their mind
    {document.getElementById("addtoCart").disabled = true;}
}
function addCommas(nStr){
 nStr += '';
 x = nStr.split('.');
 x1 = x[0];
 x2 = x.length > 1 ? '.' + x[1] : '';
 var rgx = /(\d+)(\d{3})/;
 while (rgx.test(x1)) {
  x1 = x1.replace(rgx, '$1' + ',' + '$2');
 }
 return x1 + x2;
}

</script>
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
</script>
<script language="javascript" type="text/javascript">
function minus(){
a=Number(document.mn.cash.value);
b=Number(document.mn.gtotal.value);
c=a-b;
document.mn.change.value=c;
}
</script>
<script>
function getXMLHTTP() { 
		var xmlhttp=false;	
		try{ xmlhttp=new XMLHttpRequest();}
		catch(e){		
			try{xmlhttp= new ActiveXObject("Microsoft.XMLHTTP");}
			catch(e){
                                                                        try{xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");}
				catch(e1){xmlhttp=false;}
                                                                    }
                                                  }
		 return xmlhttp;
}
	
function getCurrencyCode(strURL)
{		
	var req = getXMLHTTP();		
	if (req) 
	{
                    req.onreadystatechange = function()
		{
		if (req.readyState == 4) 
			{			
                                                        if (req.status == 200)
				{ document.getElementById('cur_code').value=req.responseText;} 
				else 
				{alert("There was a problem while using XMLHTTP:\n" + req.statusText);}
			}				
		 }			
		 req.open("GET", strURL, true);
		 req.send(null);
	}			
}

function showCustInfo(custType)
{
    var reqst = getXMLHTTP();		
	if (reqst) 
	{
                    reqst.onreadystatechange = function()
		{
		if (reqst.readyState == 4) 
			{			
                                                        if (reqst.status == 200)
				{ document.getElementById('customerInfo').innerHTML=reqst.responseText;} 
				else 
				{alert("There was a problem while using XMLHTTP:\n" + reqst.statusText);}
			}				
		 }			
		 reqst.open("GET","includes/showCustomerInfo.php?type="+custType+"&selltype=1", true);
		 reqst.send(null);
	}		
}
function showPayType(payType)
{
var reqst = getXMLHTTP();		
	if (reqst) 
	{
                    reqst.onreadystatechange = function()
		{
		if (reqst.readyState == 4) 
			{			
                                                        if (reqst.status == 200)
				{ document.getElementById('payInfo').innerHTML=reqst.responseText;} 
				else 
				{alert("There was a problem while using XMLHTTP:\n" + reqst.statusText);}
			}				
		 }			
		 reqst.open("GET","includes/showPayInfo.php?type="+payType+"&selltype=1", true);
		 reqst.send(null);
	}		
}
</script>  
 <script language="javascript" type="text/javascript">
 
function checkNumeric(objName)
  {
    var lstLetters = objName;

    var lstReplace = lstLetters.replace(/\,/g,'');
  }   
 </script>
 <script type="text/javascript">
 function pinGenerate()
	{ TINY.box.show({url:'pinGenerator.php',animate:true,close:true,boxid:'error',top:100,width:400,height:100}); }
 </script>   
</head>
    
<body onLoad="ShowTime()">

    <div id="maindiv">
<div id="header" style="width:100%;height:100px;background-image: url(images/background.gif);background-repeat: no-repeat;background-size:100% 100%;margin:0 auto;"></div></br>
<div style="width: 90%;height: 70px;margin: 0 5% 0 5%;float: none;">
    <div style="width: 33%;height: 100%; float: left;"><a href="welcome.php?back=1"><img src="images/back.png" style="width: 70px;height: 70px;"/></a></div>
    <div style="width: 33%;height: 100%; float: left;font-family: SolaimanLipi !important;text-align: center;font-size: 36px;"><?php echo $storeName;?></div>
    <div style="width: 33%;height: 100%;float: left;text-align: right;font-family: SolaimanLipi !important;"><a href="" onclick="javasrcipt:window.open('product_list.php');return false;"><img src="images/productList.png" style="width: 100px;height: 70px;"/></br>প্রোডাক্ট লিস্ট</a></div>
</div>
</br>
    <div class="wraper" style="width: 100%;font-family: SolaimanLipi !important;">
        <form action="addorder.php?selltype=3" method="post" name="abc">
     <fieldset style="border-width: 3px;margin:0 20px 0 20px;">
         <legend style="color: brown;">পণ্যের বিবরণী</legend>
    <div class="top" style="width: 100%;">
        <div class="topleft" style="float: left;width: 40%;"><b>প্রোডাক্ট কোড :</b>
            <input type="text" id="amots" name="amots" onKeyUp="bleble('sellAfterReplace.php');" autocomplete="off" style="width: 290px;"/>
      <div style="width:280px;position:absolute;top:282px;left:232px;z-index:1;padding:5px;border: 1px solid #000000; overflow:auto; height:105px; background-color:#F5F5FF;display: none;" id="layer2" ></div></br></br>
      <b>প্রোডাক্ট নাম&nbsp;&nbsp; :</b>
      <input type="text" id="allsearch" name="allsearch" onKeyUp="searchProductAll('sellAfterReplace.php');" autocomplete="off" style="width: 290px;"/>
      <div style="position:absolute;top:340px;left:232px;width:285px;z-index:10;padding:5px;border: 1px inset black; overflow:auto; height:105px; background-color:#F5F5FF;display: none;" id="searchResult" ></div>
    </div>
    <div class="topright" style="float:left; width: 60%;">
<?php
	if (isset($_GET['code']))
     	{
	 $G_summaryID = $_GET['code'];
                    $result = mysql_query("SELECT * FROM inventory WHERE idinventory = '$G_summaryID'");
                        $row = mysql_fetch_assoc($result);
                        $db_proname=$row["ins_productname"];
                        $db_price=$row["ins_sellingprice"];
                        $db_inventoryid=$row["idinventory"];
                        $db_procode=$row["ins_product_code"];
                        $db_proPV=$row["ins_pv"];
                        $db_buyingprice = $row['ins_buying_price'];
                    }
?>
        <table width="100%" cellspacing="0"  cellpadding="0" style="border: #000000 inset 1px; font-size:20px;">
  <tr>
      <td width="58%" height="50"><span style="color: #03C;font-size: 25px;"> প্রোডাক্ট-এর নাম: </span><input name="PNAME" id="pname" type="text" value="<?php echo $db_proname; ?>" style="border:0px;font-size: 18px;width:250px;" readonly/>
        <input name="inventoryID" type="hidden" value="<?php echo $db_inventoryid; ?>"/>      
      <input name="procode" type="hidden" value="<?php echo $db_procode; ?>"/><input name="propv" id="ProPV" type="hidden" value="<?php echo $db_proPV; ?>"/>
      <input name="less" type="hidden"/></td>
      <td colspan="2"><span style="color: #03C;"> তারিখ ও সময়: </span><input name="date" style="width:75px;"type="text" value="<?php echo $da; ?>" readonly/>
    <input name="time" type="text" id="txt" size="7" readonly/>
    </td>
  </tr>
  <tr>
      <td  width="60%"><span style="color: #03C;font-size: 25px;">প্রোডাক্ট-এর মূল্য: </span><input name="PPRICE" id="PPRICE" type="text" value="<?php echo $db_price ;?>" style="border:0px;font-size: 18px;width:250px;"/><input name="buyprice" id="buyprice" type="hidden" value="<?php echo $db_buyingprice; ?>"/></td>
      <td><span style="color: #03C;"> পরিমাণ : </span><input name="QTY" id="QTY" type="text" onkeyup="multiply()" onkeypress="return checkIt(event)" style="width:100px;"/></td>
      <td width="8%" rowspan="3"><input type="submit" name="addButton" style="height:120px; width: 100px;background-image: url('images/add to cart.jpg');background-repeat: no-repeat;background-size:100% 100%;cursor:pointer;" id="addtoCart" value="" /></td>
    </tr>
  <tr>
    <td  width="60%"><span style="color: #03C;font-size: 25px;">চালান নং: </span><input name="recipt" type="text" id="recipt" value="<?php echo $_SESSION['SESS_MEMBER_ID']; ?>" style="border:0px; width:200px;font-size: 18px;" readonly="readonly"/>
    </td>
      <td><span style="color: #03C;"> মোট&nbsp;&nbsp;&nbsp;&nbsp;: </span><input name="TOTAL" id="TOTAL" type="text" readonly="readonly" style="width:100px;" />
    <input name="subTotalpv" id="SubTotalPV"type="hidden"/></td>
    </tr>
   <tr>
    <td  width="60%"><span style="color: #03C;font-size: 25px;">পরিবর্তিত চালান নং: </span><input name="Rrecipt" type="text" id="Rrecipt" value="<?php echo $G_replaceRecipt ?>" style="border:0px; width:200px;font-size: 18px;" readonly="readonly"/>
    </td>
       <td colspan="2">
           <span style="color: #03C;">ফেরতকৃত : </span><input name="replacedTotal" id="replacedTotal" type="text" readonly="readonly" value="<?php echo $_SESSION['repMoney'];?>" style="width:80px;"/>
       </td>
       </tr>
</table>
</div>
</div>
</fieldset></form></div>

  <fieldset style="border-width: 3px;margin:0 20px 0 20px;font-family: SolaimanLipi !important;">
<legend style="color: brown;">ক্রয়কৃত পণ্যের তালিকা</legend>
    <table width="100%" border="1" cellspacing="0" cellpadding="0" style="border-color:#000000; border-width:thin; font-size:18px;font-family: SolaimanLipi !important;">
      <tr>
        <td width="17%"><div align="center"><strong>প্রোডাক্ট কোড</strong></div></td>
        <td width="27%"><div align="center"><strong><span style="width:130px;">প্রোডাক্ট-এর নাম</span></strong></div></td>
        <td width="14%"><div align="center"><strong>পরিমাণ</strong></div></td>
        <td width="16%"><div align="center"><strong>খুচরা মূল্য</strong></div></td>
        <td width="19%"><div align="center"><strong>মোট টাকা</strong></div></td>
        <td width="7%">&nbsp;</td>
      </tr>
    <?php
$f=$_SESSION['SESS_MEMBER_ID'];
$getresult = mysql_query("SELECT * FROM sales_temp where sales_receiptid = '$f'; ") or exit ('query failed');
while($row = mysql_fetch_array($getresult))
  {
      echo '<tr>';
      echo '<td><div align="left">'.$row['sales_product_code'].'</div></td>';
        echo '<td><div align="left">&nbsp;&nbsp;&nbsp;'.$row['sales_product_name'].'</div></td>';
        echo '<td><div align="center">'.english2bangla($row['sales_product_qty']).'</div></td>';
        echo '<td><div align="center">'.english2bangla($row['sales_product_sellprice']).'</div></td>';
        echo '<td><div align="center">'.english2bangla($row['sales_totalamount']).'</div></td>';
        echo "<td><a href=delete.php?selltype=sellAfterReplace.php&code=".$row['sales_product_code'].">Remove</a></td>";
        echo '</tr>';
}
?>
</table>
</fieldset>
<form action="previewAfterReplaced.php" method="post" name="mn" id="suggestSearch">
<div align="right" style="margin-top:10px;margin-right:100px;font-family: SolaimanLipi !important;"><b>সর্বমোট :</b>
<?php
                $recipt=$_SESSION['SESS_MEMBER_ID'];
                $G_usedMoney = $_SESSION['used'];
                $result = mysql_query("SELECT sum(sales_totalamount) FROM sales_temp where sales_receiptid = '$recipt'; ");
                while($row2 = mysql_fetch_array($result))
                  { $finalTotal=$row2['sum(sales_totalamount)']; }
                  $togive = $finalTotal - $_SESSION['repMoney'];
                  if($togive <0)
                  { $togive = 0;}
                  else $togive= $togive;
                  $replaceBack = $_SESSION['repMoney'] - $finalTotal;
                  if($replaceBack < 0)
                  {
                      $replaceBack = 0;
                  }
?>
    <input name="tretail" type="hidden" id="tretail" size="20" style="text-align:right;" value="<?php echo $finalTotal;?>" readonly/><?php echo english2bangla($finalTotal);?> টাকা</br>
    <b>প্রদেয় টাকা&nbsp;:</b> <input name="gtotal" type="hidden" id="gtotal" size="20" onblur="checkNumeric(this);" readonly style="text-align:right;" value="<?php echo $togive?>"/><?php echo english2bangla($togive);?> টাকা</br>
<b>রিপ্লেস বাবদ ফেরত:</b> <input name="getFromReplace" type="hidden" id="getFromReplace" size="20" readonly style="text-align:right;" value="<?php echo $replaceBack;?>"/><?php echo english2bangla($replaceBack);?> টাকা
</div>
    
<fieldset style="border-width: 3px;padding-bottom:50px;margin:0 20px 0 20px;font-family: SolaimanLipi !important;">
<legend style="color: brown;">মূল্য পরিশোধ</legend>
<b>পেমেন্ট টাইপ :</b>
<select name="payType" id="payType" onchange="showPayType(this.value)" style="font-size: 20px;font-family: SolaimanLipi !important;">
    <option value="0">-সিলেক্ট করুন-</option>
    <option value="1">ক্যাশ</option>
    <option value="2">অ্যাকাউন্ট</option>
</select>
</br>
  <div id="payInfo" class="text" style="margin-top: 10px;"></div></br></br>
    <input name="print" id="print" type="submit" value="বিক্রয় করুন" style="cursor:pointer;margin-left:42%;font-family: SolaimanLipi !important;" />
    </fieldset>
  </form>
<div style="background-color:#f2efef;border-top:#009 dashed 2px;padding:3px 50px;">
     <a href="http://www.comfosys.com" target="_blank"><img src="images/footer_logo.png"/></a> 
         RIPD Universal &copy; All Rights Reserved 2013 - Designed and Developed By <a href="http://www.comfosys.com" target="_blank" style="color:#772c17;">comfosys Limited<img src="images/comfosys_logo.png" style="width: 50px;height: 40px;"/></a>
</div>
  </div>
</body>
</html>

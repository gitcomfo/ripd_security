<?php
error_reporting(0);
session_start();
include_once 'includes/ConnectDB.inc';
include_once 'includes/connectionPDO.php';
include_once 'includes/MiscFunctions.php';
if(isset($_SESSION['calanArray']))
    {
        unset($_SESSION['calanArray']);
    }
if (!isset($_SESSION['chalanNO']))
{
 $_SESSION['chalanNO'] = get_time_random_no(10);
}
$storeName= $_SESSION['loggedInOfficeName'];
$cfsID = $_SESSION['userIDUser'];
$storeID = $_SESSION['loggedInOfficeID'];
$scatagory =$_SESSION['loggedInOfficeType'];

$sel_product_chart = $conn->prepare("SELECT * FROM product_chart WHERE idproductchart = ? ");

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
function beforeSave()
{
      a=Number(document.abc.QTY.value);
      b=Number(document.abc.buyPrice.value);
    if ((a != 0) && (b != 0)) 
    {
        document.getElementById("addtoCart").readonly = false; return true;}
    else {
            document.getElementById("addtoCart").readonly = true; return false;}
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
function addToTable() // to add into temporary array*******************
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
                location.reload();
            }
        }
        var id = document.getElementById("proChartID").value;
        var name = document.getElementById("pname").value;
        var code = document.getElementById("pcode").value;
        var totalqty = Number(document.getElementById("QTY").value);
        var totalamount = Number(document.getElementById("buyPrice").value);
        xmlhttp.open("GET","includes/inProductTemporary.php?name="+name+"&code="+code+"&totalQty="+totalqty+"&amount="+totalamount+"&chartID="+id,true);
        xmlhttp.send();    
}
function deleteProduct(id) // to add into temporary array*******************
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
                location.reload();
            }
        }
        xmlhttp.open("GET","includes/inProductTemporary.php?type=del&chartID="+id,true);
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
    <div style="width: 33%;height: 100%;float: left;text-align: right;font-family: SolaimanLipi !important;"><a href="" onclick="javasrcipt:window.open('product_list.php');return false;" style="float: right;text-align: center;padding-left: 20px;"><img src="images/productList.png" style="width: 100px;height: 70px;"/></br>সেলসস্টোর প্রোডাক্ট লিস্ট</a>
        <a href="" onclick="javasrcipt:window.open('all_ripd_product_list.php');return false;" style="float: right"><img src="images/allproductlist.png" style="width: 100px;height: 70px;"/></br>অল প্রোডাক্ট লিস্ট</a></div>
</div>
</br>
     <fieldset style="border-width: 3px;margin:0 20px 0 20px;font-family: SolaimanLipi !important;">
         <legend style="color: brown;">পণ্য প্রবেশ</legend>
    <div class="top" style="width: 100%;">
        <div class="topleft" style="float: left;width: 30%;">
            <b>প্রোডাক্ট কোড</b>
            <input type="text" id="amots" name="amots" onKeyUp="searchCode('productIN_step1.php')" autocomplete="off" style="width: 300px;"/>
            <div id="layer2"style="width:400px;position:absolute;top:52%;left:8%;z-index:1;padding:5px;border: 1px solid #000000; overflow:auto; height:105px; background-color:#F5F5FF;display: none;" ></div></br></br>
            <b>প্রোডাক্ট নাম</b><input type="text" id="allsearch" name="allsearch" onKeyUp="searchName('productIN_step1.php');" autocomplete="off" style="width: 300px;"/>
            <div  id="searchResult"style="position:absolute;top:64%;left:8%;width:400px;z-index:10;padding:5px;border: 1px inset black; overflow:auto; height:105px; background-color:#F5F5FF;display: none;" ></div>
        </div>
    <div class="topright" style="float:left; width: 70%;">
    <?php
            if (isset($_GET['code']))
            {
                        $G_proChartID = $_GET['code'];
                        $sel_product_chart->execute(array($G_proChartID));
                        $result = $sel_product_chart->fetchAll();
                        foreach ($result as $row) {
                           $db_proname=$row["pro_productname"];
                           $db_procode=$row["pro_code"];
                           $db_prounit=$row["pro_unit"];
                     }
            }
    ?>
<table width="100%" cellspacing="0"  cellpadding="0" style="border: #000000 inset 1px; font-size:20px;">
  <tr>
      <td><span style="color: #03C;"> প্রোডাক্ট-এর কোড: </span><input name="pcode" id="pcode" type="text" value="<?php echo $db_procode; ?>" style="border:0px;font-size: 18px;width: 250px;" readonly/>
          <input id="proChartID" type="hidden" value="<?php echo $G_proChartID; ?>"/></td>
      <td colspan="2"><span style="color: #03C;">চালান নং </span> <input name="chalanNo" id="chalanNo" type="text" style="width:200px;" readonly value="<?php echo $_SESSION['chalanNO'];?>" /></td>     
  </tr>
  <tr>
      <td ><span style="color: #03C;"> প্রোডাক্ট-এর নাম: </span><input name="pname" id="pname" type="text" value="<?php echo $db_proname; ?>" style="border:0px;font-size: 18px;width: 310px;" readonly/></td>
          <td  colspan="2"><span style="color: #03C;">মোট ক্রয়মূল্য</span> <input name="buyPrice" id="buyPrice" type="text" onkeypress="return checkIt(event)" style="width:100px;"/> টাকা</td>
  </tr>
  <tr>
    <td><span style="color: #03C;"> প্রোডাক্ট-এর একক:</span> <input name="unit" id="unit" type="text" readonly="readonly" style="border:0px;font-size: 18px;width: 250px;" value="<?php echo $db_prounit;?>"/></td>
      <td><span style="color: #03C;"> পরিমাণ</span> <input name="QTY" id="QTY" type="text" onkeypress=' return numbersonly(event)'  style="width:100px;" value="0"/></td>
    <td><input type="button" onclick="addToTable()" name="addButton" id="addtoCart" style="height:100px; width: 100px;background-image: url('images/addToInventory.jpeg');background-repeat: no-repeat;background-size:100% 100%;cursor:pointer;"  value="" /></td>
    </tr>
</table>
</div>
</div>
</fieldset>
<form action="productIN_step2.php" method="post" >
  <fieldset style="border-width: 3px;margin:0 20px 0 20px;font-family: SolaimanLipi !important;">
    <legend style="color: brown;">প্রবেশকৃত পণ্যের তালিকা</legend>
    <table width="100%" border="1" cellspacing="0" cellpadding="0" style="border-color:#000000; border-width:thin; font-size:18px;">
      <tr>
          <td width="3%" style="color: #0000cc;text-align: center;"><strong>ক্রম</strong></td>
          <td width="19%" style="color: #0000cc;text-align: center;"><strong>প্রোডাক্ট কোড</strong></td>
        <td width="37%" style="color: #0000cc;text-align: center;"><strong>প্রোডাক্টের নাম</strong></td>
        <td width="8%" style="color: #0000cc;text-align: center;"><strong>পরিমান</strong></td>
        <td width="13%" style="color: #0000cc;text-align: center;"><strong>সর্বমোট মূল্য (টাকা)</strong></td>
        <td width="14%" style="color: #0000cc;text-align: center;"><strong>প্রতি একক মূল্য (টাকা)</strong></td>
        <td width="6%">&nbsp;</td>
      </tr>
        <tbody id="tablebody">
        <?php
            $sl = 1;$total =0;
            foreach($_SESSION['arrProductTemp'] as $key => $proinfo) {
                $slNo = english2bangla($sl);
                echo '<tr>
                        <td style="text-align: center;">'.$slNo.'</td>
                        <td style="text-align: left;padding-left:2px;">'.$proinfo['1'].'</td>
                        <td style="text-align: left;">'.$proinfo['0'].'</td>
                        <td style="text-align: center;">'.english2bangla($proinfo['2']).'</td>
                        <td style="text-align: right;padding-right:2px;">'.english2bangla($proinfo['3']).'</td>
                        <td style="text-align: right;padding-right:2px;">'.english2bangla($proinfo['4']).'</td>
                        <td style="text-align: center;"><img src="images/del.png" style="cursor:pointer;" width="20px" height="20px" onclick="deleteProduct('.$key.')" /></td></tr>';
                $sl ++;
                $total = $total + $proinfo['3'];
            }
        ?>
        </tbody>
</table>
    <table width="100%" cellspacing="0" cellpadding="0" style="border: 1px solid black;  font-size:18px;">
        <tr>
            <td>সর্বমোট ক্রয়মূল্য</td>
            <td>: <input type="text" id="totalBuyingPrice" name="totalBuyingPrice" style="text-align: right;" readonly value="<?php echo $total?>" /> টাকা</td>
        </tr>
        <tr>
            <td>পরিবহন খরচ</td>
            <td>: <input type="text" id="transportCost" name="transportCost" style="text-align: right;" onkeypress="return checkIt(event)" /> টাকা</td>
            <td rowspan="3">মন্তব্য</br><textarea name="transportComment"></textarea></td>
        </tr>
        <tr>
            <td>অন্যান্য খরচ</td>
            <td>: <input type="text" id="otherCost" name="otherCost" style="text-align: right;" onkeypress="return checkIt(event)" /> টাকা</td>
        </tr>
        <tr>
            <td>চালান কপি</td>
            <td>: <input type="file" name="calanCopy" /><input type="hidden" /> </td>
        </tr>
    </table>
</fieldset>
    <input class="btn" name="next" id="next" type="submit" value="বিস্তারিত দেখুন" style="cursor:pointer;margin-left:45%;font-family: SolaimanLipi !important;" /></br></br>
</form>
<div style="background-color:#f2efef;border-top:1px #eeabbd dashed;padding:3px 50px;">
     <a href="http://www.comfosys.com" target="_blank"><img src="images/footer_logo.png"/></a> 
         RIPD Universal &copy; All Rights Reserved 2013 - Designed and Developed By <a href="http://www.comfosys.com" target="_blank" style="color:#772c17;">comfosys Limited<img src="images/comfosys_logo.png" style="width: 50px;height: 40px;"/></a>
</div>
  </div>
</body>
</html>
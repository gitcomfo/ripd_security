<?php
error_reporting(0);
include 'session.php';
include 'includes/ConnectDB.inc';
include_once 'includes/MiscFunctions.php';
function get_catagory()
{
    echo  "<option value=0> -সিলেক্ট করুন- </option>";
    $catagoryRslt= mysql_query("SELECT DISTINCT pro_catagory, pro_cat_code FROM product_catagory ORDER BY pro_catagory;");
    while($catrow = mysql_fetch_assoc($catagoryRslt))
    {
	echo  "<option value=".$catrow['pro_cat_code'].">".$catrow['pro_catagory']."</option>";
    }
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html;" charset="utf-8" />
<link rel="icon" type="image/png" href="images/favicon.png" />
<title>পণ্যের তালিকা</title>
<link rel="stylesheet" href="css/style.css" type="text/css" media="screen" charset="utf-8"/>
<script language="JavaScript" type="text/javascript" src="productsearch.js"></script>
<link rel="stylesheet" href="css/css.css" type="text/css" media="screen" />
 <script src="scripts/tinybox.js" type="text/javascript"></script>
  <script type="text/javascript">
 function productUpdate(id)
	{ TINY.box.show({iframe:'updateProduct.php?proid='+id,width:800,height:400,opacity:30,topsplit:3,animate:true,close:true,maskid:'bluemask',maskopacity:50,boxid:'success'}); }
 </script>
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
function showTypes(catagory) // for types dropdown list
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
                document.getElementById('showtype').innerHTML=xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET","includes/searchProcess.php?id=t&catagory="+catagory,true);
        xmlhttp.send();	
}
function showBrands(type) // for brand dropdown list
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
                document.getElementById('brand').innerHTML=xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET","includes/searchProcess.php?id=b&type="+type,true);
        xmlhttp.send();	
}
function showClass(brand,protype) // for product name dropdown list
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
                document.getElementById('classi').innerHTML=xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET","includes/searchProcess.php?id=c&brand="+brand+"&type="+protype,true);
        xmlhttp.send();	
}
function showProduct(productChartId,idbrand,cataID) // show product details from selecting product from dropdown
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
                document.getElementById('resultTable').innerHTML=xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET","includes/searchProcess.php?id=all&chartID="+productChartId+"&idbrand="+idbrand+"&cataID="+cataID,true);
        xmlhttp.send();
}
function showTypeProducts(proCatID) // show products from selecting types
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
                document.getElementById('resultTable').innerHTML=xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET","includes/searchProcess.php?id=type&proCatID="+proCatID,true);
        xmlhttp.send();
}

function showBrandProducts(brandcode,procatid) // show products from brand
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
                document.getElementById('resultTable').innerHTML=xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET","includes/searchProcess.php?id=brnd&brandCode="+brandcode+"&procatid="+procatid,true);
        xmlhttp.send();
}
</script>  
</head>
    
<body onLoad="ShowTime()">

    <div id="maindiv">
<div id="header" style="width:100%;height:100px;background-image: url(images/background.gif);background-repeat: no-repeat;background-size:100% 100%;margin:0 auto;"></div></br>
    <div style="width: 100%;height: 50px;font-family: SolaimanLipi !important;text-align: center;font-size: 36px;"><?php echo $storeName;?></div></br>
<div class="wraper" style="width: 80%;font-family: SolaimanLipi !important;">
<fieldset style="border-width: 3px;width: 100%;">
         <legend style="color: brown;">প্রোডাক্ট লিস্ট ফিল্টার</legend>
    <div class="top" style="width: 100%;height: auto;">
        <div class="topleft" style="width: 100%;"><b>পণ্য খুঁজুন&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b>
            : <input type="text" id="allsearch" name="allsearch" onKeyUp="searchProductAll('product_list.php');" autocomplete="off" style="width: 300px;"/></br>
        <div style="position:absolute;top:262px;left:400px;width:290px;z-index:10;padding:5px;border: 1px inset black; overflow:auto; height:105px; background-color:#F5F5FF;display: none;" id="searchResult"></div>
    </div></br></br>
    <div style="float: left;width: 25%;"><b>পণ্যের ক্যাটাগরি</b></br>
      <select id="catagorySearch" name="catagorySearch" onchange="showTypes(this.value)" style="width: 200px;font-family: SolaimanLipi !important;">
                <?php echo get_catagory(); ?>
            </select>
        </div>
        <div style="float: left;width: 25%;"><b>পণ্যের টাইপ</b></br>
            <span id="showtype">
            <select style="width: 200px;font-family: SolaimanLipi !important;">
                </select></span>
        </div>
        <div style="float: left;width: 25%;"><b>ব্র্যান্ড / গ্রুপ</b></br>
            <span id="brand">
            <select id="brandSearch" name="brandSearch" style="width: 200px;font-family: SolaimanLipi !important;">
            </select></span>
        </div>
        <div style="float: left;width: 25%;"><b>প্রকার</b></br>
            <span id="classi">
            <select id="classification" name="classification"  style="width: 200px;font-family: SolaimanLipi !important;">
                </select></span>
        </div>
    </div>
</fieldset></div>

  <fieldset   style="border-width: 3px;margin:0 20px 50px 20px;font-family: SolaimanLipi !important;">
<legend style="color: brown;">পণ্যের তালিকা</legend>
<div id="resultTable">
    <table width="100%" border="1" cellspacing="0" cellpadding="0" style="border-color:#000000; border-width:thin; font-size:18px;">
      <tr>
          <td width="8%"><div align="center"><strong>ক্রমিক নং</strong></div></td>
        <td width="23%"><div align="center"><strong>প্রোডাক্ট কোড</strong></div></td>
        <td width="30%"><div align="center"><strong>প্রোডাক্ট-এর নাম</strong></div></td>
        <td width="11%"><div align="center"><strong>পর্যাপ্ত পরিমাণ</strong></div></td>
        <td width="12%"><div align="center"><strong>খুচরা মূল্য</strong></div></td>
        <td width="10%"><div align="center"><strong>পি.ভি.</strong></div></td>
        <td width="6%"><div align="center"><strong>করনীয়</strong></div></td>
      </tr>
    <?php
if (isset($_GET['code']))
     	{	
                    $G_summaryID = $_GET['code'];
                    $result = mysql_query("SELECT * FROM inventory WHERE idinventory = '$G_summaryID';");
                        $row = mysql_fetch_assoc($result);
                        $db_proname=$row["ins_productname"];
                        $db_price=english2bangla($row["ins_sellingprice"]);
                        $db_qty=english2bangla($row["ins_how_many"]);
                        $db_procode=$row["ins_product_code"];
                        $db_proPV=english2bangla($row["ins_pv"]);
                        $inventoryID= $row['idinventory'];
                        
      echo '<tr>';
      echo '<td><div align="center">১</div></td>';
      echo '<td><div align="left">'.$db_procode.'</div></td>';
        echo '<td><div align="left">&nbsp;&nbsp;&nbsp;'.$db_proname.'</div></td>';
        echo '<td><div align="center">'.$db_qty.'</div></td>';
        echo '<td><div align="center">'.$db_price.'</div></td>';
        echo '<td><div align="center">'.$db_proPV.'</div></td>';
        echo "<td><a onclick='productUpdate($inventoryID)' style='cursor:pointer;color:blue;'><u>আপডেট করুন</u></a></td>";
        echo '</tr>';
        }
?>
</table>
</div>
</fieldset>

<div style="background-color:#f2efef;border-top:#009 dashed 2px;padding:3px 50px;">
     <a href="http://www.comfosys.com" target="_blank"><img src="images/footer_logo.png"/></a> 
         RIPD Universal &copy; All Rights Reserved 2013 - Designed and Developed By <a href="http://www.comfosys.com" target="_blank" style="color:#772c17;">comfosys Limited<img src="images/comfosys_logo.png" style="width: 50px;height: 40px;"/></a>
</div>
  </div>
</body>
</html>

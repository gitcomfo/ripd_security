<?php
error_reporting(0);
include 'session.php';
include 'includes/ConnectDB.inc';
include 'includes/connectionPDO.php';
include_once 'includes/MiscFunctions.php';
$timestamp=time(); //current timestamp
$da=date("d/m/Y", $timestamp);
$storeName= $_SESSION['offname'];
$cfsID = $_SESSION['cfsid'];
$storeID = $_SESSION['offid'];
$scatagory = $_SESSION['catagory'];
$msg = "";
// ********************* package_info-e entry হওয়ার জন্য*******************************************
if(isset($_POST['ok']))
{
    $infosql = "INSERT INTO package_info(pckg_name ,pckg_code ,pckg_image ,pckg_makedate ,pckg_makerid) VALUES (?, ?, ?, ?, ?)";
    $infostmt = $conn->prepare($infosql);
    $P_pckgname=$_POST['pckg_name'];
     $P_pckgcode=$_POST['pckg_code'];
     $allowedExts = array("gif", "jpeg", "jpg", "png", "JPG", "JPEG", "GIF", "PNG");
        $extension = end(explode('.', $_FILES["pckg_pic"]["name"]));
        $image_name = $P_pckgcode."_".$_FILES["pckg_pic"]["name"];
        $image_path = "package/" . $image_name;
        if (($_FILES["pckg_pic"]["size"] < 999999999999) && in_array($extension, $allowedExts)) 
                {
                    move_uploaded_file($_FILES["pckg_pic"]["tmp_name"], "package/" . $image_name);
                } 
        else 
                {
                echo "Invalid file format.";
                }
           $timestamp=time(); //current timestamp
        $date=date("Y/m/d", $timestamp);      
    $infostmt->execute(array($P_pckgname, $P_pckgcode,$image_path, $date, $cfsID));
    $pckg_infoid = $conn->lastInsertId('idpckginfo'); 
    $_SESSION['pckgname'] = $P_pckgname;
    $_SESSION['pckgcode'] = $P_pckgcode;
    $_SESSION['pckgid'] = $pckg_infoid;
}
// ******************* package code update***************************    
$sql_pckg = mysql_query("SELECT pckg_code FROM `package_info` ORDER BY idpckginfo DESC LIMIT 1");
$sqlpckgrow = mysql_fetch_assoc($sql_pckg);
if($sqlpckgrow == "")
{
    $pckgCode = "pckg-0000";
}
else
{
    $db_str_pckgCode = $sqlpckgrow['pckg_code'];
    $code = end(explode('-', $db_str_pckgCode));
    $y = (int)$code;
    $y=$y+1;
    $str_y= (string)$y;
    $yUpdate= str_pad($str_y,4, "0", STR_PAD_LEFT);
    $pckgCode = "pckg-".$yUpdate;
}
// ********************* package_details-e entry হওয়ার জন্য*******************************************

$sql2 = "SELECT * FROM package_temp WHERE pckg_code= ?";
$selectstmt = $conn ->prepare($sql2);

$inssql = "INSERT INTO package_details(pckg_infoid, product_chartid, product_quantity) VALUES (?, ?, ?)";
$insstmt = $conn->prepare($inssql);

if(isset($_POST['entry']))
{
     $pckgcode= $_SESSION['pckgcode'];
    $selectstmt->execute(array($pckgcode));
    $all = $selectstmt->fetchAll();
    foreach($all as $row)
    {
        $db_pckginfoid= $row['pckg_infoid'];
        $db_productchartid= $row['pckg_prochart_id'];
        $db_proQTY = $row['pckg_pro_qty'];
   
       $insstmt->execute(array($db_pckginfoid,$db_productchartid,$db_proQTY));
       if($insstmt == 1)
       {
           $msg = "প্রোডাক্ট সফলভাবে এন্ট্রি হয়েছে";
       }
       else { $msg = "দুঃখিত প্রোডাক্ট এন্ট্রি হয়নি";}
      }
     $sql3 = "DELETE FROM package_temp WHERE pckg_infoid=? ";
$delstmt = $conn ->prepare($sql3);
$delstmt->execute(array($db_pckginfoid));
unset($_SESSION['pckgname']); unset($_SESSION['pckgcode']); unset($_SESSION['pckgid']);
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html;" charset="utf-8" />
<link rel="icon" type="image/png" href="images/favicon.png" />
<title>প্যাকেজ তৈরি</title>
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
    
<body onLoad="ShowTime()">

    <div id="maindiv">
<div id="header" style="width:100%;height:100px;background-image: url(images/background.gif);background-repeat: no-repeat;background-size:100% 100%;margin:0 auto;"></div></br>
<div style="width: 90%;height: 70px;margin: 0 5% 0 5%;float: none;">
    <div style="width: 33%;height: 100%; float: left;"><a href="packageWelcome.php"><img src="images/back.png" style="width: 70px;height: 70px;"/></a></div>
    <div style="width: 33%;height: 100%; float: left;font-family: SolaimanLipi !important;text-align: center;font-size: 36px;"><?php echo $storeName;?></div>
    <div style="width: 33%;height: 100%;float: left;text-align: right;font-family: SolaimanLipi !important;"><a href="" onclick="javasrcipt:window.open('package_list.php');return false;"><img src="images/packagelist.png" style="width: 100px;height: 70px;"/></br>প্যাকেজ লিস্ট</a></div>
</div>
</br>
<div align="center" style="color: green;font-size: 26px; font-weight: bold; width: 90%;height: 20px;margin: 0 5% 0 5%;float: none;"><?php if($msg != "") echo $msg;?></div></br>
    <?php
    if(!isset($_SESSION['pckgcode']))
    {
?>
    <form action="create_package.php" enctype="multipart/form-data" method="post" name="abc">
          <fieldset style="border-width: 3px;margin:0 20px 0 20px;font-family: SolaimanLipi !important;">
              <legend style="color: brown;">প্যাকেজ তৈরি</legend>
              <div style="width: 100%;">
                  <b>প্যাকেজের নাম&nbsp;&nbsp; : </b><input type="text" name="pckg_name" style="width: 200px;"/></br>
                  <b>প্যাকেজ কোড&nbsp;&nbsp;&nbsp;&nbsp;: </b><input type="text" name="pckg_code" readonly value="<?php echo $pckgCode;?>" style="width: 200px;"/></br>
                  <b>প্যাকেজ ছবি&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : </b><input type="file" name="pckg_pic" style="width: 200px;"/>
              </div>
              <input name="ok" id="ok" type="submit" value="ঠিক আছে" style="cursor:pointer;margin-left:45%;font-family: SolaimanLipi !important;" /></br>
</fieldset>
    </form>
    
    <?php }
    else
    { ?>
    <form action="addProInPckg.php" enctype="multipart/form-data" method="post" name="abc">
     <fieldset style="border-width: 3px;margin:0 20px 0 20px;font-family: SolaimanLipi !important;">
         <legend style="color: brown;">প্যাকেজে পণ্য প্রবেশ</legend>
    <div class="top" style="width: 100%;">
        <div  style="width: 100%;">
            <b>প্যাকেজের নাম : </b><input type="text" name="pckg_name" readonly value="<?php echo $_SESSION['pckgname'];?>" style="width: 200px;"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <b>প্যাকেজ কোড : </b><input type="text" name="pckg_code" readonly value="<?php echo $_SESSION['pckgcode'];?>" style="width: 200px;"/>
        </div></br>
        <div class="topleft" style="float: left;width: 30%;"><b>প্রোডাক্ট কোড</b></br>
      <input type="text" id="amots" name="amots" onKeyUp="searchCode('create_package.php');" autocomplete="off" style="width: 200px;"/>
      <div id="layer2"style="width:200px;position:absolute;top:52.5%;left:7.5%;z-index:1;padding:5px;border: 1px solid #000000; overflow:auto; height:105px; background-color:#F5F5FF;display: none;" ></div></br></br>
      <b>প্রোডাক্ট নাম&nbsp;&nbsp;  </b><input type="text" id="allsearch" name="allsearch" onKeyUp="searchName('create_package.php');" autocomplete="off" style="width: 200px;"/>
      <div  id="searchResult"style="position:absolute;top:60%;left:16%;width:200px;z-index:10;padding:5px;border: 1px inset black; overflow:auto; height:105px; background-color:#F5F5FF;display: none;" ></div>
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
      <td width="51%" height="50"><span style="color: #03C;"> প্রোডাক্ট-এর কোড: </span><input name="pcode" id="pcode" type="text" value="<?php echo $db_procode; ?>" style="border:0px;font-size: 18px;width: 250px;" readonly/>
       <input name="proChartID" type="hidden" value="<?php echo $G_proChartID; ?>"/>      
      <td colspan="3"><span style="color: #03C;"> তারিখ ও সময়: </span><input name="date" style="width:80px;"type="text" value="<?php echo $da; ?>" readonly/>
    <input name="time" type="text" id="txt" size="8" readonly/>
    </td>
  </tr>
  <tr>
      <td width="51%" height="50"><span style="color: #03C;"> প্রোডাক্ট-এর নাম: </span><input name="pname" id="pname" type="text" value="<?php echo $db_proname; ?>" style="border:0px;font-size: 22px;width: 250px;" readonly/>
      <td width="49%"><span style="color: #03C;"> পরিমাণ :</span> <input name="QTY" id="QTY" type="text" onkeypress=' return numbersonly(event)'  style="width:100px;"/></td>
      <td width="49%" rowspan="2"><input type="submit" name="addButton" style="height:100px; width: 100px;background-image: url('images/addToInventory.jpeg');background-repeat: no-repeat;background-size:100% 100%;cursor:pointer;" id="addtoCart" value="" /></td>
  </tr>
  <tr>   
    <td width="51%" height="50"><span style="color: #03C;"> প্রোডাক্ট-এর একক:</span>
    <input name="unit" id="unit" type="text" readonly="readonly" style="border:0px;font-size: 18px;width: 250px;" value="<?php echo $db_prounit;?>"/></td>
     
    </tr>
</table>
</div>
</div>
</fieldset></form>

  <fieldset style="border-width: 3px;margin:0 20px 0 20px;font-family: SolaimanLipi !important;">
<legend style="color: brown;">প্যাকেজে প্রবেশকৃত পণ্যের তালিকা</legend>
    <table width="100%" border="1" cellspacing="0" cellpadding="0" style="border-color:#000000; border-width:thin; font-size:18px;">
      <tr>
        <td width="13%"><div align="center"><strong>প্রোডাক্ট কোড</strong></div></td>
        <td width="19%"><div align="center"><strong>প্রোডাক্ট-এর নাম</strong></div></td>
         <td width="8%"><div align="center"><strong>পরিমাণ</strong></div></td>
        <td width="8%">&nbsp;</td>
      </tr>
    <?php
    $pckgcode= $_SESSION['pckgcode'];
        $getresult = mysql_query("SELECT * FROM package_temp WHERE pckg_code='$pckgcode' ") or exit ('query failed');
        while($row = mysql_fetch_array($getresult))
          {
              echo '<tr>';
              echo '<td><div align="left">'.$row['pckg_pro_code'].'</div></td>';
                echo '<td><div align="left">&nbsp;&nbsp;&nbsp;'.$row['pckg_pro_name'].'</div></td>';
                echo '<td><div align="center">'.english2bangla($row['pckg_pro_qty']).'</div></td>';
                echo "<td><a href=deletePckgPro.php?pckgcode=".$pckgcode."&code=".$row['pckg_pro_code'].">Remove</a></td>";
                echo '</tr>';
        }
?>
</table>
</fieldset>
<form action="create_package.php" method="post" >
<input name="entry" id="entry" type="submit" value="এন্ট্রি করুন" style="cursor:pointer;margin-left:45%;font-family: SolaimanLipi !important;" /></br></br>
</form>
    <?php }?>
<div style="background-color:#f2efef;border-top:#009 dashed 2px;padding:3px 50px;">
     <a href="http://www.comfosys.com" target="_blank"><img src="images/footer_logo.png"/></a> 
         RIPD Universal &copy; All Rights Reserved 2013 - Designed and Developed By <a href="http://www.comfosys.com" target="_blank" style="color:#772c17;">comfosys Limited<img src="images/comfosys_logo.png" style="width: 50px;height: 40px;"/></a>
</div>
  </div>
</body>
</html>
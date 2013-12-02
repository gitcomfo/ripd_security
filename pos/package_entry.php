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
$check = 0; $msg ="";
$arr_left_qty= array();
$arr_ri8_qty = array();

$sql_runningpv = mysql_query("SELECT * FROM running_command ;"); 
$pvrow = mysql_fetch_assoc($sql_runningpv);
$current_pv = $pvrow['pv_value'];

$sql ="SELECT * FROM package_inventory WHERE pckg_infoid=? AND ons_type=? AND ons_id=?";
$stmt = $conn->prepare($sql);

$inventsql = "SELECT * FROM inventory WHERE ins_productid= ? AND ins_ons_type=? AND ins_ons_id =? AND ins_product_type = ? ";
$inventstmt = $conn ->prepare($inventsql);

$sqlins = "INSERT INTO package_inventory(pckg_infoid ,pckg_quantity ,pckg_pv, pckg_selling_price ,pckg_buying_price, pckg_profit, pckg_extraprofit, making_date, pckg_makerid, pckg_type, ons_type, ons_id) VALUES (?,?, ?, ?, ?, ?, ?, ?, ? ,?, ?, ?)";
 $insstmt = $conn ->prepare($sqlins);

if(isset($_POST['update']))
{
    $P_updatedpckgbuy = $_POST['buyingprz'];
    $P_updatedpckgsell = $_POST['updatesellprz'];
    $P_updatedpckgprofit = $_POST['updateprofit'];
    $P_updatedpckgxprofit = $_POST['updatexprofit'];
    $P_newqty = $_POST['newentry'];
    $P_pckgid = $_POST['pckgID'];
    $P_pv = $_POST['updatepv'];
    $type = 'making';
    $timestamp=time(); //current timestamp
     $date=date("Y/m/d", $timestamp);  
    
    $yes= $insstmt->execute(array($P_pckgid, $P_newqty,$P_pv,  $P_updatedpckgsell, $P_updatedpckgbuy, $P_updatedpckgprofit, $P_updatedpckgxprofit, $date, $cfsID, $type, $scatagory, $storeID));
    if($yes ==1)
    {$msg = "প্যাকেজটি সফলভাবে এন্ট্রি হয়েছে";}
                    else { $msg = "দুঃখিত প্যাকেজটি এন্ট্রি হয়নি";}

}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html;" charset="utf-8" />
<link rel="icon" type="image/png" href="images/favicon.png" />
<title>প্যাকেজ তৈরি বিস্তারিত</title>
<link rel="stylesheet" href="css/style.css" type="text/css" media="screen" charset="utf-8"/>
<script src="scripts/jquery-1.10.2.min.js"></script>
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
      if (document.getElementById("check").value == '1')
           {
               document.getElementById("okok").disabled = false;
           }
       if (document.getElementById("okok").disabled == true)
           {
               document.getElementById("update").disabled = false;
               document.getElementById("ok").disabled = false;
           }
       else 
       {
           document.getElementById("ok").disabled = true;
       }

}
    function checkTime(i)
    {
      if (i<10)
      {
        i="0" + i
      }
      return i
    }
    
    $(document).ready(function() {
    if ($('#okok').is(':disabled') == false) {
            $('#update').attr('disabled','disabled');
        }
    });
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

$(document).ready(function(){
  $('#okok').click(function() {
    if($('#check').val() == 1 )
        {
            //$('#okok').attr('','enable');
            $("#show").html("দুঃখিত, এই পরিমান প্যাকেজ এন্ট্রি করার জন্য প্রয়োজনীয় পরিমান পণ্য নেই");
            $('#update').attr('disabled','disabled');
            $('#ok').attr('disabled','disabled');
        }
        else{ 
            $("#show").html("প্যাকেজটি এন্ট্রি করুন");
            $('#okok').attr('disabled','disabled');
            $('#update').removeAttr('disabled');
            $('#ok').removeAttr('disabled');
        }
  });
});
    </script>
	
<!--===========================================================================================================================-->
<script>
function searchPckg(str_key) // for all packages search
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
                document.getElementById('searchResult').setAttribute('style','position:absolute;top:36%;left:30.5%;width:290px;z-index:10;padding:5px;border: 1px inset black; overflow:auto; height:105px; background-color:#F5F5FF;');
                    }
                document.getElementById('searchResult').innerHTML=xmlhttp.responseText;
        }
        xmlhttp.open("GET","includes/searchPackage.php?searchKey="+str_key,true);
        xmlhttp.send();	
}

function checkqty(qty,left,ri8) // check qty after enter pckg qty
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
               document.getElementById('check').value=xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET","includes/checkPckgQty.php?pckgqty="+qty+"&leftstr="+left+"&ri8str="+ri8,true);
        xmlhttp.send();
}

function getUpdate(xprofit) // after update pckg prices
{
   var run_pv = <?php echo $current_pv?>;
        var profit = Number(document.getElementById('updateprofit').value);
   var totalprft = profit + Number(xprofit);
    var curprft = Number(document.getElementById('currentpckgprft').value);
    var curxprft = Number(document.getElementById('currentpckgxprft').value);
    var totalcurprft = curprft + curxprft;
    var pv = ((run_pv)/100) * profit;
    pv = (pv).toFixed(2);
     document.getElementById('updatepv').value = pv;
     
    if(totalprft < totalcurprft)
        {
            var difference = totalcurprft - totalprft;
            var currentsell = Number(document.getElementById('currentpckgprz').value);
            var updatesell = currentsell - difference;
            document.getElementById('updatesellprz').value = updatesell;
        }
        else
            {
                var difference = totalprft - totalcurprft;
                var currentsell = Number(document.getElementById('currentpckgprz').value);
                var updatesell = currentsell +difference;
                document.getElementById('updatesellprz').value = updatesell;
            }
}
</script>  
</head>
    
<body onLoad="ShowTime()">

    <div id="maindiv">
<div id="header" style="width:100%;height:100px;background-image: url(images/background.gif);background-repeat: no-repeat;background-size:100% 100%;margin:0 auto;"></div></br>
    <div style="width: 90%;height: 70px;margin: 0 5% 0 5%;float: none;">
    <div style="width: 33%;height: 100%; float: left;"><a href="../pos_management.php"><img src="images/back.png" style="width: 70px;height: 70px;"/></a></div>
    <div style="width: 33%;height: 100%; float: left;font-family: SolaimanLipi !important;text-align: center;font-size: 36px;"><?php echo $storeName;?></div>
    <div style="width: 33%;height: 100%;float: left;text-align: right;font-family: SolaimanLipi !important;"><a href="" style="text-decoration: none;" onclick="javasrcipt:window.open('package_list.php');return false;"><img src="images/packagelist.png" style="width: 100px;height: 70px;"/></br>প্যাকেজ লিস্ট</a></div>
</div>
</br>
<div class="wraper" style="width: 80%;font-family: SolaimanLipi !important;float: none;">
<fieldset style="border-width: 3px;width: 100%;">
         <legend style="color: brown;">প্যাকেজ খুঁজুন</legend>
    <div class="top" style="width: 100%;height: auto;">
        <div class="topleft" style="width: 60%;float: left;"><b>প্যাকেজ কোড&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b>
            : <input type="text" id="searchPckg" name="searchPckg" onKeyUp="searchPckg(this.value);" autocomplete="off" style="width: 300px;"/></br>
        <div id="searchResult"></div>
    </div>
        <div style="width: 40%;float: left;text-align: right;"><b> তারিখ ও সময় : </b><input name="date" style="width:75px;"type="text" value="<?php echo date("d/m/Y"); ?>" readonly/>
    <input name="time" type="text" id="txt" size="7" readonly/></div>
        </div>
</fieldset>
</div></br>
<?php
if($_GET['step']==1) {
?>
<div style="width: 99.9%;font-family: SolaimanLipi !important;float: none;border: solid 1px #000;">
    <form method="post" action="package_price_entry.php">
        <div style="width: 100%;height: auto;float: none;">
            <table>
                <tr>
                    <td>
                        <table>
                            <tr>
                                <td>
                                    <fieldset style="border-width: 3px;width: 95%;">
                                         <legend style="color: brown;">প্যাকেজ বিবরণ</legend>
                                         <?php
                                                    if(isset($_GET['id']))
                                                    {
                                                        $pckgid = $_GET['id'];
                                                        $sqlsel = "SELECT * FROM package_info WHERE idpckginfo= ?";
                                                        $stmtsel = $conn ->prepare($sqlsel);
                                                        $stmtsel->execute(array($pckgid));
                                                        $all = $stmtsel->fetchAll();
                                                        foreach($all as $row)
                                                        {
                                                            $db_pckgname= $row['pckg_name'];
                                                            $db_pckgcode = $row['pckg_code'];
                                                        }
                                                        $sql2 = "SELECT * FROM package_details WHERE pckg_infoid = ?";
                                                        $selectstmt2 = $conn ->prepare($sql2);
                                                        $arr_pro_chartid = array();
                                                        $arr_pro_qty = array();
                                                        $selectstmt2->execute(array($pckgid));
                                                        $getall = $selectstmt2->fetchAll();
                                                        foreach($getall as $row2)
                                                        {
                                                            array_push($arr_pro_chartid, $row2['product_chartid']);
                                                            array_push($arr_pro_qty, $row2['product_quantity']);
                                                        }
                                                        $str_pro_chartid = implode(',', $arr_pro_chartid);
                                                        $str_pro_qty = implode(',', $arr_pro_qty);
                                                    }
                                         ?>
                                         <b>প্যাকেজের নাম : </b><input type="text" id="pckgName" name="pckgName" readonly value="<?php echo $db_pckgname;?>" style="width: 300px;"/><input type="hidden" name="pckgID"  value="<?php echo $pckgid;?>"/></br>
                                         <b>প্যাকেজ কোড &nbsp;: </b> <input type="text" id="pckgCode" name="pckgCode" readonly value="<?php echo $db_pckgcode;?>" style="width: 300px;"/></br>
                                         <input type='hidden' name='pckgproid' value='<?php echo $str_pro_chartid; ?>' />
                                         <input type='hidden' name='pckgqty' value='<?php echo $str_pro_qty; ?>' />
                                         <table border="">
                                             <thead style="background-color: #ffcccc">
                                                 <th width="33%">পণ্যের কোড</th>
                                                 <th width="53%">পণ্যের নাম</th>
                                                 <th width="14%">পরিমাণ</th>
                                             </thead>                                       
                                                 <?php
                                                            $rowNumber = count($arr_pro_chartid);
                                                            for($i = 0 ; $i< $rowNumber; $i++)
                                                            {
                                                                $prochartid = $arr_pro_chartid[$i];
                                                                $proqty = $arr_pro_qty[$i];
                                                                $sql3 = "SELECT * FROM product_chart WHERE idproductchart= ? ";
                                                                $selectstmt3 = $conn ->prepare($sql3);
                                                                $selectstmt3->execute(array($prochartid));
                                                                $all3 = $selectstmt3->fetchAll();
                                                                foreach($all3 as $row3)
                                                                {
                                                                    $procode = $row3['pro_code'];
                                                                    $proname = $row3['pro_productname'];
                                                                }
                                                                echo "<tbody><td>$procode </td>
                                                                         <td>$proname</td>
                                                                         <td align='center'>$proqty</td></tbody>";
                                                                array_push($arr_left_qty,$proqty);
                                                            }
                                                     ?>
                                         </table>
                                    </fieldset>
                                </td>
                                <td>
                                    <fieldset style="border-width: 3px;width: 98%;height: auto;">
                                         <legend style="color: brown;">ব্যাবহারযোগ্য পণ্যের পরিমাণ</legend>
                                         <table border="1">
                                             <thead style="background-color: #ffcccc">
                                                 <th width="31%">পণ্যের কোড</th>
                                                 <th width="42%">পণ্যের নাম</th>
                                                 <th width="25%">ব্যবহারযোগ্য পরিমাণ</th>
                                             </thead>
                                              <?php
                                                        $rowNumber = count($arr_pro_chartid);
                                                            for($i = 0 ; $i< $rowNumber; $i++)
                                                            {
                                                                $prochartid = $arr_pro_chartid[$i];
                                                                $proqty = $arr_pro_qty[$i];
                                                                $type = 'general';
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
                                                                   echo "<tbody><td>$procode </td>
                                                                             <td>$proname</td>
                                                                             <td align='center'>$qty</td></tbody>";
                                                                   
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
                                                                    echo "<tbody><td>$procode </td>
                                                                             <td>$proname</td>
                                                                             <td align='center'>পণ্যটি নেই</td></tbody>";
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
                                         </table></br>
                                      </fieldset>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td align="center">
                        <p>প্যাকেজ এন্ট্রি পরিমান : </b><input id="pckgQty" name="pckgQty" type="text" onkeypress=' return numbersonly(event)' onkeyup="checkqty(this.value,'<?php echo $str_left;?>','<?php echo $str_ri8;?>')"  /></br></p>
                                    <p>
                                        <?php if($check !=1) {?>
                                        <input type="hidden"  id="check"  /><span id="show" style="color: red;"></span></br>
                                        <input  id="okok" type="button" value="ঠিক আছে" style="cursor:pointer;font-family: SolaimanLipi !important;" />
                                      <input name="ok" id="ok" type="submit" value="এন্ট্রি" style="cursor:pointer;font-family: SolaimanLipi !important;" />
                                      <?php } else { echo "<span style='color:red;'>দুঃখিত, এই প্যাকেজটি এন্ট্রি করার জন্য প্রয়োজনীয় পরিমান পণ্য নেই </span>";}?>
                                    </p>
                                    </br></br>
                    </td>
                </tr>
            </table>
        </div>
</form>
</div>
<?php } elseif($_GET['step']==2) { ?>
    <!-- ************************যদি প্যাকেজ আগে এই দোকানে ব্যাবহার করা হয়*****************************-->
    <?php
    if($msg != "")
    {
?>
<div align="center" style="color: green;font-size: 26px; font-weight: bold; width: 90%;height: 20px;margin: 0 5% 0 5%;float: none;"><?php if($msg != "") echo $msg;?></div></br>
    <?php } 
    else { ?>
    </br></br>
    <div id="bush" style="width: 99.9%;font-family: SolaimanLipi !important;float: none;border: solid 1px #000;">
    <form method="post" action="">
        <div style="width: 100%;height: auto;float: none;">
            <table>
                <tr>
                    <td>
                        <table>
                            <tr>
                                <td width="58%">
                                    <fieldset style="border-width: 3px;width: 95%;">
                                         <legend style="color: brown;">প্যাকেজ বিবরণ</legend>
                                         <?php
                                                    if(isset($_GET['id']))
                                                    {
                                                        $pckgid = $_GET['id'];
                                                        $sqlsel = "SELECT * FROM package_info WHERE idpckginfo= ?";
                                                        $stmtsel = $conn ->prepare($sqlsel);
                                                        $stmtsel->execute(array($pckgid));
                                                        $all = $stmtsel->fetchAll();
                                                        foreach($all as $row)
                                                        {
                                                            $db_pckgname= $row['pckg_name'];
                                                            $db_pckgcode = $row['pckg_code'];
                                                        }
                                                        $sql2 = "SELECT * FROM package_details WHERE pckg_infoid = ?";
                                                        $selectstmt2 = $conn ->prepare($sql2);
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
                                         <table border="1">
                                             <thead style="background-color: #ffcccc">
                                                 <th width="12%">পণ্যের কোড</th>
                                                 <th width="21%">পণ্যের নাম</th>
                                                 <th width="9%">পরিমাণ</th>
                                                  <th width="12%">বর্তমান ক্রয়মূল্য</th>
                                                 <th width="14%">বর্তমান বিক্রয়মূল্য</th>
                                                 <th width="10%">বর্তমান প্রফিট</th>
                                                  <th width="10%">বর্তমান এক্সট্রা প্রফিট</th>
                                                 <th width="12%">বর্তমান পিভি</th>
                                             </thead>
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
                                                                   array_push($arr_left_qty,$proqty);
                                                            }                                         
             ?>
                                         </table></br>
                                         
                                    </fieldset>
                                </td>
                                <td width="42%">
                                    <fieldset style="border-width: 3px;width: 98%;height: auto;">
                                         <legend style="color: brown;">ব্যাবহারযোগ্য পণ্যের পরিমাণ</legend>
                                          <table width="100%" border="1">
                                             <thead style="background-color: #ffcccc">
                                                 <th width="28%">পণ্যের কোড</th>
                                                 <th width="36%">পণ্যের নাম</th>
                                                 <th width="36%">ব্যবহারযোগ্য পরিমাণ</th>
                                             </thead>
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
                                                                   echo "<tbody><td>$procode </td>
                                                                             <td>$proname</td>
                                                                             <td align='center'>$qty</td></tbody>";
                                                                   
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
                                                                    echo "<tbody><td>$procode </td>
                                                                             <td>$proname</td>
                                                                             <td align='center'>পণ্যটি নেই</td></tbody>";
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
                                         </table>
                                     </fieldset>
                                </td>
                            </tr>
                            <tr>
                                <td align="center" colspan="2" style="border: 1px solid black;">
                                    <b>বর্তমান মোট ক্রয়মূল্য &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: </b><input name="buyingprz" type="text" readonly style="text-align: right;" value="<?php echo $buysum;?>" /> টাকা</br>
                                         <b>বর্তমান মোট বিক্রয়মূল্য &nbsp;&nbsp;&nbsp;: </b><input type="text" readonly style="text-align: right;" value="<?php echo $sellsum;?>" /> টাকা</br>
                                         <b>বর্তমান মোট প্রফিট&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: </b><input type="text" readonly style="text-align: right;" value="<?php echo $profitsum;?>"/> টাকা</br>
                                         <b>বর্তমান মোট এক্সট্রা প্রফিট : </b><input type="text" readonly style="text-align: right;" value="<?php echo $xprofitsum;?>" /> টাকা</br>
                                         <b>বর্তমান মোট পিভি&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: </b><input type="text" readonly style="text-align: right;" value="<?php echo $pvsum;?>" /> টাকা
                                </td>
                            </tr>
                            <tr>
                                <td style="border: 1px solid black;">
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
                                                            $db_pckgqty= $pckgrow['ins_how_many'];
                                                        }
                                    ?>
                                        <b>বর্তমান প্যাকেজ প্রফিট&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: </b><input id="currentpckgprft" type="text" readonly style="text-align: right;" value="<?php echo $db_pckgprofit;?>" /> টাকা</br>
                                         <b>বর্তমান প্যাকেজ এক্সট্রা প্রফিট : </b><input id="currentpckgxprft" type="text" readonly style="text-align: right;" value="<?php echo $db_pckgxprofit;?>" /> টাকা</br>
                                        <b>বর্তমান প্যাকেজ বিক্রয়মূল্য&nbsp;&nbsp;&nbsp;&nbsp;: </b><input id="currentpckgprz" type="text" readonly style="text-align: right;" value="<?php echo $db_pckgsell;?>" /> টাকা</br>
                                        <b>বর্তমান প্যাকেজ পিভি&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: </b><input id="currentpckgpv" type="text" readonly style="text-align: right;" value="<?php echo $db_pckgpv;?>" /></br>
                                         
                                </td>
                                <td style="border: 1px solid black;">
                                         <b>আপডেট প্যাকেজ প্রফিট&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: </b><input id="updateprofit" name="updateprofit" onkeypress="return checkIt(event)" type="text" style="text-align: right;" value="<?php echo $db_pckgprofit;?>"  /> টাকা</br>
                                         <b>আপডেট প্যাকেজ এক্সট্রা প্রফিট : </b><input id="updatexprofit" name="updatexprofit" type="text" style="text-align: right;" onkeypress="return checkIt(event)" onblur="getUpdate(this.value)" value="<?php echo $db_pckgxprofit;?>"/> টাকা</br>
                                         <b>আপডেটেট প্যাকেজ বিক্রয়মূল্য&nbsp;&nbsp;: </b><input id="updatesellprz" name="updatesellprz" type="text" readonly style="text-align: right;" value="<?php echo $db_pckgsell;?>"/> টাকা</br>
                                         <b>আপডেটেট প্যাকেজ পিভি&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: </b><input id="updatepv" name="updatepv" type="text" readonly style="text-align: right;" value="<?php echo $db_pckgpv;?>"/> </br>
                                </td>
                            </tr>
                            <tr>
                                <td align="center" colspan="2">
                                    <p><b>প্যাকেজের বর্তমান পরিমান : </b><input name="currentqty" type="text" readonly value="<?php echo $db_pckgqty;?>" /><b>&nbsp;&nbsp;প্যাকেজ এন্ট্রি পরিমান : </b><input id="newentry" name="newentry" type="text" onkeypress=' return numbersonly(event)' onkeyup="checkqty(this.value,'<?php echo $str_left;?>','<?php echo $str_ri8;?>')" value="<?php echo 0;?>" /></br></p>
                                    <p>
                                        <?php if($check !=1) {?>
                                        <input type="hidden"  id="check"  /><span id="show" style="color: red;"></span></br>
                                        <input  id="okok" type="button" value="ঠিক আছে" style="cursor:pointer;font-family: SolaimanLipi !important;" />
                                      <input name="update" id="update" type="submit" value="আপডেট" style="cursor:pointer;font-family: SolaimanLipi !important;" />
                                      <?php } else { echo "<span style='color:red;'>দুঃখিত, এই প্যাকেজটি এন্ট্রি করার জন্য প্রয়োজনীয় পরিমান পণ্য নেই </span>";}?>
                                    </p>
                                    </br></br>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </div>
</form>
</div>
<?php }}?>
<div style="background-color:#f2efef;border-top:#009 dashed 2px;padding:3px 50px;">
     <a href="http://www.comfosys.com" target="_blank"><img src="images/footer_logo.png"/></a> 
         RIPD Universal &copy; All Rights Reserved 2013 - Designed and Developed By <a href="http://www.comfosys.com" target="_blank" style="color:#772c17;">comfosys Limited<img src="images/comfosys_logo.png" style="width: 50px;height: 40px;"/></a>
</div>
</body>
</html>
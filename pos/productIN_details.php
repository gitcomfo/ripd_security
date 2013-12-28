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

$sel_command = $conn->prepare("SELECT * FROM running_command");
$sel_command->execute();
$arr_rslt = $sel_command->fetchAll();
foreach ($arr_rslt as $value) {
    $db_pv = $value['pv_value'];
}
$ins_purchase_sum = $conn->prepare("INSERT INTO product_purchase_summary(chalan_no, total_chalan_cost, transport_cost ,others_cost ,chalan_comment , chalan_date , cfs_user_idUser ,chalan_scan_copy) VALUES (?, ?, ?, ?, ?, NOW(), ?, ?)");
$ins_purchase = $conn->prepare("INSERT INTO product_purchase(in_ons_type, in_onsid, in_input_date ,input_type ,in_howmany , in_pv , in_extra_profit ,in_profit, in_buying_price, in_sellingprice, pps_id, Product_chart_idproductchart) VALUES (?, ?, NOW(), 'in', ?, ?, ?, ?, ?, ?, ?, ?)");
$sel_purchase_sum = $conn->prepare("SELECT * FROM product_purchase_summary WHERE chalan_no= ? ");

if(isset($_POST['next']))
{
    $p_totalBuyingPrice = $_POST['totalBuyingPrice'];
    $p_totalTransportCost = $_POST['transportCost'];
    $p_comment = $_POST['transportComment'];
    $p_totalotherCost = $_POST['otherCost'];
    
      $allowedExts = array("gif", "jpeg", "jpg", "png", "JPG", "JPEG", "GIF", "PNG");
      $extension = end(explode(".", $_FILES["chalanCopy"]["name"]));
      $chalancopy = $_FILES["chalanCopy"]["name"];
        if($chalancopy != "")
        {
            $chalancopy = "ch-".$_SESSION['chalanNO']."-".$_FILES["chalanCopy"]["name"];
        }
        $chalancopy_path = "scaned/".$chalancopy;
        if( $_FILES["chalanCopy"]["name"] != ""){
            if (($_FILES["chalanCopy"]["size"] < 999999999999) && in_array($extension, $allowedExts)) 
                    {
                        move_uploaded_file($_FILES["chalanCopy"]["tmp_name"], "../scaned/".$chalancopy);
                    } 
            else 
                    {
                    echo "Invalid file format.";
                    }
        }
        
    if(!isset($_SESSION['chalanArray']))
    {
        $_SESSION['chalanArray']=array();
        $_SESSION['chalanArray'][0] = $p_totalBuyingPrice;
        $_SESSION['chalanArray'][1] = $p_totalTransportCost;
        $_SESSION['chalanArray'][2] = $p_comment;
        $_SESSION['chalanArray'][3] = $p_totalotherCost;
        $_SESSION['chalanArray'][4] = $chalancopy_path;
    }
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
   $totalbuying = $_SESSION['chalanArray'][0];
   $totaltarnsport = $_SESSION['chalanArray'][1];
   $comment = $_SESSION['chalanArray'][2];
   $totalother = $_SESSION['chalanArray'][3];
   $chalancopy = $_SESSION['chalanArray'][4];

   $noRows = count($_SESSION['arrProductTemp']); // how many products
    $p_chartID = $_POST['chartID']; 
    $p_buy = $_POST['proBuyingPrice']; 
    $p_sell = $_POST['proSellingPrice']; 
    $p_xprofit = $_POST['proXprofit']; 
    $p_profit = $_POST['proProfit']; 
    $p_pv = $_POST['proPV']; 
    $p_qty = $_POST['porQty']; 
    try {
          $conn->beginTransaction();
        $ins_purchase_sum->execute(array($chalanNo,$totalbuying,$totaltarnsport,$totalother,$comment,$cfsID,$chalancopy));
        $purchase_sum_id = $conn->lastInsertId();
        for($i=1;$i<=$noRows;$i++)
        {
            $buy=$p_buy[$i];
            $sell=$p_sell[$i];
            $profit=$p_profit[$i];
            $xtraprofit=$p_xprofit[$i];
            $pv=$p_pv[$i];
            $qty=$p_qty[$i];
            $chartid=$p_chartID[$i];
            $ins_purchase->execute(array($scatagory, $storeID, $qty, $pv,  $xtraprofit, $profit, $buy, $sell, $purchase_sum_id, $chartid));
        }
         $conn->commit();
         unset($_SESSION['chalanArray']);
         unset($_SESSION['chalanNO']);
         unset($_SESSION['arrProductTemp']);
         unset($_SESSION['pro_chart_array']);
         echo "<script>alert('প্রোডাক্ট সফলভাবে এন্ট্রি হয়েছে')</script>";
         header('Location:productIN.php');
    } 
    catch (Exception $exc) {
        $conn->rollBack();
        echo "<script>alert('দুঃখিত,প্রোডাক্ট এন্ট্রি হয়নি')</script>";
    }
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
<script language="JavaScript" type="text/javascript" src="scripts/jquery-1.10.2.min.js"></script>
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
    if((selling < buying) || (pv <= 0))
        {
            alert("দুঃখিত, বিক্রয়মূল্য < ক্রয়মূল্য হতে পারবে না\n এবং\n পিভি ০ হতে পারবে না");
            document.getElementById("proProfit["+i+"]").value = 0;
            document.getElementById("proPV["+i+"]").value = 0;
        }
        else {
                document.getElementById("proProfit["+i+"]").value = profit;
                document.getElementById("proPV["+i+"]").value = pv;
        }
}

$(document).ready(function() {
  $('#entry').click(function() {
    $(".inbox").filter(function() {
         var val = $(this).val();
        if((val == "") || (val == 0))
            {
                 $("form").submit(function(e){
                        e.preventDefault();
                    })
            }
           else {
               $("form").get(0).allowDefault = true;
           }
    });
  });
});
</script>
</head>
    
<body>
<div id="maindiv">
<div id="header" style="width:100%;height:100px;background-image: url(../images/sara_bangla_banner_1.png);background-repeat: no-repeat;background-size:100% 100%;margin:0 auto;"></div></br>
<div style="width: 90%;height: 70px;margin: 0 5% 0 5%;float: none;">
    <div style="width: 33%;height: 100%; float: left;"><a href="productIN.php"><img src="images/back.png" style="width: 70px;height: 70px;"/></a></div>
    <div style="width: 33%;height: 100%; float: left;font-family: SolaimanLipi !important;text-align: center;font-size: 36px;"><?php echo $storeName;?></div>
</div></br>
<form action="productIN_details.php" method="post" >  
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
                $poribohon = $p_totalTransportCost + $p_totalotherCost;
                $buyingprice =  $proinfo['4'] + (($proinfo['3'] * $poribohon) / ($p_totalBuyingPrice * $proinfo['2']));
                echo "<tr>
                        <td style='text-align: center;'>".english2bangla($sl)."</td>
                        <td style='text-align: left;padding-left:2px;'>$proinfo[1]</td>
                        <td style='text-align: left;'><input type='hidden' name='chartID[$sl]' value='$key' />$proinfo[0]</td>
                        <td style='text-align: center;'><input type='text' name='porQty[$sl]' value= '$proinfo[2]' readonly style='width:90%;height=100%;' /></td>
                        <td style='text-align: center;padding-right:2px;'><input type='text' name='proBuyingPrice[$sl]' id='proBuyingPrice[$sl]' value='$buyingprice' readonly style='width:95%;height=100%;text-align:right' /></td>
                        <td style='text-align: center;padding-right:2px;'><input type='text' name='proSellingPrice[$sl]' id='proSellingPrice[$sl]' style='width:95%;height=100%;text-align:right' onkeypress='return checkIt(event)' /></td>
                        <td style='text-align: center;'><input type='text' name='proXprofit[$sl]' id='proXprofit[$sl]' style='width:92%;height=100%;text-align:right' onkeypress='return checkIt(event)' onkeyup='calculate(this.value,$sl)' /></td>
                        <td style='text-align: center;'><input type='text' name='proProfit[$sl]' id='proProfit[$sl]' readonly style='width:90%;height=100%;text-align:right' /></td>
                        <td style='text-align: center;'><input class='inbox' type='text' name='proPV[$sl]' id='proPV[$sl]' readonly style='width:90%;height=100%;' /></td>
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
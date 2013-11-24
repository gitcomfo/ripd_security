<?php
//error_reporting(0);
include 'session.php';
include_once 'includes/MiscFunctions.php';
include 'includes/connectionPDO.php';
$storeName= $_SESSION['offname'];
$g_proid = $_GET['proid'];
$sql_inven_sel = $conn->prepare("SELECT * FROM inventory WHERE idinventory = ?;");
$upquery_inven = $conn->prepare(" UPDATE `inventory` SET `ins_extra_profit` = ?, `ins_sellingprice` = ?, `ins_profit` = ?,ins_pv =?, `ins_lastupdate` = NOW()  WHERE `idinventory` =?; ");

$sqlpv = $conn->prepare("SELECT * FROM running_pv;");
$rslt =$sqlpv->execute(array());
$pvrow = $sqlpv->fetchAll();
foreach ($pvrow as $row) {
    $pvinvalue= $row['value_in_pv'];
$pvintaka= $row['value_in_tk'];
}
 $unitpv = $pvinvalue / $pvintaka;

$result_inven = $sql_inven_sel->execute(array($g_proid));
$getresult = $sql_inven_sel->fetchAll();
foreach ($getresult as $row1) {
    $db_productname = $row1['ins_productname'];
    $db_buying = $row1['ins_buying_price'];
    $db_selling = $row1['ins_sellingprice'];
    $db_xtraprofit = $row1['ins_extra_profit'];
}
$msg ="";
if(isset($_POST['update']))
{
    $p_proid = $_POST['proid'];
    $p_buying = $_POST['buyingprice'];
    $p_selling = $_POST['sellingprice'];
    $p_xtraprofit = $_POST['xprofit'];
     $profit = $p_selling - ($p_buying+$p_xtraprofit);
    $pv = $profit * $unitpv;
   $uprslt = $upquery_inven->execute(array($p_xtraprofit,$p_selling,$profit,$pv,$p_proid));
    if ($uprslt ==1)
	{$msg = "আপডেট হয়েছে";}
        else { $msg ="আপডেট হয়নি"; }
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
	{ TINY.box.show({iframe:'updateProduct.php?proid='+id,width:500,height:280,opacity:30,topsplit:3,animate:true,close:true,maskid:'bluemask',maskopacity:50,boxid:'success'}); }
 </script>
</head>
    
<body>

    <div id="maindiv">
    <div style="width: 100%;height: 50px;font-family: SolaimanLipi !important;text-align: center;font-size: 36px;"><?php echo $storeName;?></div></br>
<div class="wraper" style="width: 80%;font-family: SolaimanLipi !important;">
<fieldset style="border-width: 3px;width: 100%;">
    <legend style="color: brown;">প্রোডাক্টের মূল্য আপডেট</legend>
    <div class="top" style="width: 100%;height: auto;">
        <?php
        if($msg !="")
            {echo "<b><font color='green;'>$msg</font></b>";}
        else{
        ?>
        <form method="post" action="">
            <table border="2" cellpadding="0" cellspacing="0" style="font-family: SolaimanLipi !important;">
                <tr>
                    <td width="50%"><b>প্রোডাক্টের নাম</b></td>
                    <td width="50%" style="text-align: left;"><input type="hidden" name="proid" value="<?php echo $g_proid?>"/><?php echo $db_productname;?></td>
                </tr>
                <tr>
                    <td><b>প্রোডাক্টের বর্তমান ক্রয়মূল্য</b></td>
                    <td style="text-align: center;"><input type="text" readonly name="buyingprice" style="width: 96%;text-align: right;padding-right: 5px;font-size: 16px;" value="<?php echo $db_buying; ?>" /></td>
                </tr>
                <tr>
                    <td><b>প্রোডাক্টের বর্তমান বিক্রয়মূল্য</b></td>
                    <td style="text-align: center;"><input type="text" name="sellingprice" value="<?php echo  $db_selling;?>" style="width: 96%;text-align: right;padding-right: 5px;font-size: 16px;" /></td>
                </tr>
                <tr>
                    <td><b>প্রোডাক্টের বর্তমান এক্সট্রা প্রফিট</b></td>
                    <td style="text-align: center;"><input type="text" name="xprofit" value="<?php echo $db_xtraprofit;?>" style="width: 96%;text-align: right;padding-right: 5px;font-size: 16px;" /></td>
                </tr>
                <tr>
                    <td colspan="2" style="text-align: center;"></br><input type="submit" name="update" value="আপডেট"></input></td>
                </tr>
            </table>
        </form><?php }?>
    </div>
</fieldset></br>
</div>
  </div>
</body>
</html>
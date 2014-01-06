<?php
error_reporting(0);
include_once 'includes/MiscFunctions.php';
include 'includes/connectionPDO.php';
$storeName= $_SESSION['loggedInOfficeName'];
$g_proid = $_GET['proid'];
$sql_inven_sel = $conn->prepare("SELECT * FROM inventory WHERE idinventory = ?;");
$upquery_inven = $conn->prepare(" UPDATE `inventory` SET `ins_extra_profit` = ?, `ins_sellingprice` = ?, `ins_profit` = ?,ins_pv =?, `ins_lastupdate` = NOW()  WHERE `idinventory` =?; ");

$sqlpv = $conn->prepare("SELECT * FROM running_command;");
$rslt =$sqlpv->execute(array());
$pvrow = $sqlpv->fetchAll();
foreach ($pvrow as $row) {
    $unitpv= $row['pv_value'];
}

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
<link rel="stylesheet" href="css/style.css" type="text/css" media="screen" charset="utf-8"/>
<script language="JavaScript" type="text/javascript" src="productsearch.js"></script>
<link rel="stylesheet" href="css/css.css" type="text/css" media="screen" />
</head>
    
<body>
<div id="maindiv">
<div class="wraper" style="width: 99%;font-family: SolaimanLipi !important;">

   <?php
        if($msg !="")
            { echo " <div class='top' style='width: 100%;height: auto;'>
                <b><font color='green;'>$msg</font></b></div>"; } 
    else { ?>
    <div style="width: 100%;font-family: SolaimanLipi !important;">
        
        <form method="post" action="">
            <table border="1" cellpadding="0" cellspacing="0">
                <tr>
                    <td>প্রোডাক্টের নাম : <input type="hidden" name="proid" value="<?php echo $g_proid?>"/><?php echo $db_productname;?></td>
                    <td>বর্তমানে পর্যাপ্ত পরিমান : <input type="hidden" name="proid" value="<?php echo $g_proid?>"/><?php echo $db_productname;?></td>
                </tr>
            </table>
            <fieldset style="border-width: 3px;width: 95%;">
                <legend style="color: brown;">প্রোডাক্টের সর্বশেষ ক্রয়ের মূল্য</legend>
                <table border="1" cellpadding="0" cellspacing="0" style="font-family: SolaimanLipi !important;">
                    <tr>
                        <td width="50%"><b>ক্রয়কৃত পরিমান :</b></td>
                        <td width="50%" style="text-align: left;"><b>ক্রয়ের তারিখ :</b></td>
                    </tr>
                    <tr>
                        <td colspan="2"><b>ক্রয়মূল্য</b><input type="text" readonly name="buyingprice" style="width: 100px;text-align: right;padding-right: 5px;font-size: 16px;" value="<?php echo $db_buying; ?>" /></td>
                    </tr>
                    <tr>
                        <td colspan="2"><b>বিক্রয়মূল্য</b><input type="text" name="sellingprice" value="<?php echo  $db_selling;?>" style="width: 100px;text-align: right;padding-right: 5px;font-size: 16px;" /></td>
                    </tr>
                    <tr>
                        <td colspan="2"><b>এক্সট্রা প্রফিট</b><input type="text" name="xprofit" value="<?php echo $db_xtraprofit;?>" style="width: 100px;text-align: right;padding-right: 5px;font-size: 16px;" /></td>
                    </tr>
                    <tr>
                        <td colspan="2"><b>প্রফিট</b><input type="text" name="xprofit" value="<?php echo $db_xtraprofit;?>" style="width: 100px;text-align: right;padding-right: 5px;font-size: 16px;" /></td>
                    </tr>
                    <tr>
                        <td colspan="2"><b>এক্সট্রা প্রফিট</b><input type="text" name="xprofit" value="<?php echo $db_xtraprofit;?>" style="width: 100px;text-align: right;padding-right: 5px;font-size: 16px;" /></td>
                    </tr>
                </table>
            </fieldset>
                <table cellpadding="0" cellspacing="0" style="font-family: SolaimanLipi !important;">
                    <tr>
                        <td>
                            <fieldset style="border-width: 3px;width: 95%;">
                                <legend style="color: brown;">প্রোডাক্টের বর্তমান মূল্য</legend>
                                <table border="1" cellpadding="0" cellspacing="0" style="font-family: SolaimanLipi !important;">
                                    <tr>
                                        <td width="50%"><b>ক্রয়কৃত পরিমান :</b></td>
                                        <td width="50%" style="text-align: left;"><b>ক্রয়ের তারিখ :</b></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"><b>ক্রয়মূল্য</b><input type="text" readonly name="buyingprice" style="width: 100px;text-align: right;padding-right: 5px;font-size: 16px;" value="<?php echo $db_buying; ?>" /></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"><b>বিক্রয়মূল্য</b><input type="text" name="sellingprice" value="<?php echo  $db_selling;?>" style="width: 100px;text-align: right;padding-right: 5px;font-size: 16px;" /></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"><b>এক্সট্রা প্রফিট</b><input type="text" name="xprofit" value="<?php echo $db_xtraprofit;?>" style="width: 100px;text-align: right;padding-right: 5px;font-size: 16px;" /></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"><b>প্রফিট</b><input type="text" name="xprofit" value="<?php echo $db_xtraprofit;?>" style="width: 100px;text-align: right;padding-right: 5px;font-size: 16px;" /></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"><b>এক্সট্রা প্রফিট</b><input type="text" name="xprofit" value="<?php echo $db_xtraprofit;?>" style="width: 100px;text-align: right;padding-right: 5px;font-size: 16px;" /></td>
                                    </tr>
                                </table>
                            </fieldset>
                        </td>
                        <td>
                            <fieldset style="border-width: 3px;width: 95%;">
                                <legend style="color: brown;">আপডেট প্রোডাক্টের মূল্য</legend>
                                <table border="1" cellpadding="0" cellspacing="0" style="font-family: SolaimanLipi !important;">
                                    <tr>
                                        <td width="50%"><b>ক্রয়কৃত পরিমান :</b></td>
                                        <td width="50%" style="text-align: left;"><b>ক্রয়ের তারিখ :</b></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"><b>ক্রয়মূল্য</b><input type="text" readonly name="buyingprice" style="width: 100px;text-align: right;padding-right: 5px;font-size: 16px;" value="<?php echo $db_buying; ?>" /></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"><b>বিক্রয়মূল্য</b><input type="text" name="sellingprice" value="<?php echo  $db_selling;?>" style="width: 100px;text-align: right;padding-right: 5px;font-size: 16px;" /></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"><b>এক্সট্রা প্রফিট</b><input type="text" name="xprofit" value="<?php echo $db_xtraprofit;?>" style="width: 100px;text-align: right;padding-right: 5px;font-size: 16px;" /></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"><b>প্রফিট</b><input type="text" name="xprofit" value="<?php echo $db_xtraprofit;?>" style="width: 100px;text-align: right;padding-right: 5px;font-size: 16px;" /></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"><b>এক্সট্রা প্রফিট</b><input type="text" name="xprofit" value="<?php echo $db_xtraprofit;?>" style="width: 100px;text-align: right;padding-right: 5px;font-size: 16px;" /></td>
                                    </tr>
                                </table>
                            </fieldset>
                        </td>
                    </tr>
                </table>
            <input type="submit" name="update" value="আপডেট" />
        </form>
            </div><?php }?>
</div></br>
</div>
  </div>
</body>
</html>
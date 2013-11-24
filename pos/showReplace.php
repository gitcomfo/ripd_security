<?php 
error_reporting(0);
include 'session.php';
include 'includes/ConnectDB.inc';
include_once 'includes/MiscFunctions.php';
$id= $_GET['ssumid'];
if(isset($_POST['replace']))
{
    $P_invoiceno = $_POST['reciptID'];
    $P_buyername = $_POST['buyname'];
    $P_buyeracc = $_POST['buyacc'];
    $P_buyertype = $_POST['buytype'];
    $P_buyerid = $_POST['buyid'];
    $P_arr_procode = $_POST['proCode'];
    $P_arr_proname = $_POST['proname'];
    $P_arr_soldQty = $_POST['soldqty'];
    $P_arr_soldprice = $_POST['soldprice'];
    $P_arr_inventSumID = $_POST['inventSumID'];
    $P_arr_replaceQty = $_POST['replaceUnit'];
    $repQtyCount = count($P_arr_replaceQty);
    for($i=0;$i<$repQtyCount; $i++)
    {
        if($P_arr_replaceQty[$i]!=="")
        {
        $replaceAmount = $P_arr_replaceQty[$i] * ($P_arr_soldprice[$i] / $P_arr_soldQty[$i] );
        mysql_query("INSERT INTO `replace_temp` (`reciptID` ,buyername, buyeracc, buyertype, buyerid, `inventory_sum_id` ,`product_code` ,`product_name` ,`sold_qty` ,`sold_price` ,`replace_qty` ,`replace_amount`)
                VALUES ( '$P_invoiceno','$P_buyername','$P_buyeracc', '$P_buyertype', '$P_buyerid', '$P_arr_inventSumID[$i]', '$P_arr_procode[$i]', '$P_arr_proname[$i]', '$P_arr_soldQty[$i]', '$P_arr_soldprice[$i]', '$P_arr_replaceQty[$i]', '$replaceAmount');") or exit ("coulnt insert into replace temp");
        }
        else continue;
    }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html " charset="utf-8"  />
<title>বিক্রয় চালান পত্র</title>
<link rel="stylesheet" type="text/css" href="css/print.css" media="print"/>
</head>
<body>

    <div align="center" style="font-family: SolaimanLipi !important;"><strong>রিপড ইউনিভার্সাল (রিলীভ এন্ড ইমপ্রুভমেন্ট প্ল্যান অব ডেপ্রাইভড) </strong></br>
বিক্রয় চালান পত্র</br><?php echo $_SESSION['offname'];?></br>
চালান নং: <?php echo $P_invoiceno;?> (পরিবর্তিত)</div></br>
<div style="float:left;font-family: SolaimanLipi !important;">ক্রেতার নাম: <?php echo $P_buyername;?></br>ক্রেতার অ্যাকাউন্ট নং / ক্রেতার মোবাইল নং :  <?php echo $P_buyeracc;?></div>
<div style="float:right;font-family: SolaimanLipi !important;">তারিখ : <?php echo english2bangla(date('d/m/Y'));?> সময়ঃ <?php echo english2bangla(date('g:i a' , strtotime('+4 hour')));?></div></br></br></br>
<fieldset   style="border-width: 3px;margin:0 5px;font-family: SolaimanLipi !important;">
<legend>পরিবর্তিত পণ্যের বিবরনি</legend>
<table width="100%" border="1" cellspacing="0" cellpadding="0" style="font-family: SolaimanLipi !important; font-size:14px;">
        <tr><td width="17%"><div align="center"><strong>প্রোডাক্ট কোড</strong></div></td>
        <td width="43%"><div align="center"><strong>প্রোডাক্ট-এর নাম</strong></div></td>
        <td width="10%"><div align="center"><strong>খুচরা মূল্য</strong></div></td>
        <td width="17%"><div align="center"><strong>ফেরতকৃত পরিমাণ</strong></div></td>
        <td width="13%"><div align="center"><strong>মোট টাকা</strong></div></td>
      </tr>
<?php
$selectReplaceTemp = mysql_query("SELECT * FROM replace_temp WHERE reciptID= '$P_invoiceno';");
while ($replaceRow = mysql_fetch_assoc($selectReplaceTemp))
  {
    $db_qty = $replaceRow['sold_qty'];
    $db_soldamount = $replaceRow['sold_price'];
    $sellingprc = ($db_soldamount / $db_qty);
    echo '<tr>';
      echo '<td><div align="center">'.$replaceRow['product_code'].'</div></td>';
        echo '<td><div align="left">&nbsp;&nbsp;&nbsp;'.$replaceRow['product_name'].'</div></td>';
        echo '<td><div align="center">'.english2bangla($sellingprc).'</div></td>';
        echo '<td><div align="center">'.english2bangla($replaceRow['replace_qty']).'</div></td>';
        echo '<td><div align="center">'.english2bangla($replaceRow['replace_amount']).'</div></td>';
        echo '</tr>';
}
$result = mysql_query("SELECT sum(replace_amount) FROM replace_temp where reciptID= '$P_invoiceno';");
 while($row2 = mysql_fetch_array($result))
         { $replacedGrndTotal=$row2['sum(replace_amount)']; }
?>
<td colspan="4" ><div align="right"><strong>ফেরতকৃত সর্বমোট:</strong>&nbsp;</div></td>
<td width="13%"><div align="right"><?php echo english2bangla($replacedGrndTotal);?></div></td>
</tr>
</table>
</fieldset>

<div align="center" style="width: 100%;font-family: SolaimanLipi !important;">
    <span id="noprint"><a  href="replace.php?edit=<?php echo $P_invoiceno;?>&id=<?php echo $id;?>" style="margin: 1% 5% 5% 35%;display: block;width: 100px;height: 100px;float: left;background-image: url('images/addToCart.jpeg');background-repeat: no-repeat;background-size:100% 100%;text-align:center;cursor:pointer;text-decoration:none;">
            <span  style="font-size:20px;font-weight:bolder;position: absolute;margin:100px 5px 10px -50px;">এডিট করুন </span></a></span>
<span id="noprint"><a href="newSale.php?selltype=3"  style="margin: 1% 5% 5% 5%;display: block;width: 100px;height: 100px;float: left;background-image: url('images/newSell.png');background-repeat: no-repeat;background-size:100% 100%;text-align:center;cursor:pointer;text-decoration:none;">
        <?php $_SESSION['recipt'] = $P_invoiceno; $_SESSION['repMoney']=$replacedGrndTotal;?><span  style="font-size:20px;font-weight:bolder;position: absolute;margin:100px 5px 10px -50px;">বিক্রয় করুন</span></a></span>
</div>

	  
</body>
</html>
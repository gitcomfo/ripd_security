<?php 
error_reporting(0);
require_once('auth.php');
include 'includes/ConnectDB.inc';
include_once 'includes/MiscFunctions.php';
$G_rID= $_SESSION['SESS_MEMBER_ID'];
$G_s_type = $_SESSION['catagory'];
$G_s_id= $_SESSION['offid'];
$cfsID = $_SESSION['cfsid'];
if(isset($_POST['print']))
{
    if($_POST['customerType']== 1)
    {
        $P_accNo = $_POST['accountNo'];
        $P_custname = $_POST['acName'];
        $custsql = mysql_query("SELECT * FROM cfs_user WHERE account_name= '$P_custname' AND account_number = '$P_accNo' ");
        $row = mysql_fetch_assoc($custsql);
        $buyerid = $row['idUser']; $buyertype = 'customer';
      }
    elseif($_POST['customerType']== 2)
    {
        $P_custname = $_POST['custName'];
        $P_custmbl = $_POST['custMbl'];
        $P_custoccu = $_POST['custOccupation'];
        $P_custadrs = $_POST['custAdrss'];
        $custsql = mysql_query("SELECT * FROM unregistered_customer WHERE unregcust_mobile= '$P_custmbl' ");
        $row = mysql_fetch_assoc($custsql);
        if($row == 0)
        {
            $insertsql = mysql_query("INSERT INTO `unregistered_customer` (`unregcust_name` ,`unregcust_address` ,`unregcust_occupation` ,`unregcust_mobile` ,`unregcust_email` ,`unregcust_buyingcount` ,`unregcust_status` ,`unregcust_lastupdated_date`) 
                    VALUES ('$P_custname', '$P_custadrs', '$P_custoccu', '$P_custmbl', '', '1', 'unregistered', NOW());") or exit ("could not insert unregister customer");
            $buyerid= mysql_insert_id();
        }
        else
        {
            $buycount = $row['unregcust_buyingcount'] +1;
            $upsql = mysql_query("UPDATE `unregistered_customer` SET `unregcust_buyingcount` = '$buycount' WHERE unregcust_mobile= '$P_custmbl' ") or exit("not updated");      
        }
        $buyertype='unregcustomer';
    }
    elseif($_POST['customerType']== 3)
    {
        $P_accNo = $_POST['empAccNo'];
        $P_custname = $_POST['empName'];
        $custsql = mysql_query("SELECT * FROM cfs_user WHERE account_name= '$P_custname' AND account_number = '$P_accNo'") or exit ("djhfkdsjhf");
        $row = mysql_fetch_assoc($custsql);
        $buyerid = $row['idUser'];
        $buyertype ='employee';
    }
    $P_getTaka=$_POST['cash'];
    $P_backTaka=$_POST['change'];
    $P_payType=$_POST['payType'];
    if($P_payType ==1)
    {
        $pay = "ক্যাশ";
    }
    else {$pay = "অ্যাকাউন্ট";}
}
$id=$_SESSION['SESS_MEMBER_ID'];
$result= mysql_query("SELECT * FROM `sales_summery` where sal_invoiceno='$id';");
        if (mysql_fetch_array($result)=="" )
        {
             $_SESSION['SESS_MEMBER_ID']=$_SESSION['SESS_MEMBER_ID'];
        }
        else
        {
            $forwhileloop = 1;
                while($forwhileloop==1)
                {
                    for($i=0;$i<3;$i++)
                        {
                            $str_random_no=(string)mt_rand (0 ,9999 );
                            $str_recipt_random= str_pad($str_random_no,4, "0", STR_PAD_LEFT);
                            $str_recipt =$str_recipt."-".$str_recipt_random;
                        }
                       $result1= mysql_query("SELECT * FROM `sales_summery` where sal_invoiceno='$str_recipt';");
                        if (mysql_fetch_array($result1)=="" )
                        {
                            $forwhileloop = 0;
                            break;
                        }
                }
                $_SESSION['SESS_MEMBER_ID']=$str_recipt;
        }
?>
 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html " charset="utf-8"  />
<title>বিক্রয় চালান পত্র</title>
<link rel="stylesheet" type="text/css" href="css/print.css" media="print"/>
<link rel="stylesheet" href="css/style.css" type="text/css" media="screen" charset="utf-8"/>
<link rel="stylesheet" href="css/css.css" type="text/css" media="screen" /> 
<script src="scripts/tinybox.js" type="text/javascript"></script>
<script type="text/javascript">
 function pinGenerate(ssumid,totalpv)
	{ TINY.box.show({url:'pinGenerator.php?ssumid='+ssumid+'&pv='+totalpv,animate:true,close:true,boxid:'success',top:100,width:400,height:100}); }
 </script> 
<script type="text/javascript">
 function accGenerate(ssumid)
	{ TINY.box.show({url:'accountGenerator.php?ssumid='+ssumid,animate:true,close:true,boxid:'success',top:100,width:800,height:500}); }
 </script> 
</head>
<body>

<div align="center" style="font-family: SolaimanLipi !important;"><strong>রিপড ইউনিভার্সাল (রিলীভ এন্ড ইমপ্রুভমেন্ট প্ল্যান অব ডেপ্রাইভড) </strong></br>
বিক্রয় চালান পত্র</br><?php echo $_SESSION['offname'];?></br>
চালান নং: <?php echo $_SESSION['SESS_MEMBER_ID'];?></div></br>
<div style="font-family: SolaimanLipi !important; width: 100%;">
    <div style="float:left">ক্রেতার নাম: <?php echo $P_custname;?><br />ক্রেতার অ্যাকাউন্ট নং : <?php echo $P_accNo;?> ক্রেতার মোবাইল নং : <?php echo $P_custmbl;?></div>
    <div style="float:right">তারিখ : <?php echo  english2bangla(date('d/m/Y'));?>
    সময়ঃ <?php echo english2bangla(date('g:i a' , strtotime('+4 hour')));?></div>
</div></br></br>
    <table width="100%" border="1" cellspacing="0" cellpadding="0" style="font-family: SolaimanLipi !important; font-size:14px;">
      <tr>
          <td width="17%"><div align="center"><strong>প্রোডাক্ট কোড</strong></div></td>
        <td width="43%"><div align="center"><strong>প্রোডাক্ট-এর নাম</strong></div></td>
        <td width="17%"><div align="center"><strong>পরিমাণ</strong></div></td>
        <td width="10%"><div align="center"><strong>খুচরা মূল্য</strong></div></td>
        <td width="13%"><div align="center"><strong>মোট টাকা</strong></div></td>
      </tr>
<?php
$f=$_SESSION['SESS_MEMBER_ID'];
$getresult = mysql_query("SELECT * FROM sales_temp where sales_receiptid = '$f'; ") or exit ('query failed');
while($row = mysql_fetch_array($getresult))
  {
      echo '<tr>';
      echo '<td><div align="center">'.$row['sales_product_code'].'</div></td>';
        echo '<td><div align="left">&nbsp;&nbsp;&nbsp;'.$row['sales_product_name'].'</div></td>';
        echo '<td><div align="center">'.english2bangla($row['sales_product_qty']).'</div></td>';
        echo '<td><div align="center">'.english2bangla($row['sales_product_sellprice']).'</div></td>';
        echo '<td><div align="center">'.english2bangla($row['sales_totalamount']).'</div></td>';
        echo '</tr>';
}
$result = mysql_query("SELECT sum(sales_totalamount) FROM sales_temp where sales_receiptid = '$f';");
 while($row2 = mysql_fetch_array($result))
         { $finalTotal=$row2['sum(sales_totalamount)']; }
?>
<td colspan="4" ><div align="right"><strong>সর্বমোট:</strong>&nbsp;</div></td>
<td width="13%"><div align="right" style="padding-right: 8px;"><?php echo english2bangla($finalTotal);?></div></td>
</tr>
<tr>
    <td colspan="4" ><div align="right"><strong>প্রদেয় টাকা:</strong>&nbsp;</div></td>
    <td width="13%" ><div align="right"  style="padding-right: 8px;"><?php echo english2bangla($finalTotal);?></div></td>
</tr>
<tr>
    <td colspan="4" ><div align="right"><strong>পেমেন্ট টাইপ:</strong>&nbsp;</div></td>
    <td width="13%" ><div align="right"  style="padding-right: 8px;"><?php echo $pay;?></div></td>
</tr>
<tr>
    <td colspan="4" ><div align="right"><strong>টাকা গ্রহন:</strong>&nbsp;</div></td>
    <td width="13%" ><div align="right"  style="padding-right: 8px;"><?php echo english2bangla($P_getTaka);?></div></td>
</tr>
<tr>
    <td colspan="4" ><div align="right"><strong>টাকা ফেরত:</strong>&nbsp;</div></td>
    <td width="13%" ><div align="right"><?php echo english2bangla($P_backTaka);?></div></td>
</tr>
</table>
<?php
    $P_buyertype = $buyertype;
    $P_buyerid = $buyerid;
    $reslt=mysql_query("SELECT sum(sales_totalamount), sum(sales_pv), sum(sales_buying_price) FROM sales_temp where sales_receiptid = '$G_rID'; ");
    $row1 = mysql_fetch_assoc($reslt);
    $db_totalamount = $row1['sum(sales_totalamount)'];
    $db_totalPV = $row1['sum(sales_pv)'];
    $db_totalbuy= $row1['sum(sales_buying_price)'];
    mysql_query("INSERT INTO sales_summery(sal_store_type, sal_storeid, sal_buyer_type,sal_buyerid, sal_salesdate ,sal_salestime ,sal_total_buying_price, sal_totalamount ,sal_totalpv ,sal_givenamount ,sal_invoiceno, cfs_userid) 
            VALUES ('$G_s_type', $G_s_id,'$P_buyertype', '$P_buyerid', CURDATE(), CURTIME(), $db_totalbuy, '$db_totalamount', '$db_totalPV', '$P_getTaka', '$G_rID', $cfsID);") or exit ("could not insert into salesSummery");
    $sales_sum_id= mysql_insert_id();
    $db_reslt= mysql_query("SELECT * FROM sales_temp WHERE sales_receiptid='$G_rID';");
    while($salesreslt=mysql_fetch_assoc($db_reslt))
    {
        $db_proInventID= $salesreslt['sales_inventory_sumid'];
        $db_qty = $salesreslt['sales_product_qty'];
        $db_amount = $salesreslt['sales_totalamount'];
        $db_pv = $salesreslt['sales_pv'];
        $db_buy= $salesreslt['sales_buying_price'];
        $sql_inven = mysql_query("SELECT * FROM inventory WHERE idinventory = $db_proInventID");
        $invenrow = mysql_fetch_assoc($sql_inven);
        $db_pro_profit = $invenrow['ins_profit'] * $db_qty;
        $db_pro_xprofit = $invenrow['ins_extra_profit'] * $db_qty;
                
        mysql_query("INSERT INTO sales(quantity ,sales_buying_price, sales_amount ,sales_pv , sales_profit, sales_extra_profit, inventory_idinventory ,sales_summery_idsalessummery) 
            VALUES ('$db_qty' ,$db_buy, '$db_amount', '$db_pv', $db_pro_profit, $db_pro_xprofit, '$db_proInventID', '$sales_sum_id');") or exit ("could not insert into sales");
    }
     ?></br>
<div align="center" style="width: 100%;font-family: SolaimanLipi !important;">
   <span id="noprint"><a href="javascript: window.print()"style="margin: 1% 5% 5% 20%;display: block;width: 100px;height: 100px;float: left;background-image: url('images/print-icon.png');background-repeat: no-repeat;background-size:100% 100%;text-align:center;cursor:pointer;text-decoration:none;">
        <span  style="font-size:20px;font-weight:bolder;position: absolute;margin:100px 5px 10px -15px;">প্রিন্ট </span></a></span>
<span id="noprint"><a href="saleAgain.php?selltype=1"  style="margin: 1% 5% 5% 5%;display: block;width: 100px;height: 100px;float: left;background-image: url('images/newSell.png');background-repeat: no-repeat;background-size:100% 100%;text-align:center;cursor:pointer;text-decoration:none;">
        <span  style="font-size:20px;font-weight:bolder;position: absolute;margin:100px 5px 10px -70px;">পুনরায় বিক্রয় করুন</span></a></span>
<?php if($buyertype == 'customer') {?>
    <span id="noprint" style="font-family: SolaimanLipi !important;">
    <a onclick="pinGenerate('<?php echo $sales_sum_id ?>','<?php echo $db_totalPV;?>')" style="margin: 1% 5% 5% 5%;display: block;width: 100px;height: 100px;float: left;background-image: url('images/pingenerator.png');background-repeat: no-repeat;background-size:100% 100%;text-align:center;cursor:pointer;text-decoration:none;">
<span  style="font-size:20px;font-weight:bolder;position: absolute;margin:100px 5px 10px -70px;">পিন নং জেনারেট করুন</span></a></span>
<?php } if($buyertype=='unregcustomer') {?>
<span id="noprint" style="font-family: SolaimanLipi !important;">
    <a onclick="accGenerate(<?php echo $sales_sum_id?>)" style="margin: 1% 5% 5% 5%;display: block;width: 100px;height: 100px;float: left;background-image: url('images/creatacc.png');background-repeat: no-repeat;background-size:100% 100%;text-align:center;cursor:pointer;text-decoration:none;">
<span  style="font-size:20px;font-weight:bolder;position: absolute;margin:100px 5px 10px -70px;">অ্যাকাউন্ট ওপেন করুন</span></a></span>
<?php }?>
</div></br>

</body>
</html>

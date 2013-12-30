<?php 
error_reporting(0);
session_start();
include_once './includes/connectionPDO.php';
include_once 'includes/MiscFunctions.php';

$G_s_type = $_SESSION['loggedInOfficeType'];
$G_s_id= $_SESSION['loggedInOfficeID'];
$cfsID = $_SESSION['userIDUser'];

$sel_sales_summery = $conn->prepare("SELECT * FROM `sales_summery` WHERE sal_invoiceno=? ");
$sel_cfs_user = $conn->prepare("SELECT * FROM cfs_user WHERE account_name= ? AND account_number = ? ");
$sel_unreg_customer = $conn->prepare("SELECT * FROM unregistered_customer WHERE unregcust_mobile=? ");
$ins_unreg_customer = $conn->prepare("INSERT INTO `unregistered_customer` (`unregcust_name` ,`unregcust_address` ,`unregcust_occupation` ,`unregcust_mobile` ,`unregcust_email` ,`unregcust_buyingcount` ,`unregcust_status` ,`unregcust_lastupdated_date`) 
                    VALUES (?, ?, ?, ?, '', '1', 'unregistered', NOW())");
$up_ureg_customer = $conn->prepare("UPDATE `unregistered_customer` SET `unregcust_buyingcount` = ? WHERE unregcust_mobile= ? ");
$ins_sales_summery = $conn->prepare("INSERT INTO sales_summery(sal_store_type, sal_storeid, sal_buyer_type,sal_buyerid, sal_salesdate ,sal_salestime ,sal_total_buying_price, sal_totalamount ,sal_totalpv ,sal_givenamount ,sal_invoiceno, cfs_userid) 
            VALUES (?, ?, ?, ?, CURDATE(), CURTIME(), ?, ?, ?, ?, ?, ?)");
$ins_sales = $conn->prepare("INSERT INTO sales(quantity ,sales_buying_price, sales_amount ,sales_pv , sales_profit, sales_extra_profit, inventory_idinventory ,sales_summery_idsalessummery) 
            VALUES (? ,?, ?, ?, ?, ?, ?, ?);");

if(isset($_POST['print']))
{
    if($_POST['customerType']== 1) // ******** ক্রেতা নির্ধারণ*********************************
    {
        $P_accNo = $_POST['accountNo'];
        $P_custname = $_POST['acName'];
        $sel_cfs_user->execute(array($P_custname,$P_accNo));
        $custsql = $sel_cfs_user->fetchAll();
        foreach ($custsql as $row) {
            $buyerid = $row['idUser']; 
            $buyertype = 'customer';
        }
      }
    elseif($_POST['customerType']== 2)
    {
        $P_custname = $_POST['custName'];
        $P_custmbl = $_POST['custMbl'];
        $P_custoccu = $_POST['custOccupation'];
        $P_custadrs = $_POST['custAdrss'];
        $sel_unreg_customer->execute(array($P_custmbl));
        $row = $sel_unreg_customer->fetchAll();
        if(count($row) < 1)
        {
            $ins_unreg_customer->execute(array($P_custname,$P_custadrs,$P_custoccu,$P_custmbl));
            $buyerid= $conn->lastInsertId();
        }
        else
        {
            foreach ($row as $value) {
                $buycount = $value['unregcust_buyingcount'] +1;
                $up_ureg_customer->execute(array($buycount,$P_custmbl));
            }
        }
        $buyertype='unregcustomer';
    }
    elseif($_POST['customerType']== 3)
    {
        $P_accNo = $_POST['empAccNo'];
        $P_custname = $_POST['empName'];
        $sel_cfs_user->execute(array($P_custname,$P_accNo));
        $custsql = $sel_cfs_user->fetchAll();
        foreach ($custsql as $row) {
            $buyerid = $row['idUser'];
            $buyertype ='employee';
        }
    }
    // পোস্ট ডাটা ****************************************
    $P_getTaka=$_POST['cash'];
    $P_backTaka=$_POST['change'];
    $P_payType=$_POST['payType'];
    if($P_payType ==1)
    {
        $pay = "ক্যাশ";
    }
    else {$pay = "অ্যাকাউন্ট";}
}
$id=$_SESSION['SESS_MEMBER_ID']; // চালান নং যাচাই**********************
$sel_sales_summery->execute(array($id));
$result= $sel_sales_summery->fetchAll();
        if (count($result)<1)
        {
             $_SESSION['SESS_MEMBER_ID']=$_SESSION['SESS_MEMBER_ID'];
        }
        else
        {
            $forwhileloop = 1;
                while($forwhileloop==1)
                {
                    $str_recipt = "RIPD";
                    for($i=0;$i<3;$i++)
                        {
                            $str_random_no=(string)mt_rand (0 ,9999 );
                            $str_recipt_random= str_pad($str_random_no,4, "0", STR_PAD_LEFT);
                            $str_recipt =$str_recipt."-".$str_recipt_random;
                        }
                        $sel_sales_summery->execute(array($str_recipt));
                        $result1= $sel_sales_summery->fetchAll();
                        if (count($result1) < 1)
                        {
                            $forwhileloop = 0;
                            break;
                        }
                }
              $_SESSION['SESS_MEMBER_ID']=$str_recipt;
        }
    $totalamount =0; $totalPV = 0; $totalbuy = 0;
             foreach($_SESSION['arrSellTemp'] as $key => $row) {
                   $totalamount = $totalamount + $row[5];
                   $totalPV = $totalPV + $row[6];
                   $totalbuy = $totalbuy + $row[2];
              }
    $invoiceNo = $_SESSION['SESS_MEMBER_ID'];
    $ins_sales_summery->execute(array($G_s_type,$G_s_id,$buyertype,$buyerid,$totalbuy,$totalamount,$totalPV,$P_getTaka,$invoiceNo,$cfsID));
    $sales_sum_id= $conn->lastInsertId();

    foreach($_SESSION['arrSellTemp'] as $key => $row) 
    {
        $pro_qty = $row[4];
        $pro_amount = $row[5];
        $pro_pv = $row[6];
        $pro_buy= $row[2];
        $invenrow = $_SESSION['pro_inventory_array'][$key];
        $pro_profit = $invenrow['ins_profit'] * $pro_qty;
        $pro_xprofit = $invenrow['ins_extra_profit'] * $pro_qty;
        $ins_sales->execute(array($pro_qty,$pro_buy,$pro_amount,$pro_pv,$pro_profit,$pro_xprofit,$key,$sales_sum_id));
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
বিক্রয় চালান পত্র</br><?php echo $_SESSION['loggedInOfficeName'];?></br>
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
        <td width="10%"><div align="center"><strong>খুচরা মূল্য</strong></div></td>
        <td width="17%"><div align="center"><strong>পরিমাণ</strong></div></td>
        <td width="13%"><div align="center"><strong>মোট টাকা</strong></div></td>
      </tr>
<?php
 foreach($_SESSION['arrSellTemp'] as $key => $row) 
  {
      echo '<tr>';
      echo '<td><div align="left">'.$row[0].'</div></td>';
        echo '<td><div align="left">&nbsp;&nbsp;&nbsp;'.$row[1].'</div></td>';
        echo '<td><div align="center">'.english2bangla($row[3]).'</div></td>';
        echo '<td><div align="center">'.english2bangla($row[4]).'</div></td>';
        echo '<td><div align="center">'.english2bangla($row[5]).'</div></td>';
        echo '</tr>';
}
 $finalTotal =0;
             foreach($_SESSION['arrSellTemp'] as $key => $row) {
                   $finalTotal = $finalTotal + $row[5];
              }
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
    <td width="13%" ><div align="right" style="padding-right: 8px;"><?php echo english2bangla($P_backTaka);?></div></td>
</tr>
</table>
<?php
    
     ?></br>
<div align="center" style="width: 100%;font-family: SolaimanLipi !important;">
   <span id="noprint"><a href="javascript: window.print()"style="margin: 1% 5% 5% 20%;display: block;width: 100px;height: 100px;float: left;background-image: url('images/print-icon.png');background-repeat: no-repeat;background-size:100% 100%;text-align:center;cursor:pointer;text-decoration:none;">
        <span  style="font-size:20px;font-weight:bolder;position: absolute;margin:100px 5px 10px -15px;">প্রিন্ট </span></a></span>
<span id="noprint"><a href="saleAgain.php?selltype=1"  style="margin: 1% 5% 5% 5%;display: block;width: 100px;height: 100px;float: left;background-image: url('images/newSell.png');background-repeat: no-repeat;background-size:100% 100%;text-align:center;cursor:pointer;text-decoration:none;">
        <span  style="font-size:20px;font-weight:bolder;position: absolute;margin:100px 5px 10px -70px;">পুনরায় বিক্রয় করুন</span></a></span>
<?php if($buyertype == 'customer') {?>
    <span id="noprint" style="font-family: SolaimanLipi !important;">
    <a onclick="pinGenerate('<?php echo $sales_sum_id ?>','<?php echo $totalPV;?>')" style="margin: 1% 5% 5% 5%;display: block;width: 100px;height: 100px;float: left;background-image: url('images/pingenerator.png');background-repeat: no-repeat;background-size:100% 100%;text-align:center;cursor:pointer;text-decoration:none;">
<span  style="font-size:20px;font-weight:bolder;position: absolute;margin:100px 5px 10px -70px;">পিন নং জেনারেট করুন</span></a></span>
<?php } if($buyertype=='unregcustomer') {?>
<span id="noprint" style="font-family: SolaimanLipi !important;">
    <a onclick="accGenerate(<?php echo $sales_sum_id?>)" style="margin: 1% 5% 5% 5%;display: block;width: 100px;height: 100px;float: left;background-image: url('images/creatacc.png');background-repeat: no-repeat;background-size:100% 100%;text-align:center;cursor:pointer;text-decoration:none;">
<span  style="font-size:20px;font-weight:bolder;position: absolute;margin:100px 5px 10px -70px;">অ্যাকাউন্ট ওপেন করুন</span></a></span>
<?php }?>
</div></br>

</body>
</html>

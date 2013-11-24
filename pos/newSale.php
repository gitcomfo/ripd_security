<?php
error_reporting(0);
include 'session.php';
include 'includes/ConnectDB.inc';
$storeName= $_SESSION['offname'];
$cfsID = $_SESSION['cfsid'];
$storeID = $_SESSION['offid'];
$scatagory = $_SESSION['catagory'];
$G_sellingType = $_GET['selltype'];
$str_recipt= "RIPD";
$forwhileloop = 1;
while($forwhileloop==1)
{
    for($i=0;$i<3;$i++)
        {
            $str_random_no=(string)mt_rand (0 ,9999 );
            $str_recipt_random= str_pad($str_random_no,4, "0", STR_PAD_LEFT);
            $str_recipt =$str_recipt."-".$str_recipt_random;
        }
       $result= mysql_query("SELECT * FROM `sales_summery` where sal_invoiceno='$str_recipt';");
        if (mysql_fetch_array($result)=="" )
        {
            $forwhileloop = 0;
            break;
        }
}   
$_SESSION['SESS_MEMBER_ID']=$str_recipt;
if($G_sellingType==1)
{
header("location: auto.php");
}
elseif($G_sellingType==2)
{
    header("location: wholesale.php");
}
elseif($G_sellingType==3)
{
     $prevRecipt = $_SESSION['recipt'];
    $reslt=mysql_query("SELECT sum(replace_amount) FROM replace_temp WHERE reciptID='$prevRecipt'; ");
    $row1 = mysql_fetch_assoc($reslt);
    $db_totalamount = $row1['sum(replace_amount)'];
   
    mysql_query("INSERT INTO replace_product_summary(reprosum_store_type,reprosum_storeid,reprosum_replace_date , reprosum_replace_time ,reprosum_total_amount ,reprosum_invoiceno,cfs_userid) 
                        VALUES ('$scatagory',$storeID,CURDATE(), CURTIME(), '$db_totalamount', '$prevRecipt',$cfsID);") or exit ("could not insert into replaceSummary".mysql_error());
    $replace_pro_sum_id= mysql_insert_id();
    $rTempSelect = mysql_query("SELECT * FROM `replace_temp` WHERE reciptID='$prevRecipt';");
    while($rTempRow = mysql_fetch_assoc($rTempSelect))
    {
        $db_qty=$rTempRow['replace_qty'];
        $db_amount=$rTempRow['replace_amount'];
        $db_inventID=$rTempRow['inventory_sum_id'];
        mysql_query("INSERT INTO replace_product(reppro_quantity ,reppro_amount ,inventory_idinventory ,replace_product_summary_idreproductsum) 
            VALUES ('$db_qty' , '$db_amount', '$db_inventID', '$replace_pro_sum_id');") or exit ("could not insert into replace_product".mysql_error());
       }
   
    mysql_query("delete from replace_temp WHERE reciptID='$prevRecipt';") or exit ("could not delete data!!");
    header("location: sellAfterReplace.php");
}
?>
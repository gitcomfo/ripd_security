<?php
include 'includes/ConnectDB.inc';
if (isset($_GET['code']))
{
    $location =   $_GET['selltype'];
    $dltItem = $_GET['code'];
        $receiptID = $_SESSION['SESS_MEMBER_ID'];
       mysql_query("DELETE FROM sales_temp where sales_product_code='$dltItem' AND sales_receiptid='$receiptID';") or exit("could not delete item");
       header("location: $location");
}
if (isset($_GET['storeID']))
{
    
    $store = $_GET['storeID'];
    $procodeID = $_GET['code'];
    $cat= $_GET['storeCat'];
       mysql_query("DELETE FROM product_temp where store_id='$store' AND store_type='$cat' AND pro_code='$procodeID';") or exit("could not delete item");
       header("location: productIN.php");
}
?>
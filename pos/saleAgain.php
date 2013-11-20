<?php
error_reporting(0);
require_once('auth.php');
include 'includes/ConnectDB.inc';
$G_rID= $_SESSION['SESS_MEMBER_ID'];
$G_s_type = $_SESSION['catagory'];
$G_s_id= $_SESSION['offid'];
$cfsID = $_SESSION['cfsid'];

if($_GET['selltype']==1)
{
    mysql_query("delete from sales_temp where sales_receiptid='$G_rID';") or exit ("could not delete data!!");
    unset($_SESSION['SESS_MEMBER_ID']);
    header("location: newSale.php?selltype=1");
}
//for wholesale....................................................
elseif($_GET['selltype']==2)
{
    

    mysql_query("delete from sales_temp where sales_receiptid='$G_rID';") or exit ("could not delete data!!");
    unset($_SESSION['SESS_MEMBER_ID']);
    header("location: newSale.php?selltype=2");
}

?>
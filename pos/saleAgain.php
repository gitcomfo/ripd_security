<?php
error_reporting(0);
include 'includes/ConnectDB.inc';
$G_rID= $_SESSION['SESS_MEMBER_ID'];
//$G_s_type = $_SESSION['loggedInOfficeType'];
//$G_s_id= $_SESSION['loggedInOfficeID'];
//$cfsID = $_SESSION['userIDUser'];

if($_GET['selltype']==1)
{
    unset($_SESSION['arrSellTemp']);
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
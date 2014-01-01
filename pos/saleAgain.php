<?php
error_reporting(0);
session_start();
if($_GET['selltype']==1)
{
    unset($_SESSION['arrSellTemp']);
    unset($_SESSION['SESS_MEMBER_ID']);
    header("location: newSale.php?selltype=1");
}
//for wholesale....................................................
elseif($_GET['selltype']==2)
{
    unset($_SESSION['arrSellTemp']);
    unset($_SESSION['SESS_MEMBER_ID']);
    header("location: newSale.php?selltype=2");
}
?>
<?php
error_reporting(0);
session_start();
include_once 'ConnectDB.inc';
 $p_user_name = $_SESSION['UserID'];
 //echo 'Account: '.$p_acc;
 $p_pass = md5($_GET['pass']);

$cfs_query = mysql_query("SELECT * FROM cfs_user WHERE user_name= '$p_user_name' AND password='$p_pass';");
$y = mysql_num_rows($cfs_query);
if($y <= 0)
{
    echo "দুঃখিত, অ্যাকাউন্ট নং এবং পাসওয়ার্ড ম্যাচ  হয়নি";
}
 else {
    echo "OK";
}
?>

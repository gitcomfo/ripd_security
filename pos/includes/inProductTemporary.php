<?php
session_start();
if (!isset($_SESSION['proarray']))
{
 $_SESSION['proarray'] = array();
}
$g_name = $_GET['name'];
$g_code = $_GET['code'];
$g_qty = $_GET['totalQty'];
$g_total = $_GET['amount'];
$tkPerQty = $g_total / $g_qty;
$arr_temp = array($g_name,$g_code,$g_qty,$tkPerQty);
//array_push($_SESSION['proarray'],$arr_temp);
$_SESSION['proarray'][] = $arr_temp;

?>

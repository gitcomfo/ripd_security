<?php
session_start();
if (!isset($_SESSION['arrProductTemp']))
{
 $_SESSION['arrProductTemp'] = array();
}
if(isset($_GET['name']))
{
    $g_chartID = $_GET['chartID'];
    $g_name = $_GET['name'];
    $g_code = $_GET['code'];
    $g_qty = $_GET['totalQty'];
    $g_total = $_GET['amount'];
    $tkPerQty = round(($g_total / $g_qty),2);
    $arr_temp = array($g_name,$g_code,$g_qty,$g_total,$tkPerQty);
    $_SESSION['arrProductTemp'][$g_chartID] = $arr_temp;
}

elseif (isset ($_GET['type'])) {
    $g_id = $_GET['chartID'];
    unset($_SESSION['arrProductTemp'][$g_id]);
}
?>

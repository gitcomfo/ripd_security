<?php
error_reporting(0);
session_start();
if (!isset($_SESSION['arrSellTemp']))
{
 $_SESSION['arrSellTemp'] = array();
}

if($_GET['selltype']==1)
{
    $P_pname=$_GET['name'];
     $P_QTY=$_GET['qty'];
     $P_TOTAL=$_GET['total'];
     $P_price=$_GET['selling'];
     $P_buy= $_GET['buying'];
     $P_inventoryID=$_GET['id'];
     $P_procode=$_GET['code'];
     $P_pv=$_GET['totalpv'];
     $arr_temp = array($P_procode,$P_pname,$P_buy,$P_price,$P_QTY,$P_TOTAL,$P_pv);
    $_SESSION['arrSellTemp'][$P_inventoryID] = $arr_temp;
}
elseif($_GET['selltype']==3)
{
    $P_pname=$_GET['name'];
     $P_QTY=$_GET['qty'];
     $P_TOTAL=$_GET['total'];
     $P_price=$_GET['selling'];
     $P_inventoryID=$_GET['id'];
     $P_procode=$_GET['code'];
     $P_pv=$_GET['totalpv'];
     $P_buy= $_GET['buying'];
    $arr_temp = array($P_procode,$P_pname,$P_buy,$P_price,$P_QTY,$P_TOTAL,$P_pv);
    $_SESSION['arrSellTemp'][$P_inventoryID] = $arr_temp;
}

elseif($_GET['selltype']==2)
{
    $P_pname=$_GET['name'];
     $P_QTY=$_GET['qty'];
     $P_subTotal=$_GET['total'];
     $P_price=$_GET['selling'];
     $P_buy= $_GET['buying'];
     $P_inventoryID=$_GET['id'];
     $P_procode=$_GET['code'];
     $P_pv=$_GET['totalpv'];
     $P_profitLess=$_GET['lessProfit'];
     $P_xtraprofitLess=$_GET['lessxtraProfit'];
     $totalAmount = $P_subTotal - ($P_profitLess + $P_xtraprofitLess);
     $arr_temp = array($P_procode, $P_pname,$P_buy, $P_price, $P_QTY, $totalAmount, $P_pv, $P_profitLess, $P_xtraprofitLess);
     
     $_SESSION['arrSellTemp'][$P_inventoryID] = $arr_temp;
}
?>
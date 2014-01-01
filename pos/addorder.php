<?php
error_reporting(0);
session_start();
include 'includes/connectionPDO.php';
if (!isset($_SESSION['arrSellTemp']))
{
 $_SESSION['arrSellTemp'] = array();
}
//$sql = "INSERT INTO sales_temp(sales_receiptid ,sales_product_code ,sales_product_name ,sales_inventory_sumid ,sales_buying_price, sales_product_sellprice ,sales_product_qty , sales_totalamount ,sales_pv) 
//            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
//$stmt = $conn->prepare($sql);
//$wholesql = "INSERT INTO sales_temp(sales_receiptid ,sales_product_code ,sales_product_name ,sales_inventory_sumid ,sales_buying_price, sales_product_sellprice ,sales_product_qty , sales_totalamount ,sales_pv ,sales_less_profit, sales_less_extraprofit) 
//            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
//$wholestmt = $conn->prepare($wholesql);

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
    $P_pname=$_POST['PNAME'];
     $P_QTY=$_POST['QTY'];
     $P_TOTAL=$_POST['TOTAL'];
     $P_recipt=$_POST['recipt'];
     $P_price=$_POST['PPRICE'];
     $P_inventoryID=$_POST['inventoryID'];
     $P_procode=$_POST['procode'];
     $P_pv=$_POST['subTotalpv'];
     $P_buy= $_POST['buyprice'];
   
   $stmt->execute(array($P_recipt, $P_procode,$P_pname, $P_inventoryID, $P_buy, $P_price, $P_QTY, $P_TOTAL, $P_pv));
    header("location: sellAfterReplace.php");
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
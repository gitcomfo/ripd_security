<?php
error_reporting(0);
include 'session.php';
include 'includes/connectionPDO.php';
$sql = "INSERT INTO sales_temp(sales_receiptid ,sales_product_code ,sales_product_name ,sales_inventory_sumid ,sales_buying_price, sales_product_sellprice ,sales_product_qty , sales_totalamount ,sales_pv) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$wholesql = "INSERT INTO sales_temp(sales_receiptid ,sales_product_code ,sales_product_name ,sales_inventory_sumid ,sales_buying_price, sales_product_sellprice ,sales_product_qty , sales_totalamount ,sales_pv ,sales_less_profit, sales_less_extraprofit) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
$wholestmt = $conn->prepare($wholesql);

if($_GET['selltype']==1)
{
    $P_pname=$_POST['PNAME'];
     $P_QTY=$_POST['QTY'];
     $P_TOTAL=$_POST['TOTAL'];
     $P_recipt=$_POST['recipt'];
     $P_price=$_POST['PPRICE'];
     $P_buy= $_POST['buyprice'];
     $P_inventoryID=$_POST['inventoryID'];
     $P_procode=$_POST['procode'];
     $P_pv=$_POST['subTotalpv'];
   $stmt->execute(array($P_recipt, $P_procode,$P_pname, $P_inventoryID, $P_buy, $P_price, $P_QTY, $P_TOTAL, $P_pv));
 header("location: auto.php");
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
    $P_pname=$_POST['PNAME'];
     $P_QTY=$_POST['QTY'];
     $P_subTotal=$_POST['TOTAL'];
     $P_recipt=$_POST['recipt'];
     $P_price=$_POST['PPRICE'];
     $P_buy= $_POST['buyprice'];
     $P_inventoryID=$_POST['inventoryID'];
     $P_procode=$_POST['procode'];
     $P_pv=$_POST['subTotalpv'];
     $P_profitLess=$_POST['lessProfit'];
     $P_xtraprofitLess=$_POST['lessxtraProfit'];
     echo $totalAmount = $P_subTotal - ($P_profitLess + $P_xtraprofitLess);
    
    $wholestmt->execute(array($P_recipt, $P_procode, $P_pname, $P_inventoryID, $P_buy, $P_price, $P_QTY, $totalAmount, $P_pv, $P_profitLess, $P_xtraprofitLess));
header("location: wholesale.php");
}
?>
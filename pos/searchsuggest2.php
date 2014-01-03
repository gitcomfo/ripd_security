<?php
error_reporting(0);
session_start();
include 'includes/ConnectDB.inc';
$storeID = $_SESSION['loggedInOfficeID'];
$scatagory =$_SESSION['loggedInOfficeType'];

//-------------------------- all Product chart list---------------------
if (!isset($_SESSION['pro_chart_array']))
{
 $_SESSION['pro_chart_array'] = array();
    $reslt = mysql_query("SELECT idproductchart, pro_code, pro_productname FROM product_chart ORDER BY pro_code");
    while ($suggest = mysql_fetch_assoc($reslt)){
        $_SESSION['pro_chart_array'][] = $suggest;
    }
}
//-------------------------- all Product inventory list---------------------
if (!isset($_SESSION['pro_inventory_array']))
{
 $_SESSION['pro_inventory_array'] = array();
    $reslt = mysql_query("SELECT * FROM inventory WHERE ins_ons_id=$storeID AND ins_ons_type='$scatagory' ORDER BY ins_productname");
    while ($suggest = mysql_fetch_assoc($reslt)){
        $inventID = $suggest['idinventory'];
        $_SESSION['pro_inventory_array'][$inventID] = $suggest;
    }
}
//--------------------------- searches----------------------------------------------
if (isset($_GET['searchs']) && $_GET['searchs'] != '') {
	//Add slashes to any quotes to avoid SQL problems.
	$search = $_GET['searchs'];
                    $location = $_GET['selltype'];
	foreach ($_SESSION['pro_inventory_array'] as $k => $v) {
                        if (stripos($v['ins_product_code'], $search) !== false) {
                            echo "<a class='prolinks' style='text-decoration:none;color:brown;display:block;' href=".$location."?code=" . $v['idinventory'] . ">".$v['ins_product_code']." ".$v['ins_productname']."</a>";
                        }
                    }
}

if (isset($_GET['searchKey']) && $_GET['searchKey'] != '') {
	//Add slashes to any quotes to avoid SQL problems.
	$str_key = $_GET['searchKey'];
                  $location = $_GET['where'];
	foreach ($_SESSION['pro_inventory_array'] as $k => $v) {
                        if (stripos($v['ins_productname'], $str_key) !== false) {
                            echo "<a class='prolinks' style='text-decoration:none;color:brown;display:block;' href=".$location."?code=" . $v['idinventory'] . ">".$v['ins_productname']."</a>";
                        }
                    }
}

if (isset($_GET['searchcode']) && $_GET['searchcode'] != '') {
	$str_key = $_GET['searchcode'];
                  $location = $_GET['where'];
                    foreach ($_SESSION['pro_chart_array'] as $k => $v) {
                        if (stripos($v['pro_code'], $str_key) !== false) {
                            echo "<a class='prolinks' style='text-decoration:none;color:brown;display:block;' href=".$location."?code=" . $v['idproductchart'] . ">" . $v['pro_code']." ".$v['pro_productname']."</a>";
                        }
                    }
}

if (isset($_GET['searchname']) && $_GET['searchname'] != '') {
	$str_key = $_GET['searchname'];
                  $location = $_GET['where'];
	foreach ($_SESSION['pro_chart_array'] as $k => $v) {
                        if (stripos($v['pro_productname'], $str_key) !== false) {
	            echo "<a class='prolinks' style='text-decoration:none;color:brown;display:block;' href=".$location."?code=" . $v['idproductchart'] . ">" . $v['pro_productname'] . "</a>";
                        }
                }
}
?>
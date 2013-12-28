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
    if (mysql_num_rows($reslt) < 1) {
        echo "দুঃখিত, এই নাম্বারের কোনো একাউন্ট নেই";
    }
    while ($suggest = mysql_fetch_assoc($reslt)){
        $_SESSION['pro_chart_array'][] = $suggest;
    }
}

if (isset($_GET['searchs']) && $_GET['searchs'] != '') {
	//Add slashes to any quotes to avoid SQL problems.
	$search = $_GET['searchs'];
                    $location = $_GET['selltype'];
	$suggest_query = "SELECT * FROM inventory WHERE ins_product_code like('%" .$search . "%') AND ins_ons_id=$storeID AND ins_ons_type='$scatagory' ORDER BY ins_product_code";
	$reslt= mysql_query($suggest_query);
	while($suggest = mysql_fetch_assoc($reslt)) {
                  echo "<a class='prolinks' style='text-decoration:none;color:brown;display:block;' href=".$location."?code=" . $suggest['idinventory'] . ">" . $suggest['ins_product_code'] ." ".$suggest['ins_productname'] ."</a>";
                                                                                                                                                                
	}
}

if (isset($_GET['searchKey']) && $_GET['searchKey'] != '') {
	//Add slashes to any quotes to avoid SQL problems.
	$str_key = $_GET['searchKey'];
                  $location = $_GET['where'];
	$suggest_query = "SELECT * FROM inventory WHERE ins_productname like('$str_key%') AND ins_ons_id=$storeID AND ins_ons_type='$scatagory' ORDER BY ins_productname";
	$reslt= mysql_query($suggest_query);
	while($suggest = mysql_fetch_assoc($reslt)) {
	            echo "<a class='prolinks' style='text-decoration:none;color:brown;display:block;' href=".$location."?code=" . $suggest['idinventory'] . ">" . $suggest['ins_productname'] . "</a>";
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
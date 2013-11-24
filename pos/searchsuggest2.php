<?php
error_reporting(0);
include 'includes/ConnectDB.inc';
$storeID = $_SESSION['offid'];
$scatagory = $_SESSION['catagory'];

if (isset($_GET['searchs']) && $_GET['searchs'] != '') {
	//Add slashes to any quotes to avoid SQL problems.
	$search = $_GET['searchs'];
                    $location = $_GET['selltype'];
	$suggest_query = "SELECT * FROM inventory WHERE ins_product_code like('%" .$search . "%') AND ins_ons_id=$storeID AND ins_ons_type='$scatagory' ORDER BY ins_product_code";
	$reslt= mysql_query($suggest_query);
	while($suggest = mysql_fetch_assoc($reslt)) {
                  echo "<a style='text-decoration:none;color:brown;' href=".$location."?code=" . $suggest['idinventory'] . ">" . $suggest['ins_product_code'] . "</a></br>";
                  
	}
}

if (isset($_GET['searchKey']) && $_GET['searchKey'] != '') {
	//Add slashes to any quotes to avoid SQL problems.
	$str_key = $_GET['searchKey'];
                  $location = $_GET['where'];
	$suggest_query = "SELECT * FROM inventory WHERE ins_productname like('$str_key%') AND ins_ons_id=$storeID AND ins_ons_type='$scatagory' ORDER BY ins_productname";
	$reslt= mysql_query($suggest_query);
	while($suggest = mysql_fetch_assoc($reslt)) {
	            echo "<a style='text-decoration:none;color:brown;' href=".$location."?code=" . $suggest['idinventory'] . ">" . $suggest['ins_productname'] . "</a></br>";
        	}
}
if (isset($_GET['searchcode']) && $_GET['searchcode'] != '') {
	//Add slashes to any quotes to avoid SQL problems.
	$str_key = $_GET['searchcode'];
                  $location = $_GET['where'];
	$suggest_query = "SELECT * FROM  product_chart WHERE pro_code like('%" .$str_key . "%') ORDER BY pro_code";
	$reslt= mysql_query($suggest_query);
	while($suggest = mysql_fetch_assoc($reslt)) {
	            echo "<a style='text-decoration:none;color:brown;' href=".$location."?code=" . $suggest['idproductchart'] . ">" . $suggest['pro_code'] . "</a></br>";
        	}
}
if (isset($_GET['searchname']) && $_GET['searchname'] != '') {
	//Add slashes to any quotes to avoid SQL problems.
	$str_key = $_GET['searchname'];
                    $location = $_GET['where'];
	$suggest_query = "SELECT * FROM  product_chart WHERE pro_productname like('$str_key%') ORDER BY pro_productname";
	$reslt= mysql_query($suggest_query);
	while($suggest = mysql_fetch_assoc($reslt)) {
	            echo "<a style='text-decoration:none;color:brown;' href=".$location."?code=" . $suggest['idproductchart'] . ">" . $suggest['pro_productname'] . "</a></br>";
        	}
}
?>
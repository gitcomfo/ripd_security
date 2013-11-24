<?php
//error_reporting(0);
include 'ConnectDB.inc';
if (isset($_GET['key']) && $_GET['key'] != '') {
	//Add slashes to any quotes to avoid SQL problems.
	$str_key = $_GET['key'];
                    $location = $_GET['location'];
	$suggest_query = "SELECT * FROM  product_chart WHERE pro_productname like('$str_key%') ORDER BY pro_productname";
	$reslt= mysql_query($suggest_query);
	while($suggest = mysql_fetch_assoc($reslt)) {
	            echo "<a style='text-decoration:none;color:brown;'href=".$location."?code=" . $suggest['idproductchart'] . ">" . $suggest['pro_productname'] . "</a></br>";
        	}
                
}
elseif (isset($_GET['key']) && $_GET['key'] == "") {
	//Add slashes to any quotes to avoid SQL problems.
	$location = $_GET['location'];
        header("Location:package_inventory.php");       
}
?>
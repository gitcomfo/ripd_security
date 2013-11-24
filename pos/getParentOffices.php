<?php
//error_reporting(0);
include 'ConnectDB.inc';
if (isset($_GET['searchkey']) && $_GET['searchkey'] != '') {
	//Add slashes to any quotes to avoid SQL problems.
	$str_key = $_GET['searchkey'];
                    $type = $_GET['officetype'];
	$suggest_query = "SELECT * FROM  office WHERE account_number like('$str_key%') AND office_selection= '$type' ORDER BY account_number";
	$reslt= mysql_query($suggest_query);
	while($suggest = mysql_fetch_assoc($reslt)) {
                    $acc = $suggest['account_number'];
	            echo "<a onclick='setParent('".$suggest['account_number']."');' style='text-decoration:none;color:brown;'>" . $suggest['account_number'] . " (".$suggest['office_name'].")</a></br>";
        	}
                
}
?>
<?php
error_reporting(0);
include_once 'ConnectDB.inc';
if (isset($_GET['searchkey']) && $_GET['searchkey'] != '') {
	//Add slashes to any quotes to avoid SQL problems.
	$str_key = $_GET['searchkey'];
                  $type = $_GET['officetype'];
	$suggest_query = "SELECT * FROM  office WHERE account_number like('$str_key%') AND office_selection= '$type' ORDER BY account_number";
	$reslt= mysql_query($suggest_query);
	while($suggest = mysql_fetch_assoc($reslt)) {
                    $acc = $suggest['account_number'];
                    $id = $suggest['idOffice'];
	            echo "<u><a onclick=setParent('$acc','$id'); style='text-decoration:none;color:brown;cursor:pointer;'>" . $suggest['account_number'] . " (".$suggest['office_name'].")</a></u></br>";
        	}
                
}
if (isset($_GET['search']) && ($_GET['search'] != '') && ($_GET['office'] == 1)) {
	//Add slashes to any quotes to avoid SQL problems.
	$str_key = $_GET['search'];
	$suggest_query = "SELECT * FROM  office WHERE account_number like('$str_key%') AND office_selection= 'ripd' ORDER BY account_number";
	$reslt= mysql_query($suggest_query);
	while($suggest = mysql_fetch_assoc($reslt)) {
                    $acc = $suggest['account_number'];
                    $id = $suggest['idOffice'];
	            echo "<u><a onclick=setOffice('$acc','$id'); style='text-decoration:none;color:brown;cursor:pointer;'>" . $suggest['account_number'] . " (".$suggest['office_name'].")</a></u></br>";
        	}
                
}
if (isset($_GET['key']) && ($_GET['key'] != '') && ($_GET['pwr']==1)) {
	//Add slashes to any quotes to avoid SQL problems.
	$str_key = $_GET['key'];
	$suggest_query = "SELECT * FROM  office WHERE account_number like('$str_key%') AND office_selection= 'pwr' ORDER BY account_number";
	$reslt= mysql_query($suggest_query);
	while($suggest = mysql_fetch_assoc($reslt)) {
                    $acc = $suggest['account_number'];
                    $id = $suggest['idOffice'];
	            echo "<u><a onclick=setPwr('$acc','$id'); style='text-decoration:none;color:brown;cursor:pointer;'>" . $suggest['account_number'] . " (".$suggest['office_name'].")</a></u></br>";
        	}
                
}
if (isset($_GET['key']) && ($_GET['key'] != '') && ($_GET['off']==1)) {
	//Add slashes to any quotes to avoid SQL problems.
	$str_key = $_GET['key'];
                   	$suggest_query = "SELECT * FROM  office WHERE account_number like('$str_key%') AND office_selection= 'ripd' ORDER BY account_number";
	$reslt= mysql_query($suggest_query);
	while($suggest = mysql_fetch_assoc($reslt)) {
                    $acc = $suggest['account_number'];
                     $id = $suggest['idOffice'];
	            echo "<u><a onclick=setRipd('$acc','$id'); style='text-decoration:none;color:brown;cursor:pointer;'>" . $suggest['account_number'] . " (".$suggest['office_name'].")</a></u></br>";
        	}
                
}
if (isset($_GET['office'])) {
	//Add slashes to any quotes to avoid SQL problems.
	$offid = $_GET['office'];
                   $suggest_query = "SELECT * FROM  office WHERE idOffice= $offid";
	$reslt= mysql_query($suggest_query);
	$suggest = mysql_fetch_assoc($reslt);
                  $db_address = $suggest['office_details_address'];
        	echo $db_address;
}
?>
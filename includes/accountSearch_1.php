<?php
error_reporting(0);
include_once 'ConnectDB.inc';
if (isset($_GET['key']) && $_GET['key'] != '') {
	//Add slashes to any quotes to avoid SQL problems.
	$str_key = $_GET['key'];
                    $location = $_GET['location'];
	$suggest_query = "SELECT * FROM  cfs_user WHERE account_number like('$str_key%') ORDER BY  account_number";
	$reslt= mysql_query($suggest_query);
        if(mysql_num_rows($reslt)<1){echo "দুঃখিত, এই নাম্বারের কোনো একাউন্ট নেই";}
	while($suggest = mysql_fetch_assoc($reslt)) {
	            echo "<a style='text-decoration:none;color:brown;'href=".$location."?id=" . $suggest['idUser'] . ">" . $suggest['account_number'] . " (".$suggest['account_name'].")</a></br>";
        	}            
}
?>

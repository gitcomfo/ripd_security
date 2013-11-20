<?php
error_reporting(0);
include '../session.php';
    include 'ConnectDB.inc'; 
    $storeID = $_SESSION['offid'];
$scatagory = $_SESSION['catagory'];
    if (isset($_GET['searchKey']) && $_GET['searchKey'] != '') {
	//Add slashes to any quotes to avoid SQL problems.
	$str_key = $_GET['searchKey'];
	$suggest_query = "SELECT * FROM package_info WHERE pckg_code LIKE('" .$str_key ."%') ORDER BY pckg_code";
	$reslt= mysql_query($suggest_query);
	while($suggest = mysql_fetch_assoc($reslt)) 
                    {
                                $pckgid = $suggest['idpckginfo'];
                                $query = mysql_query("SELECT * FROM package_inventory WHERE pckg_infoid=$pckgid  AND ons_type='$scatagory' AND ons_id=$storeID;");
                                $result = mysql_fetch_assoc($query);
                                if(count($result)!=1)
                                {
                                    echo "<a style='text-decoration:none;color:brown;' href=package_entry.php?step=2&id=" . $suggest['idpckginfo'] . ">" . $suggest['pckg_code'] . "</a></br>";
                                }
                                else
                                {
                                    echo "<a style='text-decoration:none;color:brown;' href=package_entry.php?step=1&id=" . $suggest['idpckginfo'] . ">" . $suggest['pckg_code'] . "</a></br>";
                                }
	            
                    }
}
?>

<?php
    include 'ConnectDB.inc';
    if (isset($_GET['searchKey']) && $_GET['searchKey'] != '') {
	//Add slashes to any quotes to avoid SQL problems.
	$str_key = $_GET['searchKey'];
	$suggest_query = "SELECT * FROM sales_summary WHERE sal_invoiceno like('%" .$str_key . "%') ORDER BY sal_invoiceno";
	$reslt= mysql_query($suggest_query);
	while($suggest = mysql_fetch_assoc($reslt)) {
	            echo "<a class='prolinks' style='text-decoration:none;color:brown;display:block;' href=replace.php?id=" . $suggest['idsalessummary'] . ">" . $suggest['sal_invoiceno'] . "</a>";
        	}
}
?>

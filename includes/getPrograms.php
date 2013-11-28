<?php
error_reporting(0);
include_once './ConnectDB.inc';
include_once './connectionPDO.php';

if (isset($_GET['key']) && ($_GET['key'] != '')) {
	$str_key = $_GET['key'];
                  $suggest_query = "SELECT * FROM program WHERE program_no LIKE('$str_key%') ORDER BY program_no";
	$reslt= mysql_query($suggest_query);
	while($suggest = mysql_fetch_assoc($reslt)) {
                    $pNo = $suggest['program_no'];
                     $id = $suggest['idprogram'];
	            echo "<u><a onclick=setProgram('$pNo','$id'); style='text-decoration:none;color:brown;cursor:pointer;'>" . $pNo . "</a></u></br>";
        	}
                
}
?>

<?php
error_reporting(0);
include_once './ConnectDB.inc';
include_once './connectionPDO.php';
include_once './MiscFunctions.php';

if (isset($_GET['key']) && ($_GET['key'] != '')) {
	$str_key = $_GET['key'];
                  $suggest_query = "SELECT * FROM program WHERE program_no LIKE('$str_key%') AND program_date >= NOW() ORDER BY program_no";
	$reslt= mysql_query($suggest_query);
	while($suggest = mysql_fetch_assoc($reslt)) {
                    $pNo = $suggest['program_no'];
                     $id = $suggest['idprogram'];
	            echo "<u><a onclick=setProgram('$pNo','$id'); style='text-decoration:none;color:brown;cursor:pointer;'>" . $pNo . "</a></u></br>";
        	}               
}
elseif(isset($_GET['type']))
{
    $g_type = $_GET['type'];
    $typeinbangla = getProgramType($g_type);
    $sel_program = mysql_query("SELECT * FROM program WHERE program_type = '$g_type' AND program_date >= NOW() AND ticket_prize IS NOT NULL ORDER BY program_name ");
     echo "<table border='1' cellpadding='0' cellspacing='0'>
            <tr id='table_row_odd'>
                <td style='border:1px black solid; '><b>$typeinbangla-এর নাম</b></td>
                <td style='border:1px black solid;'><b>তারিখ</b></td>
                <td style='border:1px black solid;'><b>সময়</b></td>
                <td style='border:1px black solid;'><b>ভেন্যু</b></td>
                <td style='border:1px black solid;'></td>
            </tr><tbody>";
    while($progrow = mysql_fetch_assoc($sel_program))
    {
        $db_programname = $progrow['program_name'];
        $db_programdate = $progrow['program_date'];
        $date = english2bangla(date('d/m/Y',  strtotime($db_programdate)));
        $db_programtime = $progrow['program_time'];
        $time = english2bangla($db_programtime);
        $db_programvanue = $progrow['program_location'];
        $db_progID = $progrow['idprogram'];
        echo "
                <tr>
                    <td style='border:1px black solid;'>$db_programname <input type='hidden' name='prgrm_id' value='$db_progID' /></td>
                    <td style='border:1px black solid;'>$date</td>
                    <td style='border:1px black solid;'>$time</td>
                    <td style='border:1px black solid;'>$db_programvanue</td>
                    <td style='border:1px black solid;text-align:center;'><input style ='font-size: 12px; width:50px;border:2px solid green;cursor:pointer;' type='submit' name='submit' value='ক্রয়' /></td>
                </tr>";
            
    }
    echo "</tbody></table>";
}
?>

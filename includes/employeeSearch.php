<?php
error_reporting(0);
include 'ConnectDB.inc';
if (isset($_GET['key']) && $_GET['key'] != '') {
	//Add slashes to any quotes to avoid SQL problems.
	$str_key = $_GET['key'];
                    $location = $_GET['location'];
	$suggest_query = "SELECT * FROM  cfs_user WHERE cfs_account_status = 'active' AND account_number like('$str_key%') ORDER BY  account_number";
	$reslt= mysql_query($suggest_query);
	while($suggest = mysql_fetch_assoc($reslt)) {
	            echo "<a style='text-decoration:none;color:brown;'href=".$location."?id=" . $suggest['idUser'] . ">" . $suggest['account_number'] . " (".$suggest['account_name'].")</a></br>";
        	}            
}

if (isset($_GET['paygradid']) && $_GET['paygradid'] != '') {
	//Add slashes to any quotes to avoid SQL problems.
	$emp_paygrdid = $_GET['paygradid'];
                    $lvpolicyid = $_GET['lvpolicyid'];
                    $location = $_GET['location'];
                    $cfsuserid  = $_GET['cfsid']; 
	$sql_lvingrade =mysql_query("SELECT * FROM `leave_in_grade`WHERE pay_grade_idpaygrade =$emp_paygrdid  AND leave_policy_idleavepolicy=$lvpolicyid");
	$getrow = mysql_fetch_assoc($sql_lvingrade);
                  $grantedleavedays = $getrow['no_of_days'];
                  $db_leaveingradID = $getrow['idleaveingrd'];
                  $sql_empleave =mysql_query("SELECT * FROM `emp_in_leave`WHERE emp_id =$cfsuserid  AND leave_in_grade_idleaveingrd=$db_leaveingradID");
	while($emplvrow = mysql_fetch_assoc($sql_empleave))
                    {
                        $timestamp=time(); //current timestamp
                        $da=date("Y/m/d",$timestamp);
                        $currentyear = date('Y', strtotime($da));
                        $db_strtday = $emplvrow['starting_date'];
                        $db_totalday = $emplvrow['total_day'];
                        $strtyear = date('Y', strtotime($db_strtday));
                       if($currentyear == $strtyear)
                       {
                           $grantedleavedays = $grantedleavedays - $db_totalday;
                       }
                    }
                    echo $grantedleavedays;                
}
?>

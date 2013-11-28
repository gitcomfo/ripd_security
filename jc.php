<?php
//include_once 'includes/session.inc';
//error_reporting(0);
include_once 'includes/header.php';
include_once 'includes/MiscFunctions.php';
include_once 'includes/makeAccountNumbers.php';
include_once 'includes/checkAccountNo.php';
include_once 'includes/email_conf.php';
include_once './includes/sms_send_function.php';

function showPowerHeads() {
    echo "<option value=0> -সিলেক্ট করুন- </option>";
    $sql_office = mysql_query("SELECT * FROM office WHERE office_type='pwr_head' ORDER BY office_name;");
    while ($headrow = mysql_fetch_assoc($sql_office)) {
        echo "<option value=" . $headrow['account_number'] . ">" . $headrow['office_name'] . "</option>";
    }
}

echo "hello world";


$sel = mysql_query("SELECT * FROM cfs_user");
if(mysql_num_rows($sel)>100000)
{
$propreitor_account_id = 1;
 header( 'Location: create_proprietor_account_inner.php?proID='.$propreitor_account_id);
}
 else {
    $propreitor_account_id = 23;
 header( 'Location: create_proprietor_account_inner.php?proID='.$propreitor_account_id);
}

?>

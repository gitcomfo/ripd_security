<?php
error_reporting(0);
include_once './connectionPDO.php';
$g_counterID = $_GET['id'];
$sel_counter_info = $conn->prepare("SELECT * FROM ons_counter WHERE idonscounter =?");
$sel_counter_info->execute(array($g_counterID));
$counterrow = $sel_counter_info->fetchAll();
 foreach ($counterrow as $value) {
            $db_status = $value['counter_status'];
            $db_tempamount = $value['temp_strt_amount'];
            $db_login = $value['counter_login'];
        }
 if($db_status == 'closed' && $db_login == 'N')
 {
     echo '<input name="open" type="submit" value="কাউন্টার খুলুন" style="cursor:pointer;margin-left:40%;width:150px;height: 25px;font-family: SolaimanLipi !important;" />
         <input type="hidden" id="status" value="closed" />';
 }
 elseif($db_status == 'open' && $db_login == 'N')
 {
     echo '<input name="close" type="submit" value="কাউন্টার বন্ধ করুন"  style="cursor:pointer;margin-left:40%;width:150px;height: 25px;font-family: SolaimanLipi !important;" />
         <input type="hidden" id="status" value="'.$db_tempamount.'" />';
 }
 else {
     echo "";
}
?>

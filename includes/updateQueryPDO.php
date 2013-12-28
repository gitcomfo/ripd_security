<?php
include_once 'connectionPDO.php';
$sql_update_prev_command = $conn->prepare("UPDATE command_execution SET com_end_date=NOW() WHERE commandno=? ORDER BY idcommandexec DESC LIMIT 1");
$sql_update_account_block = $conn->prepare("UPDATE cfs_user SET blocked='1' WHERE user_name=?");
$sql_update_password = $conn->prepare("UPDATE cfs_user SET password=? WHERE idUser=?");
$sql_update_command = $conn->prepare("UPDATE command SET commandno=?, command_desc=?, pv_value=? WHERE idcommand=?");
$sql_update_award = $conn->prepare("UPDATE ripd_award SET awd_name=?, awd_provider_name=?, awd_description=?, 
                                       awd_date=?, awd_image=?, awd_receivers_type=?, 
                                           awd_receivers_name=?, cfs_user_id=? 
                                      WHERE idaward=?");
?>

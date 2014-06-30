<?php
include_once './connectionPDO.php';
$g_currentPV = $_GET['currentpv'];
$g_selectedPV = $_GET['selectedpv'];
$sel_convert_charge = $conn->prepare("SELECT charge_amount FROM charge WHERE charge_code= 'pkc' AND charge_status = 'active'");
$sel_convert_charge->execute();
$chrgrow = $sel_convert_charge->fetchAll();
foreach ($chrgrow as $row) {
    $db_convert_charge = $row['charge_amount'];
}
$convert_step = ($g_selectedPV - $g_currentPV) / 5;
$converted_amount = $db_convert_charge * $convert_step;
echo $converted_amount;
?>

<?php
include_once './connectionPDO.php';
$g_fundID = $_GET['fundID'];
$sel_main_fund = $conn->prepare("SELECT physical_fund FROM main_fund WHERE idmainfund = ?");
$sel_main_fund->execute(array($g_fundID));
$row = $sel_main_fund->fetchAll();
foreach ($row as $value) {
    echo $value['physical_fund'];
}
?>

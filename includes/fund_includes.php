<?php
include_once './connectionPDO.php';
if($_GET['type'] == 1)
{
    $g_fundID = $_GET['fundID'];
    $sel_main_fund = $conn->prepare("SELECT physical_fund FROM main_fund WHERE idmainfund = ?");
    $sel_main_fund->execute(array($g_fundID));
    $row = $sel_main_fund->fetchAll();
    foreach ($row as $value) {
        echo $value['physical_fund'];
    }
}
elseif($_GET['type'] == 2)
{
    if (!isset($_SESSION['arrFunds']))
    {
     $_SESSION['arrFunds'] = array();
    }
    
    $g_fundID = $_GET['fundID'];
    $sel_main_fund = $conn->prepare("SELECT * FROM main_fund WHERE idmainfund = ?");
    $sel_main_fund->execute(array($g_fundID));
    $row = $sel_main_fund->fetchAll();
    foreach ($row as $value) {
        $db_fundname = $value['fund_name'];
        $db_amount = $value['physical_fund'];
        $arr_temp = array($db_fundname,$db_amount);
        $_SESSION['arrFunds'][$g_fundID] = $arr_temp;
    }
}
elseif (isset($_GET['delete'])) {
    $g_id = $_GET['id'];
    $g_url = urldecode($_GET['url']);
    unset($_SESSION['arrFunds'][$g_id]);
    header("location: $g_url");
                
}
?>

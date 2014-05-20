<?php
error_reporting(0);
//include 'includes/session.inc';
include_once './includes/connectionPDO.php';
include_once './includes/selectQueryPDO.php';
include_once './includes/MiscFunctions.php';
$g_empCfsID = $_GET['empCfsID'];

    $sql_select_working_days->execute(array($g_empCfsID));
    $row8 = $sql_select_working_days->fetchAll();
    foreach ($row8 as $totalrow) {
        $totalworkingDays = $totalrow['COUNT(idempattend)'];
    }
    $status1 = "present";
    $sql_total_attend->execute(array($status1,$g_empCfsID));
    $trow1 = $sql_total_attend->fetchAll();
    foreach ($trow1 as $value) {
        $total_presentDays = $value['COUNT(idempattend)'];
    }
    $status2 ="absent";
    $sql_total_attend->execute(array($status2,$g_empCfsID));
    $trow2 = $sql_total_attend->fetchAll();
    foreach ($trow2 as $value) {
        $total_absentDays = $value['COUNT(idempattend)'];
    }
    $status3 = "leave";
    $sql_total_attend->execute(array($status3,$g_empCfsID));
    $trow3 = $sql_total_attend->fetchAll();
    foreach ($trow3 as $value) {
        $total_leaveDays = $value['COUNT(idempattend)'];
    }
    $totalattendPercent = ($total_presentDays / $totalworkingDays) * 100;

?>
<style type="text/css">@import "css/bush.css";</style> 

    <div class="main_text_box">
            <div>           
                    <table class="formstyle"  style="font-family: SolaimanLipi !important;width: 95%;margin-left: 10px;">          
                        <tr><th style="text-align: center" colspan="2"><h1>হাজিরা সারসংক্ষেপ</h1></th></tr>
                        <tr>
                            <td style="text-align: center;">
                                <table>
                                    <tr>
                                        <td style="text-align: right;width: 50%;"> হাজিরার হার :</td>
                                        <td ><?php echo english2bangla(round($totalattendPercent, 2));?> %</td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: right;">মোট কার্যদিবস :</td>
                                        <td ><?php echo english2bangla($totalworkingDays);?> দিন</td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: right;">উপস্থিতি :</td>
                                        <td><?php echo english2bangla($total_presentDays);?> দিন</td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: right;">অনুপস্থিতি :</td>
                                        <td><?php echo english2bangla($total_absentDays);?> দিন</td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: right;">ছুটি :</td>
                                        <td><?php echo english2bangla($total_leaveDays);?> দিন</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                     <tr><td></br></td></tr>
                    </table>
            </div>
        </div>   
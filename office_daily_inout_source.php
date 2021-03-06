<?php
//error_reporting(0);
//include_once 'includes/session.inc';
include_once 'includes/header.php';
include_once 'includes/selectQueryPDO.php';
$ons_type = $_SESSION['loggedInOfficeType'];
$ons_id = $_SESSION['loggedInOfficeID'];

$sql_select_id_ons_relation->execute(array($ons_type,$ons_id));
$row = $sql_select_id_ons_relation->fetchAll();
foreach ($row as $onsrow) {
    $db_onsID = $onsrow['idons_relation'];
}
$sel_invest = $conn->prepare("SELECT SUM(inamount), receving_date FROM acc_ofc_physc_in WHERE amount_status='to_office'
                                                AND  office_id = ? AND receving_date LIKE ? GROUP BY receving_date ORDER BY receving_date");

$sel_branch_transfer = $conn->prepare("SELECT SUM(inamount), receving_date FROM acc_ofc_physc_in WHERE amount_status='branch'
                                                AND  office_id = ? AND receving_date LIKE ? GROUP BY receving_date ORDER BY receving_date");

$sel_branch_transfer_out = $conn->prepare("SELECT SUM(inamount), receving_date FROM acc_ofc_physc_in WHERE amount_status='branch'
                                                AND  sender_office = ? AND receving_date LIKE ? GROUP BY receving_date ORDER BY receving_date");

$sel_cash_in = $conn->prepare("SELECT SUM(cheque_amount), cheque_mak_datetime FROM acc_user_cheque WHERE cheque_status='in_amount'
                                                AND  chqupd_officeid = ? AND cheque_mak_datetime LIKE ? GROUP BY cheque_mak_datetime ORDER BY cheque_mak_datetime");

$sel_cash_out = $conn->prepare("SELECT SUM(cheque_amount), cheque_update_datetime FROM acc_user_cheque WHERE cheque_status='paid'
                                                AND  chqupd_officeid = ? AND cheque_update_datetime LIKE ? GROUP BY cheque_update_datetime ORDER BY cheque_update_datetime");

$sel_ticket_in = $conn->prepare("SELECT SUM(tckt_cash_paid), ticket_selling_date FROM ticket 
                                                    WHERE ticket_selling_office = ? AND ticket_selling_date LIKE ? GROUP BY ticket_selling_date ORDER BY ticket_selling_date");

$sel_daily_expenditure = $conn->prepare("SELECT SUM(exp_total_amount), exp_making_date  FROM ons_operational_exp 
                                                    WHERE exp_ons_id = ? AND exp_making_date LIKE ? GROUP BY exp_making_date ORDER BY exp_making_date");

$current_month = date('m');
$current_year = date('Y');
$monthName = date("F", mktime(0, 0, 0, $current_month, 10));

if(isset($_POST['submit']))
{
    $current_month = $_POST['month'];
    $current_year = $_POST['year'];
    $monthName = date("F", mktime(0, 0, 0, $current_month, 10));
}
?>
<style type="text/css"> @import "css/bush.css";</style>

<div class="columnSld" style=" padding-left: 50px;">
    <div class="main_text_box">
        <div style="padding-left: 9px;"><a href="accounting_sys_management.php"><b>ফিরে যান</b></a></div>
        <div>           
                <table  class="formstyle" style="width: 90%; margin: 1px 1px 1px 1px;">          
                  <tr><th colspan="2" style="text-align: center;font-size: 22px;">অফিসের বিভিন্ন দৈনিক ইন/ আউট</th></tr>                    
                    <tr>
                      <td>
                          <form method="POST" action="">
                        <b>মাসঃ </b>
                            <select class='box2' name='month' style="width: 100px;" id="month">
                                <?php
                                $inc = 1;
                                $month_array = array(0=>'সিলেক্ট করুন','01'=>'জানুয়ারি','02'=>'ফেব্রুয়ারি', '03' =>'মার্চ', '04'=>'এপ্রিল', '05'=>'মে', '06'=> 'জুন', '07'=> 'জুলাই', '08'=>'আগষ্ট', '09'=> 'সেপ্টেম্বর','10'=> 'অক্টোবর','11'=> 'নভেম্বর','12'=> 'ডিসেম্বর');
                                while (list ($inc, $val) = each($month_array))
                                    echo "<option value=$inc>$val</option>";
                                ?>
                            </select>&nbsp;&nbsp;
                            <b>বছরঃ </b>
                            <select class='box2' name='year'>
                                <?php
                                    $thisYear = date('Y');
                                    $startYear = '2000';
                                    foreach (range($thisYear, $startYear) as $year) {
                                    echo '<option value='.$year.'>'. $year .'</option>'; }
                                ?>
                            </select> &nbsp;&nbsp;&nbsp;
                            <input class="btn" style =" font-size: 12px; " type="submit" name="submit" value="সার্চ" />
                          </from>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <table>
                                <tr id="table_row_odd"><td colspan="8" style="text-align: center;"><b><?php echo $monthName." ,".$current_year?>-এর দৈনিক ইন/ আউট</b></td></tr>
                                <tr id="table_row_odd">
                                    <td rowspan="2"><b>তারিখ</b></td>
                                    <td colspan="4"><b>ইন এমাউন্ট</b></td>
                                    <td colspan="3"><b>আউট এমাউন্ট</b></td>
                                </tr>
                                <tr id="table_row_odd">
                                    <td><b>ইনভেস্ট</b></td>
                                    <td><b>ব্রাঞ্চ ট্র্যান্সফার</b></td>
                                    <td><b>কাস্টমার ক্যাশ ইন</b></td>
                                    <td><b>টিকেট বিক্রি</b></td>
                                    <td><b>দৈনিক খরচ</b></td>
                                    <td><b>ব্রাঞ্চ ট্র্যান্সফার</b></td>
                                    <td><b>কাস্টমার ক্যাশ আউট</b></td>
                                </tr>
                                <?php
                                            $total_invest_amount = 0;
                                            $total_cashin_amount = 0;
                                            $total_ticketin_amount = 0;
                                            $total_branchin_amount = 0;
                                            $total_branchout_amount = 0;
                                            $total_cashout_amount = 0;
                                            $total_dexp_amount = 0;
                                            $receiving_date = $current_year."-".$current_month."-%";
                                            $receiving_datetime = $current_year."-".$current_month."-% %";
                                           $sel_invest->execute(array($db_onsID,$receiving_date));
                                           $investrow = $sel_invest->fetchAll();
                                           foreach ($investrow as $row) {
                                                    $db_date = $row['receving_date'];
                                                    $db_in_amount = $row['SUM(inamount)'];
                                                    $total_invest_amount =+ $db_in_amount;
                                                    echo "<tr>
                                                        <td>".  english2bangla(date('d/m/Y',  strtotime($db_date)))."</td>
                                                        <td style='text-align:right;'>$db_in_amount</td>
                                                        <td style='text-align:right;'></td>
                                                       </tr>";
                                                }
                                                $sel_branch_transfer->execute(array($db_onsID,$receiving_date));
                                                $branchrow = $sel_branch_transfer->fetchAll();
                                                foreach ($branchrow as $row) {
                                                         $db_date = $row['receving_date'];
                                                         $db_branch_in_amount = $row['SUM(inamount)'];
                                                         $total_branchin_amount =+ $db_branch_in_amount;
                                                         echo "<tr>
                                                             <td>".  english2bangla(date('d/m/Y',  strtotime($db_date)))."</td>
                                                             <td style='text-align:right;'></td>
                                                             <td style='text-align:right;'>$db_branch_in_amount</td>
                                                            </tr>";
                                                     }
                                                    $sel_cash_in->execute(array($ons_id,$receiving_datetime));
                                                    $cashinrow = $sel_cash_in->fetchAll();
                                                    foreach ($cashinrow as $row) {
                                                             $db_date = $row['cheque_mak_datetime'];
                                                             $db_cash_in_amount = $row['SUM(cheque_amount)'];
                                                             $total_cashin_amount =+ $db_cash_in_amount;

                                                             echo "<tr>
                                                                 <td>".  english2bangla(date('d/m/Y',  strtotime($db_date)))."</td>
                                                                 <td style='text-align:right;'></td>
                                                                 <td style='text-align:right;'></td>
                                                                 <td style='text-align:right;'>$db_cash_in_amount</td>
                                                                </tr>";
                                                         }

                                                         $sel_ticket_in->execute(array($ons_id,$receiving_date));
                                                        $ticketrow = $sel_ticket_in->fetchAll();
                                                        foreach ($ticketrow as $row) {
                                                                 $db_date = $row['ticket_selling_date'];
                                                                 $db_ticket_amount = $row['SUM(tckt_cash_paid)'];
                                                                 $total_ticketin_amount =+ $db_ticket_amount;
                                                                 echo "<tr>
                                                                     <td>".  english2bangla(date('d/m/Y',  strtotime($db_date)))."</td>
                                                                     <td style='text-align:right;'></td>
                                                                     <td style='text-align:right;'></td>
                                                                     <td style='text-align:right;'></td>
                                                                     <td style='text-align:right;'>$db_ticket_amount</td>
                                                                    </tr>";
                                                             }
                                                        
                                                        $sel_daily_expenditure->execute(array($db_onsID,$receiving_datetime));
                                                        $dexprow = $sel_daily_expenditure->fetchAll();
                                                        foreach ($dexprow as $row) {
                                                                 $db_date = $row['exp_making_date'];
                                                                 $db_dexp_amount = $row['SUM(exp_total_amount)'];
                                                                 $total_dexp_amount =+ $db_dexp_amount;

                                                                 echo "<tr>
                                                                     <td>".  english2bangla(date('d/m/Y',  strtotime($db_date)))."</td>
                                                                     <td style='text-align:right;'></td>
                                                                     <td style='text-align:right;'></td>
                                                                     <td style='text-align:right;'></td>
                                                                     <td style='text-align:right;'></td>
                                                                     <td style='text-align:right;'>$db_dexp_amount</td>
                                                                    </tr>";
                                                             }
                                                             // branch transfer out ***************
                                                             $sel_branch_transfer_out->execute(array($db_onsID,$receiving_date));
                                                        $branchrow2 = $sel_branch_transfer_out->fetchAll();
                                                        foreach ($branchrow2 as $row) {
                                                                 $db_date = $row['receving_date'];
                                                                 $db_branch_out_amount = $row['SUM(inamount)'];
                                                                 $total_branchout_amount =+ $db_branch_out_amount;
                                                                 echo "<tr>
                                                                     <td>".  english2bangla(date('d/m/Y',  strtotime($db_date)))."</td>
                                                                     <td style='text-align:right;'></td>
                                                                     <td style='text-align:right;'></td>
                                                                     <td style='text-align:right;'></td>
                                                                     <td style='text-align:right;'></td>
                                                                     <td style='text-align:right;'></td>
                                                                     <td style='text-align:right;'>$db_branch_out_amount</td>
                                                                    </tr>";
                                                             }
                                                             // cash out by user *******************
                                                              $sel_cash_out->execute(array($ons_id,$receiving_datetime));
                                                            $cashoutrow = $sel_cash_out->fetchAll();
                                                            foreach ($cashoutrow as $row) {
                                                                     $db_date = $row['cheque_update_datetime'];
                                                                     $db_cash_out_amount = $row['SUM(cheque_amount)'];
                                                                     $total_cashout_amount =+ $db_cash_out_amount;
                                                                     echo "<tr>
                                                                         <td>".  english2bangla(date('d/m/Y',  strtotime($db_date)))."</td>
                                                                         <td style='text-align:right;'></td>
                                                                         <td style='text-align:right;'></td>
                                                                         <td style='text-align:right;'></td>
                                                                         <td style='text-align:right;'></td>
                                                                         <td style='text-align:right;'></td>
                                                                         <td style='text-align:right;'></td>
                                                                         <td style='text-align:right;'>$db_cash_out_amount</td>
                                                                        </tr>";
                                                                 }
                                ?>
                                <tr>
                                    <td style='text-align:right;border-top: 1px solid black'>মোট</td>
                                    <td style='text-align:right;border-top: 1px solid black'><?php echo $total_invest_amount;?></td>
                                    <td style='text-align:right;border-top: 1px solid black'><?php echo $total_branchin_amount;?></td>
                                    <td style='text-align:right;border-top: 1px solid black'><?php echo $total_cashin_amount;?></td>
                                    <td style='text-align:right;border-top: 1px solid black'><?php echo $total_ticketin_amount;?></td>
                                    <td style='text-align:right;border-top: 1px solid black'><?php echo $total_dexp_amount;?></td>
                                    <td style='text-align:right;border-top: 1px solid black'><?php echo $total_branchout_amount;?></td>
                                    <td style='text-align:right;border-top: 1px solid black'><?php echo $total_cashout_amount;?></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
        </div>
    </div>
</div>
<?php include 'includes/footer.php'; ?>
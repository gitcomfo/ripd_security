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
$sel_sales_in = $conn->prepare("SELECT SUM(selling_earn), SUM(sal_total_profit), SUM(sal_total_xtraprofit), sal_salesdate FROM sales_summary LEFT JOIN sales_customer_hitting 
                                                    ON sales_summery_idsalessummery = idsalessummary
                                                    WHERE sal_store_type=? AND  sal_storeid = ? AND sal_salesdate LIKE ?");

$sel_product_purchase = $conn->prepare("SELECT SUM(chln_reuse_amount) FROM product_purchase_summary WHERE pps_onstype=?
                                                AND  pps_onsID = ? AND chalan_date LIKE ?");

$sel_salary = $conn->prepare("SELECT total_month_salary FROM salary_approval WHERE salapp_onsid=? 
                                                AND  month_no = ? AND year_no=?");

$sel_daily_exp = $conn->prepare("SELECT SUM(exp_total_amount) FROM ons_operational_exp 
                                                       WHERE exp_ons_id = ? AND exp_making_date LIKE ?");

$sel_monthly_exp = $conn->prepare("SELECT ons_monthly_total FROM ons_fixed_expenditure 
                                                            WHERE fk_onsid = ? AND month =? AND year = ?");

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
                  <tr><th colspan="2" style="text-align: center;font-size: 22px;">স্টোরের মাসিক ইন/ আউট</th></tr>                    
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
                                <tr id="table_row_odd"><td colspan="3" style="text-align: center;"><b><?php echo $monthName." ,".$current_year?>-এর মাসিক ইন/ আউট</b></td></tr>
                                <tr id="table_row_odd">
                                    <td><b>খাত</b></td>
                                    <td><b>ইন এমাউন্ট</b></td>
                                    <td><b>আউট এমাউন্ট</b></td>
                                </tr>
                                <?php
                                            $receiving_date = $current_year."-".$current_month."-%";
                                            $receiving_datetime = $current_year."-".$current_month."-% %";
                                           $sel_sales_in->execute(array($ons_type,$ons_id,$receiving_date));
                                           $investrow = $sel_sales_in->fetchAll();
                                           foreach ($investrow as $row) {
                                                    $db_sellingearn_in = $row['SUM(selling_earn)'];
                                                    $db_profit_in = $row['SUM(sal_total_profit)'];
                                                    $db_extraprofit_in = $row['SUM(sal_total_xtraprofit)'];
                                           }
                                           //******* product purchase out amount ****************
                                           $sel_product_purchase->execute(array($ons_type,$ons_id,$receiving_date));
                                           $purchaserow = $sel_product_purchase->fetchAll();
                                           foreach ($purchaserow as $row) {
                                                    $db_purchase_out = $row['SUM(chln_reuse_amount)'];
                                           }
                                           //******* salary out amount ****************
                                           $sel_salary->execute(array($db_onsID,$current_month,$current_year));
                                           $salaryrow = $sel_salary->fetchAll();
                                           foreach ($salaryrow as $row) {
                                                    $db_salary_out = $row['total_month_salary'];
                                           }
                                           //******* daily expenditure out amount ****************
                                           $sel_daily_exp->execute(array($db_onsID,$receiving_datetime));
                                           $dailyrow = $sel_daily_exp->fetchAll();
                                           foreach ($dailyrow as $row) {
                                                    $db_daily_out = $row['SUM(exp_total_amount)'];
                                           }
                                           //******* monthly expenditure out amount ****************
                                           $sel_monthly_exp->execute(array($db_onsID,$current_month,$current_year));
                                           $monthlyrow = $sel_monthly_exp->fetchAll();
                                           foreach ($monthlyrow as $row) {
                                                    $db_monthly_out = $row['ons_monthly_total'];
                                           }
                                                    echo "<tr>
                                                        <td>ক্রয়মূল্য</td>
                                                        <td style='text-align:right;'>$db_sellingearn_in</td>
                                                        <td style='text-align:right;'></td>
                                                       </tr>
                                                            <tr>
                                                        <td>প্রফিট</td>
                                                        <td style='text-align:right;'>$db_profit_in</td>
                                                        <td style='text-align:right;'></td>
                                                       </tr>
                                                            <tr>
                                                        <td>এক্সট্রা প্রফিট</td>
                                                        <td style='text-align:right;'>$db_extraprofit_in</td>
                                                        <td style='text-align:right;'></td>
                                                       </tr>
                                                            <tr>
                                                        <td>প্রোডাক্ট ক্রয়</td>
                                                        <td style='text-align:right;'></td>
                                                        <td style='text-align:right;'>$db_purchase_out</td>
                                                       </tr>
                                                            <tr>
                                                        <td>কর্মচারীর বেতন</td>
                                                        <td style='text-align:right;'></td>
                                                        <td style='text-align:right;'>$db_salary_out</td>
                                                       </tr>
                                                            <tr>
                                                        <td>দৈনিক খরচ</td>
                                                        <td style='text-align:right;'></td>
                                                        <td style='text-align:right;'>$db_daily_out</td>
                                                       </tr>
                                                            <tr>
                                                        <td>মাসিক খরচ</td>
                                                        <td style='text-align:right;'></td>
                                                        <td style='text-align:right;'>$db_monthly_out</td>
                                                       </tr>";
                                                
                                ?>
                                <tr>
                                    <td style='text-align:right;border-top: 1px solid black'>মোট</td>
                                    <td style='text-align:right;border-top: 1px solid black'><?php echo ($db_sellingearn_in + $db_profit_in + $db_extraprofit_in);?></td>
                                    <td style='text-align:right;border-top: 1px solid black'><?php echo ($db_daily_out+$db_monthly_out+$db_purchase_out+$db_salary_out);?></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
        </div>
    </div>
</div>
<?php include 'includes/footer.php'; ?>
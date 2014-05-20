<?php
//error_reporting(0);
include_once 'includes/session.inc';
include_once 'includes/header.php';
include_once 'includes/selectQueryPDO.php';
$ons_type = $_SESSION['loggedInOfficeType'];
$ons_id = $_SESSION['loggedInOfficeID'];

$sql_select_id_ons_relation->execute(array($ons_type,$ons_id));
$row = $sql_select_id_ons_relation->fetchAll();
foreach ($row as $onsrow) {
    $db_onsID = $onsrow['idons_relation'];
}

$sel_daily_inout = $conn->prepare();
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
                  <tr><th colspan="2" style="text-align: center;font-size: 22px;">অফিসের দৈনিক ইন/ আউট</th></tr>                    
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
                                <tr id="table_row_odd"><td colspan="3" style="text-align: center;"><b><?php echo $monthName." ,".$current_year?>-এর দৈনিক ইন/ আউট</b></td></tr>
                                <tr id="table_row_odd">
                                    <td><b>তারিখ</b></td>
                                    <td><b>ইন এমাউন্ট</b></td>
                                    <td><b>আউট এমাউন্ট</b></td>
                                </tr>
                                <?php
                                            $total_in_amount = 0;
                                            $total_out_amount = 0;
                                            $sel_daily_inout = mysql_query("SELECT * FROM acc_ofc_daily_inout WHERE daily_date LIKE '$current_year-$current_month-%'  
                                                                                                AND daily_onsid= $db_onsID ORDER BY daily_date");
                                                while($row = mysql_fetch_assoc($sel_daily_inout)) {
                                                    $db_date = $row['daily_date'];
                                                    $db_out_amount = $row['out_amount'];
                                                    $db_in_amount = $row['in_amount'];
                                                    $total_in_amount = $total_in_amount + $db_in_amount;
                                                    $total_out_amount = $total_out_amount + $db_out_amount;
                                                    
                                                    echo "<tr>
                                                        <td>".  english2bangla(date('d/m/Y',  strtotime($db_date)))."</td>
                                                        <td style='text-align:right;'>$db_in_amount</td>
                                                        <td style='text-align:right;'>$db_out_amount</td>
                                                       </tr>";
                                                }
                                ?>
                                <tr>
                                    <td style='text-align:right;border-top: 1px solid black'>মোট</td>
                                    <td style='text-align:right;border-top: 1px solid black'><?php echo $total_in_amount;?></td>
                                    <td style='text-align:right;border-top: 1px solid black'><?php echo $total_out_amount;?></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
        </div>
    </div>
</div>
<?php include 'includes/footer.php'; ?>
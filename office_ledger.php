<?php
//error_reporting(0);
include_once 'includes/session.inc';
include_once 'includes/header.php';
$ons_type = $_SESSION['loggedInOfficeType'];
$ons_id = $_SESSION['loggedInOfficeID'];

$sql_select_id_ons_relation = $conn->prepare("SELECT idons_relation FROM  ons_relation WHERE catagory =  ? AND add_ons_id = ?");
$sql_select_id_ons_relation->execute(array($ons_type,$ons_id));
$row = $sql_select_id_ons_relation->fetchAll();
foreach ($row as $onsrow) {
    $db_onsID = $onsrow['idons_relation'];
}

$current_month = date('m');
$current_year = date('Y');
$monthName = date("F", mktime(0, 0, 0, $current_month, 10));

if(isset($_POST['submit']))
{
    $current_month = $_POST['month'];
    $current_year = $_POST['year'];
    $monthName = date("F", mktime(0, 0, 0, $current_month, 10));
}

$sel_ofc_ledger = mysql_query("SELECT * FROM acc_ofc_physc_ledger WHERE month_no= $current_month 
                                                    AND year_no = $current_year  AND ripd_office_id= $db_onsID");

    while($row = mysql_fetch_assoc($sel_ofc_ledger)) {
        $db_ripd_amount = $row['ripd_amount'];
        $db_out_amount = $row['out_amount'];
        $db_in_amount = $row['in_amount'];
        $db_total_amount = $row['total_amount'];
    }
?>
<style type="text/css"> @import "css/bush.css";</style>

<div class="columnSld" style=" padding-left: 50px;">
    <div class="main_text_box">
        <div style="padding-left: 9px;"><a href="accounting_sys_management.php"><b>ফিরে যান</b></a></div>
        <div>           
                <table  class="formstyle" style="width: 90%; margin: 1px 1px 1px 1px;">          
                  <tr><th colspan="2" style="text-align: center;font-size: 22px;">অফিসের মাসিক লেজার</th></tr>                    
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
                            <table style="width: 50%;">
                                <tr>
                                    <td style="text-align: right;"><b>মাস :</b></td>
                                    <td><?php echo $monthName?></td>
                                </tr>
                                <tr>
                                    <td style="text-align: right;"><b>বছর :</b></td>
                                    <td><?php echo $current_year?></td>
                                </tr>
                                <tr>
                                    <td style="text-align: right;"><b>রিপড এমাউন্ট :</b></td>
                                    <td><?php echo $db_ripd_amount?> TK</td>
                                </tr>
                                <tr>
                                    <td style="text-align: right;"><b>ইন এমাউন্ট :</b></td>
                                    <td><?php echo $db_in_amount?> TK</td>
                                </tr>
                                <tr>
                                    <td style="text-align: right;"><b>আউট এমাউন্ট :</b></td>
                                    <td><?php echo $db_out_amount?> TK</td>
                                </tr>
                                <tr>
                                    <td style="text-align: right;"><b>মোট বর্তমান এমাউন্ট :</b></td>
                                    <td><?php echo $db_total_amount?> TK</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
        </div>
    </div>
</div>
<?php include 'includes/footer.php'; ?>
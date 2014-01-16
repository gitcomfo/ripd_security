<?php
//include_once 'includes/session.inc';
include_once 'includes/header.php';
include_once 'includes/MiscFunctions.php';
include_once './includes/selectQueryPDO.php';

 $loginUSERid = $_SESSION['userIDUser'] ;
 
//$sql_select_working_days->execute(array($loginUSERid));
//$row8 = $sql_select_working_days->fetchAll();
//foreach ($row8 as $totalrow) {
//    $totalworkingDays = $totalrow['COUNT(idempattend)'];
//}
//    $status1 = "present";
//    $sql_total_attend->execute(array($status1,$loginUSERid));
//    $trow1 = $sql_total_attend->fetchAll();
//    foreach ($trow1 as $value) {
//        $total_presentDays = $value['COUNT(idempattend)'];
//    }
//    $status2 ="absent";
//    $sql_total_attend->execute(array($status2,$loginUSERid));
//    $trow2 = $sql_total_attend->fetchAll();
//    foreach ($trow2 as $value) {
//        $total_absentDays = $value['COUNT(idempattend)'];
//    }
//    $status3 = "leave";
//    $sql_total_attend->execute(array($status3,$loginUSERid));
//    $trow3 = $sql_total_attend->fetchAll();
//    foreach ($trow3 as $value) {
//        $total_leaveDays = $value['COUNT(idempattend)'];
//    }
//    $totalattendPercent = ($total_presentDays / $totalworkingDays) * 100;

if(isset($_POST['submit']))
{
    $p_month = $_POST['month'];;
    $p_year = $_POST['year'];
    $monthName = date("F", mktime(0, 0, 0, $p_month, 10));
    
    $select_attendance = mysql_query("SELECT COUNT(idempattend) FROM employee,employee_attendance 
    WHERE   year_no ='$p_year' AND month_no='$p_month' AND  cfs_user_idUser = $loginUSERid AND idEmployee = emp_user_id ");
    $row = mysql_fetch_assoc($select_attendance);
    $workingDays = $row['COUNT(idempattend)'];
}
?>
<title>নিয়মিত কর্মচারী হাজিরা</title>
<style type="text/css"> @import "css/bush.css";</style>
<style type="text/css">
    #search {
        width: 50px;background-color: #009933;border: 2px solid #0077D5;cursor: pointer; color: wheat;
    }
    #search:hover {
        background-color: #0077D5;border: 2px inset #009933;color: wheat;
    }
</style>
<script type="text/javascript">
    function checkIt(evt) // float value-er jonno***********************
    {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode ==8 || (charCode >47 && charCode <58) || charCode==46) {
        status = "";
        return true;
    }
    status = "This field accepts numbers only.";
    return false;
}
function calculateSalary(deduct)
{
    var monthlypay = Number(document.getElementById('monthlySalary').value);
    var xtrapay = Number(document.getElementById('xtrapay').value);
    var salary = (monthlypay+ xtrapay) - Number(deduct);
    document.getElementById('totalSalary').value = salary;
}
</script>

    <div class="main_text_box" style="width: 100% !important;">
        <div style="padding-left: 50px;"><a href="hr_employee_management.php"><b>ফিরে যান</b></a></div>
          <div>
               <table  class="formstyle" style="width: 90% !important; font-family: SolaimanLipi !important;margin:0 auto !important;">          
                    <tr><th colspan="6" style="text-align: center;">কর্মচারীদের বেতন তৈরি</th></tr>
                    <tr>
                        <td colspan="6">
                            <fieldset style="border: #686c70 solid 3px;width: 50%;margin-left:25%;">
                                <legend style="color: brown">সার্চ</legend>
                                <form method="POST"  name="frm" action="">	
                                <table>
                                    <tr>
                                        <td >মাস </td>
                                        <td >
                                            <select style="border: 1px solid black" name="month">
                                                <option value="0">-সিলেক্ট করুন-</option>
                                                <option value="1">জানুয়ারী</option>
                                                <option value="2">ফেব্রুয়ারী</option>
                                                <option value="3">মার্চ</option>
                                                <option value="4">এপ্রিল</option>
                                                <option value="5">মে</option>
                                                <option value="6">জুন</option>
                                                <option value="7">জুলাই</option>
                                                <option value="8">আগস্ট</option>
                                                <option value="9">সেপেম্বর</option>
                                                <option value="10">অক্টোবর</option>
                                                <option value="11">নভেম্বর</option>
                                                <option value="12">ডিসেম্বর</option>
                                            </select>
                                        </td>
                                        <td >বছর</td>
                                        <td ><select class="box" style="width: 70px;" name="year">
                                                <option value="0">-বছর-</option>
                                                <?php
                                                    $thisYear = date('Y');
                                                    $startYear = '2000';

                                                    foreach (range($thisYear, $startYear) as $year) {
                                                    echo '<option value='.$year.'>'. $year .'</option>'; }
                                                ?>
                                            </select>
                                        </td>
                                        <td><input id="search" type="submit" name="submit" value="দেখুন" /></td>
                                    </tr>
                                </table>
                                </form>
                            </fieldset>
                        </td>
                    </tr>
                    <tr>
                    <td colspan="2"></br>
                        <table cellspacing="0" cellpadding="0">
                            <?php 
                            ?>
                            <tr>
                                <td colspan="10" style="width: 25%; text-align: center"><b>মোট কার্যদিবস</b> : <?php echo $workingDays?>দিন </br></br></td>
                            </tr>
                            <tr id="table_row_odd">
                                        <td style='border: 1px solid #000099;text-align: center;width: 1%;' ><strong>ক্রম</strong></td>
                                        <td style='border: 1px solid #000099;text-align: center;width: 10%;' ><strong>কর্মচারীর নাম</strong></td>
                                        <td style='border: 1px solid #000099;text-align: center;width: 5%;' ><strong>গ্রেড</strong></td>
                                        <td style='border: 1px solid #000099;text-align: center;width: 10%;' ><strong>পোস্ট</strong></td>
                                        <td style='border: 1px solid #000099;text-align: center;width: 15%;'><strong>উপস্থিতির হিসেব</strong></td>
                                         <td style='border: 1px solid #000099;text-align: center;width: 3%;'><strong>উপস্থিতির বিস্তারিত তথ্য</strong></td>
                                        <td style='border: 1px solid #000099;text-align: center;width: 10%;'><strong>মূল বেতন (পেনসন কর্তিত)</strong></td>
                                        <td style='border: 1px solid #000099;text-align: center;width: 10%;'><strong>মাসে পাবে (টাকা)</strong></td>
                                        <td style='border: 1px solid #000099;text-align: center;width: 10%;'><strong>অতিরিক্ত প্রদান (টাকা)</strong></td>
                                        <td style='border: 1px solid #000099;text-align: center;width: 10%;'><strong>বেতন কর্তন (টাকা)</strong></td>
                                        <td style='border: 1px solid #000099;text-align: center;width: 10%;'><strong>মোট বেতন (টাকা)</strong></td>
                            </tr>
                                <tbody style="font-size: 12px !important">
                                 <?php
                                 if(isset($_POST['submit']))
                                 {
                                     $sl = 1;
                                     $sql_select_emponsid->execute(array($loginUSERid));
                                     $row4 = $sql_select_emponsid->fetchAll();
                                     foreach ($row4 as $emprow) {
                                         $db_onsid = $emprow['emp_ons_id'];
                                         $db_empID = $emprow['idEmployee'];
                                     }
                                     $sql_select_all_employee->execute(array($db_onsid));
                                     $row5 = $sql_select_all_employee->fetchAll();
                                     foreach ($row5 as $allemprow) 
                                        {
                                            $db_name = $allemprow['account_name'];
                                            $db_userid = $allemprow['idUser'];
                                           $sql_attend =$conn->prepare("SELECT COUNT(idempattend) FROM employee,employee_attendance WHERE emp_atnd_type=? AND  year_no =? AND month_no=? AND  cfs_user_idUser = ? AND idEmployee = emp_user_id ");
                                           $status1 = "present";
                                           $sql_attend->execute(array($status1,$p_year,$p_month,$db_userid));
                                           $row1 = $sql_attend->fetchAll();
                                           foreach ($row1 as $value) {
                                               $presentDays = $value['COUNT(idempattend)'];
                                           }
                                           $status2 ="absent";
                                           $sql_attend->execute(array($status2,$p_year,$p_month,$db_userid));
                                           $row2 = $sql_attend->fetchAll();
                                           foreach ($row2 as $value) {
                                               $absentDays = $value['COUNT(idempattend)'];
                                           }
                                           $status3 = "leave";
                                           $sql_attend->execute(array($status3,$p_year,$p_month,$db_userid));
                                           $row3 = $sql_attend->fetchAll();
                                           foreach ($row3 as $value) {
                                               $leaveDays = $value['COUNT(idempattend)'];                                             
                                           }
                                           $sql_total_overtime->execute(array($p_year,$p_month,$db_userid));
                                           $row7 = $sql_total_overtime->fetchAll();
                                           foreach ($row7 as $value) {
                                               $db_overtime = $value['SUM(emp_extratime)'];
                                           }
                                           $sel_emp_salary = $conn->prepare("SELECT * FROM employee_salary WHERE user_id= ?");
                                           $sel_emp_salary->execute(array($db_empID));
                                           $row6 = $sel_emp_salary->fetchAll();
                                           foreach ($row6 as $salaryrow) {
                                               $db_main_salary = $salaryrow['total_salary'];
                                               $db_pension = $salaryrow['pension'];
                                               $totalsalary = $db_main_salary - $db_pension;
                                           }
                                           $sql_select_employee_grade->execute(array($db_empID));
                                           $row8 = $sql_select_employee_grade->fetchAll();
                                           foreach ($row8 as $gradrow) {
                                               $db_empgrade = $gradrow['grade_name'];
                                           }
                                           $sql_select_view_emp_post = $conn->prepare("SELECT post_name FROM employee_posting,post_in_ons,post 
                                               WHERE Employee_idEmployee = ? AND ons_relation_idons_relation=? AND post_in_ons_idpostinons= idpostinons 
                                               AND Post_idPost= idPost ORDER BY posting_date DESC LIMIT 1");
                                           $sql_select_view_emp_post->execute(array($db_empID,$db_onsid));
                                           $row9 = $sql_select_view_emp_post->fetchAll();
                                           foreach ($row9 as $postrow) {
                                               $db_post = $postrow['post_name'];
                                           }
                                           echo "<tr><td style='border: 1px solid black; text-align: center'>".  english2bangla($sl)."</td>
                                               <td style='border: 1px solid black; text-align: left'>$db_name</td>
                                                <td style='border: 1px solid black; text-align: center'>$db_empgrade</td>
                                                <td style='border: 1px solid black; text-align: center'>$db_post</td>
                                               <td style='border: 1px solid black; text-align: left'>
                                                <b>উপস্থিতঃ</b> $presentDays দিন</br>
                                                <b>অনুপস্থিতঃ</b> $absentDays দিন</br>
                                                <b>ছুটিঃ</b> $leaveDays দিন</br>
                                                <b>ওভারটাইমঃ</b> $db_overtime ঘণ্টা    
                                               </td>
                                               <td style='border: 1px solid black; text-align: center'><input type='button' value='বিস্তারিত' style='cursor:pointer;border:2px solid blue;' /></td>
                                               <td style='border: 1px solid black; text-align: center'>".english2bangla($totalsalary)."</td>
                                               <td style='border: 1px solid black; text-align: center'><input type='hidden' name='monthlySalary' id='monthlySalary' value='$totalsalary' />".english2bangla($totalsalary)."</td>
                                               <td style='border: 1px solid black; text-align: left;padding-left:0px;'><input class='box' type='text' style='width:92%;text-align:right' id='xtrapay' name='xtrapay' onkeypress='return checkIt(event)'  /></td>
                                               <td style='border: 1px solid black; text-align: left;padding-left:0px;'><input class='box' type='text' style='width:92%;text-align:right;' onkeypress='return checkIt(event)' onkeyup='calculateSalary(this.value)' /></td>
                                               <td style='border: 1px solid black; text-align: left;padding-left:0px;'><input class='box' type='text' style='width:92%;text-align:right;' readonly id='totalSalary' name='totalSalary' /></td></tr>";
                                           $sl++;
                                    }
                                 }
                                ?>
                                </tbody>
                            </table>
                           </td>
                    </tr>
                </table>
        </div>                 
    </div>
    <?php include_once 'includes/footer.php';?>

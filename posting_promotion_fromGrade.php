<?php
error_reporting(0);
include_once 'includes/MiscFunctions.php';
include 'includes/ConnectDB.inc';
include 'includes/header.php';
?>
<style type="text/css">
    @import "css/bush.css";
</style>

<?php
    function showGrades($gradeName)
            {
            $showGradeName = array('employee' => 'কর্মচারীর', 'presenter' => 'প্রেজেন্টারের', 'programmer' => 'প্রোগ্রামারের', 'trainer' => 'ট্রেইনারের');
            $printGradeName = $showGradeName[$gradeName];
            echo "<table  class='formstyle'>";          
                echo "<tr><th colspan='7' style='text-align: center;'>গ্রেড ভিত্তিক $printGradeName সংখ্যা</th></tr>";
                echo "<tr align='left' id='table_row_odd'>
                    <td>গ্রেডের নাম</td>
                    <td colspan='2'>$printGradeName সংখ্যা</td>
                </tr>";
                 $query_grade = mysql_query("SELECT idpaygrade, grade_name, COUNT(*) as num
                                                    FROM pay_grade, employee as emp
                                                    WHERE emp.employee_type='$gradeName' AND pay_grade_id = idpaygrade
                                                    GROUP BY grade_name");
                //$query_grade = mysql_query("SELECT idEmployee_grade, grade_name, COUNT(*) FROM employee, employee_grade WHERE Employee_grade_idEmployee_grade=idEmployee_grade AND employee_type='$gradeName' GROUP BY grade_name");
                $total_employee = 0;
                
                while($rows_grade = mysql_fetch_array($query_grade))
                        {                    
                        $grade_id = $rows_grade['idpaygrade'];
                        $grade_name = $rows_grade['grade_name'];
                        $employee_number = $rows_grade['num'];
                        $numShow = english2bangla($employee_number);
                        $total_employee = $total_employee + $employee_number;
                        echo "<tr>
                            <td>$grade_name</td>
                            <td>$numShow জন</td>
                            <td><a href='posting_promotion_fromGrade.php?iffimore=00d110t01l11s01&sh110ow1=$gradeName&i010d10=$grade_id'>$printGradeName তালিকা দেখুন</a></td>
                        </tr>";
                        }
                        $totalNumShow = english2bangla($total_employee);
                echo "<tr align='left' id='table_row_odd'>                                                 
                    <td style='text-align: right;'>সর্বমোট $printGradeName সংখ্যাঃ</td>
                    <td colspan='2' style='text-align: left;'>$totalNumShow জন</td>
                </tr>";
            echo "</table>";
            }
?>

<div class="column6">

    <?php
    if($_GET['iffimore'] == '00d110t01l11s01') {
    ?>
    <div class="main_text_box">
        <div style="padding-left: 110px;"><a href="posting_promotion_fromGrade.php?iffimore=1m10a01i11n"><b>ফিরে যান</b></a></div>
        <div>
            <?php
            $dtls_gradeName = $_GET['sh110ow1'];
            $showGradeName = array('employee' => 'কর্মচারীর', 'presenter' => 'প্রেজেন্টারের', 'programmer' => 'প্রোগ্রামারের', 'trainer' => 'ট্রেইনারের');
            $printGradeName = $showGradeName[$dtls_gradeName];
            $dtls_grade_id = $_GET['i010d10'];
            echo "<table  class='formstyle'>";          
                echo "<tr><th colspan='10' style='text-align: center;'>গ্রেড ভিত্তিক $printGradeName তালিকা</th></tr>";
                echo "<tr align='left' id='table_row_odd'>
                    <td>ক্রম</td>
                    <td>$printGradeName নাম</td>
                    <td>একাউন্ট নাম্বার</td>
                    <td>গ্রেড</td>
                    <td>গ্রেডের স্থায়িত্বকাল</td>
                    <td>দায়িত্ব</td>
                    <td>অফিসে সময়কাল</td>
                    <td colspan='3'></td>
                </tr>";
                $go2parent = "posting_promotion_fromGrade.php?iffimore=00d110t01l11s01%%sh110ow1=".$dtls_gradeName."%%i010d10=$dtls_grade_id";
                $row_count = 1;
               $query_employee = mysql_query("SELECT account_name, account_number, grade_name
                                                        FROM pay_grade, cfs_user, employee
                                                        WHERE cfs_user_idUser = idUser
                                                        AND idpaygrade = pay_grade_id
                                                        AND idpaygrade ='$dtls_grade_id'");
             /*   $query_employee = mysql_query("SELECT * FROM employee, pay_grade
                                                                                WHERE idEmployee = Employee_idEmployee AND idUser = cfs_user_idUser AND idEmployee_grade = Employee_grade_idEmployee_grade
                                                                                        AND employee_type='$dtls_gradeName' AND Employee_grade_idEmployee_grade='$dtls_grade_id'"); */
                while($rows_employee = mysql_fetch_array($query_employee))
                        {
                        $employee_name = $rows_employee['account_name'];
                        $account_number = $rows_employee['account_number'];
                        $grade_name = $rows_employee['grade_name'];
                        $rowShow = english2bangla($row_count);
                        echo "<tr>
                            <td>$rowShow</td>
                            <td>$employee_name</td>
                            <td>$account_number</td>
                            <td>$grade_name</td>
                            <td>২ বছর ৩ মাস</td>
                            <td>কেয়ারটেকার</td>
                            <td>১৬ মাস</td>
                            <td><a href='posting_to.php?i001d1=$dtls_grade_id&bkprnt=$go2parent'>পোস্টিং করুন</a></td>
                            <td><a href='promotion_to.php?i001d1=$dtls_grade_id&bkprnt=$go2parent'>প্রোমশন</a></td>
                            <td><a href='postingNpromotion.php?i001d1=$dtls_grade_id&bkprnt=$go2parent'>পোস্টিং এন্ড প্রোমশন</a></td>
                        </tr>";
                        $row_count = $row_count + 1;
                        }
            echo "</table>";
            ?>
        </div>
    </div>
    <?php 
        }
        else {
    ?>
    <div class="main_text_box">
        <div style="padding-left: 110px;"><a href="hr_employee_management.php"><b>ফিরে যান</b></a></div>
        <div class="domtab">
            <ul class="domtabs">
                <li class="current"><a href="#01">কর্মচারী</a></li>
                <li class="current"><a href="#02">প্রেজেন্টার</a></li>
                <li class="current"><a href="#03">প্রোগ্রামার</a></li>
                <li class="current"><a href="#04">ট্রেইনার</a></li>
            </ul>
        </div>
        <div>
            <h2><a name="01" id="01"></a></h2><br/>
            <?php showGrades("employee");?>
        </div>
        <div>
            <h2><a name="02" id="02"></a></h2><br/>
            <?php showGrades("presenter");?>
        </div>
        <div>
            <h2><a name="03" id="03"></a></h2><br/>
            <?php showGrades("programmer");?>
        </div>
        <div>
            <h2><a name="04" id="04"></a></h2><br/>
            <?php showGrades("trainer");?>
        </div>
    </div>    
    
<?php
        }
include 'includes/footer.php';
?>
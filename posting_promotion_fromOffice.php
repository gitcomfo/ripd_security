<?php
include_once 'includes/MiscFunctions.php';
include 'includes/header.php';
?>

<style type="text/css">@import "css/bush.css";</style>
<script type="text/javascript" src="javascripts/area.js"></script>
<script type="text/javascript" src="javascripts/external/mootools.js"></script>
<script type="text/javascript" src="javascripts/dg-filter.js"></script>
<script type="text/javascript">
    function infoFromThana()
    {
        var xmlhttp;
        if (window.XMLHttpRequest) xmlhttp=new XMLHttpRequest();
        else xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
        xmlhttp.onreadystatechange=function()
        {
            if (xmlhttp.readyState==4 && xmlhttp.status==200) 
                document.getElementById('office').innerHTML=xmlhttp.responseText;
        }
        var division_id, district_id, thana_id;
        division_id = document.getElementById('division_id').value;
        district_id = document.getElementById('district_id').value;
        thana_id = document.getElementById('thana_id').value;
        xmlhttp.open("GET","includes/infoSetteleOfficeFromThana.php?dsd="+district_id+"&dvd="+division_id+"&ttid="+thana_id,true);
        xmlhttp.send();
    }
</script>

<div class="column6">
    
    <?php if($_GET['iffimore'] != 'll1i1s0t01'){?>
    <div class="main_text_box">
        <div style="padding-left: 110px;"><a href="hr_employee_management.php"><b>ফিরে যান</b></a></div>
        <div>
            <table  class='formstyle'>       
                <tr><th style='text-align: center;'>সকল অফিসের তালিকা</th></tr>
                <tr><td>
                    <div style="padding-bottom: 10px;">
                        <?php
                        include_once 'includes/areaSearch.php';
                        getArea("infoFromThana()");
                        ?>
                        <input type="hidden" id="method" value="infoFromThana()">
                        সার্চ/খুঁজুন:  <input type="text" id="search_box_filter">
                    </div>
                </td></tr>
                <tr><td>    
                    <span id="office">
                        <div>
                            <table id="office_info_filter" border="1" align="center" width= 99%" cellpadding="5px" cellspacing="0px">
                                <thead>
                                    <tr id="table_row_odd" style="font-weight: bold">
                                        <td>অফিস নং</td>
                                        <td>অফিসের নাম</td>
                                        <td>অফিস নম্বর</td>
                                        <td>একাউন্ট নম্বর</td>
                                        <td>ব্রাঞ্চের নাম</td>
                                        <td>অফিসের ঠিকানা</td>
                                        <td></td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    //officeTableHead();
                                    $sql_setteleOfficeTable = "SELECT * from $dbname.office ORDER BY office_name ASC";
                                    $db_slNo = 0;
                                    $rs = mysql_query($sql_setteleOfficeTable);
                                    //echo mysql_num_rows($rs);
                                    while ($row_setteleOfficeTable = mysql_fetch_array($rs)) 
                                        {
                                        $db_slNo = $db_slNo + 1;
                                        $db_setteleOfficeID = $row_setteleOfficeTable['idOffice'];
                                        $db_setteleOfficeName = $row_setteleOfficeTable['office_name'];
                                        $db_setteleOfficeNumber = $row_setteleOfficeTable['office_number'];
                                        $db_setteleOfficeAN = $row_setteleOfficeTable['account_number'];
                                        $db_setteleOfficeBranch = $row_setteleOfficeTable['branch_name'];
                                        $db_setteleOfficeAddress = $row_setteleOfficeTable['office_details_address'];
                                        echo "<tr>";
                                        echo "<td>$db_slNo</td>";
                                        echo "<td>$db_setteleOfficeName</td>";
                                        echo "<td>$db_setteleOfficeNumber</td>";
                                        echo "<td>$db_setteleOfficeAN</td>";
                                        echo "<td>$db_setteleOfficeBranch</td>";
                                        echo "<td>$db_setteleOfficeAddress</td>";
                                        echo "<td><a href='posting_promotion_fromOffice.php?iffimore=ll1i1s0t01&i010d10=$db_setteleOfficeID'>কর্মচারীদের তালিকা</a></td>";
                                        echo "</tr>";
                                        }
                                    ?>
                                </tbody>
                            </table>                        
                        </div>
                    </span> 
                </td></tr>                
            </table>
        </div>
    </div>       
    <script type="text/javascript">
        var filter = new DG.Filter({
            filterField : $('search_box_filter'),
            filterEl : $('office_info_filter')
        });
    </script>
    <?php     
            }
    else if ($_GET['iffimore']=='ll1i1s0t01')
            {
    ?>
        <div class="main_text_box">
        <div style="padding-left: 110px;"><a href="posting_promotion_fromOffice.php"><b>ফিরে যান</b></a></div>
        <div>
            <?php
           $get_office_id = $_GET['i010d10'];
            $sql = mysql_query("SELECT * FROM office WHERE idOffice=$get_office_id");
            $row = mysql_fetch_array($sql);
            $office_name = $row['office_name'];
            echo "<table  class='formstyle'>";          
                echo "<tr><th colspan='10' style='text-align: center;font-size:18px;'>$office_name - এ কর্মচারীদের তালিকা</th></tr>";
                echo "<tr align='left' id='table_row_odd'>
                    <td><b>ক্রম</b></td>
                    <td><b>কর্মচারীদের নাম</b></td>
                    <td><b>একাউন্ট নাম্বার</b></td>
                    <td><b>গ্রেড</b></td>
                    <td><b>গ্রেডের স্থায়িত্বকাল</b></td>
                    <td><b>দায়িত্ব</b></td>
                    <td><b>অফিসে সময়কাল</b></td>
                    <td colspan='3'></td>
                </tr>";
                $sel_office_employee = mysql_query("SELECT * FROM cfs_user,employee,ons_relation 
                    WHERE catagory='office' AND add_ons_id=$get_office_id AND idons_relation=emp_ons_id AND employee.employee_type='employee' 
                    AND cfs_user_idUser = idUser");
                $sl = 1;
                while($emprow = mysql_fetch_assoc($sel_office_employee))
                {
                    $empID = $emprow['idEmployee'];
                    $timestamp=time(); //current timestamp
                    $sql_employee_grade = mysql_query("SELECT grade_name,employee_salary.insert_date  FROM employee_salary,employee,pay_grade
                                                                    WHERE pay_grade_id = 	idpaygrade AND user_id = $empID AND pay_grade_idpaygrade = idpaygrade ORDER BY employee_salary.insert_date DESC LIMIT 1");
                    $arr_grade = mysql_fetch_assoc($sql_employee_grade);
                    $db_gradeInsertDate = $arr_grade['insert_date'];
                    $start= abs(strtotime(date("Y/m/d",  strtotime($db_gradeInsertDate))));
                     $end =abs(strtotime(date("Y/m/d", $timestamp)));
                     $grddifference = $end - $start;
                     $grdyears = english2bangla(floor($grddifference / (365 * 60 * 60 * 24)));
                     $grdmonths2 = english2bangla(floor(($grddifference - ($grdyears * 365 * 60 * 60 * 24)) / ((365 * 60 * 60 * 24) / 12)));
                     $grddays = english2bangla(floor(($grddifference - ($grdyears * 365 * 60 * 60 * 24) -( $grdmonths2 * 30 * 60 * 60 * 24))/ (60 * 60 * 24)));
                    
                    $sql_employee_posting = mysql_query("SELECT * FROM view_emp_post 
                        WHERE Employee_idEmployee=$empID AND add_ons_id= $get_office_id ORDER BY posting_date DESC LIMIT 1");
                    $arr_row = mysql_fetch_assoc($sql_employee_posting);
                    $db_post = $arr_row['post_name'];
                    $db_postingDate = $arr_row['posting_date'];
                     $timestamp_start= abs(strtotime(date("Y/m/d",  strtotime($db_postingDate))));
                     $timestamp_end =abs(strtotime(date("Y/m/d", $timestamp)));
                     $difference = $timestamp_end - $timestamp_start;
                        $years = english2bangla(floor($difference / (365 * 60 * 60 * 24)));
                        $months2 = english2bangla(floor(($difference - ($years * 365 * 60 * 60 * 24)) / ((365 * 60 * 60 * 24) / 12)));
                        $days = english2bangla(floor(($difference - ($years * 365 * 60 * 60 * 24) -( $months2 * 30 * 60 * 60 * 24))/ (60 * 60 * 24)));
                    echo "<tr>
                        <td>".english2bangla($sl)."</td>
                        <td>".$emprow['account_name']."</td>
                        <td>".$emprow['account_number']."</td>
                        <td>".$arr_grade['grade_name']."</td>
                        <td>$grdyears বছর, $grdmonths2 মাস, $grddays দিন</td>
                        <td>$db_post</td>
                        <td>$years বছর, $months2 মাস, $days দিন</td>
                        <td><a href='posting_to.php?0to1o1ff01i0c1e0=$empID&bkprnt=posting_promotion_fromOffice.php?iffimore=ll1i1s0t01%%i010d10=$get_office_id'>পোস্টিং করুন</a></td>
                        <td><a href='promotion_to.php?0to1o1ff01i0c1e0=$empID&bkprnt=posting_promotion_fromOffice.php?iffimore=ll1i1s0t01%%i010d10=$get_office_id'>প্রোমোশন করুন</a></td>
                        <td><a href='postingNpromotion.php?0to1o1ff01i0c1e0=$empID&bkprnt=posting_promotion_fromOffice.php?iffimore=ll1i1s0t01%%i010d10=$get_office_id'>পোস্টিং এন্ড প্রোমোশন</a></td>
                    </tr>"; // give the user id in the the place of $get_office_id
                    $sl++;
                }
            echo "</table>";
            ?>
        </div>
    </div>
    <?php
            }
    ?>
<?php
include 'includes/footer.php';?>

<?php
error_reporting(0);
include_once 'includes/MiscFunctions.php';
include 'includes/header.php';
?>
<style type="text/css">@import "css/bush.css";</style>
<link rel="stylesheet" href="css/tinybox.css" type="text/css">
<script src="javascripts/tinybox.js" type="text/javascript"></script>
<script type="text/javascript">
    function selectOffice(url)
    { TINY.box.show({iframe:'select_office.php?url='+url,width:900,height:400,opacity:30,topsplit:3,animate:true,close:true,maskid:'bluemask',maskopacity:50,boxid:'success'}); }
</script>
<script language=javascript>
window.name = "parentWindow";
</script>

<div class="main_text_box">
        <?php
        $back_parent = $_GET['bkprnt'];
        $back_parent_change = str_replace("%%", "&", $back_parent);
        echo "<div style='padding-left: 110px;'><a href='$back_parent_change'><b>ফিরে যান</b></a></div>";
        ?>
        <div>
            <form onsubmit="" method="post" style="width: 90%;">
                <?php
                $url= urlencode($_SERVER['REQUEST_URI']);
                //$g_officeID = $_GET['ll1i1s0t01%%i010d10'];
                $employee_id = $_GET['0to1o1ff01i0c1e0'];
                $sql_sel_cfsuser = mysql_query("SELECT * FROM cfs_user,employee,employee_information WHERE idUser = cfs_user_idUser AND idEmployee = $employee_id");
                $cfs_row = mysql_fetch_assoc($sql_sel_cfsuser);
                $sql_sel_address = mysql_query("SELECT * FROM address,thana,district,division WHERE 	address_whom = 'emp'
                                                                        AND address_type='Present' AND adrs_cepng_id = $employee_id
                                                                        AND Thana_idThana = idThana AND District_idDistrict=idDistrict AND Division_idDivision= idDivision ");
                $addressrow = mysql_fetch_assoc($sql_sel_address); 
                $sql_employee_grade = mysql_query("SELECT grade_name,employee_salary.insert_date,total_salary  FROM employee_salary,employee,pay_grade WHERE pay_grade_id = idpaygrade AND user_id = $employee_id AND pay_grade_idpaygrade = idpaygrade ORDER BY employee_salary.insert_date DESC LIMIT 1");
                    $arr_grade = mysql_fetch_assoc($sql_employee_grade);
                    $db_salary = $arr_grade['total_salary'];                                       
                    $sql_employee_posting = mysql_query("SELECT * FROM view_emp_post WHERE Employee_idEmployee=$employee_id ORDER BY posting_date DESC LIMIT 1");
                    $arr_row = mysql_fetch_assoc($sql_employee_posting);
                    $db_post = $arr_row['post_name'];
                    $db_postingDate = $arr_row['posting_date'];                
                echo "<table  class='formstyle'>";
                echo "<tr >
                                <th colspan='4' style='text-align: center'>
                                <div style='width: 80%; float: left; padding-top: 18px;'>
                                    <h1>".$cfs_row['account_name']."</h1>
                                    <h2>".$cfs_row['account_number']."</h2>
                                    <h3>মোবাইলঃ ".$cfs_row['mobile']."</h3>
                                    <h3>বাসা-".$addressrow['house'].",".$addressrow['house_no'].", রোড-".$addressrow['house'].", থানাঃ ".$addressrow['thana_name'].", জেলাঃ".$addressrow['district_name'].", বিভাগঃ".$addressrow['division_name']."</h3>
                                </div>
                                <div style='float: right'><img src='".$cfs_row['emplo_scanDoc_picture']."' style='width:150px;height:150px;' /></div></th>
                            </tr>";
                echo "<tr><td colspan='4'><hr></td></tr>";
                echo '<tr>
                     <td colspan="4">
                     <fieldset style="border:3px solid #686c70;width: 99%;">
                            <legend style="color: brown;font-size: 14px;">বর্তমান অবস্থা</legend>
                            <table>
                            <tr>
                                <td style="width: 25%; text-align:right">গ্রেড</td>
                                <td style="width: 25%; text-align:left">: '.$arr_grade['grade_name'].'</td>
                                <td style="width: 25%; text-align:right">পোস্ট</td>
                                <td style="width: 25%; text-align:left">: '.$db_post.'</td>
                            </tr>
                            <tr>
                               <td style="width: 25%; text-align:right">অফিস</td>
                                <td style="width: 25%; text-align:left">: </td>
                                <td style="width: 25%; text-align:right">কর্মচারীর ধরন</td>
                                <td style="width: 25%; text-align:left">: কর্মচারী</td>
                            </tr>
                            <tr>
                               <td style="width: 25%; text-align:right">যোগদানের তারিখ</td>
                                <td style="width: 25%; text-align:left">: '.english2bangla(date("d/m/Y",  strtotime($db_postingDate))).'</td>
                                <td style="width: 25%; text-align:right">বেতন</td>
                                <td style="width: 25%; text-align:left">: '.english2bangla($db_salary).' টাকা</td>
                            </tr>
                            </table>
                            </filedset></td>
                    </tr>';

                echo '<tr>
                     <td colspan="4">
                     <fieldset style="border:3px solid #686c70;width: 99%;">
                            <legend style="color: brown;font-size: 14px;">সামগ্রিক কর্মজীবন</legend>
                            <table>
                            <tr>
                                <td colspan="2" style="width: 50%; text-align:right">কর্মজীবন</td>
                                <td colspan="2" style="width: 50%; text-align:left">: </td>     
                            </tr>
                            <tr>
                               <td style="width: 25%; text-align:right">উপস্থিতির হার</td>
                                <td style="width: 25%; text-align:left">: </td>
                                <td style="width: 25%; text-align:right">মোট কর্মদিবস</td>
                                <td style="width: 25%; text-align:left">: </td>
                            </tr>
                            <tr>
                               <td style="width: 25%; text-align:right">প্রেজেন্ড ডে</td>
                                <td style="width: 25%; text-align:left">: </td>
                                <td style="width: 25%; text-align:right">অ্যাবসেন্ট</td>
                                <td style="width: 25%; text-align:left">: </td>
                            </tr>
                            <tr>
                                <td colspan="2" style="width: 50%; text-align:right">ছুটি</td>
                                <td colspan="2" style="width: 50%; text-align:left">: </td>     
                            </tr>
                            <tr>
                            <td colspan="4"><div align="center"><a onclick="detailsWithPrice()" style="cursor:pointer;color:blue;">উপস্থিতির বিস্তারিত তথ্য</a></div></td>
                            </tr>
                            </table>
                            </filedset></td>
                    </tr>';

                echo '<tr>
                     <td colspan="4">
                     <fieldset style="border:3px solid #686c70;width: 99%;">
                            <legend style="color: brown;font-size: 14px;">পোস্টিং এ</legend>
                            <table>
                            <tr>
                                <td style="width: 30%; text-align:right">পোস্টিং অফিস</td>
                                <td style="width: 40%"><input type="text" class="box" name="promotion"/></td>';
                                echo "<td colspan='2'><div align='center'><a onclick=selectOffice('$url') style='cursor:pointer;color:blue;'>সিলেক্ট অফিস</a></div></td> "; 
                           echo  '</tr>
                            <tr>
                                <td style="width: 30%; text-align:right">পোস্টিং</td>
                                <td colspan="3" style="width: 40%"><input type="text" class="box" name="promotion"/></td>
                             </tr>
                            <tr>
                                <td style="width: 30%; text-align:right">পোস্টিং তারিখ</td>
                                <td colspan="3" style="width: 40%"><input type="date" class="box" name="promotion"/></td>
                             </tr>
                            </table>
                            </filedset></td>
                    </tr>';
                echo "<tr><td colspan='4' style='text-align: center' ><input class='btn' style ='font-size: 12px' type='reset' name='reset' value='পোস্টিং' /></td></tr>";
                echo "</table>";
                ?>
            </form>
        </div>
    </div>

    <?php
    include 'includes/footer.php';
    ?>
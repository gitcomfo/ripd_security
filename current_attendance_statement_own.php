<?php
//include_once 'includes/session.inc';
include_once 'includes/header.php';
include_once 'includes/MiscFunctions.php';

$loginUSERname = $_SESSION['acc_holder_name'] ;
?>
<title>নিয়মিত কর্মচারী হাজিরা</title>
<style type="text/css"> @import "css/bush.css";</style>

    <div class="main_text_box" style="width: 100% !important;">
        <div style="padding-left: 50px;"><a href="personal_official_profile_employee.php"><b>ফিরে যান</b></a></div>
          <div>
           <form method="POST"  name="frm" action="">	
               <table  class="formstyle" style="width: 90% !important; font-family: SolaimanLipi !important;margin:0 auto !important;">          
                    <tr><th colspan="2" style="text-align: center;">কর্মচারী হাজিরা বিবরণ</th></tr>
                    <tr><td colspan="13" style="color: sienna; text-align: center; font-size: 20px;"><b><?php echo $loginUSERname;?></b></td></tr>
                    <tr><td colspan="13" style="color: sienna; text-align: center; font-size: 16px;"> চলতি মাস (<?php echo date('F');?>)-এর হাজিরা বিবরণ</td></tr>
                    <tr>
                        <td>
                            <fieldset style="border: #686c70 solid 3px;width: 60%;margin-left:20%;">
                                <legend style="color: brown">সারসংক্ষেপ</legend>
                                <table>
                                    <tr>
                                        <td >চলতি মাসের হাজিরার হার :</td>
                                        <td > %</td>
                                    </tr>
                                    <tr>
                                        <td >মোট কার্যদিবস :</td>
                                        <td > দিন</td>
                                    </tr>
                                    <tr>
                                        <td>উপস্থিতি :</td>
                                        <td> দিন</td>
                                        <td>অনুপস্থিতি :</td>
                                        <td> দিন</td>
                                        <td>ছুটি :</td>
                                        <td> দিন</td>
                                    </tr>
                                </table>
                            </fieldset>
                        </td>
                    </tr>
                    <tr>
                    <td colspan="2">
                        <table align="center" style="border: black solid 1px !important; border-collapse: collapse;">
                                    <thead>                                     
                                        <tr id="table_row_odd">
                                        <td style='border: 1px solid #000099; text-align: center' >তারিখ</td>
                                        <td style='border: 1px solid #000099;text-align: center' >স্ট্যাটাস</td>
                                        <td style='border: 1px solid #000099;text-align: center'>ইন টাইম</td>
                                        <td style='border: 1px solid #000099;text-align: center'>আউট টাইম</td>
                                        </tr>
                                </thead>
                                <tbody style="font-size: 12px !important">
                                <?php
//                                    $db_cfsid = $_SESSION['userIDUser'];
//                                    $sel_attendace = mysql_query("SELECT * FROM employee_attendance WHERE ");
                                ?>
                                </tbody>
                            </table>
                           </td>
                    </tr>
                </table>
            </form>
        </div>                 
    </div>
    <?php include_once 'includes/footer.php';?>

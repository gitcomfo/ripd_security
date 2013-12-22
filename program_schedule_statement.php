<?php
//include_once 'includes/session.inc';
include_once 'includes/header.php';
include_once 'includes/MiscFunctions.php';

$loginUSERname = $_SESSION['acc_holder_name'] ;
?>
<title></title>
<style type="text/css"> @import "css/bush.css";</style>

    <div class="main_text_box" style="width: 100% !important;">
        <div style="padding-left: 50px;"><a href="personal_official_profile_employee.php"><b>ফিরে যান</b></a></div>
          <div>
           <form method="POST"  name="frm" action="">	
               <table  class="formstyle" style="width: 90% !important; font-family: SolaimanLipi !important;margin:0 auto !important;">          
                    <tr><th colspan="2" style="text-align: center;">চলতি এবং আপ-কামিং প্রেজেন্টেশান</th></tr>
                    <tr><td colspan="13" style="color: sienna; text-align: center; font-size: 20px;"><b><?php echo $loginUSERname;?></b></td></tr>
                    <tr><td colspan="13" style="color: sienna; text-align: center; font-size: 16px;"> চলতি মাস (<?php echo date('F');?>)-এর অনুসূচি</td></tr>
                    <tr>
                    <td colspan="2">
                        <table align="center" style="border: black solid 1px !important; border-collapse: collapse;">
                                    <thead>                                     
                                        <tr id="table_row_odd">
                                        <td style='border: 1px solid #000099; text-align: center' >তারিখ</td>
                                        <td style='border: 1px solid #000099;text-align: center' >প্রেজেন্টেশান -এর নাম</td>
                                        <td style='border: 1px solid #000099;text-align: center'>অফিস</td>
                                        <td style='border: 1px solid #000099;text-align: center'>ভেন্যু</td>
                                        <td style='border: 1px solid #000099;text-align: center'>সময়</td>
                                        <td style='border: 1px solid #000099;text-align: center'>প্রেসেন্টারস</td>
                                        </tr>
                                </thead>
                                <tbody style="font-size: 12px !important">
                                </tbody>
                            </table>
                           </td>
                    </tr>
                </table>
            </form>
        </div>                 
    </div>
    <?php include_once 'includes/footer.php';?>
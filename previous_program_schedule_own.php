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
                    <tr><th colspan="2" style="text-align: center;">পূর্ববর্তি প্রেজেন্টেশান তালিকা</th></tr>
                    <tr><td colspan="2" style="color: sienna; text-align: center; font-size: 20px;"><b><?php echo $loginUSERname;?></b></td></tr>
                    <tr>
                        <td>
                            <fieldset style="border: #686c70 solid 3px;width: 90%;margin-left:5%;">
                                <legend style="color: brown">সার্চ</legend>
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
                                        <td ><select class="box" style="width: 50px;" name="year">
                                                
                                            </select>
                                        </td>
                                        <td><input type="button" style="width: 50px;background-color: #009933;border: 2px solid #0077D5;cursor: pointer; color: wheat;" value="দেখুন" /></td>
                                    </tr>
                                </table>
                            </fieldset>
                        </td>
                        <td>
                            <fieldset style="border: #686c70 solid 3px;width: 90%;margin-left:5%;">
                                <legend style="color: brown">মোট সারসংক্ষেপ</legend>
                                <table>
                                    <tr>
                                        <td >হাজিরার হার :</td>
                                        <td > %</td>
                                    </tr>
                                    <tr>
                                        <td >মোট প্রেজেন্টেশান :</td>
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
                        <table cellspacing="0" cellpadding="0">
                            <tr>
                                <td colspan="4" style="text-align: center;color: sienna; text-align: center; font-size: 20px;"></br> <?php echo "মাস";?> -এর হাজিরা বিবরণ </td>
                            </tr>
                            <tr>
                                <td colspan="4" style="text-align: center;">
                                    <fieldset style="border: #686c70 solid 3px;width: 60%;margin-left: 20%;">
                                        <legend style="color: brown">মোট সারসংক্ষেপ</legend>
                                        <table>
                                            <tr>
                                                <td >হাজিরার হার :</td>
                                                <td > %</td>
                                            </tr>
                                            <tr>
                                                <td >মোট প্রেজেন্টেশান :</td>
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
                                    </fieldset></br>
                                </td>
                            </tr>
                            <tr id="table_row_odd">
                                        <td style='border: 1px solid #000099; text-align: center' >তারিখ</td>
                                        <td style='border: 1px solid #000099;text-align: center' >প্রেজেন্টেশান -এর নাম</td>
                                        <td style='border: 1px solid #000099;text-align: center'>অফিস</td>
                                        <td style='border: 1px solid #000099;text-align: center'>ভেন্যু</td>
                                        <td style='border: 1px solid #000099;text-align: center'>সময়</td>
                                        <td style='border: 1px solid #000099;text-align: center'>প্রেসেন্টারস</td
                            </tr>
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
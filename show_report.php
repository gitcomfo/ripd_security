<?php
error_reporting(0);
include 'includes/ConnectDB.inc';
$cfsID = $_SESSION['userIDUser'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<style type="text/css"> @import "css/bush.css";</style>
</head>
<body>

    <div class="main_text_box">
        <div>	
                <table  class="formstyle" style="font-family: SolaimanLipi !important; margin: 5px !important;width: 100%;">          
                    <tr><th colspan="4" style="text-align: center;">রিপোর্ট</th></tr>
                    <tr>
                        <td>প্রেজেন্টেশন / প্রোগ্রাম / ট্রেইনিং / ট্রাভেল এর নম্বর</td>
                        <td>:  <input class="box" type="text" id="prgrm_number" name="prgrm_number" readonly=""/></td>
                    </tr>
                    <tr>
                        <td>প্রেজেন্টেশন / প্রোগ্রাম / ট্রেইনিং / ট্রাভেল এর নাম</td>
                        <td>:  <input class="box" type="text" id="prgrm_number" name="prgrm_number" readonly=""/></td>
                    </tr>
                    <tr>
                        <td>তারিখ</td>
                        <td colspan="3">: <input class="box"type="date" id="presentation_date" name="presentation_date" value="<?php echo $pdate;?>"/></td>    
                    </tr>
                   <tr>
                    <td>টিকেট বিক্রি হতে মোট আয়</td>               
                    <td colspan="3">: <input class="box" id="off_name" name="offname"  value="<?php echo $offname;?>" /> টাকা</td>
                </tr>
                <tr>
                    <td>প্রোগ্রামের খরচ</td>
                    <td colspan="3">: <input  class="box" type="text" id="place" name="place" value="<?php echo $place;?>"/> টাকা</td>            
                </tr>           
                <tr>
                    <td>প্রোগ্রামারদের বেতন বাবদ খরচ</td>
                    <td colspan="3">: <input  class="box" type="time" id="presentation_time" name="presentation_time" value="<?php echo $ptime;?>"/> টাকা</td>  
                </tr>
                    <tr>
                        <td colspan="3"><hr/></td>
                    </tr>
                <tr>
                    <td>প্রফিট / লস</td>
                    <td>: <input  class="box" type="text" id="budget" name="budget" onkeypress=' return numbersonly(event)'  /> টাকা</td>
                </tr>
                </table>
        </div>
    </div>      
</body>
</html>

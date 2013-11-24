<?php
error_reporting(0);
require_once('auth.php');
include 'includes/ConnectDB.inc';
$cfsid= $_SESSION['cfsid'];
$sumeryid = $_GET['ssumid'];
$check=1;
while($check==1)
{
$str_pin= "Sales";
for($i=0;$i<3;$i++)
    {
        $str_random_no=(string)mt_rand (0 ,9999 );
        $str_pin_random= str_pad($str_random_no,4, "0", STR_PAD_LEFT);
        $str_pin =$str_pin."-".$str_pin_random;
    }
$sql= "SELECT * FROM pin_makingused where pin_no= '$str_pin' ";
$result = mysql_query($sql) or exit("soryy");
$row= mysql_fetch_assoc($result);
if($row['pin_no']!= $str_pin)
{
	$sql_pin = mysql_query("SELECT * FROM pin_makingused WHERE sales_summery_idsalessummery = $sumeryid;");
    $pinrow = mysql_fetch_assoc($sql_pin);
	if($pinrow['idpin'] == "")
        {
             $inssql= "INSERT INTO pin_makingused (`pin_no` ,`pin_state`, pin_making_date, pin_madeby_cfsuserid, sales_summery_idsalessummery) 
                                    VALUES ('$str_pin', 'open', CURDATE(), $cfsid, $sumeryid);";
	$insreslt = mysql_query($inssql) or exit ("sorry have problem");
	$check=2;
        }
   else
   {
       $str_pin = $pinrow['pin_no']; $check =2;
   }
}
}
$random_pass = mt_rand (0 ,9999 );
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>অ্যাকাউন্ট ওপেন</title>
<link rel="stylesheet" href="css/style.css" type="text/css" media="screen" charset="utf-8"/>
<link rel="stylesheet" href="css/css.css" type="text/css" media="screen" />
</head>
<body>
    <div id="maindiv">
        <div align="center" style="width: 100%;height: 480px;font-family: SolaimanLipi !important; padding: 10px;color: #000;">
    <form>
        <table style="width: 90%;height: 450px;font-family: SolaimanLipi !important; padding: 10px;color: #000;">
            <tr>
                <td style="text-align: right;">প্যাকেজ নাম</td><td>: <input class="box" type="text" name="pin_number" id="account_number" ></td>
                <td style="text-align: right;">পিন নাম্বার</td><td>: <input class="box" type="text" name="pin_number" id="account_number" readonly=""></td>
            </tr>
                        <tr>
                            <td style="text-align: right;">নাম</td><td>: <input class="box" type="text" name="account_number" id="name" ></td>
                        
                            <td style="text-align: right;">পেশা</td><td>: <input class="box" type="text" name="occupation" id="account_balance" ></td>
                        </tr>
                        <tr>
                            <td style="text-align: right;">ঠিকানা</td><td>: <input class="box" type="text" name="address" id="address" ></td>
                        
                            <td style="text-align: right;">ধর্ম </td>
                            <td>:   <input  class="box" type="text" id="cust_religion" name="cust_religion" /></td>	                         
                        </tr>
                        <tr>
                            <td style="text-align: right;">জাতীয়তা</td>
                            <td>:   <input class="box" type="text" id="cust_nationality" name="cust_nationality" /> </td>			
                       
                            <td style="text-align: right;">মোবাইল নং</td>
                            <td>:   <input class="box" type="text" id="cust_mobile" name="cust_mobile"/></td>			
                        </tr>
                        <tr>
                            <td style="text-align: right;">ইমেল</td>
                            <td>:   <input class="box" type="text" id="cust_email" name="cust_email" /></td>			
                        
                            <td style="text-align: right;">জন্মতারিখ</td>
                            <td >:   <select  class="box1"  name="date" style =" font-size: 16px;font-family: SolaimanLipi !important; ">
                                    <option >দিন</option>
                                    <?php
                                    for ($i = 1; $i <= 31; $i++) {
                                        $date = english2bangla($i);
                                        echo "<option value=1>" . $date . "</option>";
                                    }
                                    ?>
                                </select>				
                                <select class="box1" name="month" style =" font-size: 16px;font-family: SolaimanLipi !important; ">
                                    <option >মাস</option>
                                    <option value="January">জানুয়ারি</option>
                                    <option value="February">ফেব্রুয়ারী</option>
                                    <option value="March">মার্চ</option>
                                    <option value="April">এপ্রিল </option>
                                    <option value="May">মে</option>
                                    <option value="June">জুন</option>
                                    <option value="July">জুলাই</option>
                                    <option value="August">আগষ্ট</option>
                                    <option value="September">সেপ্টেম্বর</option>
                                    <option value="October">অক্টোবর </option>
                                    <option value="November">নভেম্বর</option>
                                    <option value="December">ডিসেম্বর</option> 
                                </select>

                                <select class="box1" id="year" name="year" style =" font-size: 16px;font-family: SolaimanLipi !important; " >
                                    <option>বছর </option>
                                    <?php
                                    for ($i = 2050; $i >= 1930; $i--) {
                                        $year = english2bangla($i);
                                        echo "<option value=1>" . $year . "</option>";
                                    }
                                    ?>
                                </select>
                            </td>			
                        </tr>
                        <tr>
                            <td style="text-align: right;">ইউজার নাম</td><td>: <input class="box" type="text" name="user_name" id="user_name"></td>
                        
                            <td style="text-align: right;">পাসওয়ার্ড</td><td>: <input class="box" type="password" name="password" id="password" readonly=""></td>
                        </tr>
        </table>
    <input type="submit" value="ঠিক আছে" name="ok" style="font-family: SolaimanLipi !important;"/>
    </form>
    </div>
    </div>
</body>
</html>
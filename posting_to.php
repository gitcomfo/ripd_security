<?php
error_reporting(0);
include_once 'includes/MiscFunctions.php';
include 'includes/header.php';
?>
<style type="text/css">
    @import "css/bush.css";
</style>
<link rel="stylesheet" type="text/css" media="all" href="javascripts/jsDatePick_ltr.min.css" />
<script type="text/javascript" src="javascripts/jsDatePick.min.1.3.js"></script>
<script type="text/javascript">
    window.onclick = function()
    {
        new JsDatePick({
            useMode:2,
            target:"posting_date",
            dateFormat:"%Y-%m-%d"
        });
    };
</script>

<div class="column6">

    <div class="main_text_box">
        <?php
        $back_parent = $_GET['bkprnt'];
        $back_parent_change = str_replace("%%", "&", $back_parent);
        echo "<div style='padding-left: 110px;'><a href='$back_parent_change'><b>ফিরে যান</b></a></div>";
        ?>
        <div>
            <form onsubmit="" method="post">
            <?php
            $employee_id = $_GET['i001d1'];
            $employee_name = 'মোঃ মোখলেছুর রহমান'; //sql query
            echo "<table  class='formstyle'>";
                echo "<tr >
                                <th colspan='4' style='text-align: center'>
                                <div style='width: 80%; float: left; padding-top: 18px;'>
                                    <h1>$employee_name</h1>
                                    <h2>একাউন্ট নম্বরঃ acc-221144</h2>
                                    <h3>মোবাইলঃ ০১৭ ২৭ ২০৮ ৭১৪</h3>
                                    <h3>৪১/৩-বি, পুরানা পল্টন, ঢাকা - ১০০০।</h3>
                                </div>
                                <div style='float: right'><img src='images/iftee.jpg' alt='Iftee'></div></th>
                            </tr>";
                echo "<tr><td colspan='4'><hr></td></tr>";
                echo '<tr>
                     <fieldset style="border:3px solid #686c70;width: 99%;">
                            <legend style="color: brown;font-size: 14px;">সার্চ করুন</legend>
                            </filedset>
                    </tr>';
                echo "<tr id='table_row_odd'>
                                <td colspan='2' style='width: 50%'>সামগ্রিক কর্মজীবন</td>
                                <td colspan='2'>সর্বশেষ কর্মজীবন</td>
                            </tr>";
                echo "<tr>
                                <td>কর্মজীবন</td>
                                <td>: ৩ বছর ২ মাস</td>
                                <td>কর্মজীবন</td>
                                <td>: ১৭ মাস</td>
                            </tr>";
                echo "<tr>
                                <td>গ্যাপ টাইম</td>
                                <td>: ৯ মাস</td>
                                <td>গ্যাপ টাইম</td>
                                <td>: ১ মাস</td>
                            </tr>";
                echo "<tr>
                                <td>অতিরিক্ত সময়</td>
                                <td>: ২ মাস</td>
                                <td>অতিরিক্ত সময়</td>
                                <td>: ১৩ দিন</td>
                            </tr>";
                echo "<tr><td colspan='4'><hr></td></tr>";
                echo "<tr>
                                <td colspan='4' style='text-align:center;'><a href='#'><b>উপস্থিতির বিস্তারিত তথ্য</b></a></td>
                                 </tr>";
                echo "<tr><td colspan='4'><hr></td></tr>";
                echo "<tr>
                                <td>প্রোমশন দিন</td>
                                <td>: <select class='box' >
                                            <option value='grade-a'>- গ্রেড -</option>
                                            <option value='grade-a'>গ্রেড - এ</option>
                                            <option value='grade-b'>গ্রেড - বি</option>
                                            <option value='grade-c'>গ্রেড - সি</option>
                                        </select> 
                                </td>
                                <td>বেতন</td>
                                <td>: <input type='text' class='box' name='promotion' value=''> টাকা</td>
                            </tr>";
                echo "<tr>
                                <td>পোস্টিং করুন</td>
                                <td>: <select class='box' >
                                            <option value='grade-a'>- অফিসের নাম -</option>
                                            <option value='grade-a'>অফিস - এ</option>
                                            <option value='grade-b'>অফিস - বি</option>
                                            <option value='grade-c'>অফিস - সি</option>
                                        </select> 
                                </td>
                                </tr>";
                echo "<tr>
                                <td>পোস্টিং-এর তারিখ</td>
                                <td>: <input type='text' class='box' name='posting_date' id='posting_date' placeholder='তারিখ লিখুন' /> ইং</td>
                            </tr>";
                echo "<tr>
                                <td>পোস্টিং ধরণ</td>
                                <td>: <select class='box' >
                                            <option value='grade-b'>স্থায়ী দায়িত্ব</option>
                                            <option value='grade-c'>ভারপ্রাপ্ত</option>
                                        </select> 
                                </td>
                                 </tr>";
                    echo "<tr>                    
                                    <td colspan='4' style='text-align: center' ><input class='btn' style ='font-size: 12px;' type='submit' name='submit' value='সেভ করুন' />
                                        <input class='btn' style ='font-size: 12px' type='reset' name='reset' value='রিসেট করুন' /></td>                           
                            </tr>";
            echo "</table>";
            ?>
            </form>
        </div>
    </div>
    
<?php
include 'includes/footer.php';
?>

    echo "<tr id='table_row_odd'>
                                <td colspan='4' style='width: 50%'>বর্তমান অবস্থা</td>
                            </tr>";
                echo "<tr>
                                <td>গ্রেড</td>
                                <td>: </td>
                                <td>পোস্ট</td>
                                <td>: </td>
                            </tr>";
                echo "<tr>
                                <td>অফিস</td>
                                <td>: </td>
                                <td>কর্মচারীর ধরন</td>
                                <td>: </td>
                            </tr>";
                echo "<tr>
                                <td>যোগদানের তারিখ</td>
                                <td>: </td>
                                <td>বেতন</td>
                                <td>: </td>
                            </tr>";
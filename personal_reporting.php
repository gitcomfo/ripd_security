<?php
include_once 'includes/header.php';
include_once 'includes/columnViewAccount.php';

$logedInUserType = $_SESSION['userType'];
?>
<style type="text/css">@import "css/bush.css";</style>
<div class="columnSubmodule" style="font-size: 14px;">
    <table class="formstyle" style ="width: 100%; margin-left: 0px; font-family: SolaimanLipi !important;"> 
        <tr>
            <th colspan="2">সকল ধরনের রিপোর্ট</th>
        </tr>
        <tr>
            <td><a href="personal_purchase_statement.php">ব্যক্তিগত ক্রয় স্টেটমেন্ট</a></td>
            <td><a href="payment_statement_chart.php">পেমেন্ট স্টেটমেন্ট চার্ট</a></td>
        </tr>
        <tr>
            <td><a href="systemic_earn_system.php">সিস্টেমিক আর্ন স্টেটমেন্ট</a></td>
            <td><a href="in_amount_description.php">ইন ডেসক্রিপশন</a></td>
        </tr>
        <tr>
            <td><a href="personal_balanced_description.php">ব্যালেন্সড ডেসক্রিপশন</a></td>
        </tr>
        <?php 
        if($logedInUserType=='customer'){
        ?>
        <tr>
            <th colspan="2">সেলিং স্টেটমেন্ট</th>
        </tr>
        <tr>
            <td colspan="2"><a href="total_buying_description_with_referer_pv.php">টোটাল সেলিং ডেসক্রিপশন উইথ রেফারার পি.ভি</a></td>
        </tr>
        <?php        
        }
        ?>
    </table>
</div>
<?php
include_once 'includes/footer.php';
?>
<?php
include_once 'includes/header.php';
include_once 'includes/columnViewAccount.php';

$logedInUserType = $_SESSION['userType'];
?>
<style type="text/css">
    @import "css/bush.css";
</style>
<div class="columnSubmodule" style="font-size: 14px;">
    <table class="formstyle" style ="width: 100%; margin-left: 0px; font-family: SolaimanLipi !important;"> 
        <?php 
        if($logedInUserType=='employee'){
        ?>
        <tr>
            <th colspan="2">এটেন্ডেন্স স্টেটমেন্ট</th>
        </tr>
        <tr>
            <td><a href="">কারেন্ট (চলতি)</a></td>
            <td><a href="">প্রিভিয়াস (পুরাতন)</a></td>
        </tr>
        <?php 
        }else{            
        ?>
        <tr>
            <th colspan="2">প্রোগ্রাম, প্রেজেন্টেশন, ট্রেইনিং সিডিউল</th>
        </tr>
        <tr>
            <td><a href="">কারেন্ট এন্ড কামিং সিডিউল</a></td>
            <td><a href="">প্রিভিয়াস সিডিউল এন্ড এটেন্ডেন্স স্টেটমেন্ট</a></td>
        </tr>
        <?php 
        }
        ?>
        <tr>
            <th colspan="2">প্রোমোশন, পোস্টিং, সেলারী, পেনশন</th>
        </tr>
        <tr>
            <td><a href="">প্রোমোশন ডেসক্রিপশন</a></td>
            <td><a href="payment_statement_chart.php">পোস্টিং ডেসক্রিপশন</a></td>
        </tr>
        <tr>
            <td><a href="">সেলারী ডেসক্রিপশন</a></td>
            <td><a href="">পেনশন</a></td>
        </tr>
        <tr>
            <th colspan="2">লোন স্টেটমেন্ট</th>
        </tr>
        <tr>
            <td><a href="">কারেন্ট (চলতি) লোন</a></td>
            <td><a href="">প্রিভিয়াস (পুরাতন) লোন</a></td>
        </tr>
    </table>
</div>
<?php
include_once 'includes/footer.php';
?>
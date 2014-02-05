<?php
include_once 'ConnectDB.inc';
$g_id = $_GET['inventID'];
$sel_product = mysql_query("SELECT * FROM inventory,product_chart,product_catagory WHERE idinventory= $g_id
                                               AND ins_product_type='general' AND ins_productid= idproductchart 
                                               AND product_catagory_idproduct_catagory = idproduct_catagory ");
$row_product = mysql_fetch_assoc($sel_product);
$db_proname = $row_product['ins_productname'];
$db_procode = $row_product['ins_product_code'];
$db_procat = $row_product['pro_catagory'];
$db_protype = $row_product['pro_type'];
$db_probrand = $row_product['pro_brand_or_grp'];
$db_proclass = $row_product['pro_classification'];
?>
<style type="text/css">@import "css/bush.css";</style>
<div class="main_text_box">
    <div>           	
        <table class="formstyle"  style="font-family: SolaimanLipi !important;width: 80%;">      
            <tr><th style="text-align: center" colspan="8"><h1>প্রিভিয়াস প্রডাক্ট ডিটেইলস</h1></th></tr>
            <tr>
                <td colspan="2" style="width: 25%; text-align: right">প্রডাক্টের নাম</td>
                <td colspan="2"style="width: 25%; text-align: left">: <?php echo $db_proname?></td>
                <td colspan="2" style="width: 25%; text-align: right">কোড</td>
                <td colspan="2" style="width: 25%; text-align: left">: <?php echo $db_procode?></td>
            </tr>
            <tr>
                 <td colspan="2" style="width: 25%; text-align: right">ক্যাটাগরি</td>
                <td colspan="2" style="width: 25%; text-align: left">: <?php echo $db_procat?></td>
                <td colspan="2" style="width: 25%; text-align: right">টাইপ</td>
                <td colspan="2" style="width: 25%; text-align: left">: <?php echo $db_protype?></td>
            </tr>
            <tr>
                <td colspan="2" style="width: 25%; text-align: right">ব্যান্ড / গ্রুপ</td>
                <td colspan="2" style="width: 25%; text-align: left">: <?php echo $db_probrand?></td>
                <td colspan="2" style="width: 25%; text-align: right">প্রকার</td>
                <td colspan="2" style="width: 25%; text-align: left">: <?php echo $db_proclass?></td>
            </tr>
             <tr>
                 <td colspan="2" style="width: 25%; text-align: right">বিক্রি শুরুর তারিখ</td>
                <td colspan="2" style="width: 25%; text-align: left">: </td>
                <td colspan="2" style="width: 25%; text-align: right">সর্বশেষ বিক্রির তারিখ</td>
                <td colspan="2" style="width: 25%; text-align: left">: </td>
            </tr>
            <tr>
                <td colspan="4" style="width: 50%; text-align: right">মোট বিক্রির পরিমাণ</td>
                <td colspan="4" style="width: 50%; text-align: left">: </td>
            </tr>
            <tr>
                <td colspan="4" style="width: 50%; text-align: right">মোট এক্সট্রা প্রফিট</td>
                <td colspan="4" style="width: 50%; text-align: left">: </td>
            </tr>
             <tr>
                <td colspan="4" style="width: 50%; text-align: right">মোট সেলিং আর্ন</td>
                <td colspan="4" style="width: 50%; text-align: left">: </td>
            </tr>
            <tr>
                <td colspan="4" style="width: 50%; text-align: right">মোট রিপড ইনকাম</td>
                <td colspan="4" style="width: 50%; text-align: left">: </td>
            </tr>
            <tr>
                <td colspan="4" style="width: 50%; text-align: right">মোট প্রফিট</td>
                <td colspan="4" style="width: 50%; text-align: left">: </td>
            </tr>
             <tr>
                 <td colspan="4" style="width: 50%; text-align: right">সর্বমোট প্রফিট</td>
                <td colspan="4" style="width: 50%; text-align: left">: </td>
            </tr>
        </table>
    </div>
</div>   
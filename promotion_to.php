<?php
error_reporting(0);
include_once 'includes/MiscFunctions.php';
include 'includes/header.php';

function get_catagory() {
    echo "<option value=0> -সিলেক্ট করুন- </option>";
    $catagoryRslt = mysql_query("SELECT DISTINCT pro_catagory, pro_cat_code FROM product_catagory ORDER BY pro_catagory;");
    while ($catrow = mysql_fetch_assoc($catagoryRslt)) {
        echo "<option value=" . $catrow['pro_cat_code'] . ">" . $catrow['pro_catagory'] . "</option>";
    }
}

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
<link rel="stylesheet" href="css/tinybox.css" type="text/css">
<script src="javascripts/tinybox.js" type="text/javascript"></script>
<script type="text/javascript">
    function selectOffice()
    { TINY.box.show({iframe:'includes/select_office.php',width:900,height:400,opacity:30,topsplit:3,animate:true,close:true,maskid:'bluemask',maskopacity:50,boxid:'success'}); }
    
    function promotionSalaryUpdate()
    {
        TINY.box.show({iframe:'includes/promotion_salary_update.php',width:650,height:400,opacity:30,topsplit:3,animate:true,close:true,maskid:'bluemask',maskopacity:50,boxid:'success'}); 
    }
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
                     <td colspan="4">
                     <fieldset style="border:3px solid #686c70;width: 99%;">
                            <legend style="color: brown;font-size: 14px;">বর্তমান অবস্থা</legend>
                            <table>
                            <tr>
                                <td style="width: 25%; text-align:right">গ্রেড</td>
                                <td style="width: 25%; text-align:left">: </td>
                                <td style="width: 25%; text-align:right">পোস্ট</td>
                                <td style="width: 25%; text-align:left">: </td>
                            </tr>
                            <tr>
                               <td style="width: 25%; text-align:right">অফিস</td>
                                <td style="width: 25%; text-align:left">: </td>
                                <td style="width: 25%; text-align:right">কর্মচারীর ধরন</td>
                                <td style="width: 25%; text-align:left">: </td>
                            </tr>
                            <tr>
                               <td style="width: 25%; text-align:right">যোগদানের তারিখ</td>
                                <td style="width: 25%; text-align:left">: </td>
                                <td style="width: 25%; text-align:right">বেতন</td>
                                <td style="width: 25%; text-align:left">: </td>
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
                            <legend style="color: brown;font-size: 14px;">প্রমোশন এন্ড সেলারি আপডেট</legend>
                            <table>
                            <tr>
                            <td colspan="2" style="width: 50%; text-align:right">কর্মচারীর ধরণ</td>
                            <td colspan="2" style="width: 50%; text-align:left"> : </td>
                            </tr>
                            <tr>
                                <td style="width: 20%; text-align:right">রানিং গ্রেড</td>
                                <td style="width: 30%; text-align:left">: </td>
                                <td style="width: 20%; text-align:right">নেক্সট গ্রেড</td>
                                <td style="width: 30%; text-align:left">: <input type="text" class="box" name="promotion"/></td>
                            </tr>
                            <tr>
                                <td style="width: 20%; text-align:right">রানিং সেলারি</td>
                                <td style="width: 30%; text-align:left">: </td>
                                <td style="width: 20%; text-align:right">নেক্সট সেলারি</td>
                                <td style="width: 30%; text-align:left">: <input type="text" class="box" name="promotion"/></td>
                            </tr>
                             <tr>
                                <td style="width: 20%; text-align:right">রানিং দায়িত্ব / পোস্ট</td>
                                <td style="width: 30%; text-align:left">: </td>
                                <td style="width: 20%; text-align:right">নেক্সট পোস্ট</td>
                                <td style="width: 30%; text-align:left">: <select class="box" id="catagorySearch" name="catagorySearch" onchange="showTypes(this.value);showCatProducts(this.value);" style="width: 180px;font-family: SolaimanLipi !important;">
                                            <?php echo get_catagory(); ?>
                                        </select></td>
                            </tr>
                           
                           
                            </table>
                            </filedset></td>
                    </tr>';
                echo "<tr>                    
                                    <td colspan='4' style='text-align: center' ><input class='btn' style ='font-size: 12px' type='reset' name='reset' value='প্রমোশন' /></td>                           
                            </tr>";
                echo "</table>";
                ?>
            </form>
        </div>
    </div>

    <?php
    include 'includes/footer.php';
    ?>
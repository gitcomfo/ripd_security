<?php
include_once 'includes/session.inc';
include_once 'includes/header.php';
$sql_select_category = $conn->prepare("SELECT DISTINCT pro_catagory FROM product_catagory ORDER BY pro_catagory");
$sql_select_type = $conn->prepare("SELECT DISTINCT pro_type FROM product_catagory ORDER BY pro_type")
?>
<style type="text/css">
    @import "css/bush.css";
    .formstyle td{
        padding: 5px;
    }
    .formstyle table td { border: 1px solid black; text-align: center;}
</style>

<div class="column6">
    <div class="main_text_box">
        <div style="padding-left: 110px;"><a href="product_info_management.php"><b>ফিরে যান</b></a></div>
        <div class="domtab">
            <ul class="domtabs">
                <li class="current"><a href="#01">ব্র্যান্ড / গ্রুপ লিস্ট</a></li>
                <li class="current"><a href="#02">প্রকার লিস্ট</a></li>
                <li class="current"><a href="#03">পণ্য তথ্য</a></li>
            </ul>
        </div>   
        <div>
            <h2><a name="01" id="01"></a></h2><br/>
            <from method="post" action="" >
            <table  class="formstyle">          
                <tr><th colspan="7" style="text-align: center;">ব্র্যান্ড / গ্রুপ লিস্ট</th></tr>
                <tr>
                    <td colspan="2">
                        <table style="border: 1px solid #808080">
                            <tr id="table_row_odd">
                                <td><b>ক্যাটাগরি</b></td>
                                <td><b>নাম আপডেট</b></td>
                                <td><b>কোড আপডেট</b></td>
                            </tr>
                            <?php
                                    $sql_select_category->execute();
                                    $arr_category = $sql_select_category->fetchAll();
                                    foreach ($arr_category as $catrow) {
                                        echo "<tr>
                                                    <td>".$catrow['pro_catagory']."</td>
                                                    <td><a onclick='updateCatName(".$catrow['pro_catagory'].");' style='cursor:pointer;color:green'><u>নাম আপডেট</u></a></td>
                                                    <td><a onclick='updateCatCode(".$catrow['pro_catagory'].");' style='cursor:pointer;color:#D03D29'><u>কোড আপডেট</u></a></td>
                                            </tr>";
                                    }
                            ?>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td colspan="3" style="text-align: center"><input type="submit" class="btn" name="catsubmit" value="সেভ">&nbsp;<input type="reset" class="btn" name="reset" value="রিসেট"></td>
                </tr>
            </table>
          </from>
        </div>
        
        <div>
            <h2><a name="02" id="02"></a></h2><br/>
            <from method="post" action="" >
            <table  class="formstyle">          
                <tr><th colspan="7" style="text-align: center;">প্রকার লিস্ট</th></tr>
                <tr>
                    <td colspan="2">
                        <table style="border: 1px solid #808080">
                            <tr id="table_row_odd">
                                <td><b>টাইপ</b></td>
                                <td><b>নাম আপডেট</b></td>
                                <td><b>কোড আপডেট</b></td>
                            </tr>
                            <?php
                                    $sql_select_type->execute();
                                    $arr_type = $sql_select_type->fetchAll();
                                    foreach ($arr_type as $typerow) {
                                        echo "<tr>
                                                    <td>".$typerow['pro_type']."</td>
                                                    <td><a onclick='updateTypeName(".$typerow['pro_type'].");' style='cursor:pointer;color:green'><u>নাম আপডেট</u></a></td>
                                                    <td><a onclick='updateTypeCode(".$typerow['pro_type'].");' style='cursor:pointer;color:#D03D29'><u>কোড আপডেট</u></a></td>
                                            </tr>";
                                    }
                            ?>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td colspan="3" style="text-align: center"><input type="submit" class="btn" name="typesubmit" value="সেভ">&nbsp;<input type="reset" class="btn" name="reset" value="রিসেট"></td>
                </tr>
            </table>
          </from>
        </div>
        
                <div>
            <h2><a name="03" id="03"></a></h2><br/>
            <from method="post" action="" >
            <table  class="formstyle">          
                <tr><th colspan="7" style="text-align: center;">পণ্য তথ্য</th></tr>
                <tr>
                    <td colspan="2">
                        <table style="border: 1px solid #808080">
                            <tr id="table_row_odd">
                                <td><b>টাইপ</b></td>
                                <td><b>নাম আপডেট</b></td>
                                <td><b>কোড আপডেট</b></td>
                            </tr>
                            <?php
                                    $sql_select_type->execute();
                                    $arr_type = $sql_select_type->fetchAll();
                                    foreach ($arr_type as $typerow) {
                                        echo "<tr>
                                                    <td>".$typerow['pro_type']."</td>
                                                    <td><a onclick='updateTypeName(".$typerow['pro_type'].");' style='cursor:pointer;color:green'><u>নাম আপডেট</u></a></td>
                                                    <td><a onclick='updateTypeCode(".$typerow['pro_type'].");' style='cursor:pointer;color:#D03D29'><u>কোড আপডেট</u></a></td>
                                            </tr>";
                                    }
                            ?>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td colspan="3" style="text-align: center"><input type="submit" class="btn" name="typesubmit" value="সেভ">&nbsp;<input type="reset" class="btn" name="reset" value="রিসেট"></td>
                </tr>
            </table>
          </from>
        </div>
        
    </div>
</div>
<?php include_once 'includes/footer.php';?>
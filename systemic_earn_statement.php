<?php

error_reporting(0);
include_once 'includes/MiscFunctions.php';
include_once 'includes/selectQueryPDO.php';
include 'includes/header.php';
$user_own_id = $_SESSION['userIDUser'];
?>
<title>সিস্টেমিক আর্ন স্টেটমেন</title>
<style type="text/css"> @import "css/bush.css";</style>
<link rel="stylesheet" href="css/style.css" type="text/css" media="screen" charset="utf-8"/>
<link rel="stylesheet" href="css/tinybox.css" type="text/css" media="screen" charset="utf-8"/>
<script src="javascripts/tinybox.js" type="text/javascript"></script>
<script type="text/javascript">
</script>

<div class="column6">
    <div class="main_text_box">
        <table  class="formstyle" style="font-family: SolaimanLipi !important;">          
            <tr><th style="text-align: center;">সিস্টেমিক আর্ন স্টেটমেন</th></tr>
            <tr>
                <td>
                    <table border="1" align="center" width= 99%" cellpadding="5px" cellspacing="0px">
                        <thead style="background-color: #ffcccc">
                            <tr align="left" id="table_row_odd">
                                <th style="border: black 1px solid;">ক্রম</th>
                                <th style="border: black 1px solid;">তারিখ</th>
                                <th style="border: black 1px solid;" >এমাউন্ট</th>
                                <th style="border: black 1px solid;">মাধ্যম</th>
                                <th style="border: black 1px solid;">ট্যাক্স / চার্জ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="border: black 1px solid;">1</td>
                                <td style="border: black 1px solid;">1</td>
                                <td style="border: black 1px solid;">1</td>
                                <td style="border: black 1px solid;">1</td>
                                <td style="border: black 1px solid;">1</td>
                            </tr> 
                        <td colspan="2" style='border: black 1px solid; text-align: right;'>সর্বমোট :</td>
                        <td colspan="3"style='border: black 1px solid; text-align: left'></td>
                        </tbody>
                    </table>
                </td>
            </tr>   
        </table>
    </div>           
</div>
<?php

include 'includes/footer.php';
?>
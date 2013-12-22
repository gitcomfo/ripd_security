<?php

include_once 'includes/header.php';
include_once 'includes/showTables.php';
?>
<style type="text/css">@import "css/bush.css";</style>
<script type="text/javascript" src="javascripts/external/mootools.js"></script>
<script type="text/javascript" src="javascripts/dg-filter.js"></script>


<div class="main_text_box" >
    <div style="padding-left: 80px;"><a href="personal_reporting.php"><b>ফিরে যান</b></a></div>
    <div>           
        <form method="POST" onsubmit="" >	
            <table class="formstyle"  style="font-family: SolaimanLipi !important;width: 90%; margin-left: 80px">          
                <tr><th style="text-align: center" colspan="2"><h1>টোটাল বায়িং ডেসক্রিপশন উইথ রেফারার পিভি</h1></th></tr>
                <?php
                if ($msg != "") {
                    echo '<tr><td colspan="2" style="text-align: center;font-size: 16px;color: green;">' . $msg . '</td></tr>';
                }
                ?>
                
                <tr>
                    <td>
                        <fieldset   style="border: 3px solid #686c70 ; width: 99%;font-family: SolaimanLipi !important;">
                            <legend style="color: brown;font-size: 14px;">টোটাল বায়িং ডেসক্রিপশন উইথ রেফারার পিভি</legend>
                            <div id="resultTable">
                                
                                <table style="width: 98%;margin: 0 auto;" cellspacing="0" cellpadding="0">         
                                    <thead>
                    <tr align="left" id="table_row_odd">
                        <th style="border: solid black 1px;">তারিখ</th>
                        <th colspan="2" style="border: solid black 1px;">ব্যাক্তিগত ক্রয়</th>
                        <th colspan="2" style="border: solid black 1px;">R1</th>
                        <th colspan="2" style="border: solid black 1px;">R2</th>
                        <th colspan="2" style="border: solid black 1px;">R3</th>
                        <th colspan="2" style="border: solid black 1px;">R4</th>
                        <th colspan="2" style="border: solid black 1px;">R5</th>
                        <th colspan="2" style="border: solid black 1px;">মোট</th>
                    </tr>
                </thead>
                <tr>
                    <td style="border: solid black 1px;"></td>
                    <td style="border: solid black 1px;">PV</td>
                    <td style="border: solid black 1px;">TK</td>
                    <td style="border: solid black 1px;">PV</td>
                    <td style="border: solid black 1px;">TK</td>
                    <td style="border: solid black 1px;">PV</td>
                    <td style="border: solid black 1px;">TK</td>
                    <td style="border: solid black 1px;">PV</td>
                    <td style="border: solid black 1px;">TK</td>
                    <td style="border: solid black 1px;">PV</td>
                    <td style="border: solid black 1px;">TK</td>
                    <td style="border: solid black 1px;">PV</td>
                    <td style="border: solid black 1px;">TK</td>
                    <td style="border: solid black 1px;">PV</td>
                    <td style="border: solid black 1px;">TK</td>
                </tr>
                <tr>
                    <td colspan="13" style="text-align: right">সর্বমোট</td>
                    <td></td>
                    <td></td>
                </tr>
                                </table>
                            </div>
                        </fieldset>
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>   

<?php include_once 'includes/footer.php'; ?>





<?php
//include_once 'includes/session.inc';
include_once 'includes/header.php';
include_once 'includes/MiscFunctions.php';

?>
<title>কারেন্ট লোন</title>
<style type="text/css"> @import "css/bush.css";</style>
<link rel="stylesheet" href="css/tinybox.css" type="text/css" media="screen" charset="utf-8"/>
<script src="javascripts/tinybox.js" type="text/javascript"></script>

<div class="main_text_box">
    <div style="padding-left: 110px;"><a href="personal_official_profile_employee.php"><b>ফিরে যান</b></a></div>
    <div>
        <table  class="formstyle" style="font-family: SolaimanLipi !important;width: 80%;">          
            <tr><th colspan="2" style="text-align: center;">কারেন্ট লোন</th></tr>
            <tr >
                <td style="text-align: right; width: 50%"><b>টোটাল লোন এমাউন্টঃ</b></td>
                <td></td>
            </tr>
            <tr >
                <td style="text-align: right; width: 50%"><b>লোন গ্রহনের তারিখঃ </b></td>
                <td></td>
            </tr>
            <tr >
                <td style="text-align: right; width: 50%"><b>টোটাল কিস্তির পরিমাণঃ </b></td>
                <td></td>
            </tr>
            <tr >
                <td style="text-align: right; width: 50%"><b>প্রতি কিস্তিতে এমাউন্টঃ </b></td>
                <td></td>
            </tr>
            <tr>
                <td colspan="2" ><hr /></td>
            </tr>

            <tr>
                <td style="width: 50%; border-right: 2px solid black;">
                    <table>
                        <tr>
                            <td style="text-align: right; width: 50%">টোটাল প্রদেয় কিস্তিঃ </td>
                            <td style="text-align: left"></td>
                        </tr>
                        <tr>
                            <td style="text-align: right; width: 50%">টোটাল প্রদেয় এমউন্টঃ </td>
                            <td style="text-align: left"></td>
                        </tr>
                    </table>
                </td>

                <td><table>
                        <tr>
                            <td style=" width: 50%">বাকি কিস্তিঃ </td>
                            <td style=""></td>
                        </tr>
                        <tr>
                            <td style=" width: 50%">বাকি এমউন্টঃ </td>
                            <td style=""></td>
                        </tr>
                    </table></td>
            </tr>

            <tr>
                <td colspan="2" ><hr /></td>
            </tr>

            <tr>
                <td colspan="2">
                        <table border="1" align="center" width= 99%" cellpadding="5px" cellspacing="0px">    
                            <tr  id="table_row_odd">
                                <td style="border: black 1px solid; text-align: center">তারিখ</td>
                                <td style="border: black 1px solid; text-align: center" >এমাউন্ট</td>
                                <td style="border: black 1px solid; text-align: center">চার্জ</td>
                            </tr>
                        
                            <tr>
                                <td style="border: black 1px solid; text-align: center">1</td>
                                <td style="border: black 1px solid; text-align: center">1</td>
                                <td style="border: black 1px solid; text-align: center">1</td>
                            </tr> 
                        </table>
                </td>
            </tr>

        </table>

    </div>           
</div>
<?php

include_once 'includes/footer.php';
?>

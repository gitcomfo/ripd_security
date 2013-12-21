<?php
error_reporting(0);
include_once 'includes/header.php';
?>
<title>ব্যাল্যান্সড ডেসক্রিপশন</title>
<link rel="stylesheet" type="text/css" media="all" href="css/bush.css" />
<link rel="stylesheet" type="text/css" media="all" href="javascripts/jsDatePick_ltr.min.css" />
<div class="main_text_box">
    <div style="padding-left: 10px;"><a href="personal_reporting.php"><b>ফিরে যান</b></a></div>
    <div class="domtab " >
        <ul class="domtabs" style="padding-left: 200px">
            <li class="current"><a href="#01">ইন এমাউন্ট</a></li><li class="current"><a href="#02">আউট এমাউন্ট</a></li>
        </ul>
    </div>
   
    <div>

        <div>
            <a name="01" id="01"></a>
            <table class="formstyle" style ="width: 100%; margin-left: 0px; font-family: SolaimanLipi !important;">    
                <tr><td></br></td></tr>
                <tr>
                    <th >সিস্টেমিক আর্ন স্টেটমেন্ট</th>
                </tr>
                <tr>
                    <td >
                        <table border='1' cellpadding='0' cellspacing='0'>
                            <tr id='table_row_odd'>
                                <td style='border:1px black solid;'>তারিখ</td>
                                <td style='border:1px black solid;'>বেতনিক মাসের নাম</td>
                                <td style='border:1px black solid;'>এমাউন্ট</td>
                                <td style='border:1px black solid;'>ট্রান্সফারারের একাউন্ট নাম্বার</td>
                                <td style='border:1px black solid;'>পরিমাণ</td>
                                <td style='border:1px black solid;'>পার্সনাল ইন নাম্বার</td>
                                <td style='border:1px black solid;'>পরিমাণ</td>
                                <td style='border:1px black solid;'>পারচেইজিং আর্ন</td>
                                <td style='border:1px black solid;'>বেতন এমাউন্ট</td>
                                <td style='border:1px black solid;'>পরিমাণ</td>
                            </tr>
                            <tr>
                                <td style='border:1px black solid;'>11111</td>
                                <td style='border:1px black solid;'>11111111</td>
                                <td style='border:1px black solid;'>11111111</td>
                                <td style='border:1px black solid;'>22222222</td>
                                <td style='border:1px black solid;'>3333333</td>
                                <td style='border:1px black solid;'>44444444</td>
                                <td style='border:1px black solid;'>555555</td>
                                <td style='border:1px black solid;'>2222222</td>
                                <td style='border:1px black solid;'>4444444</td>
                                <td style='border:1px black solid;'>4444444</td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </div>

        <div>
            <a name="02" id="02"></a><br/>
            <table class="formstyle" style ="width: 100%; margin-left: 0px; font-family: SolaimanLipi !important;"> 
                <tr><td></br></td></tr>
                <tr>
                    <th >সিস্টেমিক আর্ন স্টেটমেন্ট</th>
                </tr>
                <tr>
                    <td >
                        <table border='1' cellpadding='0' cellspacing='0'>
                            <tr id='table_row_odd'>
                                <td style='border:1px black solid;'>তারিখ</td>
                                <td style='border:1px black solid;'>চেক নাম্বার</td>
                                <td style='border:1px black solid;'>এমাউন্ট</td>
                                <td style='border:1px black solid;'>ট্রান্সফারকৃতএকাউন্ট নাম্বার</td>
                                <td style='border:1px black solid;'>এমাউন্ট</td>
                                <td style='border:1px black solid;'>সেন্ডের পিন নাম্বার</td>
                                <td style='border:1px black solid;'>এমাউন্ট</td>
                                <td style='border:1px black solid;'>মোট এমাউন্ট</td>
                            </tr>
                            <tr>
                                <td style='border:1px black solid;'>11111</td>
                                <td style='border:1px black solid;'>11111111</td>
                                <td style='border:1px black solid;'>11111111</td>
                                <td style='border:1px black solid;'>22222222</td>
                                <td style='border:1px black solid;'>3333333</td>
                                <td style='border:1px black solid;'>44444444</td>
                                <td style='border:1px black solid;'>555555</td>
                                <td style='border:1px black solid;'>2222222</td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </div>

    </div>
</div>         
<?php include_once 'includes/footer.php'; ?>
<?php
error_reporting(0);
session_start();
include_once 'includes/connectionPDO.php';
include_once 'includes/MiscFunctions.php';
$storeName = $_SESSION['loggedInOfficeName'];
$cfsID = $_SESSION['userIDUser'];
$storeID = $_SESSION['loggedInOfficeID'];
$scatagory = $_SESSION['loggedInOfficeType'];

$sql_select_shift_date_range = $conn->prepare("SELECT * FROM ons_counter AS cc RIGHT JOIN 
                                                                (SELECT  fk_counterid, starting_cash,ending_cash, shift_start, shift_end,account_name
                                                                    FROM ons_shifting INNER JOIN cfs_user ON cfs_userid = idUser
                                                                    WHERE shifting_date = ?) AS cs
                                                            ON  cs.fk_counterid = cc.idonscounter WHERE cc.counter_onsid =? AND cc.counter_onstype= ?");

if(isset($_POST['show']))
{
    $p_shiftdate = $_POST['shiftdate'];
}
else
{
    $p_shiftdate = date('Y-m-d');
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html;" charset="utf-8" />
        <link rel="icon" type="image/png" href="images/favicon.png" />
        <title>শিফটিং রিপোর্ট</title>
        <link rel="stylesheet" href="css/style.css" type="text/css" media="screen" charset="utf-8"/>
        <link rel="stylesheet" href="css/css.css" type="text/css" media="screen" />
    </head>

    <body>
        <div id="maindiv">
            <form method="post">
            <div id="header" style="width:100%;height:100px;background-image: url(../images/sara_bangla_banner_1.png);background-repeat: no-repeat;background-size:100% 100%;margin:0 auto;"></div></br>
            <div style="width: 90%;height: 70px;margin: 0 5% 0 5%;float: none;">
                <div style="width: 40%;height: 100%; float: left;"><a href="../pos_management.php"><img src="images/back.png" style="width: 70px;height: 70px;"/></a></div>
                <div style="width: 60%;height: 100%;float: left;font-family: SolaimanLipi !important;text-align: left;font-size: 36px;"><?php echo $storeName; ?></div></br>
            </div>

            <div class="wraper" style="width: 80%;font-family: SolaimanLipi !important;">
                <fieldset style="border-width: 3px;width: 100%;">
                    <legend style="color: brown;">শিফট ফিল্টার</legend>                    
                        <div class="top" style="width: 100%;height: auto;">
                            <div style="float: left;width: 25%;"><b>তারিখ</b></br>
                                <input type="date" name="shiftdate"></input>
                            </div>
                            <div style="float: left;width: 25%;"></br>
                                <input style="width: 100px; height: 30px" type="submit" value="দেখুন" name="show"></input>
                            </div>
                        </div>                  
                </fieldset></div>

            <fieldset   style="border-width: 3px;margin:0 20px 50px 20px;font-family: SolaimanLipi !important;">
                <legend style="color: brown;">কাউন্টারের শিফট স্টেটমেন্ট</legend>
                <div id="resultTable">
                    <table width="100%" border="1" cellspacing="0" cellpadding="0" style="border-color:#000000; border-width:thin; font-size:18px;">
                        <tr>
                            <td colspan="6" align="center">তারিখ</td>
                        </tr>
                        <tr>
                            <td width="10%" style="color: blue; font-size: 25px"><div align="center"><strong>কাউন্টার</strong></div></td>
                            <td width="20%" style="color: blue; font-size: 25px"><div align="center"><strong>বিক্রয়কারী</strong></div></td>
                            <td width="10%" style="color: blue; font-size: 25px"><div align="center"><strong>শিফট শুরু</strong></div></td>
                            <td width="10%" style="color: blue; font-size: 25px"><div align="center"><strong>শিফট শেষ</strong></div></td>
                            <td width="10%" style="color: blue; font-size: 25px"><div align="center"><strong>টাকা (শুরু)</strong></div></td>
                            <td width="10%" style="color: blue; font-size: 25px"><div align="center"><strong>টাকা (শেষ)</strong></div></td>
                        </tr>
                        <?php

                            $sql_select_shift_date_range->execute(array($p_shiftdate,$storeID, $scatagory));
                            $arr_shift = $sql_select_shift_date_range->fetchAll();
                            foreach ($arr_shift as $row) {
                                echo '<tr>';
                                echo '<td><div align="center">' . $row["counter_name"] . '</div></td>';
                                echo '<td><div align="center">' . $row["account_name"] . '</div></td>';
                                echo '<td><div align="center">' . $row["shift_start"] . '</div></td>';
                                echo '<td><div align="center">' .$row["shift_end"] . '</div></td>';
                                echo '<td><div align="center">' . $row["starting_cash"] . '</div></td>';
                                echo '<td><div align="center">' . $row["ending_cash"] . '</div></td>';
                            }
                        ?>
                    </table>
                </div>
            </fieldset>

            <div style="background-color:#f2efef;border-top:1px #eeabbd dashed;padding:3px 50px;">
                <a href="http://www.comfosys.com" target="_blank"><img src="images/footer_logo.png"/></a> 
                RIPD Universal &copy; All Rights Reserved 2013 - Designed and Developed By <a href="http://www.comfosys.com" target="_blank" style="color:#772c17;">comfosys Limited<img src="images/comfosys_logo.png" style="width: 50px;height: 40px;"/></a>
            </div>
        </form>
        </div>
    </body>
</html>
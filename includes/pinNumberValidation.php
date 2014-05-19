<?php
include_once './ConnectDB.inc';
$logedInUserID = $_SESSION['userIDUser'];

if(isset($_GET['pin']))
{
    $g_pin = $_GET['pin'];
    $sel_pinmakingused= mysql_query("SELECT * FROM pin_makingused WHERE pin_no='$g_pin' AND pin_state ='open' ");
    if(mysql_num_rows($sel_pinmakingused) == 1)
    {
        $pinmsg = "";
    }
    else
    {$pinmsg = "দুঃখিত আপনার পিন নম্বরটি সঠিক নয় অথবা ব্যবহৃত হয়েছে";}
    echo $pinmsg;
}

elseif(isset($_GET['pinno']))
{
    $g_pin = $_GET['pinno'];
    $sel_pinmakingused= mysql_query("SELECT * FROM pin_makingused LEFT JOIN sales_summary ON fk_idsalessummary = idsalessummary
                                                                WHERE pin_no='$g_pin' AND pin_state ='open' AND  sal_buyerid= '$logedInUserID'");
    $pin_row = mysql_fetch_assoc($sel_pinmakingused);
    if(mysql_num_rows($sel_pinmakingused) == 1)
    {
        $db_pinprofit = $pin_row['pin_total_profit'];
        $db_commandid = $pin_row['command_id'];
        $db_pinmakingdate = $pin_row['pin_making_date'];
        $db_salesummaryID = $pin_row['fk_idsalessummary'];
        
        $sel_command = mysql_query("SELECT  pv_value FROM command WHERE idcommand = $db_commandid");
        $command_row = mysql_fetch_assoc($sel_command);
        $command_pv_rate = $command_row['pv_value'];
        
        echo "<td colspan='2' style='text-align:center;'>
                    <table style='width:100%;'>
                        <tr>
                            <td  style='text-align: right;width: 50%;'>পিন পিভি ভ্যালু : <input type='hidden' name='commandID' value='$db_commandid' /></td>
                            <td style='text-align: left;width: 50%;'><input class='box' name='pinvalue' value='".english2bangla($db_pinprofit * $command_pv_rate)."' /></td>
                        </tr>
                        <tr>
                            <td style='text-align: right;'>পিন তৈরির তারিখ : <input type='hidden' name='pinprofit' value='$db_pinprofit' />
                                                                        <input type='hidden' name='salessummaryID' value='$db_salesummaryID' /></td>
                            <td><input class='box' name='pindate' id='pindate' value='".english2bangla(date('d/m/Y',  strtotime($db_pinmakingdate)))."' /></td>
                        </tr>
                    </table>
            </td>";
    }
    else
    {
        echo "<td colspan='2' style='text-align:center;color:red;'>দুঃখিত আপনার পিন নম্বরটি সঠিক নয় অথবা ব্যবহৃত হয়েছে</td>";
    }
}
?>

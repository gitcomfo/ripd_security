<?php
include_once './ConnectDB.inc';
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
?>

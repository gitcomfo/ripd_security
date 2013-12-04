<?php
$tkPerTicket = $_GET['TP'];
$mpPerTicket = $_GET['MP'];
$totalseat = $_GET['seat'];
if($totalseat == 0)
{
    echo ' <table style="color: darkblue;"> ';
    echo ' <tr><td colspan="2" style="padding-left: 10px;"></br>
              <span style="color: red; font-size: 15px; text-decoration: blink; padding-left: 220px !important;">কমপক্ষে একটি সিট সিলেক্ট করুন</span></td></tr>';
    echo '</table>';
}
else
{
$total_takawith = ($tkPerTicket+$mpPerTicket)*$totalseat;
$total_takawithout = ($tkPerTicket)*$totalseat;
    echo ' <table style="color: darkblue;"> ';
    echo " <tr>
    <td style='width:30%;padding-left: 0px !important;'>মোট টিকেট</td>
    <td style='width:20%;'>: <span style='color: black;'>$totalseat টি</span></td><td style='width:30%;'></td><td style='width:20%;'></td>
    </tr>
    <tr>
    <td style='padding-left: 0px !important;'>মোট টিকেট প্রাইজ(মেকিং চার্জ সহ)</td>
    <td style='color: black;'>: $total_takawith TK</td>
     <td style='padding-left: 0px !important;'>মোট টিকেট প্রাইজ(মেকিং চার্জ ছাড়া)</td>
    <td style='color: black;'>: $total_takawithout TK</td>
    </tr>
    <tr>
    <td colspan='2' style='text-align:center;'><input class = 'btn' style =' font-size: 12px; ' type = 'button' value='প্রিন্ট করা হবে' onclick=showPaymentBox($total_takawith) /></td>
    <td colspan='2' style='text-align:center;'><input class = 'btn' style =' font-size: 12px; ' type = 'button' value='প্রিন্ট করা হবে না' onclick=showPaymentBox2($total_takawithout) /></td>
    </tr>
";
//        <tr>                    
//    <td colspan='4' style='padding-left: 278px; ' > 
//    <input class = 'btn' style =' font-size: 12px; ' type = 'submit' name='submit_ticket' value='ক্রয় করা হল' /></td>
//    </tr>
    echo '</table>';
}
?>
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
$total_taka = ($tkPerTicket+$mpPerTicket)*$totalseat;
    echo ' <table style="color: darkblue;"> ';
    echo " <tr>
    </br><td style='width: 40%; padding-left: 0px !important;'>মোট টিকেট</td>
    <td>: <span style='color: black;'>$totalseat টি</span></td>
    </tr>
    <tr>
    <td style='width: 40%; padding-left: 0px !important;'>মোট টিকেট প্রাইজ</td>
    <td>: <span style='color: black;'>$total_taka TK</span></td>
    </tr>
    <tr>                    
    <td colspan='2' style='padding-left: 278px; ' > 
    <input class = 'btn' style =' font-size: 12px; ' type = 'submit' name='submit_ticket' value='ক্রয় করা হল' />
    </tr>";
    echo '</table>';
}
?>
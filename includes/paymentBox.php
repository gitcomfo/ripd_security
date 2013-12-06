<?php
if(isset($_GET['paytaka']))
{
    $payTaka = $_GET['paytaka'];
    echo ' <table style="color: darkblue;"> ';
    echo " <tr>
    <td style='width:50%;padding-left: 0px !important;text-align:center;'><input type='radio' name='bycash' onclick='paycash($payTaka)' />পেমেন্ট বাই ক্যাশ</td>
    <td style='width:50%;text-align:center;'><input type='radio' name='bycash' onclick='paybyaccount($payTaka)'/>পেমেন্ট বাই অ্যাকাউন্ট</td>
    </tr>
    ";
    echo '</table>';
}
elseif (isset ($_GET['ticketprize'])) 
    {
     $ticketTaka = $_GET['ticketprize'];
    echo " <td colspan='4' style='padding-left: 278px; ' ><input type= 'hidden' name='totalTaka' value='$ticketTaka' />
        <input type= 'hidden' name='paymenttype' value='cash' />
 <input class = 'btn' style =' font-size: 12px; ' type = 'submit' name='submit_ticket' value='ক্রয় করা হল' /></td>";
}
elseif (isset ($_GET['ticketprizeForAcc'])) 
    {
     $ticketTaka = $_GET['ticketprizeForAcc'];
     { 
       // code throgh send sms here ....................................................  
     }
    echo " <td colspan='4' style='text-align:center; ' > <input type= 'hidden' name='totalTaka' value='$ticketTaka' />
        <input type= 'hidden' name='paymenttype' value='account' />
        ভ্যারিফিকেশন কোডঃ <input class='box' name='varificationCode' onkeyup='checkVarificationCode(this.value)' /><span id='checkmsg'></span></br></br>
        অথবা &nbsp;&nbsp;
        <input class='btn' type='button' name='sendEmail' value='সেন্ড ইমেইল' /></br>
 <input class = 'btn' style =' font-size: 12px;visibility: hidden; ' type = 'submit' name='submit_ticket' value='ক্রয় করা হল'  /></td>";
}
?>
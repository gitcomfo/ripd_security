<?php
if (isset ($_GET['ticketprize'])) 
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
         <input class = 'btn' style =' font-size: 12px;' type = 'submit' name='submit_ticket' id='submit_ticket' value='ক্রয় করা হল'  /></td>";
}
?>
<?php
error_reporting(0);
include 'includes/ConnectDB.inc';
$cfsID = $_SESSION['userIDUser'];
if($_GET['generate'] == 1)
{
    $check=1;
    while($check==1)
    {
        $str_pin= "pin";
        for($i=0;$i<3;$i++)
            {
                $str_random_no=(string)mt_rand (0 ,9999 );
                $str_pin_random= str_pad($str_random_no,4, "0", STR_PAD_LEFT);
                $str_pin =$str_pin."-".$str_pin_random;
            }
        $result = mysql_query("SELECT * FROM pin_makingused where pin_no= '$str_pin'");
        if(mysql_num_rows($result) == 0)
        {
            $insreslt = mysql_query( "INSERT INTO pin_makingused (pin_no ,pin_state, pin_making_date, pin_madeby_cfsuserid) 
                                                    VALUES ('$str_pin', 'open', CURDATE(), $cfsID)");
            $check = 2;
        }
    }
    echo $str_pin;
}
 elseif(isset($_GET['ssumid'])) 
 {
     $sumeryid = $_GET['ssumid'];
     $sql_pin = mysql_query("SELECT * FROM pin_makingused WHERE sales_summery_idsalessummery = $sumeryid;");
            $pinrow = mysql_fetch_assoc($sql_pin);
                if($pinrow['idpin'] == "")
                {
                    $g_totalpv = $_GET['pv']; 
                    $insreslt = mysql_query( "INSERT INTO pin_makingused (`pin_no` ,`pin_state`, pin_totalpv, pin_making_date, pin_madeby_cfsuserid, sales_summery_idsalessummery) 
                                            VALUES ('$str_pin', 'open', $g_totalpv, CURDATE(), $cfsID, $sumeryid)") or exit ("sorry have problem");
                    $check=2;
                }
           else
           {
               $str_pin = $pinrow['pin_no']; 
               $check =2;
           }
 }
?>

<?php
error_reporting(0);
require_once('auth.php');
include 'includes/ConnectDB.inc';
$cfsid= $_SESSION['cfsid'];
$sumeryid = $_GET['ssumid'];
$check=1;
while($check==1)
{
$str_pin= "sales";
for($i=0;$i<3;$i++)
    {
        $str_random_no=(string)mt_rand (0 ,9999 );
        $str_pin_random= str_pad($str_random_no,4, "0", STR_PAD_LEFT);
        $str_pin =$str_pin."-".$str_pin_random;
    }
$sql= "SELECT * FROM pin_makingused where pin_no= '$str_pin' ";
$result = mysql_query($sql) or exit("soryy");
$row= mysql_fetch_assoc($result);
if($row['pin_no']!= $str_pin)
{
    $sql_pin = mysql_query("SELECT * FROM pin_makingused WHERE sales_summery_idsalessummery = $sumeryid;");
    $pinrow = mysql_fetch_assoc($sql_pin);
	if($pinrow['idpin'] == "")
        {
            $g_totalpv = $_GET['pv']; 
            $inssql= "INSERT INTO pin_makingused (`pin_no` ,`pin_state`, pin_totalpv, pin_making_date, pin_madeby_cfsuserid, sales_summery_idsalessummery) 
                                    VALUES ('$str_pin', 'open', $g_totalpv, CURDATE(), $cfsid, $sumeryid);";
	$insreslt = mysql_query($inssql) or exit ("sorry have problem");
	$check=2;
        }
   else
   {
       $str_pin = $pinrow['pin_no']; $check =2;
   }
}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
</head>
<body>
    <div align="center" style="width: 100%;font-family: SolaimanLipi !important; padding: 5px;color: #000;">
আপনার পিন নং : <?php echo $str_pin;?>
    </div>
</body>
</html>

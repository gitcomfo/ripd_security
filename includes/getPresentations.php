<?php
error_reporting(0);
include_once 'ConnectDB.inc';
include_once 'MiscFunctions.php';

if(isset($_GET['t']))
{
$type=$_GET['t'];
$typeinbangla = getProgramType($type);

            $psql="SELECT * FROM program WHERE program_type='$type' AND program_location IS NULL;";
            $prslt=mysql_query($psql) or exit('query failed: '.mysql_error());
            echo "<select class='selectOption' name='nam' onchange='getall(this.value)' style='width: 167px !important;'>";
            echo "<option value=''>----$typeinbangla সিলেক্ট করুন-----</option>";
            while($prow=mysql_fetch_assoc($prslt))
            {
                $pid=$prow['idprogram'];
                $name=$prow['program_name'];
                echo "<option value='$pid'>$name</option>";
            }
            echo '</select>';
            echo "<input type='hidden' name='type' value='$type' />";
}

$value=$_GET['v'];
$str_emp_name = "";
$str_emp_email = "";
if($value !="")
{
$allsql="SELECT * FROM program WHERE idprogram=$value;";
$allrslt=mysql_query($allsql) or exit('query failed: '.mysql_error());
while($all=  mysql_fetch_assoc($allrslt))
{
    $p_name=$all['program_name'];
    $p_no=$all['program_no'];
    $p_date=$all['program_date'];
    $p_time=$all['program_time'];
    $p_type = $all['program_type'];
    $p_location = $all['program_location'];
}
$typeinbangla = getProgramType($p_type);
$whoinbangla =  getProgramer($p_type);
$sql = "SELECT * FROM cfs_user,employee WHERE idUser =  cfs_user_idUser AND idEmployee = ANY( SELECT fk_Employee_idEmployee FROM presenter_list WHERE fk_idprogram = $value);";
    $finalsql=mysql_query($sql) or exit('query failed: '.mysql_error());
    while($finalget = mysql_fetch_assoc($finalsql))
    {
        $e_name=$finalget['account_name'];
        $e_mail=$finalget['email'];
        $str_emp_name = $e_name.", ".$str_emp_name;
        $str_emp_email = $e_mail.", ".$str_emp_email;
    }
    echo ' <table> ';
    echo " <tr><td style='width: 310px; padding-left: 0px !important;'>$typeinbangla-এর নাম</td>
                        <td>:    $p_name</td >                
                    </tr>
                    <tr>
                        <td style='padding-left: 0px !important;'>$whoinbangla-এর নাম</td>
                        <td>:    $str_emp_name </td>            
                    </tr>
                    <tr>
                        <td style='padding-left: 0px !important;'>$whoinbangla-এর ইমেইল</td>
                        <td>:    $str_emp_email</td>            
                    </tr>
                    <tr>
                        <td style='padding-left: 0px !important;'>স্থান</td>
                        <td>: $p_location <input type='place' value='$p_location' /></td>            
                    </tr>
                    <tr>
                        <td style='padding-left: 0px !important;'>তারিখ</td>
                        <td>:  ".english2bangla(date('d/m/Y',  strtotime($p_date)))." </td>            
                    </tr>
                    <tr>
                        <td style='padding-left: 0px !important;'>সময়</td>
                        <td>: ".english2bangla(date('h:i a',  strtotime($p_time)))."   </td>
                    </tr>
                    <tr><td>
                    <input type='hidden' name='programID' value=$value />
                     <input type='hidden' name='type' value=$p_type />
                    <input type='hidden' name='programName'  value='$p_name' />
                    <input type='hidden' name='programDate'  value='$p_date' />
                    <input type='hidden' name='programTime' value='$p_time' />
                    <input type='hidden' name='emp_name' value='$str_emp_name' />
                    <input type='hidden' name='emp_mail' value='$str_emp_email' />
                    </td></tr>";
    echo '</table>';
}
?>
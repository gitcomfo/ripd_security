<?php
error_reporting(0);
include_once 'ConnectDB.inc';
include_once 'MiscFunctions.php';

if(isset($_GET['t']))
{
    $type=$_GET['t'];
    $typeinbangla = getProgramType($type);

            $psql="SELECT * FROM " . $dbname . ".program WHERE program_type='$type' AND program_location IS NOT NULL;";
            $prslt=mysql_query($psql) or exit('query failed: '.mysql_error());
            echo '<table>';
            echo '<tr>';
            echo "<td style='width: 40% !important; padding-right: 0px !important; '>$typeinbangla -এর নাম</td>";
            echo '<td>';
            echo ': <select class="selectOption" name="ProgName" onchange="getall(this.value)" style=" width: 170px !important;">';
           while($prow=mysql_fetch_assoc($prslt))
            {
                $pid=$prow['idprogram'];
                $name=$prow['program_name'];
                echo "<option value='$pid'>$name</option>";
            }
            echo '</select>';
            echo "<input type='hidden' name='type' value='$type' />";
            echo '</td></tr>';
            echo '<tr>                    
                      <td colspan= "2" style="padding-left: 310px ; padding-top: 10px; " ><input class="btn" style =" font-size: 12px; " type="submit" name="submit" value="ঠিক আছে" /></td>                           
                      </tr> ';
            echo '</table>';
        
}
?>
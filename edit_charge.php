<?php
error_reporting(0);
include_once 'includes/ConnectDB.inc';
//echo"<pre>";
//print_r($_POST);
//echo"</pre>";
    $db_charge_criteria_value = $_POST['charge_criteria_amount'];
    $db_charge_criteria_id = $_POST['charge_criteria_id'];    
    echo "db_charge_criteria_value ".$db_charge_criteria_value. " db_charge_criteria_id= ".$db_charge_criteria_id;
    
if(isset($_POST['edit'])){
    $edit_charge_value= "UPDATE charge SET charge_amount='$db_charge_criteria_value' WHERE idCharge='$db_charge_criteria_id'";
    if(mysql_query($edit_charge_value)){
        //echo "I am successful Edit" ;
           header("location: charge_making.php");
    }
}elseif(isset ($_POST['postpond'])){    
    //$db_charge_criteria_id = $_POST['charge_criteria_id'];
    $postpond_charge_value= "UPDATE charge SET  charge_status='Postpond' WHERE idCharge='$db_charge_criteria_id'";
    if(mysql_query($postpond_charge_value)){
            header("location: charge_making.php");
    }
}
    elseif(isset ($_POST['restart'])){
    //$db_charge_criteria_id = $_POST['charge_criteria_id'];
    $restart_charge_value= "UPDATE charge SET  charge_status='Active' WHERE idCharge='$db_charge_criteria_id'";
    if(mysql_query($restart_charge_value)){
        //echo "I am successful restart" ;
            header("location: charge_making.php");
    }
    }
?>

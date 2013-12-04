<?php
include_once 'includes/session.inc';
include_once 'includes/header.php';
include_once 'includes/MiscFunctions.php';
?>
<?php
$flag = 'false';
$msg = "";
$msgedit = $_GET['editmsg'];
$flagedit = $_GET['editflag'];
//echo "MSG: ".$msgedit. " Flag : ".$flagedit;

function showEditMessage($flagedit, $msgedit) {
    if (!empty($msgedit)) {
        if($msgedit=='2'){
            $showEditMsg = "চার্জটি সফলভাবে পরিবর্তন হয়েছে";
        }elseif ($msgedit=='3') {
            $showEditMsg = "চার্জটি সফলভাবে স্থগিত হয়েছে";
        }elseif ($msgedit=='4') {
            $showEditMsg = "চার্জটি সফলভাবে পুনরায় চালু হয়েছে";
        }  else {
            $showEditMsg = "দুঃখিত, আবার চেষ্টা করুন";
        }
        if ($flagedit == '2') {
            echo '<tr><td colspan="2" height="30px" style="text-align:center;"><b><span style="color:green;font-size:15px;">' . $showEditMsg . '</b></td></tr>';
        } else {
            echo '<tr><td colspan="2" height="30px" style="text-align:center;"><b><span style="color:red;font-size:15px;"><blink>' . $showEditMsg . '</blink></b></td></tr>';
        }
    }
}

function showMessage($flag, $msg) {
    if (!empty($msg)) {
        if ($flag == 'true') {
            echo '<tr><td colspan="2" height="30px" style="text-align:center;"><b><span style="color:green;font-size:15px;">' . $msg . '</b></td></tr>';
        } else {
            echo '<tr><td colspan="2" height="30px" style="text-align:center;"><b><span style="color:red;font-size:15px;"><blink>' . $msg . '</blink></b></td></tr>';
        }
    }
}
?>
<title>চার্জ মেইকিং</title>
<style type="text/css"> @import "css/bush.css";</style>
<script type="text/javascript" src="javascripts/area.js"></script>
<script type="text/javascript" src="javascripts/external/mootools.js"></script>
<script type="text/javascript" src="javascripts/dg-filter.js"></script>
<script>
    var fieldName='chkName[]';
    function numbersonly(e)
    {
        var unicode=e.charCode? e.charCode : e.keyCode
        if (unicode!=8)
        { //if the key isn't the backspace key (which we should allow)
            if (unicode<48||unicode>57) //if not a number
                return false //disable key press
        }
    }


    function checkIt(evt) {
        evt = (evt) ? evt : window.event
        var charCode = (evt.which) ? evt.which : evt.keyCode
        if (charCode ==8 || (charCode >47 && charCode <58) || charCode==46) {
            status = ""
            return true
        }
        status = "This field accepts numbers only."
        return false
    }
</script>

<?php
//$rowEntry = mysql_query("SELECT * FROM charge");
//$rowNumber = mysql_num_rows($rowEntry);
//$selectCharge = mysql_query("Select * from charge");
//$rows_selected_charge = mysql_num_rows($selectCharge);
if (isset($_POST['submit']) && ($_GET['action'] == 'new')) {

    $new_charge_criteria_name = $_POST['charge_criteria_name'];
    $new_charge_amount = $_POST['charge_amount'];
    $new_charge_status = "Active";
    $newChargeInsert = "INSERT INTO charge (charge_criteria ,charge_amount ,charge_status) values('$new_charge_criteria_name', '$new_charge_amount', '$new_charge_status')";

    if (mysql_query($newChargeInsert)) {
        $msg = "আপনি সফলভাবে " . $new_charge_criteria_name . " নামে নতুন চার্জটি তৈরি করেছেন";
        $flag = 'true';
    } else {
        $msg = "দুঃখিত, আবার চেষ্টা করুন";
        $flag = 'false';
    }
            header("Location:charge_making.php");
}
?>      

<?php
if ($_GET['action'] == 'new') {
    ?>
    <div style="padding-top: 10px;">    
        <div style="padding-left: 110px; width: 65%; float: left"><a href="command_system_management.php"><b>ফিরে যান</b></a></div>
        <div  ><a href="charge_making.php?action=new"> নতুন চার্জ</a>&nbsp;&nbsp;<a href="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>">চার্জ পরিবর্তন</a></div>
    </div>
    <div>
        <form method="POST" onsubmit="" name="" action="">

            <table  class="formstyle" style="font-family: SolaimanLipi !important; width: 78%; text-align: center;">          
                <tr><th colspan="2" style="text-align: center;">নতুন চার্জ  মেইকিং</th></tr>
                <?php 
                showMessage($flag, $msg);
                ?>
                <tr>
                    <td style="width: 40%; text-align: center;">চার্জ নাম</td>
                    <td>: <input class="box" type="text" id="charge_criteria_name" name="charge_criteria_name" value=""/></td>
                </tr>
                <tr>
                    <td style="text-align: center;">চার্জ পরিমান</td>
                    <td>: <input class="box" type="text" id="charge_amount" name="charge_amount" value="" onkeypress="return checkIt(event)"/> টাকা</td>
                </tr>    
                <tr>                    
                    <td colspan="2" style="padding-left: 250px; " ><input class="btn" style =" font-size: 12px; " type="submit" name="submit" value="সেভ করুন" />
                        <input class="btn" style =" font-size: 12px" type="reset" name="reset" value="রিসেট করুন" /></td>                           
                </tr>  

            </table>
        </form>
    </div>
    <?php
} else {
    ?>
    <div style="padding-top: 10px;">    
        <div style="padding-left: 110px; width: 65%; float: left"><a href="command_system_management.php"><b>ফিরে যান</b></a></div>
        <div><a href="charge_making.php?action=new"> নতুন চার্জ </a>&nbsp;&nbsp;<a href="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>">চার্জ পরিবর্তন</a></div>
    </div>
    <div>
        <table  class='formstyle' style='font-family: SolaimanLipi !important; width: 78%;'>          
            <tr><th colspan='2' style='text-align: center;'>চার্জ পরিবর্তন</th></tr>
            <?php 
            showEditMessage($flagedit, $msgedit);
            ?>
            <?php
            $selectCharge = mysql_query("Select * from charge");
            $num_of_charge_criteria = mysql_num_rows($selectCharge);
            if($num_of_charge_criteria < 1){
                echo "<tr><td colspan='2' style='text-align:center;'>কোনো চার্জের ধরণ তৈরি করা হয় নাই,<a href='charge_making.php?action=new'> নতুন চার্জ তৈরি করুন </a></td></tr>";
            }
            while ($selectChargeRow = mysql_fetch_array($selectCharge)) {
                $db_charge_id_selected = $selectChargeRow['idcharge'];
                $db_charge_criteria_selected = $selectChargeRow['charge_criteria'];
                $db_charge_amount_selected = $selectChargeRow['charge_amount'];
                $db_charge_status_selected = $selectChargeRow['charge_status'];
                echo "<form method='POST' onsubmit='' name='' action='edit_charge.php'>";
                echo " <tr>
                        <td style='width:25%; text-align:center;'>$db_charge_criteria_selected<input type='hidden' id='charge_criteria_id' name='charge_criteria_id' value='$db_charge_id_selected'/>                        
                            <input type='hidden' id='charge_status' name='charge_status' value='$db_charge_status_selected'/></td>";

                if ($db_charge_status_selected == 'Active') {
                    echo"<td>: <input class='box' type='text' id='charge_criteria_amount' name='charge_criteria_amount' value='$db_charge_amount_selected' /> Taka
                                  <input class='btn' type='submit' id='edit' name='edit' value='পরিবর্তন' style='background: #0099A1 !important;height: 20px !important;width: 100px;'/>
                                  <input class='btn' type='submit' id='postpond' name='postpond' value='স্থগিত' style='background: red !important;height: 20px !important;width: 100px;'/>
                                  <input class='btn' type='submit' id='restart' name='restart' value='রিস্টার্ট' style='background: gray !important;height: 20px !important;width: 100px;' disabled='true'/>";
                } else {
                    echo"<td>: <input class='box' type='text' id='charge_criteria_amount' name='charge_criteria_amount' value='$db_charge_amount_selected' disabled='true' /> Taka
                                    <input class='btn' type='submit' id='edit' name='edit' value='পরিবর্তন' style='background: gray !important;height: 20px !important;width: 100px;' disabled='true'/>
                                    <input class='btn' type='submit' id='postpond' name='postpond' value='স্থগিত' style='background: gray !important;height: 20px !important;width: 100px;' disabled='true'/>
                                    <input class='btn' type='submit' id='restart' name='restart' value='রিস্টার্ট' style='background: green !important;height: 20px !important;width: 100px;'/>";
                }
                echo "</td> 
                                  </tr></form>";
            }
            ?>   
        </table>
    </div>
<?php
}
include_once 'includes/footer.php';
?>
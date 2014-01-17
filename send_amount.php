<?php
error_reporting(0);
include_once 'includes/header.php';
include_once 'includes/columnViewAccount.php';
include_once 'includes/selectQueryPDO.php';
include_once 'includes/MiscFunctions.php';
include_once 'includes/insertQueryPDO.php';
include_once 'includes/sms_send_function.php';

$flag = 'false';
$charge_code = "sda";
$db_charge_amount = 0;
$db_charge_type = "";
$sql_select_charge->execute(array($charge_code));
$row_charge = $sql_select_charge->fetchAll();
foreach ($row_charge as $row){
    $db_charge_amount = $row['charge_amount'];
    $db_charge_type = $row['charge_type'];
}
$sql_select_balace_check->execute(array($_SESSION['userIDUser']));
$row_balace_check = $sql_select_balace_check->fetchAll();
foreach ($row_balace_check as $row){
    $db_balance = $row['total_balanace'];
}

function showMessage($flag, $msg) {
    if (!empty($msg)) {
        if ($flag == 'true') {
            echo '<tr><td colspan="2" height="30px" style="text-align:center;"><b><span style="color:green;font-size:20px;">' . $msg . '</b></td></tr>';
        } else {
            echo '<tr><td colspan="2" height="30px" style="text-align:center;"><b><span style="color:red;font-size:20px;"><blink>' . $msg . '</blink></b></td></tr>';
        }
    }
}

if (isset($_POST['save'])) {
    $receiver_mobile_num = $_POST['mobileNo'];
    $receiver_mobile_num = "88$receiver_mobile_num";
    $p_trans_amount = $_POST['amount'];
    $trans_purpose = $_POST['trans_des'];
    $p_receiver_get= $_POST['trans_amount_val'];
    $p_trans_charge= $_POST['trans_charge_val'];
    $p_total_amount = $_POST['total_amount_val'];
    $trans_type = "send";
    $trans_senderid = $_SESSION['userIDUser'];
    $chrg_givenby = $_POST['charger'];
    $sts = "unpaid";
    random:
    $random = mt_rand(10000000, 99999999);
    $sql_select_random->execute(array($random));
    $row_random = $sql_select_random->fetchColumn();   
    if($row_random>0){ // exist
        goto random;
    }
    else{
        $reciever_id = 0;
        $sql_insert_acc_user_amount_transfer->execute(array($trans_type, $trans_senderid, $reciever_id, $receiver_mobile_num,
                                                                    $p_trans_amount, $p_receiver_get, $p_trans_charge, $trans_purpose,
                                                                    $chrg_givenby, $p_total_amount, $sts, $random));
        $sms_body = "Dear User,\nYou have received: $p_trans_amount Taka.\nTransaction Charge: $p_trans_charge Taka,\nYou will get $p_receiver_get Taka in Cash.\nYour code $random";
        $sendResult = SendSMSFuntion($receiver_mobile_num, $sms_body);
        $sendStatus = substr($sendResult, 0, 4);
        if($sendStatus == '1701'){
            $msg = "টাকা সফল ভাবে সেন্ড হয়েছে, আপনার কোডটি ".$random;
        }else{
            $msg = "দুঃখিত, ম্যাসেজটি পাঠানো যায়নি, আপনার কোডটি ".$random;
        }
    }
}
?>

<title>সেন্ড এমাউন্ট</title>
<script src="javascripts/cfs_accounting.js" type="text/javascript"></script>
<style type="text/css">@import "css/bush.css";</style>

<div class="columnSubmodule" style="font-size: 14px;">
    <form  action="" id="amountTransForm" method="post" style="font-family: SolaimanLipi !important;">
        <table class="formstyle" style ="width: 100%; margin-left: 0px; font-family: SolaimanLipi !important;">        
            <tr>
                <th colspan="2">সেন্ড এমাউন্ট</th>
            </tr>
            <?php
            showMessage($flag, $msg);
            $transfer_type = "send";
            $sender_id = $_SESSION['userIDUser'];
            $sql_last_userAmountTransfer->execute(array($transfer_type, $sender_id));
            $row_last_amountTransfer = $sql_last_userAmountTransfer->fetchAll();
            foreach ($row_last_amountTransfer as $rlat)
                $db_last_send = date("d-m-Y", strtotime($rlat['trans_date_time']));
            $sql_userBalance->execute(array($sender_id));
            $row_user_balance = $sql_userBalance->fetchAll();
            foreach ($row_user_balance as $rub) {
                $db_total_balance = $rub['total_balanace'];
                $db_last_withdrawl = date("d-m-Y", strtotime($rub['last_withdrawl']));
            }
            ?>
            <tr>
                <td colspan="2">
                    <fieldset style="border: #686c70 solid 3px;width: 80%;margin-left: 10%;">
                        <legend style="color: brown;">একাউন্ট স্ট্যাটাস</legend>
                        <table width="100%" align="center" >
                            <tr>
                                <td style="text-align: right; width: 50%;"><b>টোটাল ব্যালেন্স :</b></td>
                                <td style="width: 50%;padding-left: 0px;"><?php echo english2bangla($db_total_balance) . " টাকা"; ?></td>
                            </tr>
                            <tr>
                                <td style="text-align: right;"><b>সর্বশেষ সেন্ড এমাউন্টের তারিখ :</b></td>
                                <td style="padding-left: 0px;"><?php echo english2bangla($db_last_send); ?></td>
                            </tr>
                            <tr>
                                <td style="text-align: right;"><b>শেষ উত্তোলনের তারিখ :</b></td>
                                <td style="padding-left: 0px;"><?php echo english2bangla($db_last_withdrawl); ?></td>
                            </tr>
                        </table>
                    </fieldset>
                </td>
            </tr>
            <tr>                    
                <td style='text-align: center;' colspan='2'>
                    <input type='radio' name='charger' checked="checked" id="chargeSender" value="sender" onclick="resetForm('chargeSender');"/> চার্জ প্রেরকের &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <input type='radio' name='charger' id="chargeRec" value="receiver" onclick="resetForm('chargeRec');"/> চার্জ প্রাপকের
                </td>
            </tr>
            <tr>
                <td style="width: 55%">
                    <table>
                    <tr>
                            <td style="text-align: right;">প্রাপকের মোবাইল নাম্বার</td>
                            <td style="text-align: left;">: <input  class="box" style="width: 100px" type="text" name="mobileNo" id="mobileNo" maxlength="11" onkeypress= "return numbersonly(event)" onblur= "validateMobile(this.value)" placeholder="01XXXXXXXXX"/><span id='mblValidationMsg'></span></td>
                        </tr>
                        <tr>
                            <td style="text-align: right;">টাকার পরিমান</td>
                            <td>: <input  class="box" type="text" style="width: 100px" name="amount"  id="amount"  onkeypress="return checkIt(event);" onblur="sendTransAmount(this.value, '<?php echo $db_charge_amount; ?>', '<?php echo $db_charge_type; ?>', '<?php echo $db_balance; ?>'); " value="0"/> টাকা <br/><span id="errorbalance"></span></td>   
                        </tr>
                        <tr>
                            <td style="text-align: right; ">টাকার পরিমান (পুনরায়)</td>
                            <td>: <input  class="box" type="text" name="amount_rep" style="width: 100px"  id="amount_rep"  onkeypress="return checkIt(event);" onblur="repeatAmount(this.value, 'mblValidationMsg', 'mobileNo');" value="0"/> টাকা <br/><span id="errormsg"></span></td>   
                        </tr>
                        <tr>
                            <td style="text-align: right;">সেন্ডের কারন</td>
                            <td> <textarea  class="box" type="text" style="width: 100px" name="trans_des"  id="trans_des" value=""></textarea></td>   
                        </tr>
                </table>    
            </td>
            <td style="width: 45%">
                <table>
                        <tr>
                            <td style='text-align: right;'>ট্রান্সফার এমাউন্ট</td>
                            <td style='' >: <span id="trans_amount" name="trans_amount">0</span> টাকা<input type="hidden" id="trans_amount_val" name="trans_amount_val" value="0" /></td>   
                        </tr>
                        <tr>
                            <td style='text-align: right;'>ট্রান্সফার চার্জ</td>
                            <td>: <span id="trans_charge" name="trans_charge">0</span> টাকা<input type="hidden" id="trans_charge_val" name="trans_charge_val" value="0" /></td>   
                        </tr>
                        <tr>
                            <td style='text-align: right; '>টোটাল এমাউন্ট</td>
                            <td>: <span id="total_amount" name="total_amount">0</span> টাকা<input type="hidden" id="total_amount_val" name="total_amount_val" value="0" /></td>   
                        </tr>
                    </table>               
            </td>
            </tr>
            <tr>
                <td colspan="2" style="text-align: center"></br><input type="button" class="btn"  name="view" id="view" disabled value="ঠিক আছে" onclick="getPassword();" ></td>
            </tr>
            <tr>
                <td colspan="2" id="passwordbox"></td>
            </tr>
        </table>
    </form>
</div>
<?php include_once 'includes/footer.php'; ?> 

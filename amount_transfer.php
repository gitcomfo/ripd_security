<?php
error_reporting(0);
include_once 'includes/ConnectDB.inc';
include_once 'includes/header.php';
include_once 'includes/columnViewAccount.php';
include_once 'includes/connectionPDO.php';
include_once 'includes/selectQueryPDO.php';
include_once 'includes/insertQueryPDO.php';
include_once 'includes/sms_send_function.php';


$charge_code = "tra";
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
$flag = 'false';
function showMessage($flag, $msg) 
        {
        if (!empty($msg))
                {
                if ($flag == 'true') 
                    {
                    echo '<tr><td colspan="3" height="30px" style="text-align:center;"><b><span style="color:green;font-size:20px;">' . $msg . '</b></td></tr>';
                    }
                else 
                    {
                    echo '<tr><td colspan="3" height="30px" style="text-align:center;"><b><span style="color:red;font-size:20px;"><blink>' . $msg . '</blink></b></td></tr>';
                    }
                }
        }
if (isset($_POST['save'])) {
    $receiver_id =$_POST['receiver_user_id'];
    $trans_amount = $_POST['amount1'];
    $trans_purpose = $_POST['trans_des'];
    $trans_servicecharge = $db_charge_amount;
    $trans_type = "transfer";
    $trans_senderid = $_SESSION['userIDUser'];
    $chrg_givenby = $_POST['charger'];
    $sts = "transfer";
    random:
    $random = mt_rand(10000000, 99999999);
    $sql_select_random->execute(array($random));
    $row_random = $sql_select_random->fetchColumn();   
    if($row_random>0){ // exist
        goto random;
    }
    else{
        $receiver_mobile_num = $_POST['user_mobile'];
        $sql_insert_acc_user_amount_transfer->execute(array($trans_type, $trans_senderid, $receiver_id, $receiver_mobile_num,
                                                                    $trans_amount, $reciever_get, $trans_servicecharge, $trans_purpose,
                                                                    $chrg_givenby, $total_transaction, $sts, $random));
        $sms_body = "Dear User, You have received: $trans_amount Taka.\nTransaction Charge: $trans_servicecharge Taka,\nYou will get $reciever_get Taka in Cash\nYour code $random.";
        $sendResult = SendSMSFuntion($receiver_mobile_num, $sms_body);
        $sendStatus = substr($sendResult, 0, 4);
        if($sendStatus == '1701'){
            $msg = "টাকা সফল ভাবে ট্রান্সফার হয়েছে, আপনার কোডটি ".$random;
        }else{
            $msg = "দুঃখিত, ম্যাসেজটি পাঠানো যায়নি, আপনার কোডটি ".$random;
        }
    }
}
        
        
        
?>

<title>ব্যাক্তিগত অ্যামাউন্ট ট্রান্সফার</title>
<script src="javascripts/send_transfer_amount.js" type="text/javascript"></script>
<style type="text/css">@import "css/bush.css";</style>
<script type="text/javascript">
function getEmployee(accountNo) //search employee by account number***************
{
    var xmlhttp;
        if (window.XMLHttpRequest)
        {// code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp=new XMLHttpRequest();
        }
        else
        {// code for IE6, IE5
            xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange=function()
        {
             document.getElementById('recieverInfo').innerHTML=xmlhttp.responseText;
        }
        xmlhttp.open("GET","includes/employeeSearch.php?account="+accountNo,true);
        xmlhttp.send();	
}
</script>
 
 <div class="columnSubmodule" style="font-size: 14px;">
    <form  action="" id="amountTransForm" method="post" style="font-family: SolaimanLipi !important;">
            <table class="formstyle" style ="width: 100%; margin-left: 0px; font-family: SolaimanLipi !important;">        
                <tr>
                    <th colspan="3">ব্যাক্তিগত অ্যামাউন্ট ট্রান্সফার</th>
                </tr>
                <?php
            showMessage($flag, $msg);
            $transfer_type = "transfer";
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
                    <td colspan="3">
                        <fieldset style="border: #686c70 solid 3px;width: 80%;margin-left: 10%;">
                            <legend style="color: brown;">একাউন্ট স্ট্যাটাস</legend>
                                <table width="100%" align="center" >
                                    <tr>
                                        <td style="text-align: right; width: 50%;"><b>টোটাল ব্যালেন্স :</b></td>
                                        <td style="width: 50%;padding-left: 0px;"><?php echo english2bangla($db_total_balance) . " টাকা"; ?></td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: right;"><b>সর্বশেষ ট্রান্সফার এমাউন্টের তারিখ :</b></td>
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
                <td style='text-align: center;' colspan='3'>
                    <input type='radio' name='charger' checked="checked" id="chargeSender" value="sender" onclick="resetForm('chargeSender');"/> চার্জ প্রেরকের &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <input type='radio' name='charger' id="chargeRec" value="receiver" onclick="resetForm('chargeRec');"/> চার্জ প্রাপকের
                </td>
               </tr>
                <tr>
                    <td style="text-align: right; width: 25%;padding-left: 10px;">প্রাপকের অ্যাকাউন্ট নং</td>
                    <td style="text-align: left; width: 45%;">: <input  class="box" type="text" name="accountNo"  id="accountNo" maxlength="15" onblur="getEmployee(this.value)" /> <em>(ইংরেজিতে লিখুন)</em></td>
                    <td rowspan="7" style="text-align: right; width: 35%; padding-left: 0px;" id='recieverInfo' ></td>
                </tr>
                <tr>
                    <td style="text-align: right;">টাকার পরিমান</td>
                    <td>: <input  class="box" type="text" style="width: 100px" name="amount1"  id="amount1"  onkeypress="return checkIt(event)" value="0"/> টাকা </td>   
                </tr>
                <tr>
                    <td style="text-align: right; ">টাকার পরিমান (পুনরায়)</td>
                    <td>: <input  class="box" type="text" name="amount2" style="width: 100px"  id="amount2"  onkeypress="return checkIt(event)" onblur="checkAmountTrans(this.value, '<?php echo $db_charge_amount; ?>', '<?php echo $db_charge_type; ?>', '<?php echo $db_balance; ?>'); " value="0"/> টাকা 
                        </br><span id="errormsg"></span></td>   
                </tr>
                <tr>
                    <td style="text-align: right; padding-left: 10px;">ট্রান্সফারের কারন</td>
                    <td> <textarea  class="box" type="text" name="trans_des"  id="trans_des" value=""></textarea></td>   
                </tr>
                <tr>
                    <td style='text-align: right;'>ট্রান্সফার এমাউন্ট</td>
                    <td style='' >: <span id="trans_amount" name="trans_amount">0</span> টাকা</td>   
                </tr>
                <tr>
                    <td style='text-align: right;'>ট্রান্সফার চার্জ</td>
                    <td>: <span id="trans_charge" name="trans_charge">0</span> টাকা</td>   
                </tr>
                <tr>
                    <td style='text-align: right; '>টোটাল এমাউন্ট</td>
                    <td>: <span id="total_amount" name="total_amount">0</span> টাকা</td>   
                </tr>
                <tr>
                    <td colspan="3" style="text-align: center"></br><input type="button" class="btn"  name="submit" id="submit" onclick="getPassword();" disabled value="ঠিক আছে"></td>
                </tr>
                <tr>
                    <td colspan="3" id="passwordbox"></td>
                </tr>
            </table>
        </form>
    </div>

<?php include_once 'includes/footer.php'; ?> 
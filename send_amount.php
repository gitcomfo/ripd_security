<?php
error_reporting(0);
include_once 'includes/header.php';
include_once 'includes/columnViewAccount.php';
include_once 'includes/selectQueryPDO.php';
include_once 'includes/MiscFunctions.php';

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
    
}
?>

<title>ব্যাক্তিগত অ্যামাউন্ট ট্রান্সফার</title>
<style type="text/css">@import "css/bush.css";</style>
<script type="text/javascript">
    var radio_id = "chargeSender";
    function getPassword() // for showing the password box
    {
        var acc = document.getElementById('mobileNo').value; 
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
            if (xmlhttp.readyState==4 && xmlhttp.status==200)
            {
                document.getElementById("passwordbox").innerHTML=xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET","includes/amount_transfer_with_paswrd.php?accountno="+acc,true);
        xmlhttp.send();
    }

    function checkIt(evt) // float value-er jonno***********************
    {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode ==8 || (charCode >47 && charCode <58) || charCode==46) 
        {
            status = "";
            return true;
        }
        status = "This field accepts numbers only.";
        return false;
    }
    function numbersonly(e)
    {
        var unicode=e.charCode? e.charCode : e.keyCode
        if (unicode!=8)
        { //if the key isn't the backspace key (which we should allow)
            if (unicode<48||unicode>57) //if not a number
                return false //disable key press
        }
    }        
    function checkAmount(checkvalue, charge_amount, charge_type) // check amount value in repeat
    {
        var trans_amount = 0;
        var charge = 0;
        var total = 0;
        var message = document.getElementById("mblValidationMsg").innerText;
        var amount = document.getElementById('amount1').value;
        var amount1 = document.getElementById('amount1');
        var amount2 = document.getElementById('amount2');
        if(amount != checkvalue) 
        {
            document.getElementById('amount2').focus();
            document.getElementById('errormsg').style.color='red';
            document.getElementById('errormsg').innerHTML = "পরিমান সঠিক হয় নি";
        }
        else if(amount1.value.length == 0 || amount2.value.length == 0){
            document.getElementById('errormsg').style.color='red';
            document.getElementById('errormsg').innerHTML = "পরিমানের ঘরটি খালি";
            document.getElementById('trans_amount').innerHTML = 0;
            document.getElementById('trans_charge').innerHTML = 0;
            document.getElementById('total_amount').innerHTML = 0;
        }
        else
        {
            if(charge_type == "percent"){
                if(radio_id == "chargeSender"){
                    trans_amount = amount;
                    charge = charge_amount * amount / 100;
                    total = parseFloat(trans_amount) + parseFloat(charge);
            } else if(radio_id == "chargeRec"){
                    total = amount;
                    charge = charge_amount * amount / 100;
                    trans_amount = total - charge;
                }
            }else if(charge_type == "fixed"){
                if(radio_id == "chargeSender"){
                    trans_amount = amount;
                    charge = charge_amount;
                    total = parseFloat(trans_amount) + parseFloat(charge);
                   // total = trans_amount + charge;
            } else if(radio_id == "chargeRec"){
                    total = amount;
                    charge = charge_amount;
                    trans_amount = total - charge;
                }
            }
            document.getElementById('trans_amount').innerHTML = trans_amount;
            document.getElementById('trans_charge').innerHTML = charge;
            document.getElementById('total_amount').innerHTML = total;
            document.getElementById('errormsg').innerHTML="";  
           
            if (message == " ঠিক আছে"){
              document.getElementById('submit').disabled= false;  
            }  
        }
    }

    function checkPass(passvalue) // check password in repeat
    {
        var password = document.getElementById('password1').value;
        if(password != passvalue)
        {
            document.getElementById('password2').focus();
            document.getElementById('passcheck').style.color='red';
            document.getElementById('passcheck').innerHTML = "পাসওয়ার্ড সঠিক হয় নি";
        }
        else
        {
            document.getElementById('passcheck').style.color='green';
            document.getElementById('passcheck').innerHTML="পাসওয়ার্ড মিলেছে";
            document.getElementById('submit').disabled= false;
        }
    }
        
    function beforeSave()
    {
        if(document.getElementById('showError').innerHTML != "") 
        {
            document.getElementById('save').disabled= true;
        }
    }

    function  checkCorrectPass() // match password with account
    {
        var pass = document.getElementById('password1').value;
        var acc = document.getElementById('accountNo').value;
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
            if (xmlhttp.readyState==4 && xmlhttp.status==200)
            {
                document.getElementById('showError').style.color='red';
                document.getElementById("showError").innerHTML=xmlhttp.responseText;
                var message = document.getElementById("showError").innerText;
                if(message != " ঠিক আছে")
                {
                    document.getElementById('accountNo').focus();
                }
            }
        }
        xmlhttp.open("GET","includes/matchPassword.php?acc="+acc+"&pass="+pass,true);
        xmlhttp.send();
    }
  
    function validateMobile(mblno)
    {
        if (window.XMLHttpRequest)
        {// code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        }
        else
        {// code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function()
        {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
            {
                document.getElementById("mblValidationMsg").innerHTML = xmlhttp.responseText;
                var message = document.getElementById("mblValidationMsg").innerText;
                if (message != "")
                {
                    document.getElementById('mobile').focus();
                }
            }
        }
        xmlhttp.open("GET", "includes/mobileNoValidation.php?mobile=" + mblno, true);
        xmlhttp.send();
    }

 function resetForm(id){
     radio_id = id;
     var amount = 0;
     document.getElementById('trans_amount').innerHTML = amount;
     document.getElementById('trans_charge').innerHTML = amount;
     document.getElementById('total_amount').innerHTML = amount;
     document.getElementById('amount1').value = 0;
     document.getElementById('amount2').value = 0;
     document.getElementById(id).checked = true;
 }
</script>

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
                            <td>: <input  class="box" type="text" style="width: 100px" name="amount1"  id="amount1"  onkeypress="return checkIt(event)" value="0"/> টাকা </td>   
                        </tr>
                        <tr>
                            <td style="text-align: right; ">টাকার পরিমান (পুনরায়)</td>
                            <td>: <input  class="box" type="text" name="amount2" style="width: 100px"  id="amount2"  onkeypress="return checkIt(event)" onblur="checkAmount(this.value, '<?php echo $db_charge_amount ?>', '<?php echo $db_charge_type ?>'); " value="0"/> টাকা 
                                </br><span id="errormsg"></span></td>   
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
                            <td style='' >: <span id="trans_amount">0</span> টাকা</td>   
                        </tr>
                        <tr>
                            <td style='text-align: right;'>ট্রান্সফার চার্জ</td>
                            <td>: <span id="trans_charge">0</span> টাকা</td>   
                        </tr>
                        <tr>
                            <td style='text-align: right; '>টোটাল এমাউন্ট</td>
                            <td>: <span id="total_amount">0</span> টাকা</td>   
                        </tr>
                    </table>               
            </td>
            </tr>

            <tr>
                <td colspan="2" style="text-align: center"></br><input type="button" class="btn"  name="submit" id="submit" disabled value="ঠিক আছে" onclick="getPassword();" ></td>
            </tr>
            <tr>
                <td colspan="2" id="passwordbox"></td>
            </tr>
        </table>
    </form>
</div>

<?php include_once 'includes/footer.php'; ?> 
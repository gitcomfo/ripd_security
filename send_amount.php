<?php
error_reporting(0);
include_once 'includes/header.php';
include_once 'includes/columnViewAccount.php';
include_once 'includes/selectQueryPDO.php';
include_once 'includes/MiscFunctions.php';

$flag = 'false';
function showMessage($flag, $msg) 
        {
        if (!empty($msg))
                {
                if ($flag == 'true') 
                    {
                    echo '<tr><td colspan="2" height="30px" style="text-align:center;"><b><span style="color:green;font-size:20px;">' . $msg . '</b></td></tr>';
                    }
                else 
                    {
                    echo '<tr><td colspan="2" height="30px" style="text-align:center;"><b><span style="color:red;font-size:20px;"><blink>' . $msg . '</blink></b></td></tr>';
                    }
                }
        }
if(isset($_POST['save']))
        {

        }
?>

<title>ব্যাক্তিগত অ্যামাউন্ট ট্রান্সফার</title>
<style type="text/css">@import "css/bush.css";</style>
<script type="text/javascript">
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
function checkAmount(checkvalue) // check amount value in repeat
        {
        var amount = document.getElementById('amount1').value;
        if(amount != checkvalue) 
                {
                document.getElementById('amount2').focus();
                document.getElementById('errormsg').style.color='red';
                document.getElementById('errormsg').innerHTML = "পরিমান সঠিক হয় নি";
                }
        else
                {
                document.getElementById('errormsg').innerHTML="";  document.getElementById('submit').disabled= false;  
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
                        if(message != "")
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
                if (message != "ঠিক আছে")
                {
                    document.getElementById('mobile').focus();
                }
            }
        }
        xmlhttp.open("GET", "includes/mobileNoValidation.php?mobile=" + mblno, true);
        xmlhttp.send();
    }
    
function chargeGivenBy(user){
    var amount1 = document.getElementById('amount1').value;
    var amount2 = document.getElementById('amount2').value;
}

</script>
 
 <div class="columnSubmodule" style="font-size: 14px;">
    <form  action="" id="amountTransForm" method="post" style="font-family: SolaimanLipi !important;">
            <table class="formstyle" style ="width: 100%; margin-left: 0px; font-family: SolaimanLipi !important;">        
                <tr>
                    <th colspan="3">সেন্ড এমাউন্ট</th>
                </tr>
                <?php
                showMessage($flag, $msg);
                $transfer_type = "send";
                $sender_id = $_SESSION['userIDUser'];
                $sql_last_userAmountTransfer->execute(array($transfer_type, $sender_id));
                $row_last_amountTransfer = $sql_last_userAmountTransfer->fetchAll();
                foreach($row_last_amountTransfer as $rlat) $db_last_send = date("d-m-Y", strtotime ($rlat['trans_date_time']));
                $sql_userBalance->execute(array($sender_id));
                $row_user_balance = $sql_userBalance->fetchAll();
                foreach($row_user_balance as $rub) 
                    {
                    $db_total_balance = $rub['total_balanace'];
                    $db_last_withdrawl = date("d-m-Y", strtotime ($rub['last_withdrawl']));
                    }
                ?>
                <tr>
                    <td colspan="3">
                        <fieldset style="border: #686c70 solid 3px;width: 80%;margin-left: 10%;">
                            <legend style="color: brown;">একাউন্ট স্ট্যাটাস</legend>
                                <table width="100%" align="center" >
                                    <tr>
                                        <td style="text-align: right; width: 50%;"><b>টোটাল ব্যালেন্স :</b></td>
                                        <td style="width: 50%;padding-left: 0px;"><?php echo english2bangla($db_total_balance)." টাকা";?></td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: right;"><b>সর্বশেষ সেন্ড এমাউন্টের তারিখ :</b></td>
                                        <td style="padding-left: 0px;"><?php echo english2bangla($db_last_send);?></td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: right;"><b>শেষ উত্তোলনের তারিখ :</b></td>
                                        <td style="padding-left: 0px;"><?php echo english2bangla($db_last_withdrawl);?></td>
                                    </tr>
                                </table>
                        </fieldset>
                    </td>
                </tr>
                <tr>                    
                    <td style='text-align: center;' colspan='2'>
                        <input type='radio' name='charger' checked="checked" value="sender" onclick="chargeGivenBy(this.value)"/> চার্জ প্রেরকের &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <input type='radio' name='charger' value="receiver" onclick="chargeGivenBy(this.value)"/> চার্জ প্রাপকের
                    </td>
                </tr>
                <tr>
                    <td style="text-align: right; width: 50%;padding-left: 10px;">প্রাপকের মোবাইল নাম্বার</td>
                    <td style="text-align: left; width: 50%;">: <input  class="box" type="text" name="mobileNo" id="mobileNo" maxlength="11" onkeypress= "return numbersonly(event)" onblur= "validateMobile(this.value)" placeholder="01XXXXXXXXX"/><span id='mblValidationMsg'></span></td>
                </tr>
                <tr>
                    <td style="text-align: right;padding-left: 10px;">টাকার পরিমান</td>
                    <td>: <input  class="box" type="text" name="amount1"  id="amount1"  onkeypress="return checkIt(event)" /> টাকা </td>   
                </tr>
                 <tr>
                    <td style="text-align: right; padding-left: 10px;">টাকার পরিমান (পুনরায়)</td>
                    <td>: <input  class="box" type="text" name="amount2"  id="amount2"  onkeypress="return checkIt(event)" onblur="checkAmount(this.value);"/> টাকা 
                        </br><span id="errormsg"></span></td>   
                </tr>
                <tr>
                    <td style="text-align: right; padding-left: 10px;">সেন্ডের কারন</td>
                    <td> <textarea  class="box" type="text" name="trans_des"  id="trans_des" value=""></textarea></td>   
                </tr>
                <tr>
                    <td colspan="3" style="text-align: center"></br><input type="button" class="btn"  name="submit" id="submit" disabled value="ঠিক আছে" onclick="getPassword();" ></td>
                </tr>
                    <tr>
                    <td colspan="3" id="passwordbox"></td>
                </tr>
            </table>
        </form>
    </div>

<?php include_once 'includes/footer.php'; ?> 
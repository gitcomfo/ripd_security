<?php
error_reporting(0);
include_once 'includes/ConnectDB.inc';
include_once 'includes/header.php';
include_once 'includes/columnViewAccount.php';
include_once 'includes/connectionPDO.php';

?>
<?php
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
</script>
 
 <div class="columnSubmodule" style="font-size: 14px;">
    <form  action="" id="amountTransForm" method="post" style="font-family: SolaimanLipi !important;">
            <table class="formstyle" style ="width: 100%; margin-left: 0px; font-family: SolaimanLipi !important;">        
                <tr>
                    <th colspan="2">ব্যাক্তিগত অ্যামাউন্ট ট্রান্সফার</th>
                </tr>
                <?php showMessage($flag, $msg);?>
                <tr>
                    <td style="text-align: right; width: 37%;">অ্যাকাউন্ট নং</td>
                    <td>: <input  class="box" type="text" name="accountNo"  id="accountNo" value=""/> <em>(ইংরেজিতে লিখুন)</em></td>   
                </tr>
                <tr>
                    <td style="text-align: right;">টাকার পরিমান</td>
                    <td>: <input  class="box" type="text" name="amount1"  id="amount1"  onkeypress="return checkIt(event)" /> টাকা </td>   
                </tr>
                 <tr>
                    <td style="text-align: right;">টাকার পরিমান (পুনরায়)</td>
                    <td>: <input  class="box" type="text" name="amount2"  id="amount2"  onkeypress="return checkIt(event)" onblur="checkAmount(this.value);"/> টাকা <span id="errormsg"></span></td>   
                </tr>
                <tr>
                    <td style="text-align: right;">ট্রান্সফারের কারন</td>
                    <td> <textarea  class="box" type="text" name="trans_des"  id="trans_des" value=""></textarea></td>   
                </tr>
                <tr>
                    <td colspan="2" style="text-align: center"></br><input type="button" class="btn" name="submit" id="submit" value="ঠিক আছে" onclick="getPassword();" disabled=""></td>
                </tr>
                    <tr>
                    <td colspan="2" id="passwordbox"></td>
                </tr>
            </table>
        </form>
    </div>

<?php
include_once 'includes/footer.php';
?> 
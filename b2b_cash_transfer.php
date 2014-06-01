<?php
include_once 'includes/session.inc';
include_once 'includes/header.php';

$logedInUserID = $_SESSION['userIDUser'];
$logedInOfficeAcc = $_SESSION['loggedInOfficeAccNo'];

$ins_acc_ofc = $conn->prepare("INSERT INTO acc_ofc_physc_in (inamount, amount_status, sender_id,sender_office, office_id, sending_date)
                                                VALUES (?,'branch', ?,?,?, NOW()) ");
$insert_notification = $conn->prepare("INSERT INTO notification (nfc_senderid,nfc_receiverid,nfc_message,nfc_actionurl,nfc_date,nfc_status, nfc_type, nfc_catagory) 
                                                        VALUES (?,?,?,?,NOW(),?,?,?)");
$sel_onsID = $conn->prepare("SELECT idons_relation FROM ons_relation LEFT JOIN office ON add_ons_id = idOffice 
                                                WHERE catagory='office' AND account_number = ?");

if(isset($_POST['submit']))
{  
    $p_officeAccountNo = $_POST['acNo'];
    $p_amount = $_POST['t_in_amount'];

    $sel_onsID->execute(array($p_officeAccountNo));
    $offrow = $sel_onsID->fetchAll();
    foreach ($offrow as $value) {
       $office_ons_id = $value['idons_relation'];
    }
    
    $sel_onsID->execute(array($logedInOfficeAcc));
    $senderrow = $sel_onsID->fetchAll();
    foreach ($senderrow as $value) {
       $logedInOfficeonsID = $value['idons_relation'];
    }
    
    $conn->beginTransaction();
        $y1 = $ins_acc_ofc->execute(array($p_amount, $logedInUserID,$logedInOfficeonsID, $office_ons_id));
        $db_last_insert_id = $conn->lastInsertId();
        $msg = "টাকা প্রাপ্তি";
        $url = "b2b_cash_receive.php?id=".$db_last_insert_id;
        $status = "unread";
        $type="action";
        $nfc_catagory="official";
        $sqlrslt3 = $insert_notification->execute(array($logedInOfficeonsID,$office_ons_id,$msg,$url,$status,$type,$nfc_catagory));
        
    if ($y1 && $sqlrslt3) {
        $conn->commit();
         unset($_SESSION['arrFunds']);
         unset($_SESSION['arrCashinInfo']);
       echo "<script>alert('টাকা ট্র্যান্সফার করা হল')</script>";
    } else {
        $conn->rollBack();
        echo "<script>alert('টাকা ট্র্যান্সফার করা হয়নি')</script>";
    }
}
?>
<style type="text/css"> @import "css/bush.css";</style>
<script>
function numbersonly(e)
    {
        var unicode=e.charCode? e.charCode : e.keyCode
        if (unicode!=8)
        { //if the key isn't the backspace key (which we should allow)
            if (unicode<48||unicode>57) //if not a number
                return false //disable key press
        }
    }
function beforeSubmit()
{
    var what = document.querySelector('input[name = "officetype"]:checked').value;
    if ((what != "") 
            && (document.getElementById('t_in_amount').value != "")
            && (document.getElementById('t_in_amount').value != "0"))
        { return true; }
    else {
        alert("ফর্মের * বক্সগুলো সঠিকভাবে পূরণ করুন");
        return false; 
    }
}
</script>
<script>
    function getAccountInfo(acNo)
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
            if (xmlhttp.readyState==4 && xmlhttp.status==200)
            {
                document.getElementById('info').innerHTML=xmlhttp.responseText;
            }
        }
        var what = document.querySelector('input[name = "officetype"]:checked').value;
        xmlhttp.open("GET","includes/getAccountInfoForCashIn.php?acNo="+acNo+"&type=office&what="+what,true);
        xmlhttp.send();
    }

function checkAmount(amount)
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
            if (xmlhttp.readyState==4 && xmlhttp.status==200)
            {
                var status=xmlhttp.responseText;
                if(status != "")
                    {
                        alert("দুঃখিত, এই পরিমান টাকা বর্তমানে নেই");
                    }
            }
        }
        var acNo = <?php echo $logedInOfficeAcc;?>;
        xmlhttp.open("GET","includes/office_amount_check.php?acNo="+acNo+"&amount="+amount,true);
        xmlhttp.send();
    }
</script>

<div class="columnSld" style=" padding-left: 50px;">
    <div class="main_text_box">
        <div style="padding-left: 9px;"><a href="accounting_sys_management.php"><b>ফিরে যান</b></a></div>
        <div>           
            <form method="POST" onsubmit="return beforeSubmit();" action="">	
                <table  class="formstyle" style="width: 90%; margin: 1px 1px 1px 1px;">          
                    <tr><th colspan="2" style="text-align: center;font-size: 22px;">অন্য অফিস/ সেলসস্টোরে টাকা ট্রান্সফার</th></tr>
                    <tr>
                        <td>যেখানে টাকা দেয়া হবে</td>
                        <td>: <input type="radio" name="officetype" value="office" checked="" /> অফিস &nbsp;&nbsp;&nbsp;&nbsp;
                                 <input type="radio" name="officetype" value="s_store" /> সেলসস্টোর<em2> *</em2></td>          
                    </tr>
                    <tr>
                        <td >অফিস/ সেলসস্টোরের একাউন্ট নাম্বার</td>
                        <td>: <input class="box" type="text" id="acNo" name="acNo" maxlength="15" onblur="getAccountInfo(this.value)" /><em2> *</em2></td>          
                    </tr>
                    <tr>
                        <td>অফিস/ সেলসস্টোরের নাম</td>
                        <td id="info"></td>
                    </tr>
                    <tr>
                        <td >মোট পরিমান</td>
                        <td>: <input class="box" type="text" id="t_in_amount" name="t_in_amount" onkeypress=' return numbersonly(event)' onkeyup="checkAmount(this.value)" /><em2> *</em2> TK</td>          
                    </tr>
                    <tr>                    
                        <td colspan="2" style="text-align: center; " ><input class="btn" style =" font-size: 12px; " type="submit" name="submit" value="ঠিক আছে" /></td>                           
                    </tr>    
                </table>
                </fieldset>
            </form>
        </div>
    </div>
</div>
<?php include_once 'includes/footer.php'; ?>
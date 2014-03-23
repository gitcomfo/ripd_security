<?php
include 'includes/session.inc';
include_once 'includes/header.php';
include_once 'includes/MiscFunctions.php';

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
    if ((document.getElementById('acNo').value != "") 
            && (document.getElementById('acName').value != "")
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
        xmlhttp.open("GET","includes/getAccountInfoForCashIn.php?acNo="+acNo+"&type=personal",true);
        xmlhttp.send();
    }
</script>

<div class="columnSld" style=" padding-left: 50px;">
    <div class="main_text_box">
        <div style="padding-left: 9px;"><a href="accounting_sys_management.php"><b>ফিরে যান</b></a></div>
        <div>           
            <form method="POST" onsubmit="return beforeSubmit();" action="cash_in.php">	
                <table  class="formstyle" style="width: 90%; margin: 1px 1px 1px 1px;">          
                    <tr><th colspan="2" style="text-align: center;">ক্যাশ ইন</th></tr>
                    <tr>
                        <td>একাউন্ট নাম্বার</td>
                        <td>: <input class="box" type="text" id="acNo" name="acNo" maxlength="15" onblur="getAccountInfo(this.value)" /><em2> *</em2></td>
                    </tr>
                    <tr>
                        <td colspan="2" id="info" style="padding-left: 0px !important;"></td>
                    </tr>
                    <tr>
                        <td >টোটাল ইন এ্যামাউন্ট</td>
                        <td>: <input class="box" type="text" id="t_in_amount" name="t_in_amount" onkeypress=' return numbersonly(event)' /><em2> *</em2> TK</td>          
                    </tr> 
                    <tr> 
                        <td>কারন</td>
                        <td> <textarea name="inDescription" ></textarea></td>           
                    </tr>
                    <tr>                    
                        <td colspan="2" style="text-align: center; " ><input class="btn" style =" font-size: 12px; " type="submit" name="cash_in" value="ক্যাশ ইন করুন" /></td>                           
                    </tr>    
                </table>
                </fieldset>
            </form>
        </div>
    </div>
</div>
<?php include 'includes/footer.php'; ?>
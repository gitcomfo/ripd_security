<?php
include 'includes/header.php';
include_once 'includes/MiscFunctions.php';

if(isset($_POST['submit']))
{
    
}
?>

<style type="text/css"> @import "css/bush.css";</style>
<link href="css/print.css" rel="stylesheet" type="text/css" media="print"/>
<script type="text/javascript">
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
        var amount = document.getElementById('amount').value;
        if(amount != checkvalue) 
                {
                document.getElementById('amount_rep').focus();
                document.getElementById('errormsg').style.color='red';
                document.getElementById('errormsg').innerHTML = "পরিমান সঠিক হয় নি";
                }
        else
                {
                    document.getElementById('errormsg').style.color='green';
                    document.getElementById('errormsg').innerHTML="OK";
                    document.getElementById('view').disabled= false;  
                }
        }
function viewCheque()
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
            document.getElementById('viewCheque').innerHTML=xmlhttp.responseText;
        }
        var amount = document.getElementById('amount_rep').value;
        xmlhttp.open("GET","includes/cheque.php?amount="+amount,true);
        xmlhttp.send();	
}
</script>

    <div class="main_text_box">
        <div id="noprint" style="padding-left: 110px;"><a href=""><b>ফিরে যান</b></a></div>
        <div>           
            <form method="POST" onsubmit="" name="cheque" action="">	
                <table  class="formstyle" style="width: 80%;font-family: SolaimanLipi !important; font-size: 14px;">          
                    <tr id="noprint"><th colspan="2" style="text-align: center;font-size: 16px;">ব্যক্তিগত টাকা উত্তোলনের চেক</th></tr>
                    <tr id="noprint">
                        <td style="text-align: right;width: 50%;">মোট এমাউন্ট</td>
                        <td style="text-align: left;width: 50%;"><input class="box" type="text" readonly="" /> টাকা</td>
                    </tr>
                    <tr id="noprint">
                        <td style="text-align: right;">টাকা উত্তোলনের পরিমান</td>
                        <td style="text-align: left;"><input class="box" id='amount' type="text" onkeypress="return checkIt(event);" /> টাকা</td>
                    </tr>
                    <tr id="noprint">
                        <td style="text-align: right;">টাকা উত্তোলনের পরিমান (পুনরায়)</td>
                        <td style="text-align: left;"><input class="box" id="amount_rep" type="text" onkeypress="return checkIt(event);" onblur="checkAmount(this.value);"  /> টাকা <span id="errormsg"></span></td>
                    </tr>
                    <tr>
                        <td id="noprint" colspan="2" style="text-align: center;" ></br><input class="btn" style =" font-size: 12px; " id='view' disabled="" type="button" value="চেক দেখুন" onclick="viewCheque()" /></td>
                    </tr>
                    <tr>
                        <td colspan="2" style="text-align: center;" id="viewCheque"></td>
                    </tr>
                    <tr>                    
                        <td id="noprint" colspan="2" style="text-align: center; " ><input class="btn" style =" font-size: 12px; width: 150px;" type="submit" name="save_cheque" value="মেইক চেক এন্ড প্রিন্ট " /></td>                           
                    </tr>    
                </table>
                </fieldset>
            </form>
        </div>
    </div>
<?php include 'includes/footer.php'; ?>
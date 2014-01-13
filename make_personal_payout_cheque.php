<?php
include 'includes/header.php';
include_once 'includes/MiscFunctions.php';
include_once 'includes/selectQueryPDO.php';
include_once 'includes/insertQueryPDO.php';
?>
<style type="text/css"> @import "css/bush.css";</style>
<link href="css/print.css" rel="stylesheet" type="text/css" media="print"/>
<?php

if (isset($_POST['save_cheque'])) {
    $p_amount = $_POST['amount'];
    $p_desc = $_POST['amount_desc'];
    $accountnumber = $_SESSION['personalAccNo'];
    $accountname = $_SESSION['acc_holder_name'];
    $cheque_no = getChequeNo();
    $takaInWords = convert_number($p_amount);

    echo "</br><div id='cheque' style='width: 574px; height: 320px; font-size:12px; border: blue solid 1px; margin: 0 auto; background-image: url(images/cheque.gif);background-repeat: no-repeat;background-size:100% 320px;'>
                 <div style='width: 558px;height: 70px;float: left;padding-left: 15px; background-image: url(images/background.gif);background-repeat: no-repeat;background-size:100% 70px;'></div>
                 <div id='cheque_body' style='width: 570px;float: left;padding-left: 2px;'>
                        <div style='width: 570px;float: left;'>
                               <div id='cheque_dateTime' style='text-align:left; width: 280px;float: left'><b>তারিখ :</b> "; echo date("d.m.y");echo "&nbsp;&nbsp;&nbsp;&nbsp;<b>সময় :</b> ";echo date('g:i a' , strtotime('+5 hour'));echo"</div>
                               <div id='cheque_no' style='text-align: right;width: 290px;float: left;'><b>চেক নাম্বার :</b> <input type='text'readonly='' style='width: 200px;' value='$cheque_no' /></div>
                         </div></br></br>
                          <div style='text-align: left;'><span><b>টাকার পরিমাণ :</b> <input type='text' readonly='' style='width:200px;text-align:right;padding:0px 2px;' value='$p_amount' /> TK</span></div>
                          <div id='amount_in_words' style='text-align: left;'><span><b>টাকার পরিমাণ (কথায়) :</b></span>$takaInWords Taka only.</div></br>
                          <div style='text-align: left;'><span><b>অ্যাকাউন্ট নং  :</b></span><input type='text' readonly style='width:200px;padding:0px 2px;' value='$accountnumber' /></div></br>
                              <div style='text-align: left;'><span><b>অ্যাকাউন্টের নাম :</b></span><input type='text' readonly style='width:200px;padding:0px 2px;' value='$accountname' /></div>
                          <div style='float: right;height: 20px;padding-top: 10px;text-align: right;'><input type='text' readonly style='width:230px;' /><hr style='width:230px; height: 2px; background-color: black;'/> এখানে স্বাক্ষর করুন&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>
                  </div>
             </div></br>";
       $sql_insert_cheque_making->execute(array($cheque_no, "out", $p_desc, $p_amount, $_SESSION['userIDUser'], "made"));                             
echo '<script> window.print(); </script>';
} else {
    
?>


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
        var amount = document.getElementById('amount').value;
        var amount1 = document.getElementById('amount');
        var amount2 = document.getElementById('amount_rep');
        if(amount1.value.length == 0 || amount2.value.length == 0){
            document.getElementById('errormsg').style.color='red';
            document.getElementById('errormsg').innerHTML = "পরিমানের ঘরটি খালি";
        } else if(amount != checkvalue) 
        {
            document.getElementById('errormsg').style.color='red';
            document.getElementById('errormsg').innerHTML = "পরিমান সঠিক হয় নি";
        } else {
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
    <div id="noprint" style="padding-left: 110px;"><a href="personal_accounting_balance.php"><b>ফিরে যান</b></a></div>
    <div>           
        <form method="POST" onsubmit="" name="cheque" action="">	
            <table  class="formstyle" style="width: 80%;font-family: SolaimanLipi !important; font-size: 14px;">          
                <tr id="noprint"><th colspan="2" style="text-align: center;font-size: 16px;">ব্যক্তিগত টাকা উত্তোলনের চেক</th></tr>
                <tr id="noprint">
                    <td colspan="2">
                        <?php
                        $cheque_type = "out";
                        $sender_id = $_SESSION['userIDUser'];
                        $sql_select_last_cheque_making->execute(array($cheque_type, $sender_id));
                        $row_last_cheque_making_date = $sql_select_last_cheque_making->fetchAll();
                        foreach ($row_last_cheque_making_date as $rlat)
                            $db_last_cheque_make_date = date("d-m-Y", strtotime($rlat['cheque_mak_datetime']));
                        $sql_userBalance->execute(array($sender_id));
                        $row_user_balance = $sql_userBalance->fetchAll();
                        foreach ($row_user_balance as $rub) {
                            $db_total_balance = $rub['total_balanace'];
                            $db_last_withdrawl = date("d-m-Y", strtotime($rub['last_withdrawl']));
                        }
                        ?>
                        <fieldset style="border: #686c70 solid 3px;width: 80%;margin-left: 10%;">
                            <legend style="color: brown;">একাউন্ট স্ট্যাটাস</legend>
                            <table width="100%" align="center" >
                                <tr>
                                    <td style="text-align: right; width: 50%;"><b>টোটাল ব্যালেন্স :</b></td>
                                    <td style="width: 50%;padding-left: 0px;"><?php echo english2bangla($db_total_balance) . " টাকা"; ?></td>
                                </tr>
                                <tr>
                                    <td style="text-align: right;"><b>সর্বশেষ চেক তৈরির তারিখ :</b></td>
                                    <td style="padding-left: 0px;"><?php echo english2bangla($db_last_cheque_make_date); ?></td>
                                </tr>
                                <tr>
                                    <td style="text-align: right;"><b>শেষ উত্তোলনের তারিখ :</b></td>
                                    <td style="padding-left: 0px;"><?php echo english2bangla($db_last_withdrawl); ?></td>
                                </tr>
                            </table>
                        </fieldset>
                    </td>
                </tr>
                <tr id="noprint">
                    <td style="text-align: right;">টাকা উত্তোলনের পরিমান</td>
                    <td style="text-align: left;"><input class="box" id='amount' type="text" onkeypress="return numbersonly(event);" /> টাকা</td>
                </tr>
                <tr id="noprint">
                    <td style="text-align: right;">টাকা উত্তোলনের পরিমান (পুনরায়)</td>
                    <td style="text-align: left;"><input class="box" id="amount_rep" name="amount" type="text" onkeypress="return numbersonly(event);" onblur="checkAmount(this.value);"  /> টাকা <span id="errormsg"></span></td>
                </tr>
                <tr id="noprint">
                    <td style="text-align: right;">বর্ণনা</td>
                    <td style="text-align: left;"><textarea name="amount_desc"></textarea></td>
                </tr>
                <tr>
                    <td id="noprint" colspan="2" style="text-align: center;" ></br><input class="btn" style =" font-size: 12px; " id='view' disabled="" type="button" value="চেক দেখুন" onclick="viewCheque()" /></td>
                </tr>
                <tr>
                    <td colspan="2" style="text-align: center;" id="viewCheque"></td>
                </tr>
                <tr>                    
                    <td id="noprint" colspan="2" style="text-align: center; " ><input class="btn" style =" font-size: 12px; width: 150px;" type="submit" name="save_cheque" value="মেইক চেক এন্ড প্রিন্ট " />                           
                </tr>    
            </table>
            </fieldset>
        </form>
    </div>
</div>
<?php }
include 'includes/footer.php'; ?>
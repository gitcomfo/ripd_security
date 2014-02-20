<?php
include 'includes/session.inc';
include_once 'includes/header.php';
include_once 'includes/MiscFunctions.php';
$sql = $conn->prepare("SELECT * FROM main_fund ORDER BY fund_name");
$sel_banks = $conn->prepare("SELECT * FROM bank_list ORDER BY bank_name");
function getFunds($sql)
{
    echo "<option value= 0> -সিলেক্ট করুন- </option>";
    $sql->execute(array());
    $arr_fund = $sql->fetchAll();
    foreach ($arr_fund as $fundrow) {
        echo "<option value=".$fundrow['idmainfund'].">". $fundrow['fund_name'] ."</option>";
    }
}
function getBanks($sql)
{
     echo "<option value= 0> -সিলেক্ট করুন- </option>";
    $sql->execute(array());
    $arr_bank = $sql->fetchAll();
    foreach ($arr_bank as $bankrow) {
        echo "<option value=".$bankrow['idbank'].">". $bankrow['bank_name'] ."</option>";
    }
}
?>
<style type="text/css"> @import "css/bush.css";</style>
<script type="text/javascript" src="javascripts/jquery-1.4.3.min.js"></script>
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
    var radiocheck = 0;
      var radios = document.getElementsByName("cashInType");
      for(var i=0; i<radios.length; i++){
	if(radios[i].checked) { radiocheck = 1; }
	}
    if ((document.getElementById('acNo').value != "")
            && (document.getElementById('t_in_amount').value != "")
            && (document.getElementById('t_in_amount').value != "0")
            && (radiocheck == 1)
            && (document.getElementById('t_in_amount').value == document.getElementById('totalGivenAmount').value))
        { return true; }
    else {
        alert("ফর্মের * বক্সগুলো সঠিকভাবে পূরণ করুন");
        return false; 
    }
}
function showBox(classname)
{
    elements = $(classname);
    elements.each(function() { 
        $(this).css("visibility","visible"); 
    });
}
function hideBox(classname)
{
    elements = $(classname);
    elements.each(function() { 
        $(this).css("visibility","hidden"); 
    });
}
function checkBalance(qty,i)
{
    var totalbalance = Number(document.getElementById("balanceAmount["+i+"]").value);
    if(Number(qty) > totalbalance)
        {
            document.getElementById("inAmount["+i+"]").value = "";
            document.getElementById('totalGivenAmount').value = "0";
            alert("দুঃখিত,পরিমান অতিক্রম করেছে");
        }
        else{
            var givenAmount = 0;
            for (var j=1;j<=document.getElementsByName('inAmount[]').length;j++){
                givenAmount = givenAmount + Number(document.getElementById('inAmount['+j+']').value);
            }
            document.getElementById('totalGivenAmount').value = givenAmount;
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
        xmlhttp.open("GET","includes/getAccountInfoForCashIn.php?acNo="+acNo+"&type=office",true);
        xmlhttp.send();
    }
function setFund(fundID)
{
    var officeAcc = document.getElementById("acNo").value;
    var totalAmount = document.getElementById("t_in_amount").value;
    var officeName = document.getElementById("info").innerHTML;

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
           location.reload();
       }
   }
   xmlhttp.open("GET","includes/fund_includes.php?fundID="+fundID+"&type=2&offAcc="+officeAcc+"&totalAmount="+totalAmount+"&offname="+officeName,true);
   xmlhttp.send();
}
</script>

<div class="columnSld" style=" padding-left: 50px;">
    <div class="main_text_box">
        <div style="padding-left: 9px;"><a href="accounting_sys_management.php"><b>ফিরে যান</b></a></div>
        <div>           
            <form method="POST" onsubmit="return beforeSubmit('<?php echo count($_SESSION['arrFunds'])?>')" action="">	
                <table  class="formstyle" style="width: 90%; margin: 1px 1px 1px 1px;">          
                    <tr><th colspan="2" style="text-align: center;font-size: 22px;">অফিস / সেলসস্টোরে টাকা প্রদান</th></tr>
                    <?php
                            foreach ($_SESSION['arrCashinInfo'] as $value) {
                           $officeAccontNo = $value[0];
                           $totalAmount = $value[1];
                           $officeName = $value[2];
                       }
                    ?>
                    <tr>
                        <td >অফিসের একাউন্ট নাম্বার</td>
                        <td>: <input class="box" type="text" id="acNo" name="acNo" maxlength="15" onblur="getAccountInfo(this.value)" value="<?php echo $officeAccontNo;?>" /><em2> *</em2></td>          
                    </tr>
                    <tr>
                        <td>অফিসের নাম</td>
                        <td id="info"><?php echo $officeName;?></td>
                    </tr>
                    <tr>
                        <td >মোট পরিমান</td>
                        <td>: <input class="box" type="text" id="t_in_amount" name="t_in_amount" onkeypress=' return numbersonly(event)' value="<?php echo $totalAmount;?>" /><em2> *</em2> TK</td>          
                    </tr>
                    <tr>
                        <td >পদ্ধতি</td>
                        <td>: <input type="radio" name="cashInType" value="cash" onclick="hideBox('.bank')" /> ক্যাশ &nbsp;&nbsp;&nbsp;&nbsp;
                                 <input type="radio" name="cashInType" value="cheque" onclick="showBox('.bank')" /> চেক<em2> *</em2></td>          
                    </tr>
                    <tr class="bank" style="visibility: hidden;">
                        <td >ব্যাংক</td>
                        <td>: <select class="box" name="bankName">
                                <?php getBanks($sel_banks);?>
                            </select></td>          
                    </tr>
                    <tr class="bank" style="visibility: hidden;">
                        <td >চেক নং</td>
                        <td>: <input class="box" type="text" name="chequeNo" value="0"/> 
                    </tr>
                    <tr>
                        <td >ফান্ড</td>
                        <td>: <select class="box" name="fromfund" id="fromfund" onchange="setFund(this.value);">
                                <?php getFunds($sql);?>
                            </select><em2> *</em2></td>          
                    </tr>
                    <tr>
                        <td colspan="2">
                            <table cellspacing="0">
                                <tr id="table_row_odd">
                                    <td style="border: 1px solid black;">ফান্ড </td>
                                    <td style="border: 1px solid black;">মোট টাকার পরিমান</td>
                                    <td style="border: 1px solid black;">টাকা প্রদানের পরিমান</td>
                                    <td style="border: 1px solid black;"></td>
                                </tr>
                                <?php
                                        $sl = 1;
                                        $url= urlencode($_SERVER['REQUEST_URI']);
                                         foreach ($_SESSION['arrFunds'] as $key => $row) {
                                        echo '<tr>';
                                        echo '<td >' . $row[0] . '</td>';
                                        echo '<td><input class="box" id="balanceAmount['.$sl.']" value="' . $row[1].'" style="text-align:right" /> টাকা</td>';
                                        echo "<td><input class='box' name='inAmount[]' id='inAmount[$sl]' onkeyup='checkBalance(this.value,$sl)' style='text-align:right' /> টাকা</td>";
                                        echo '<td style="text-align:center"><a href="includes/fund_includes.php?delete=1&id='.$key.'&url='.$url.'"><img src="images/del.png" style="cursor:pointer;" width="20px" height="20px" /></a></td>';
                                        echo '</tr>';
                                        $sl++;
                                    }
                                ?>
                                <tr>
                                    <td colspan="4"><hr/></td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="text-align: right">মোট টাকা</td>
                                    <td><input class="box" name="totalGivenAmount" id="totalGivenAmount" value="0" style="text-align: right;" readonly=""  /> টাকা</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>                    
                        <td colspan="2" style="text-align: center; " ><br/><input class="btn" style =" font-size: 12px; " type="submit" name="submit" value="টাকা প্রদান করুন" /></td>                           
                    </tr>    
                </table>
                </fieldset>
            </form>
        </div>
    </div>
</div>
<?php
include 'includes/footer.php';
?>
<?php
include 'includes/session.inc';
include_once 'includes/header.php';
include_once 'includes/MiscFunctions.php';
$sql = $conn->prepare("SELECT * FROM main_fund ORDER BY fund_name");
function getFunds($sql)
{
    echo "<option value= 0> -সিলেক্ট করুন- </option>";
    $sql->execute(array());
    $arr_fund = $sql->fetchAll();
    foreach ($arr_fund as $fundrow) {
        echo "<option value=".$fundrow['idmainfund'].">". $fundrow['fund_name'] ."</option>";
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
    if ((document.getElementById('fund').value != "0") 
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
function setFund(fundID)
{
    alert(fundID);
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
   xmlhttp.open("GET","includes/fund_includes.php?fundID="+fundID+"&type=2",true);
   xmlhttp.send();
}
</script>

<div class="columnSld" style=" padding-left: 50px;">
    <div class="main_text_box">
        <div style="padding-left: 9px;"><a href="accounting_sys_management.php"><b>ফিরে যান</b></a></div>
        <div>           
            <form method="POST" onsubmit="return beforeSubmit();" action="">	
                <table  class="formstyle" style="width: 90%; margin: 1px 1px 1px 1px;">          
                    <tr><th colspan="2" style="text-align: center;font-size: 22px;">অফিস / সেলসস্টোরে টাকা প্রদান</th></tr>
                    <tr>
                        <td>যেখানে টাকা দেয়া হবে</td>
                        <td>: <input type="radio" name="officetype" value="office" /> অফিস &nbsp;&nbsp;&nbsp;&nbsp;
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
                        <td>: <input class="box" type="text" id="t_in_amount" name="t_in_amount" onkeypress=' return numbersonly(event)' /><em2> *</em2> TK</td>          
                    </tr>
                    <tr>
                        <td >পদ্ধতি</td>
                        <td>: <input type="radio" name="cashInType" value="cash" /> ক্যাশ &nbsp;&nbsp;&nbsp;&nbsp;
                                 <input type="radio" name="cashInType" value="cheque" /> চেক<em2> *</em2></td>          
                    </tr> 
                    <tr> 
                        <td>কারন</td>
                        <td> <textarea name="inDescription" ></textarea></td>           
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
                                $url= urlencode($_SERVER['REQUEST_URI']);
                                 foreach ($_SESSION['arrFunds'] as $key => $row) {
                                echo '<tr>';
                                echo '<td >' . $row[0] . '</td>';
                                echo '<td>' . $row[1].' টাকা</td>';
                                echo '<td><input class="box" name="inAmount[]" /> টাকা</td>';
                                echo '<td style="text-align:center"><a href="includes/fund_includes.php?delete=1&id='.$key.'&url='.$url.'"><img src="images/del.png" style="cursor:pointer;" width="20px" height="20px" /></a></td>';
                                echo '</tr>';
                            }
                        ?>
                            </table>
                        </td>
                    </tr>
                    <tr>                    
                        <td colspan="2" style="text-align: center; " ><input class="btn" style =" font-size: 12px; " type="submit" name="submit" value="টাকা প্রদান করুন" /></td>                           
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
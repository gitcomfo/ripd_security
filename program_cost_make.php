<?php
error_reporting(0);
include_once 'includes/session.inc';
include_once 'includes/header.php';
include_once 'includes/MiscFunctions.php';

if(isset($_POST['submit']))
{
    $t_prize=$_POST['ticket_prize'];
    $seat=$_POST['number_of_seat'];
    $xtra_seat=$_POST['extra_seat'];
    $programID=$_POST['programID'];
    $programname=$_POST['programName'];
    $date=$_POST['programDate'];
    $time=$_POST['programTime'];
    $employee_name=$_POST['emp_name'];
    $employee_mail = $_POST['emp_mail'];
    $P_description = $_POST['description'];
    $P_type = $_POST['type'];
    
    $pupsql = "UPDATE `program` SET `total_seat` = '$seat',`extra_seat` = '$xtra_seat', `ticket_prize` = '$t_prize', `subject`= '$P_description' WHERE `program`.`idprogram` = '$programID' ;";
    $pusresult=mysql_query($pupsql) or exit('query failed: '.mysql_error());
    $msg = " টিকেটটি সফলভাবে তৈরি হয়েছে " ;
}
?>

<style type="text/css">@import "css/bush.css";</style>
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
   function checkIt(evt) // float value-er jonno***********************
    {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode ==8 || (charCode >47 && charCode <58) || charCode==46) {
        status = "";
        return true;
    }
    status = "This field accepts numbers only.";
    return false;
}
function setProgram(progNo,progid)
{
        document.getElementById('prgrm_number').value = progNo;
        document.getElementById('prgrm_id').value = progid;
        document.getElementById('progResult').style.display = "none";
        getall(progid);
}
     function beforeSubmit(){
    if ((document.getElementById('prgrm_number').value !="")
    && (document.getElementById('ticket_prize').value !="")
    && (document.getElementById('number_of_seat').value !="")
    && (document.getElementById('extra_seat').value !=""))
        { return true; }
    else {
        alert("ফর্মের * বক্সগুলো সঠিকভাবে পূরণ করুন");
        return false; 
    }
}
</script>
<script  type="text/javascript">
    function getname(type)
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
                document.getElementById('p_name').innerHTML=xmlhttp.responseText;
                
            }
        }
        xmlhttp.open("GET","includes/getPresentations.php?t="+type,true);
        xmlhttp.send();
    }
    
    function getall(val)
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
                document.getElementById('pall').innerHTML=xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET","includes/getPresentations.php?v="+val,true);
        xmlhttp.send();
    }

function getProgram(key)
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
            if(key.length ==0)
                {
                   document.getElementById('progResult').style.display = "none";
               }
                else
                    {document.getElementById('progResult').style.visibility = "visible";
                document.getElementById('progResult').setAttribute('style','position:absolute;top:38%;left:62.2%;width:250px;z-index:10;border: 1px inset black; overflow:auto; height:105px; background-color:#F5F5FF;');
                    }
                document.getElementById('progResult').innerHTML=xmlhttp.responseText;
        }
        xmlhttp.open("GET","includes/getPrograms.php?key="+key,true);
        xmlhttp.send();	
}
</script>

<div class="column6">
    <div class="main_text_box">
        <div style="padding-left: 110px;"><a href="program_management.php"><b>ফিরে যান</b></a></div> 
        <div>
            <form method="POST" onsubmit="return beforeSubmit()" action="making_ticket.php?step=02">	
                <table  class="formstyle" style="font-family: SolaimanLipi !important;">          
                    <tr><th colspan="4" style="text-align: center;">বাজেট তৈরি</th></tr>
                    <tr>
                        <td colspan="2"><?php if($msg!=""){echo $msg; } ?></td>
                    </tr>
                    <tr>
                        <td>প্রেজেন্টেশন / প্রোগ্রাম / ট্রেইনিং / ট্রাভেল এর নম্বর</td>
                        <td>:  <input class="box" type="text" id="prgrm_number" name="prgrm_number" onkeyup="getProgram(this.value);"/><em2> *</em2>
                            <div id="progResult"></div><input type="hidden" name="prgrm_id" id="prgrm_id"/>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" id="pall">
                        </td>
                    </tr>
                    <tr>
                        <td>সম্ভাব্য বাজেট</td>
                        <td>: <input  class="box" type="text" id="budget" name="budget" onkeypress=' return numbersonly(event)'  /> টাকা<em2> *</em2></td>
                    </tr>
                    <tr>
                        <td>প্রয়োজনীয় টাকার পরিমান</td>
                        <td>: <input  class="box" type="text" id="need_amount" name="need_amount" onkeypress=' return numbersonly(event)'  /> টাকা<em2> *</em2></td>
                    </tr>
                    <tr>                    
                        <td colspan="2" style="padding-left: 300px; padding-top: 10px; " ><input class="btn" style =" font-size: 12px; " type="submit" name="submit" value="বাজেট করুন" /></td>
                    </tr>    
                </table>
            </form>
        </div>
    </div>      
</div>
<?php include 'includes/footer.php'; ?>
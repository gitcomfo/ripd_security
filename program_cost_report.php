<?php
error_reporting(0);
//include_once 'includes/session.inc';
include_once 'includes/header.php';
include_once 'includes/MiscFunctions.php';

$userID = $_SESSION['userIDUser'];
$sel_cfs = mysql_query("SELECT * FROM cfs_user WHERE idUser = $userID");
$cfsrow = mysql_fetch_assoc($sel_cfs);
$sqlerror="";$str_emp_name="";$str_emp_email="";
?>

<link href="css/bush.css" rel="stylesheet" type="text/css"/>
<link href="css/print.css" rel="stylesheet" type="text/css" media="print"/>
<link rel="stylesheet" href="css/tinybox.css" type="text/css" media="screen" charset="utf-8"/>
<script src="javascripts/tinybox.js" type="text/javascript"></script>
<script type="text/javascript">
    function showProgReport(progID)
    {
        { TINY.box.show({url:'show_report.php?progid='+progID,animate:true,close:true,boxid:'success',top:100,width:600,height:400}); }
    }
</script>
<script  type="text/javascript">
function showTotal(ticket_prize)
    {
        var seat = countCheckboxes();
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
                document.getElementById('prize').innerHTML=xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET","includes/getTotal.php?ticketTotal="+ticket_prize+"&seat="+seat,true);
        xmlhttp.send();
    }
function getList(type)
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
           document.getElementById('list').innerHTML=xmlhttp.responseText;
        }
        xmlhttp.open("GET","includes/getPrograms.php?type="+type+"&report=1",true);
        xmlhttp.send();	
}
function  checkCorrectPass(passwrd) // match password with account
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
                        document.getElementById('passmsg').style.color='red';
                        document.getElementById("passmsg").innerHTML=xmlhttp.responseText;                      
                        }
                }
        xmlhttp.open("GET","includes/matchPassword.php?pass="+passwrd,true);
        xmlhttp.send();
  }
</script>

    <div class="column6">
        <div class="main_text_box">
            <div style="padding-left: 110px;"><a href="program_management.php"><b>ফিরে যান</b></a></div> 
            <div>	
                    <table  class="formstyle" style="font-family: SolaimanLipi !important;">          
                        <tr><th colspan="4" style="text-align: center;font-size: 22px;">বাজেট রিপোর্ট</th></tr>
                        <tr>
                            <td style="width: 40%">প্রেজেন্টেশন / প্রোগ্রাম / ট্রেইনিং / ট্রাভেল</td>
                            <td>: <select class="selectOption" name="type" id="type" onchange="getList(this.value)" style="width: 170px !important;">
                                    <option value=" ">----টাইপ সিলেক্ট করুন-----</option>
                                    <option value="presentation">প্রেজেন্টেশন</option>
                                    <option value="program">প্রোগ্রাম</option>
                                    <option value="training">ট্রেইনিং</option>
                                    <option value="travel">ট্রাভেল</option>
                                </select></br></br>  
                            </td>      
                        </tr>
                        <tr>
                            <td colspan="2" id="list"></td>
                        </tr>
                    </table>
            </div>
        </div>      
    </div>
<?php include 'includes/footer.php';?>
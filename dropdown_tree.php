<?php
error_reporting(0);
include_once 'includes/MiscFunctions.php';
include 'includes/ConnectDB.inc';
include 'includes/header.php';

function showList($sl)
{
     echo '<li><div id="left" style="height:auto;width:350px;opacity:0;position: absolute;left:-999999px;">
                                            <div style="float:left;border:1px solid black;background-color:cornsilk;width:80%">
                                                <table>
                                                <tr><td colspan="2" style="border:1px solid black;"><img src="<?php echo $osign;?>" width="50px" height="50px"/></td></tr>
                                                <tr><td colspan="2" style="border:1px solid black;">স্টেপ পজিসন</td></tr>
                                                <tr><td colspan="2" style="border:1px solid black;"><a href="#" style="width:100%; background-color:none;">ইন</a></td></tr>
                                                <tr><td style="border:1px solid black;">অ্যাকাউন্ট নং </td><td style="border:1px solid black;">dd-3428u4-jdh</td></tr>
                                                <tr><td style="border:1px solid black;">মোবাইল নং </td><td style="border:1px solid black;">0128394372</td></tr>
                                                <tr><td colspan="2" style="border:1px solid black;">রেফারকারির নাম </td></tr>
                                                <tr><td style="border:1px solid black;">আর ১</td><td style="border:1px solid black;">৭</td></tr>
                                                <tr><td style="border:1px solid black;">আর ২</td><td style="border:1px solid black;">৩৪</td></tr>
                                                <tr><td style="border:1px solid black;">আর ৩</td><td style="border:1px solid black;">৫৩২</td></tr>
                                                <tr><td style="border:1px solid black;">আর ৪</td><td style="border:1px solid black;">১৩৪৩</td></tr>
                                                <tr><td style="border:1px solid black;">আর ৫</td><td style="border:1px solid black;">৩৫৪৩১৩৪</td></tr>
                                                </table>
                                            </div>
                                            <div style="width:15%;height:25px;float:left; text-align:right;background-image: url(images/left.png); background-size: 100% 100%;background-repeat: no-repeat;"></div>
                    </div>
                   <a id="target" onmouseover="showspecifics('.$sl.')" ><b>রেফারার -১  নাম</b></a>
                    <div id="ri8" style="height:auto;width:330px;opacity:0;position: absolute;left:-999999px;">
                        <div style="width:15%;height:25px;float:left; text-align:right;background-image: url(images/right.png); background-size: 100% 100%;background-repeat: no-repeat;"></div>                                            
                        <div style="float:left;background-color:red;width:80%">
                            <div class="treeButton" style="width:80%;">
                                <ul>
                                <li><a><b>অ্যাকাউন্টধারীর নাম</b></a>
                                    <ul></ul>
                                </li>
                                </ul>
                                </div>
                        </div>                                            
                    </div></li>';
}
?>
<title>ড্রপডাউন ট্রি</title>
<style type="text/css"> @import "css/bush.css";</style>
<link rel="stylesheet" href="css/style.css" type="text/css" media="screen" charset="utf-8"/>
<link rel="stylesheet" href="css/css.css" type="text/css" media="screen" />
<script type="text/javascript" src="javascripts/jquery-1.10.2.min.js"></script>
<script>

    var fieldName='chkName[]';
    function numbersonly(e)
   {
        var unicode=e.charCode? e.charCode : e.keyCode
            if (unicode!=8)
            { //if the key isn't the backspace key (which we should allow)
                if (unicode<48||unicode>57) //if not a number
                return false //disable key press
            }
}
window.onclick = function()
    {
        new JsDatePick({
            useMode: 2,
            target: "date",
            dateFormat: "%Y-%m-%d"
        });
    }
</script>
<script>
     function showall()
    {
        document.getElementById('stepBYstep').style.opacity = 1
    }
    function hideall()
    {
        document.getElementById('stepBYstep').style.opacity = 0
    }
    function showspecifics(index)
    {
        document.getElementById('left').style.opacity = 1;
         document.getElementById('left').style.left = "-331px";
        var topposition = ((document.getElementById("target").offsetHeight * index)+(5*index))+"px";
        document.getElementById('left').style.top = topposition;
        document.getElementById('ri8').style.opacity = 1;
         document.getElementById('ri8').style.left = "298px";
        document.getElementById('ri8').style.top = topposition;
    }
    function hideIT()
    {
        document.getElementById('left').style.opacity = 0;
        document.getElementById('ri8').style.opacity = 0;
    }
</script>

<div class="column6" style="width: 100% !important;">
    <div class="main_text_box" style="width: 100% !important;height: 500px;">
        <div style="padding-left: 10px;"><a href="index.php?apps=ACM"><b>ফিরে যান</b></a></div>
        <div>
            <form method="POST" onsubmit="" name="" action="cheque_make_out.php">	
                <table  class="formstyle" style="font-family: SolaimanLipi !important; margin:0 !important;width: 98% !important; height: 480px !important;">          
                    <tr><th colspan="2" style="text-align: center;">ড্রপডাউন ট্রি</th></tr>
                    <tr id="print">
                        <td height="368" style="padding-left: 35%;">
                            <div class="treeButton">
                                <ul>
                                <li><a><b>অ্যাকাউন্টধারীর নাম</b></a>
                                    
                                    <ul>
                                           <?php
                                    for($i=0;$i<7;$i++)
                                    {
                                       showList($i);
                                    }
                                   ?>
                                    </ul>
                                </li>
                                </ul>
                                </div>
                        </td>
                    </tr>
                    <tr>                    
                        <td colspan="2" style="padding-left: 5%; " ><input class="btn" style =" font-size: 12px;" type="submit" name="submit" value="সেভ করুন" />
                        <input class="btn" style =" font-size: 12px" type="reset" name="reset" value="রিসেট করুন" /></td>                           
                    </tr>    
                </table>
            </form>
        </div>           
    </div>
    <?php
    include 'includes/footer.php';
    ?>
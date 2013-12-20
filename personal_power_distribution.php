<?php
//include_once 'includes/session.inc';
include_once 'includes/header.php';
include_once 'includes/MiscFunctions.php';

?>
<style type="text/css"> @import "css/bush.css";</style>
<link rel="stylesheet" href="css/tinybox.css" type="text/css" media="screen" charset="utf-8"/>
<script type="text/javaScript">
     function moveToRightOrLeft(side)
        {
            var listLeft= document.getElementById('selectLeft');
            var listRight=document.getElementById('selectRight');

            if(side==1) // left to right
            {
                if(listLeft.options.length==0){
                    alert('সব সাবমডিউল অব্যবহৃত করা হয়ে গেছে');
                    return false;
                }else{
                    var selectedCountry=listLeft.options.selectedIndex;

                    move(listRight,listLeft.options[selectedCountry].value,listLeft.options[selectedCountry].text);
                    listLeft.remove(selectedCountry);

                    if(listLeft.options.length>0){
                        listLeft.options[0].selected=true;
                    }
                }
            }
            else if(side==2)// right to left
            {
                if(listRight.options.length==0){
                    alert('সব সাবমডিউল ব্যবহার করা হয়ে গেছে');
                    return false;
                }else{
                    var selectedCountry=listRight.options.selectedIndex;

                    move(listLeft,listRight.options[selectedCountry].value,listRight.options[selectedCountry].text);
                    listRight.remove(selectedCountry);

                    if(listRight.options.length>0){
                        listRight.options[0].selected=true;
                    }
                }
            }
        }

        function move(listBoxTo,optionValue,optionDisplayText)// move function
        {
            var newOption = document.createElement("option");
            newOption.value = optionValue;
            newOption.text = optionDisplayText;
            listBoxTo.add(newOption, null);
            return true;
        }
</script>
<script type="text/javascript">
function show()
{
var arr = new Array();
var select1 = document.getElementById('selectLeft');

for(var i=0; i < select1.options.length; i++){
    arr.push(select1.options[i].value);
}
document.getElementById('optionlist').value = arr.toString();
}
</script>
<script>
    function getEmployee(keystr) //search employee by account number***************
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
            if(keystr.length ==0)
                {
                   document.getElementById('empfound').style.display = "none";
               }
                else
                    {document.getElementById('empfound').style.visibility = "visible";
                document.getElementById('empfound').setAttribute('style','position:absolute;top:36%;left:62.5%;width:225px;z-index:10;padding:5px;border: 1px inset black; overflow:auto; height:105px; background-color:#F5F5FF;');
                    }
                document.getElementById('empfound').innerHTML=xmlhttp.responseText;
        }
        xmlhttp.open("GET","includes/employeeSearch.php?key="+keystr+"&location=personal_power_distribution.php",true);
        xmlhttp.send();	
}

</script>

    <div class="main_text_box">
        <div style="padding-left: 110px;"><a href=""><b>ফিরে যান</b></a></div>
        <div>
            <form method="POST" onsubmit="" name="" enctype="multipart/form-data" action="">	
                <table  class="formstyle" style="font-family: SolaimanLipi !important;width: 80%;">          
                    <tr><th colspan="2" style="text-align: center;">ক্ষমতা বিকেন্দ্রীকরণ / স্থগিতকরন</th></tr>
                    <tr>
                                                <?php
                                        if(isset($_GET['id']))
                                        {
                                            $empCfsid = $_GET['id'];
                                            $selreslt= mysql_query("SELECT * FROM  cfs_user WHERE idUser = $empCfsid");
                                            $getrow = mysql_fetch_assoc($selreslt);
                                            $db_empname = $getrow['account_name'];
                                            $db_empmobile = $getrow['mobile'];
                                            $sql_post = mysql_query("SELECT post_name FROM employee, employee_posting, post_in_ons, post
                                                                                        WHERE idPost = Post_idPost AND idpostinons = post_in_ons_idpostinons AND Employee_idEmployee = idEmployee
                                                                                            AND  cfs_user_idUser = $empCfsid");
                                            $sql_postrow = mysql_fetch_assoc($sql_post);
                                            $db_empposition = $sql_postrow['post_name'];
                                            $sql_employee = mysql_query("SELECT * FROM employee WHERE cfs_user_idUser = $empCfsid");
                                            $emprow = mysql_fetch_assoc($sql_employee);
                                            $db_paygrdid = $emprow['pay_grade_id'];
                                            $db_empid = $emprow['idEmployee'];
                                            $sql_empinfo = mysql_query("SELECT * FROM employee_information WHERE Employee_idEmployee = $db_empid");
                                            $empinforow = mysql_fetch_assoc($sql_empinfo);
                                            $db_empphoto = $empinforow['emplo_scanDoc_picture'];
                                            $sql_empsal = mysql_query("SELECT * FROM employee_salary WHERE user_id=$db_empid AND pay_grade_idpaygrade= $db_paygrdid;");
                                            $empsalrow = mysql_fetch_assoc($sql_empsal);
                                            $db_empsalary = $empsalrow['total_salary'];
                                        }
                            ?>
                        <td></br>
                            <table style="margin-left: 0px !important;">
                                                                 <thead>
                                     <th colspan="3" style="background-image: none!important; background-color: #cccccc">সেট সাবমডিউল</th>
                                 </thead>
                                 <tbody>
                                    <tr>
                                        <td width="45%">
                                             <fieldset style="border: #999999 solid 2px; text-align: center;">
                                                 <legend  style="color: brown;">ব্যবহৃত সাবমডিউল</legend>
                                                    <select name="selectLeft" size="10" id="selectLeft" style="width: 240px; overflow: auto; padding: 3px; border: 1px solid #808080">
                                                        <?php // getUsedSubMod($g_roleid);?>
                                                    </select>
                                             </fieldset>
                                         </td>
                                        <td width="10%" style="padding-top: 70px;text-align: center;">
                                             <input name="btnLeft" type="button" id="btnLeft" value="&lt;&lt;" onClick="javaScript:moveToRightOrLeft(2);"/></br>
                                             <input name="btnRight" type="button" id="btnRight" value="&gt;&gt;" onClick="javaScript:moveToRightOrLeft(1);"/>
                                        </td>
                                        <td width="45%">
                                             <fieldset style="border:#999999 solid 2px;text-align: center;">
                                                 <legend  style="color: brown;">অব্যবহৃত সাবমডিউল</legend>
                                                    <select name="selectRight" size="10" id="selectRight" style="width: 240px; overflow: auto; padding: 3px; border: 1px solid #808080;">
                                                       <?php // getUnusedSubMod($g_roleid);?>
                                                   </select>
                                              </fieldset>
                                         </td>
                                     </tr>
                                 </tbody>
                            </table>     
                        </td>
                         <td width="41%"></br>
                            <table>
                                 <tr>
                                     <td colspan="8" style="text-align: right">খুঁজুন:  <input type="text" class="box" style="width: 230px;" id="empsearch" name="empsearch" onkeyup="getEmployee(this.value)"/>
                                    <div id="empfound"></div></td>
                                    </tr>
                                    <tr>
                                        <td width="40%" rowspan='5' style="padding-left: 0px;"> <img src="<?php echo $db_empphoto;?>" width="128px" height="128px" alt=""></td> 
                                    </tr>
                                    <tr>
                                        <td width="57%"><input type="hidden" readonly="" value="<?php echo $db_empname;?>" /><?php echo $db_empname;?></td>
                                    </tr>     
                                    <tr>
                                        <td><input type="hidden" readonly="" value="<?php echo $db_empposition;?>" /><?php echo $db_empposition;?>
                                            <input type="hidden" readonly="" id="emp_paygrade" name="emp_paygrade" value="<?php echo $db_paygrdid;?>" /></td>
                                    </tr>    
                                    <tr>
                                        <td><input type="hidden" readonly="" value="<?php echo $db_empmobile;?>" /><?php echo $db_empmobile;?>
                                        <input type="hidden" readonly="" name="empid"value="<?php echo $db_empid;?>" /></td>
                                    </tr>
                                     <tr>
                                        <td><input type="hidden" readonly="" value="<?php echo $db_empsalary;?>" />বেতন : <?php echo $db_empsalary;?> টাকা</td>
                                    </tr>     
                                    <tr>
                                        <td style="text-align: center;"><a href="">বিস্তারিত</a></td>
                                    </tr>     
                                    </table>
                                </td>
                            </tr>
                            <tr>                    
                        <td colspan="2" style="padding-left: 250px; " ></br></br><input class="btn" style =" font-size: 12px; " type="submit" name="submit" value="সেভ করুন" /></td>                           
                    </tr>    
                </table>
                </fieldset>
            </form>
        </div>           
    </div>
    <?php include_once 'includes/footer.php'; ?>
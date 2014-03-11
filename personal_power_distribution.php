<?php
//include_once 'includes/session.inc';
include_once 'includes/header.php';
include_once 'includes/MiscFunctions.php';
if(isset($_GET['id']))
{
    $empCfsid = $_GET['id'];
    $selreslt= mysql_query("SELECT * FROM  cfs_user WHERE idUser = $empCfsid");
    $getrow = mysql_fetch_assoc($selreslt);
    $db_empname = $getrow['account_name'];
    $db_empmobile = $getrow['mobile'];
    $db_roleid = $getrow['security_roles_idsecurityrole'];
    
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

function getUsedPages($id)
{
    $submodRslt= mysql_query("SELECT * FROM security_pages LEFT JOIN security_groups 
                                                    ON security_pages.security_submodule_idsecuritysubmod = security_groups.security_submodules_idsecuritysubmod 
                                                    WHERE security_roles_idsecurityrole = $id ORDER BY page_view_name");
    while($submodrow = mysql_fetch_assoc($submodRslt))
    {
	echo  "<option value=".$submodrow['idsecuritypage'].">".$submodrow['page_view_name']."</option>";
    }
}
//function getUnusedSubMod($id)
//{
//    $submodRslt= mysql_query("SELECT * FROM securiy_submodules WHERE idsecuritysubmod NOT IN 
//                                                (SELECT security_submodules_idsecuritysubmod FROM security_groups WHERE security_roles_idsecurityrole = $id);");
//    while($submodrow = mysql_fetch_assoc($submodRslt))
//    {
//	echo  "<option value=".$submodrow['idsecuritysubmod'].">".$submodrow['submod_name']."</option>";
//    }
//}
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
               alert('দুঃখিত, আর কোন ক্ষমতা নেই');
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
               alert('দুঃখিত, আর কোন ক্ষমতা নেই');
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
    <div class="main_text_box">
        <div style="padding-left: 50px;"><a href="employee_for_power_distribution.php"><b>ফিরে যান</b></a></div>
        <div>
            <form method="POST" enctype="multipart/form-data" action="">	
                <table  class="formstyle" style="font-family: SolaimanLipi !important;width: 90%;margin-left: 50px;">          
                    <tr><th colspan="2" style="text-align: center;font-size: 20px;">ক্ষমতা বিকেন্দ্রীকরণ</th></tr>
                    <tr>
                        <td>
                            <table style="margin-left: 0px !important;">
                                 <tbody>
                                    <tr>
                                        <td width="45%">
                                             <fieldset style="border: #999999 solid 2px; text-align: center;">
                                                 <legend  style="color: brown;">নিজের দায়িত্ব</legend>
                                                    <select name="selectLeft" size="10" id="selectLeft" style="width: 240px; overflow: auto; padding: 3px; border: 1px solid #808080">
                                                        <?php getUsedPages($db_roleid);?>
                                                    </select>
                                             </fieldset>
                                         </td>
                                        <td width="10%" style="padding-top: 70px;text-align: center;">
                                            <input name="btnRight" type="button" id="btnRight" value="&gt;&gt;" onClick="javaScript:moveToRightOrLeft(1);"/><br/>
                                             <input name="btnLeft" type="button" id="btnLeft" value="&lt;&lt;" onClick="javaScript:moveToRightOrLeft(2);"/>                            
                                        </td>
                                        <td width="45%">
                                             <fieldset style="border:#999999 solid 2px;text-align: center;">
                                                 <legend  style="color: brown;">বিকেন্দ্রীকৃত দায়িত্ব</legend>
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
<?php
include_once 'includes/session.inc';
include_once 'includes/header.php';
include_once 'includes/MiscFunctions.php';
$msg = "";

$loginUSERname = $_SESSION['UserID'] ;
$queryemp = mysql_query("SELECT idUser FROM cfs_user WHERE user_name = '$loginUSERname';");
$emprow = mysql_fetch_assoc($queryemp);
$db_onsid = $emprow['idUser'];

if(isset($_POST['submit']))
{
    $p_empid = $_POST['empid'];
    $giverid = $db_onsid;
    $p_fund = $_POST['fund'];
    $p_loanamount = $_POST['loanamount'];
    $p_repaymonths = $_POST['instalment_period'];
    $p_repayamount = $_POST['instalment_amount'];
    $sql_fund = mysql_query("INSERT INTO loan (loan_amount, fund_name, repay_howmany_month, repay_amount_monthly, loan_date, loan_givenbyid, Employee_idEmployee)
                                                VALUES ($p_loanamount,'$p_fund', $p_repaymonths, $p_repayamount, NOW(), $giverid, $p_empid)"); //or exit('query failed: '.mysql_error());
    if($sql_fund ==1)
    {
        $msg = "লোন প্রদান হয়েছে";
    }
    else { $msg = "দুঃখিত, লোন তৈরি হয়নি";}
}
?>
<title>লোন প্রদান</title>
<style type="text/css"> @import "css/bush.css";</style>
<link rel="stylesheet" href="css/tinybox.css" type="text/css" media="screen" charset="utf-8"/>
<script src="javascripts/tinybox.js" type="text/javascript"></script>
  <script type="text/javascript">
 function update(id)
	{ TINY.box.show({iframe:'updateSalaryRange.php?gradeid='+id,width:500,height:280,opacity:30,topsplit:3,animate:true,close:true,maskid:'bluemask',maskopacity:50,boxid:'success'}); }
 </script>

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

function calculateInstalment(month) // for calculation instalment amount*************
{
    var loanamount = document.getElementById('loanamount').value;
    var instalment = loanamount / month;
    instalment = (instalment).toFixed(2);
    document.getElementById('instalment_amount').value = instalment;
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
        xmlhttp.open("GET","includes/employeeSearch.php?key="+keystr+"&location=loan_given.php",true);
        xmlhttp.send();	
}

</script>

    <div class="main_text_box">
        <div style="padding-left: 110px;"><a href="hr_employee_management.php"><b>ফিরে যান</b></a></div>
        <div>
            <form method="POST" onsubmit="" name="" enctype="multipart/form-data" action="">	
                <table  class="formstyle" style="font-family: SolaimanLipi !important;width: 80%;">          
                    <tr><th colspan="2" style="text-align: center;">লোন প্রদান</th></tr>
                    <?php
                    if($msg !="")
                    {
                        echo "<tr><td colspan='2' style='color:red;font-size:16px;text-align:center;'>$msg</td></tr>";                        
                    }
                    ?>
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
                                 <tr>
                                     <td width="35%" style="padding-left: 0px;" >লোনের পরিমাণ</td>
                                    <td width="65%">:  <input class="box" type="text" name="loanamount" id="loanamount" onkeypress="return checkIt(event)" /> টাকা</td>	 
                                </tr>  
                                <tr>
                                    <td style="padding-left: 0px;">ফান্ডের নাম</td>
                                   <td>:   <select class="box2" name="fund" style="width: 167px;">
                                        <option value="">-সিলেক্ট করুন-</option>
                                        <option value="pension">পেনশন</option>
                                        <option value="ripd_income">রিপড ইনকাম</option>
                                        <option value="extra">এক্সট্রা</option>
                                    </select></br></br></td>	  
                                </tr>  
                                <tr>
                                    <td colspan="2" style="text-align: center;font-size: 16px;padding-left: 0px;">------------------লোন পরিশোধ সিস্টেম--------------------</td>                                    
                                </tr> 
                                <tr>
                                    <td style="padding-left: 0px;">লোন পরিশোধের সময়সীমা</td>
                                    <td>:   <input class="box" type="text" id="instalment_period" name="instalment_period" onkeypress=' return numbersonly(event)' onblur ="calculateInstalment(this.value)" /> মাস</td>
                                </tr>
                                <tr>
                                    <td style="padding-left: 0px;">মাসিক কিস্তির পরিমান</td>
                                    <td>:   <input class="box" readonly="" type="text" id="instalment_amount" name="instalment_amount" /> টাকা</td>
                                </tr>
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
                        <td colspan="2" style="padding-left: 250px; " ></br></br><input class="btn" style =" font-size: 12px; " type="submit" name="submit" value="সেভ করুন" />
                        <input class="btn" style =" font-size: 12px" type="reset" name="reset" value="রিসেট করুন" /></br></br></td>                           
                    </tr>    
                </table>
                </fieldset>
            </form>
        </div>           
    </div>
    <?php
    include_once 'includes/footer.php';
    ?>

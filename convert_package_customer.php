<?php
error_reporting(0);
//include_once 'includes/session.inc';
include_once 'includes/header.php';

$loginUserID = $_SESSION['userIDUser']; 
$loginUSERname = $_SESSION['acc_holder_name'];
$logedInAccNo = $_SESSION['personalAccNo'];
$sel_cust_account = $conn->prepare("SELECT idCustomer_account, account_name, account_minPV_value 
                                                                FROM customer_account JOIN account_type ON Account_type_idAccount_type = idAccount_type
                                                                WHERE cfs_user_idUser = ?");
$sel_cust_account->execute(array($loginUserID));
$custrow = $sel_cust_account->fetchAll();
foreach ($custrow as $row) {
    $current_account = $row['account_name'];
    $current_account_value = $row['account_minPV_value'];
}
function get_packages($current_ac_value,$conn)
{
    echo "<option value= 0> -সিলেক্ট করুন- </option>";
    $sel_packages = $conn->prepare("SELECT * FROM account_type WHERE account_minPV_value > ?");
    $sel_packages->execute(array($current_ac_value));
    $arr_packages = $sel_packages->fetchAll();
    foreach ($arr_packages as $row) {
        $str_value = $row['idAccount_type'].','.$row['account_minPV_value'];
        echo "<option value='$str_value' >". $row['account_name'] ."</option>";
    }
}
?>
<style type="text/css"> @import "css/bush.css";</style>
<script type="text/javascript" src="javascripts/jquery-1.4.3.min.js"></script>
<script type="text/javascript">
   function setPVvalue(str)
    {
        var array1 = str.split(',');
        var pvvalue = array1[1];
        document.getElementById('pvvalue').value = pvvalue;
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
</script>

<div class="main_text_box">
    <div style="padding-left: 110px;"><a href="profile_account_management.php"><b>ফিরে যান</b></a></div>
    <div>
        <form method="POST" onsubmit="" enctype="multipart/form-data" action="">	
            <table  class="formstyle" style="font-family: SolaimanLipi !important;width: 80%;">          
                <tr><th colspan="2" style="text-align: center;font-size: 22px;">কনভার্ট একাউন্ট প্যাকেজ</th></tr>
                <tr>
                    <td>
                        <table style="margin-left: 0px !important;">
                            <tr>
                                <td style="padding-left: 0px; text-align: right; width: 35%" >একাউন্টধারীর নামঃ</td>
                                <td style="width: 65%"><?php echo $loginUSERname;?></td>	 
                            </tr> 
                            <tr>
                                <td style="padding-left: 0px; text-align: right; width: 35%">একাউন্ট নাম্বারঃ</td>
                                <td width="65%"><?php echo $logedInAccNo;?></td>	 
                            </tr> 
                            <tr>
                                <td style="padding-left: 0px; text-align: right; width: 35%" >বর্তমান প্যাকেজঃ</td>
                                <td width="65%"><?php echo $current_account;?></td>	 
                            </tr> 
                            <tr>
                                <td colspan="2">
                                    <fieldset style="border: #686c70 solid 3px;width: 80%; margin-left: 50px">
                                        <legend style="color: brown;">সার্চ প্যাকেজ</legend>
                                        পরবর্তী প্যাকেজঃ <select class="box" name="next_packages" onclick="setPVvalue(this.value)" >
                                             <?php get_packages($current_account_value,$conn);?>
                                        </select>
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        প্রয়োজনীয় পি.ভি. : 
                                        <input class="box" type="text" id="pvvalue" name="pvvalue" style="width: 100px" />
                                    </fieldset>
                                </td>
                            </tr>
                            <tr>         
                                <td style="padding-left: 0px; text-align: right; width: 35%"><input type="radio" name="pvtype" value="pin" onclick="showBox('.permanentBox1')" /> পিন ব্যবহার</td>
                                <td><input type="radio" name="pvtype" value="account" onclick="hideBox('.permanentBox1')" />অর্জিত পিভি ব্যবহার</td>
                            </tr>
                            <tr class="permanentBox1" style="visibility: hidden;">
                                <td style="padding-left: 0px; text-align: right; width: 35%">এন্টার পিন নং :</td>
                                <td><input class="box" type="text" id="pin_no" name="pin_no" /></td>                             
                            </tr>
                            <tr>
                                <td style="padding-left: 0px; text-align: right; width: 35%">কনভার্ট সার্ভিস চার্জ :</td>
                                <td> <input class="box" type="text" id="pckg_convert_charge" name="pckg_convert_charge" /> টাকা</td>
                            </tr>
                            <tr>
                                <td style="padding-left: 0px; text-align: right; width: 35%">একাউন্ট চার্জ :</td>
                                <td> <input class="box" type="text" id="account_charge" name="account_charge" /> টাকা</td>
                            </tr>
                            <tr>
                                <td style="padding-left: 0px; text-align: right; width: 35%">টোটাল একাউন্ট পে:</td>
                                <td> <input class="box" type="text" id="total_pay" name="total_pay" /> টাকা</td>
                            </tr>
                             <tr>
                                <td style="padding-left: 0px; text-align: right; width: 35%">পাসওয়ার্ড:</td>
                                <td> <input class="box" type="password" id="pass" name="pass" /></td>
                            </tr>
                            <tr>
                                <td style="padding-left: 0px; text-align: right; width: 35%">রি-পাসওয়ার্ড:</td>
                                <td> <input class="box" type="password" id="retype_pass" name="retype_pass" /></td>
                            </tr>
                        </table>     
                    </td>
                </tr>
                <tr>                    
                    <td colspan="2" style="padding-left: 350px;" ><br/><input class="btn" style =" font-size: 12px; " type="submit" name="submit" value="কনভার্ট" /><br/></td>                           
                </tr>    
            </table>
            </fieldset>
        </form>
    </div>           
</div>
<?php include_once 'includes/footer.php'; ?>
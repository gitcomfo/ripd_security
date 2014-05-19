<?php
mysql_error();
include_once 'includes/header.php';
$logedInUserID = $_SESSION['userIDUser'];
$logedinOfficeId = $_SESSION['loggedInOfficeID'];

if(isset($_POST['check']))
{
    $p_commandid = $_POST['commandID'];
    $p_pinprofit = $_POST['pinprofit'];
    $p_ssumID = $_POST['salessummaryID'];
    
    // select referers *************************************
        $sel_referer = mysql_query("SELECT * FROM view_usertree WHERE ut_customerid = $logedInUserID");
        while($row = mysql_fetch_assoc($sel_referer)) {
            $one = $row['ut_first_parentid'];
            $two = $row['ut_second_parentid'];
            $three = $row['ut_third_parentid'];
            $four = $row['ut_fourth_parentid'];
            $five = $row['ut_fifth_parentid'];
        }
        // select customer pkg ******************************
        $sel_cust_pkg = mysql_query("SELECT Account_type_idAccount_type FROM customer_account WHERE cfs_user_idUser = $logedInUserID");
        while($row = mysql_fetch_assoc($sel_cust_pkg)) {
            $pkgtype = $row['Account_type_idAccount_type'];
        }
        
     // select view pv view **************************
     $sel_pv_view = mysql_query("SELECT * FROM view_pv_view WHERE cust_type = 'account' AND sales_type= 'general' 
                                                    AND store_type='both' AND account_type_id=$pkgtype AND idcommand = $p_commandid");
    while($row = mysql_fetch_assoc($sel_pv_view)) {
        $direct_sales = $row['direct_sales_cust'];
        $Rone = $row['Rone'];
        $Rtwo = $row['Rtwo'];
        $Rthree = $row['Rthree'];
        $Rfour = $row['Rfour'];
        $Rfive = $row['Rfive'];
    }
    $borkot = 0;
     mysql_query("START TRANSACTION");
        if($one != 0)
        {
            $one_hit = ($p_pinprofit * $Rone) / 100;
            $sql1 = mysql_query("UPDATE acc_user_balance SET pv_balance = pv_balance + $one_hit, total_balanace = total_balanace + $one_hit WHERE cfs_user_iduser = $one ");
            $sql5 = mysql_query("UPDATE main_fund SET fund_amount = fund_amount + $one_hit, last_update = NOW() WHERE fund_code = 'RHC'");
            $sel_child_row = mysql_query("SELECT * FROM cust_pv_child_date WHERE cust_own_id = $one AND date = CURDATE() ");
            if(mysql_num_rows($sel_child_row)> 0)
            {
               $sql6 = mysql_query("UPDATE cust_pv_child_date SET cust_c1 = cust_c1+$one_hit WHERE cust_own_id = $one AND date = CURDATE() ");
            }
            else
                {
                    $sql6 = mysql_query("INSERT INTO cust_pv_child_date (cust_own_id,cust_c1,date) VALUES ($one,$one_hit,NOW())");
                }
        }
        else { $borkot = $borkot + (($p_pinprofit * $Rone) / 100); $one_hit = 0; $sql1=1; $sql5=1; $sql6 =1;}
        
        if($two != 0)
        {
            $two_hit = ($p_pinprofit * $Rtwo) / 100;
            $sql1=mysql_query("UPDATE acc_user_balance SET pv_balance = pv_balance + $two_hit, total_balanace = total_balanace + $two_hit WHERE cfs_user_iduser = $two ");
            $sql5 = mysql_query("UPDATE main_fund SET fund_amount = fund_amount + $two_hit, last_update = NOW() WHERE fund_code = 'RHC'");
            $sel_child_row = mysql_query("SELECT * FROM cust_pv_child_date WHERE cust_own_id = $two AND date = CURDATE()");
            if(mysql_num_rows($sel_child_row)> 0)
            {
               $sql6 = mysql_query("UPDATE cust_pv_child_date SET cust_c2 = cust_c2+$two_hit WHERE cust_own_id = $two AND date = CURDATE()");
            }
            else
                {
                    $sql6 = mysql_query("INSERT INTO cust_pv_child_date (cust_own_id,cust_c2,date) VALUES ($two,$two_hit,NOW())");
                }
        }
        else { $borkot = $borkot + (($p_pinprofit * $Rtwo) / 100); $two_hit = 0;  }
        
        if($three != 0)
        {
            $three_hit = ($p_pinprofit * $Rthree) / 100;
            $sql1 = mysql_query("UPDATE acc_user_balance SET pv_balance = pv_balance + $three_hit, total_balanace = total_balanace + $three_hit WHERE cfs_user_iduser = $three ");
            $sql5 = mysql_query("UPDATE main_fund SET fund_amount = fund_amount + $three_hit, last_update = NOW() WHERE fund_code = 'RHC'");
            $sel_child_row = mysql_query("SELECT * FROM cust_pv_child_date WHERE cust_own_id = $three AND date = CURDATE()");
            if(mysql_num_rows($sel_child_row)> 0)
            {
               $sql6 = mysql_query("UPDATE cust_pv_child_date SET cust_c3 = cust_c3+$three_hit WHERE cust_own_id = $three AND date = CURDATE()");
            }
            else
                {
                    $sql6 = mysql_query("INSERT INTO cust_pv_child_date (cust_own_id,cust_c3,date) VALUES ($three,$three_hit,NOW())");
                }
        }
        else { $borkot = $borkot + (($p_pinprofit * $Rthree) / 100); $three_hit = 0;  }
        if($four != 0)
        {
            $four_hit = ($p_pinprofit * $Rfour) / 100;
            $sql1 = mysql_query("UPDATE acc_user_balance SET pv_balance = pv_balance + $four_hit, total_balanace = total_balanace + $four_hit WHERE cfs_user_iduser = $four ");
            $sql5 = mysql_query("UPDATE main_fund SET fund_amount = fund_amount + $four_hit, last_update = NOW() WHERE fund_code = 'RHC'");
            $sel_child_row = mysql_query("SELECT * FROM cust_pv_child_date WHERE cust_own_id = $four AND date = CURDATE()");
            if(mysql_num_rows($sel_child_row)> 0)
            {
               $sql6 = mysql_query("UPDATE cust_pv_child_date SET cust_c4 = cust_c4+$four_hit WHERE cust_own_id = $four AND date = CURDATE()");
            }
            else
                {
                    $sql6 = mysql_query("INSERT INTO cust_pv_child_date (cust_own_id,cust_c4,date) VALUES ($four,$four_hit,NOW())");
                }
        }
        else { $borkot = $borkot + (($p_pinprofit * $Rfour) / 100); $four_hit = 0;  }
        if($five != 0)
        {
            $five_hit = ($p_pinprofit * $Rfive) / 100;
            $sql1 = mysql_query("UPDATE acc_user_balance SET pv_balance = pv_balance + $five_hit, total_balanace = total_balanace + $five_hit WHERE cfs_user_iduser = $five ");
            $sql5 = mysql_query("UPDATE main_fund SET fund_amount = fund_amount + $five_hit, last_update = NOW() WHERE fund_code = 'RHC'");
            $sel_child_row = mysql_query("SELECT * FROM cust_pv_child_date WHERE cust_own_id = $five AND date = CURDATE()");
            if(mysql_num_rows($sel_child_row)> 0)
            {
               $sql6 = mysql_query("UPDATE cust_pv_child_date SET cust_c5 = cust_c5+$five_hit WHERE cust_own_id = $five AND date = CURDATE()");
            }
            else
                {
                    $sql6 = mysql_query("INSERT INTO cust_pv_child_date (cust_own_id,cust_c5,date) VALUES ($five,$five_hit,NOW())");
                }
        }
        else { $borkot = $borkot + (($p_pinprofit * $Rfive) / 100); $five_hit = 0;  }
        
        $own_hit = ($p_pinprofit * $direct_sales) / 100;
        $sel_own_row = mysql_query("SELECT * FROM cust_pv_child_date WHERE cust_own_id = $logedInUserID AND date = CURDATE()");
            if(mysql_num_rows($sel_own_row)> 0)
            {
               $sql7 = mysql_query("UPDATE cust_pv_child_date SET cust_own_pv = cust_own_pv+$own_hit WHERE cust_own_id = $logedInUserID AND date = CURDATE()");
            }
            else
                {
                    $sql7 = mysql_query("INSERT INTO cust_pv_child_date (cust_own_id,cust_own_pv,date) VALUES ($logedInUserID,$own_hit,NOW())");
                }
           
           $sql5 = mysql_query("UPDATE sales_customer_hitting SET own = $own_hit ,Rone = $one_hit,Rtwo = $two_hit,Rthree = $three_hit ,
                                                Rfour = $four_hit ,Rfive = $five_hit,borkot = $borkot WHERE  sales_summery_idsalessummery = $p_ssumID") or exit(mysql_error());
           $sql4 = mysql_query("UPDATE acc_user_balance SET pv_balance = pv_balance + $own_hit, total_balanace = total_balanace + $own_hit WHERE cfs_user_iduser = $logedInUserID ");
           $sql8 = mysql_query("UPDATE main_fund SET fund_amount = fund_amount + $own_hit, last_update = NOW() WHERE fund_code = 'RHC'");
           $sql9 = mysql_query("UPDATE pin_makingused SET pin_state = 'selfaccount', pin_used_date= CURDATE(), 
                                                pin_usedby_cfsuserid = $logedInUserID WHERE fk_idsalessummary = $p_ssumID");
           
           if($sql1 && $sql4 && $sql5 && $sql6 && $sql7 && $sql8 && $sql9)
           {         
                mysql_query("COMMIT");
                echo "<script>alert('পিন ব্যবহৃত হয়েছে');</script>";
           }
          else {
               mysql_query("ROLLBACK");
               echo "<script>alert('দুঃখিত,পিন ব্যবহৃত হয়নি');</script>";
           }
}
?>

<style type="text/css"> @import "css/bush.css";</style>
<script type="text/javascript">
function getPinInfo(pin) // find pin info *****************
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
                document.getElementById('pin_details').innerHTML=xmlhttp.responseText;
        }
        xmlhttp.open("GET","includes/PinNumberValidation.php?pinno="+pin,true);
        xmlhttp.send();	
}

function beforeSubmit()
    {
        if(document.getElementById('pindate').value != '')
        {
            return true;
        }
        else {
            alert("দুঃখিত, আপনার পিন নম্বরটি সঠিক নয় অথবা ব্যবহৃত হয়েছে");
            return false; 
        }
    }
</script>

    <div class="main_text_box">
        <div id="noprint" style="padding-left: 110px;"><a href="profile_account_management.php"><b>ফিরে যান</b></a></div>
        <div>           
               <table  class="formstyle" style="width: 80%;font-family: SolaimanLipi !important; font-size: 14px;">          
                    <tr ><th colspan="2" style="text-align: center;font-size: 16px;">পিন নং ব্যবহার </th></tr>
                    <tr>
                        <td>
                            <form method="POST" action="">
                                <table>
                                    <tr>
                                        <td style="text-align: right;width: 50%;">পিন নাম্বার :</td>
                                        <td style="text-align: left;width: 50%;"><input class="box" type="text" name='pinNo' maxlength="18" onblur="getPinInfo(this.value)"/> </td>
                                    </tr>
                                    <tr id="pin_details"></tr>
                                    <tr>
                                        <td  colspan="2" style="text-align: center;" ></br><input class="btn" style =" font-size: 12px; " name='check' type="submit" value="ব্যবহার করুন" /></td>
                                    </tr>
                                </table>
                            </form>
                        </td>
                    </tr>
                </table>
        </div>
    </div>
<?php include 'includes/footer.php'; ?>
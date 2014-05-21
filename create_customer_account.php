<?php
error_reporting(0);
//include_once 'includes/session.inc';
include_once 'includes/MiscFunctions.php';
include_once 'includes/makeAccountNumbers.php';
include_once 'includes/checkAccountNo.php';
include_once 'includes/email_conf.php';
include_once './includes/sms_send_function.php';
if(isset($_GET['from'])
{
 
}

$sql_runningpv = $conn->prepare("SELECT * FROM running_command ;");
$sql_runningpv->execute();
$pvrow = $sql_runningpv->fetchAll();
foreach ($pvrow as $value) {
    $current_pv = $value['pv_value'];
}

if (isset($_POST['submit']) || isset($_POST['retry']))
  {
        $user_username = $_POST['user_username'];
        $account_name = $_POST['name'];
        $account_number = $_POST['acc_num'];
        $account_email = $_POST['email'];
        $pin_number = $_POST['pin_num'];
        $account_mobile = $_POST['mobile'];
        $account_mobile1 = "88".$account_mobile;
        $account_number1 = checkAccountNo($account_number);
        $emailusername = str_replace("-", "", $account_number1);
        $ripdemailid = $emailusername . "@ripduniversal.com";
         //  ****************** password create & send ******************************************
        $pass = getRandomPassword();
        $passwrd = md5($pass);

        $send_sms_content = "Dear User,Your\nACC.# $account_number\nUsername: $user_username\nRIPD email: $ripdemailid\nPassword: $pass\nThanks";
        $sendResult = SendSMSFuntion($account_mobile1, $send_sms_content);
        $sendStatus = substr($sendResult, 0, 2);

        if ($sendStatus == 'OK') {
            mysql_query("START TRANSACTION");
        //************************* create official email *************************************************
             $email_create_status = CreateEmailAccount($emailusername, $pass);
            if ($email_create_status == '777') {
                $ripdemailid = $emailusername . "@ripduniversal.com";
            } else {
            $ripdemailid = "";}
            
            $sel_securityroles = mysql_query("SELECT * FROM security_roles WHERE role_name= 'customer' ");
            $securityrolesrow = mysql_fetch_assoc($sel_securityroles);
            $roleid =$securityrolesrow['idsecurityrole'];
            
            $ins_cfsuser=mysql_query("INSERT INTO cfs_user (user_name, password, blocked, account_name, account_number, account_open_date, mobile, email, ripd_email,cfs_account_status, security_roles_idsecurityrole, user_type)
                                                                        VALUES ('$user_username', '$passwrd', '0', '$account_name', '$account_number1', NOW(), '$account_mobile1', '$account_email', '$ripdemailid','active', $roleid,'customer')") or exit(mysql_error()." sorry");
            $cfs_user_id = mysql_insert_id();
       
             // **************************get referer ID*****************************
                    $getreferer_sql = mysql_query("SELECT * FROM pin_makingused, sales_summary WHERE idsalessummary =  	fk_idsalessummary AND pin_no = '$pin_number'");
                    $refererrow = mysql_fetch_assoc($getreferer_sql);
                    $db_referid = $refererrow['sal_buyerid'];
                    $db_pv= ($refererrow['pin_total_profit'] * $current_pv);
                    $db_commandid = $refererrow['command_id'];
                    $db_salesummaryID = $refererrow['fk_idsalessummary'];
           //*************************************get account type from pv ************************
                    $getactype_sql = mysql_query("SELECT * FROM account_type WHERE account_minPV_value <= $db_pv ORDER BY account_minPV_value DESC LIMIT 1");
                    $actyperow = mysql_fetch_assoc($getactype_sql);
                    $db_accounttypeID = $actyperow['idAccount_type'];
                    $db_accountpv = $actyperow['account_minPV_value'];
             //*************************cutomer_account table-e insert*************
                    $ins_custaccount = mysql_query("INSERT INTO customer_account (opening_pin_no, referer_id, Account_type_idAccount_type, Designation_idDesignation, cfs_user_idUser)
                                                                        VALUES ('$pin_number', $db_referid, $db_accounttypeID, 1, $cfs_user_id )") or exit(mysql_error());
                    $cust_acc_id= mysql_insert_id();
          // **************************** update pinmakingused table ******************************** 
                    $up_pinmakingused = mysql_query("UPDATE pin_makingused SET pin_state= 'newaccount', pin_used_date=NOW(), pin_usedby_cfsuserid = $cfs_user_id
                                                                                WHERE pin_no= '$pin_number'");
        // ******************************** hit own rest pv ******************************************************
                    $rest_pv = $db_pv - $db_accountpv;
                    $rest_profit = $rest_pv / $current_pv;
               // select referers *************************************
                    $sel_referer = mysql_query("SELECT * FROM view_usertree WHERE ut_customerid = $db_referid");
                    while($row = mysql_fetch_assoc($sel_referer)) {
                        $one = $row['ut_first_parentid'];
                        $two = $row['ut_second_parentid'];
                        $three = $row['ut_third_parentid'];
                        $four = $row['ut_fourth_parentid'];
                        $five = $row['ut_fifth_parentid'];
                    }
                    // select customer pkg ******************************
                    $sel_cust_pkg = mysql_query("SELECT Account_type_idAccount_type FROM customer_account WHERE cfs_user_idUser = $db_referid");
                    while($row = mysql_fetch_assoc($sel_cust_pkg)) {
                        $pkgtype = $row['Account_type_idAccount_type'];
                    }

                 // select view pv view **************************
                 $sel_pv_view = mysql_query("SELECT * FROM view_pv_view WHERE cust_type = 'account' AND sales_type= 'general' 
                                                                AND store_type='both' AND account_type_id=$pkgtype AND idcommand = $db_commandid");
                while($row = mysql_fetch_assoc($sel_pv_view)) {
                    $direct_sales = $row['direct_sales_cust'];
                    $Rone = $row['Rone'];
                    $Rtwo = $row['Rtwo'];
                    $Rthree = $row['Rthree'];
                    $Rfour = $row['Rfour'];
                    $Rfive = $row['Rfive'];
                }
                $borkot = 0;
                    if($one != 0)
                    {
                        $one_hit = ($rest_profit * $Rone) / 100;
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
                    else { $borkot = $borkot + (($rest_profit * $Rone) / 100); $one_hit = 0; $sql1=1; $sql5=1; $sql6 =1;}

                    if($two != 0)
                    {
                        $two_hit = ($rest_profit * $Rtwo) / 100;
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
                    else { $borkot = $borkot + (($rest_profit * $Rtwo) / 100); $two_hit = 0;  }

                    if($three != 0)
                    {
                        $three_hit = ($rest_profit * $Rthree) / 100;
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
                    else { $borkot = $borkot + (($rest_profit * $Rthree) / 100); $three_hit = 0;  }
                    if($four != 0)
                    {
                        $four_hit = ($rest_profit * $Rfour) / 100;
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
                    else { $borkot = $borkot + (($rest_profit * $Rfour) / 100); $four_hit = 0;  }
                    if($five != 0)
                    {
                        $five_hit = ($rest_profit * $Rfive) / 100;
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
                    else { $borkot = $borkot + (($rest_profit * $Rfive) / 100); $five_hit = 0;  }

                    $own_hit = ($rest_profit * $direct_sales) / 100;
                    $sel_own_row = mysql_query("SELECT * FROM cust_pv_child_date WHERE cust_own_id = $db_referid AND date = CURDATE()");
                        if(mysql_num_rows($sel_own_row)> 0)
                        {
                           $sql7 = mysql_query("UPDATE cust_pv_child_date SET cust_own_pv = cust_own_pv+$own_hit WHERE cust_own_id = $db_referid AND date = CURDATE()");
                        }
                        else
                            {
                                $sql7 = mysql_query("INSERT INTO cust_pv_child_date (cust_own_id,cust_own_pv,date) VALUES ($db_referid,$own_hit,NOW())");
                            }

                       $sql5 = mysql_query("UPDATE sales_customer_hitting SET own = $own_hit ,Rone = $one_hit,Rtwo = $two_hit,Rthree = $three_hit ,
                                                            Rfour = $four_hit ,Rfive = $five_hit,borkot = $borkot WHERE  sales_summery_idsalessummery = $db_salesummaryID") or exit(mysql_error());
                       $sql4 = mysql_query("UPDATE acc_user_balance SET pv_balance = pv_balance + $own_hit, total_balanace = total_balanace + $own_hit WHERE cfs_user_iduser = $db_referid ");
                       $sql8 = mysql_query("UPDATE main_fund SET fund_amount = fund_amount + $own_hit, last_update = NOW() WHERE fund_code = 'RHC'");
                   
                    $encodedID = base64_encode($cust_acc_id);
                    if ($ins_cfsuser && $ins_custaccount && $up_pinmakingused && $sql1 && $sql4 && $sql5 && $sql6 && $sql7 && $sql8) {
                        mysql_query("COMMIT");
                        echo "<script>alert('কাস্টমার তৈরি হয়েছে')</script>";
                        header( 'Location: create_customer_account_inner.php?custACid='.$encodedID);
                    } else {
                        mysql_query("ROLLBACK");
                        $msg = "দুঃখিত, কর্মচারী তৈরি হয়নি";
                    }
        }
        else {
        $smserror = "দুঃখিত,একাউন্টধারীর মোবাইল নাম্বারে মেসেজ পাঠানো যাচ্ছে না, পুনরায় চেষ্টা করুন অথবা মেন্যুয়াল পাসওয়ার্ড দিয়ে সেভ করুন";
        $error = 1;
    }
}
if (isset($_POST['submitwithpass']))
  {
        $user_username = $_POST['user_username'];
        $account_name = $_POST['name'];
        $account_number = $_POST['acc_num'];
        $account_email = $_POST['email'];
        $pin_number = $_POST['pin_num'];
        $account_mobile = $_POST['mobile'];
        $account_mobile1 = "88".$account_mobile;
        $account_number1 = checkAccountNo($account_number);
        $emailusername = str_replace("-", "", $account_number1);
        $ripdemailid = $emailusername . "@ripduniversal.com";
        $pass = $_POST['reap_password'];
        $passwrd = md5($pass);

            mysql_query("START TRANSACTION");
//        //************************* create official email *************************************************
             $email_create_status = CreateEmailAccount($emailusername, $pass);
            if ($email_create_status == '777') {
                $ripdemailid = $emailusername . "@ripduniversal.com";
            } else {
            $ripdemailid = "";}
            $sel_securityroles = mysql_query("SELECT * FROM security_roles WHERE role_name= 'customer' ");
            $securityrolesrow = mysql_fetch_assoc($sel_securityroles);
            $roleid =$securityrolesrow['idsecurityrole'];
            
            $ins_cfsuser=mysql_query("INSERT INTO cfs_user (user_name, password, blocked, account_name, account_number, account_open_date, mobile, email, ripd_email,cfs_account_status, security_roles_idsecurityrole, user_type)
                                                                        VALUES ('$user_username', '$passwrd', '0', '$account_name', '$account_number1', NOW(), '$account_mobile1', '$account_email', '$ripdemailid','active', $roleid,'customer')") or exit(mysql_error()." sorry");
            $cfs_user_id = mysql_insert_id();
       
             // **************************get referer ID*****************************
                    $getreferer_sql = mysql_query("SELECT * FROM pin_makingused, sales_summary WHERE idsalessummary =  	fk_idsalessummary AND pin_no = '$pin_number'");
                    $refererrow = mysql_fetch_assoc($getreferer_sql);
                    $db_referid = $refererrow['sal_buyerid'];
                    $db_pv= ($refererrow['pin_total_profit'] * $current_pv);
                    $db_commandid = $refererrow['command_id'];
                    $db_salesummaryID = $refererrow['fk_idsalessummary'];
           //*************************************get account type from pv ************************
                    $getactype_sql = mysql_query("SELECT * FROM account_type WHERE account_minPV_value <= $db_pv ORDER BY account_minPV_value DESC LIMIT 1");
                    $actyperow = mysql_fetch_assoc($getactype_sql);
                    $db_accounttypeID = $actyperow['idAccount_type'];
             //*************************cutomer_account table-e insert*************
                    $ins_custaccount=mysql_query("INSERT INTO customer_account (opening_pin_no, referer_id, Account_type_idAccount_type, Designation_idDesignation, cfs_user_idUser)
                                                                        VALUES ('$pin_number', $db_referid, $db_accounttypeID, 1, $cfs_user_id )") or exit(mysql_error());
                    $cust_acc_id= mysql_insert_id();
           // **************************** update pinmakingused table ******************************** 
                    $up_pinmakingused = mysql_query("UPDATE pin_makingused SET pin_state= 'newaccount', pin_used_date=NOW(), pin_usedby_cfsuserid = $cfs_user_id
                                                                                WHERE pin_no= '$pin_number'");
           // ******************************** hit own rest pv ******************************************************
                    $rest_pv = $db_pv - $db_accountpv;
                    $rest_profit = $rest_pv / $current_pv;
               // select referers *************************************
                    $sel_referer = mysql_query("SELECT * FROM view_usertree WHERE ut_customerid = $db_referid");
                    while($row = mysql_fetch_assoc($sel_referer)) {
                        $one = $row['ut_first_parentid'];
                        $two = $row['ut_second_parentid'];
                        $three = $row['ut_third_parentid'];
                        $four = $row['ut_fourth_parentid'];
                        $five = $row['ut_fifth_parentid'];
                    }
                    // select customer pkg ******************************
                    $sel_cust_pkg = mysql_query("SELECT Account_type_idAccount_type FROM customer_account WHERE cfs_user_idUser = $db_referid");
                    while($row = mysql_fetch_assoc($sel_cust_pkg)) {
                        $pkgtype = $row['Account_type_idAccount_type'];
                    }

                 // select view pv view **************************
                 $sel_pv_view = mysql_query("SELECT * FROM view_pv_view WHERE cust_type = 'account' AND sales_type= 'general' 
                                                                AND store_type='both' AND account_type_id=$pkgtype AND idcommand = $db_commandid");
                while($row = mysql_fetch_assoc($sel_pv_view)) {
                    $direct_sales = $row['direct_sales_cust'];
                    $Rone = $row['Rone'];
                    $Rtwo = $row['Rtwo'];
                    $Rthree = $row['Rthree'];
                    $Rfour = $row['Rfour'];
                    $Rfive = $row['Rfive'];
                }
                $borkot = 0;
                    if($one != 0)
                    {
                        $one_hit = ($rest_profit * $Rone) / 100;
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
                    else { $borkot = $borkot + (($rest_profit * $Rone) / 100); $one_hit = 0; $sql1=1; $sql5=1; $sql6 =1;}

                    if($two != 0)
                    {
                        $two_hit = ($rest_profit * $Rtwo) / 100;
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
                    else { $borkot = $borkot + (($rest_profit * $Rtwo) / 100); $two_hit = 0;  }

                    if($three != 0)
                    {
                        $three_hit = ($rest_profit * $Rthree) / 100;
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
                    else { $borkot = $borkot + (($rest_profit * $Rthree) / 100); $three_hit = 0;  }
                    if($four != 0)
                    {
                        $four_hit = ($rest_profit * $Rfour) / 100;
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
                    else { $borkot = $borkot + (($rest_profit * $Rfour) / 100); $four_hit = 0;  }
                    if($five != 0)
                    {
                        $five_hit = ($rest_profit * $Rfive) / 100;
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
                    else { $borkot = $borkot + (($rest_profit * $Rfive) / 100); $five_hit = 0;  }

                    $own_hit = ($rest_profit * $direct_sales) / 100;
                    $sel_own_row = mysql_query("SELECT * FROM cust_pv_child_date WHERE cust_own_id = $db_referid AND date = CURDATE()");
                        if(mysql_num_rows($sel_own_row)> 0)
                        {
                           $sql7 = mysql_query("UPDATE cust_pv_child_date SET cust_own_pv = cust_own_pv+$own_hit WHERE cust_own_id = $db_referid AND date = CURDATE()");
                        }
                        else
                            {
                                $sql7 = mysql_query("INSERT INTO cust_pv_child_date (cust_own_id,cust_own_pv,date) VALUES ($db_referid,$own_hit,NOW())");
                            }

                       $sql5 = mysql_query("UPDATE sales_customer_hitting SET own = $own_hit ,Rone = $one_hit,Rtwo = $two_hit,Rthree = $three_hit ,
                                                            Rfour = $four_hit ,Rfive = $five_hit,borkot = $borkot WHERE  sales_summery_idsalessummery = $db_salesummaryID") or exit(mysql_error());
                       $sql4 = mysql_query("UPDATE acc_user_balance SET pv_balance = pv_balance + $own_hit, total_balanace = total_balanace + $own_hit WHERE cfs_user_iduser = $db_referid ");
                       $sql8 = mysql_query("UPDATE main_fund SET fund_amount = fund_amount + $own_hit, last_update = NOW() WHERE fund_code = 'RHC'");
                    
                     $encodedID = base64_encode($cust_acc_id);
                    if ($ins_cfsuser && $ins_custaccount && $up_pinmakingused && $sql1 && $sql4 && $sql5 && $sql6 && $sql7 && $sql8) 
                     {
                        mysql_query("COMMIT");
                        echo "<script>alert('কাস্টমার তৈরি হয়েছে')</script>";
                        header( 'Location: create_customer_account_inner.php?custACid='.$encodedID);
                    } else {
                        mysql_query("ROLLBACK");
                        $msg = "দুঃখিত, কর্মচারী তৈরি হয়নি";
                    }          
   }
?>
<?php include_once 'includes/header.php';?>
<title>ক্রিয়েট কাস্টমার অ্যাকাউন্ট</title>
<style type="text/css">@import "css/bush.css";</style>
<script>
    function goBack()
    {
        window.history.go(-1);
    }
    function numbersonly(e)
    {
        var unicode = e.charCode ? e.charCode : e.keyCode
        if (unicode != 8)
        { //if the key isn't the backspace key (which we should allow)
            if (unicode < 48 || unicode > 57) //if not a number
                return false //disable key press
        }
    }
    function checkIt(evt) // float value-er jonno***********************
    {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode == 8 || (charCode > 47 && charCode < 58) || charCode == 46) {
            status = "";
            return true;
        }
        status = "This field accepts numbers only.";
        return false;
    }
    function checkPass(passvalue) // check password in repeat
    {
        var user_password = document.getElementById('user_password').value;
        if (user_password != passvalue)
        {
            document.getElementById('reap_password').focus();
            document.getElementById('passcheck').style.color = 'red';
            document.getElementById('passcheck').innerHTML = "পাসওয়ার্ড সঠিক হয় নি";
        }
        else {
            document.getElementById('passcheck').style.color = 'green';
            document.getElementById('passcheck').innerHTML = "OK";
        }
    }

    function beforeSave()
    {
        if ((document.getElementById('usernamecheck').innerHTML == "")
                && (document.getElementById('user_username').value != "")
                && (document.getElementById('mblValidationMsg').innerHTML == "")
                && (document.getElementById('pin_num').value != "")
                && (document.getElementById('pinerror').innerHTML == ""))
        {
            document.getElementById('save').readonly = false;
            return true;
        }
        else {
            document.getElementById('save').readonly = true;
            return false;
        }
    }
    function beforeSave2()
    {
        if ((document.getElementById('usernamecheck').innerHTML == "") 
                && (document.getElementById('pin_num').value != "")
                && (document.getElementById('pinerror').innerHTML == "")
                && (document.getElementById('mblValidationMsg').innerHTML == "")
                && (document.getElementById('passcheck').innerHTML == "OK"))
        {
            document.getElementById('save2').readonly = false;
            return true;
        }
        else {
            document.getElementById('save2').readonly = true;
            return false;
        }
    }
    function beforeSaveRetry()
    {
        if ((document.getElementById('usernamecheck').innerHTML == "")
                && (document.getElementById('pin_num').value != "")
                && (document.getElementById('pinerror').innerHTML == "")
                && (document.getElementById('mblValidationMsg').innerHTML == "")
                && (document.getElementById('passcheck').innerHTML == ""))
        {
            document.getElementById('retry').readonly = false;
            return true;
        }
        else {
            document.getElementById('retry').readonly = true;
            return false;
        }
    }
function userminlength(username)
{
    if(username.length < 5)
        {
            document.getElementById('user_username').focus();
            document.getElementById('minlegthcheck').innerHTML= "কমপক্ষে ৫ অক্ষর হতে হবে";
        }
         else{
           document.getElementById('minlegthcheck').innerHTML= "";
        }
}
function passminlength(pass)
{
    if(pass.length < 10)
        {
            document.getElementById('user_password').focus();
            document.getElementById('minlengtherror').innerHTML= "কমপক্ষে ১০ অক্ষর হতে হবে";
        }
    else {
            document.getElementById('minlengtherror').innerHTML= "";
        }
}
</script>
<script>
    function check(str) // for currect email address form checking
    {
        if (str.length == 0)
        {
            document.getElementById("error_msg").innerHTML = "";
            document.getElementById("error_msg").style.border = "0px";
            return;
        }
        if (window.XMLHttpRequest)
        {// code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        }
        else
        {// code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function()
        {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
            {
                document.getElementById("error_msg").innerHTML = xmlhttp.responseText;
                document.getElementById("error_msg").style.display = "inline";
            }
        }
        xmlhttp.open("GET", "includes/check.php?x=" + str, true);
        xmlhttp.send();
    }

    function checkUserName(uname)
    {
        if (window.XMLHttpRequest)
        {// code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        }
        else
        {// code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function()
        {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
            {
                document.getElementById("usernamecheck").innerHTML = xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET", "includes/checkUserName.php?strkey=" + uname, true);
        xmlhttp.send();
    }
    function validateMobile(mblno)
    {
        if (window.XMLHttpRequest)
        {// code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        }
        else
        {// code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function()
        {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
            {
                document.getElementById("mblValidationMsg").innerHTML = xmlhttp.responseText;
                var message = document.getElementById("mblValidationMsg").innerText;
                if (message != "")
                {
                    document.getElementById('mobile').focus();
                }
            }
        }
        xmlhttp.open("GET", "includes/mobileNoValidation.php?mobile=" + mblno, true);
        xmlhttp.send();
    }
    function pinValidation(pin)
    {
        if (window.XMLHttpRequest)
        {// code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        }
        else
        {// code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function()
        {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
            {
                document.getElementById("pinerror").innerHTML = xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET", "includes/pinNumberValidation.php?pin=" +pin, true);
        xmlhttp.send();
    }
</script>
<div class="column6">
    <div class="main_text_box">
        <div style="padding-left: 110px;"><a onclick="goBack();" style="cursor: pointer;"><b><u>ফিরে যান</u></b></a></div> 
        <div>            
            <form method="POST" action="">
                <?php
                    if ((isset($_POST['submit']) || isset($_POST['retry'])) && $error == 1) {
                    $input = 'customer';
                    $arrayAccountType = array('employee' => 'কর্মচারীর', 'customer' => 'কাস্টমারের', 'proprietor' => 'প্রোপ্রাইটারের');
                    $showAccountType  = $arrayAccountType[$input];
                    
                    echo "<tr><td><input type='hidden' value='$input' name='account_type'/></td></tr>
                    <table  class='formstyle'>          
                    <tr><th colspan='4' style='text-align: center;'>$showAccountType মূল তথ্য</th></tr>
                    <tr><td colspan ='2' style='text-align: center;'><font color='read'>$smserror</font></td></tr>
                    <tr>
                        <td >$showAccountType নাম</td>
                        <td>: <input class='box' type='text' id='name' name='name' value='$account_name'/><em2> *</em2></td>			
                    </tr>
                    <tr>
                        <td >একাউন্ট নাম্বার</td>
                        <td>:   <input class='box' type='text' id='acc_num' name='acc_num' readonly value= '$account_number1' /></td>			
                    </tr>
                    <tr>
                        <td >ই মেইল</td>
                       <td>:   <input class='box' type='text' id='email' name='email' onblur='check(this.value)' value='$account_email' /> <em>ইংরেজিতে লিখুন</em></br><span id='error_msg' style='margin-left: 5px'></span></td>			
                    </tr>
                    <tr>
                        <td >মোবাইল</td>
                        <td>: <input class='box' type='text' id='mobile' name='mobile' onkeypress=' return numbersonly(event)' onblur='validateMobile(this.value)' style='font-size:16px;' placeholder='01XXXXXXXXX' value='$account_mobile' />
                        <em2>*</em2></br><span id='mblValidationMsg'></span></td>		
                    </tr>
                    <tr>
                        <td >পিন নাম্বার</td>
                        <td>:   <input class='box' type='text' id='pin_num' name='pin_num' onblur='pinValidation(this.value)' /><em2>*</em2><em>ইংরেজিতে লিখুন</em></br><span id='pinerror' style='color:red;'></span></td>		
                    </tr>
                   <tr>
                        <td>ইউজারের নাম</td>
                      <td>: <input class='box' type='text' id='user_username' name='user_username' onblur='userminlength(this.value),checkUserName(this.value)' value='$user_username' />
                      <em2>*</em2><em>ইংরেজিতে লিখুন</em></br><span style='color:red;' id='usernamecheck'></span><span style='color:red;' id='minlegthcheck'></span></td>
                    </tr>   
                    <tr>
                        <td>পাসওয়ার্ড</td>
                       <td>: <input class='box' type='password' id='user_password' name='user_password' maxlength='15' onblur='passminlength(this.value)'/><em2>*</em2><em>ইংরেজিতে লিখুন</em></br><span style='color:red;' id='minlengtherror'></span></td>
                    </tr>
                    <tr>
                        <td>কনফার্ম পাসওয়ার্ড</td>
                       <td>:   <input class='box' type='password' id='reap_password' name='reap_password' onkeyup='checkPass(this.value);'/> <em>ইংরেজিতে লিখুন</em> <span id='passcheck'></span></td>
                    </tr>
                    <tr>                    
                        <td colspan='4' style='padding-left: 250px; '>
                         <input class='btn' style ='font-size: 12px;' type='submit' name='submitwithpass' id='save2' value='সেভ' readonly onclick='return beforeSave2();'/>                   
                        <input class='btn' style ='font-size: 12px;' type='submit' name='retry' id='retry' value='রি ট্রাই' onclick='return beforeSaveRetry()'/>
                   </td>                           
                    </tr>             
                </table>";
                    }
              else {
                    $input = 'customer';
                    $arrayAccountType = array('employee' => 'কর্মচারীর', 'customer' => 'কাস্টমারের', 'proprietor' => 'প্রোপ্রাইটারের');
                    $showAccountType  = $arrayAccountType[$input];
                    
                    echo "<tr><td><input type='hidden' value='$input' name='account_type'/></td></tr>";

                    echo "<table  class='formstyle'>          
                    <tr><th colspan='4' style='text-align: center;'>$showAccountType মূল তথ্য</th></tr>  
                    <tr>
                        <td >$showAccountType নাম</td>
                        <td>:   <input class='box' type='text' id='name' name='name'/><em2> *</em2></td>			
                    </tr>
                    <tr>
                        <td >একাউন্ট নাম্বার</td>
                        <td>:   <input class='box' type='text' id='acc_num' name='acc_num' readonly value= ".getPersonalAccount()." /></td>			
                    </tr>
                    <tr>
                        <td >ই মেইল</td>
                       <td>:   <input class='box' type='text' id='email' name='email' onblur='check(this.value)' /> <em>ইংরেজিতে লিখুন</em></br><span id='error_msg' style='margin-left: 5px'></span></td>			
                    </tr>
                    <tr>
                        <td >মোবাইল</td>
                        <td>: <input class='box' type='text' id='mobile' name='mobile' onkeypress=' return numbersonly(event)' onblur='validateMobile(this.value)' style='font-size:16px;' placeholder='01XXXXXXXXX' />
                        <em2>*</em2></br><span id='mblValidationMsg'></span></td>		
                    </tr>
                    <tr>
                        <td >পিন নাম্বার</td>
                        <td>:   <input class='box' type='text' id='pin_num' name='pin_num' onblur='pinValidation(this.value)'/><em2>*</em2><em>ইংরেজিতে লিখুন</em></br><span id='pinerror' style='color:red;'></span></td>		
                    </tr>
                   <tr>
                        <td>ইউজারের নাম</td>
                      <td>:   <input class='box' type='text' id='user_username' name='user_username' onblur='userminlength(this.value),checkUserName(this.value)' />
                      <em2>*</em2><em>ইংরেজিতে লিখুন</em></br><span style='color:red;' id='usernamecheck'></span><span style='color:red;' id='minlegthcheck'></span></td>
                    </tr>   
                    <tr>                    
                        <td colspan='4' style='padding-left: 250px; '>
                        <input class='btn' style ='font-size: 12px;width:200px;' type='submit' name='submit' id='save' value='সেভ এন্ড সেন্ড পাসওয়ার্ড' readonly onclick='return beforeSave();'/>
                   </td>                           
                    </tr>             
                </table>";
                    }
                ?>
            </form>
        </div>
    </div>      
</div> 
<?php include_once 'includes/footer.php'; ?>
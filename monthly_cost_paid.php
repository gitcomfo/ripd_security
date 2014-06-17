<?php
//include 'includes/session.inc';
//error_reporting(0);
include_once 'includes/header.php';
 $loginUSERid = $_SESSION['userIDUser'] ;
 $logedinOfficeId = $_SESSION['loggedInOfficeID'];
 $logedInOfficeType = $_SESSION['loggedInOfficeType'];
 
 $g_ons_exp_id = $_GET['id'];
 $g_nfcid = $_GET['nfcid'];
 $currentMonth = date('n');
 $currentYear = date('Y');

$sql_update_notification = $conn->prepare("UPDATE notification SET nfc_status=? WHERE idnotification=? ");
$sql_fixed_expenditure = $conn->prepare("UPDATE ons_fixed_expenditure SET status='given' WHERE idfixexp=? ");
$sel_fixed_exp = $conn->prepare("SELECT * FROM ons_fixed_expenditure WHERE idfixexp= ? AND 	status = 'approved' ");
$ins_daily_inout = $conn->prepare("INSERT INTO acc_ofc_daily_inout (daily_date, daily_onsid, out_amount) VALUES (NOW(),?,?)");
$sel_ledger = $conn->prepare("SELECT total_amount FROM acc_ofc_physc_ledger 
                                                    WHERE month_no= ? AND year_no = ? AND ripd_office_id = ?");
$sel_main_fund = $conn->prepare("SELECT fund_amount FROM main_fund WHERE fund_code= 'SOF'");
$sel_store_logical = $conn->prepare("SELECT * FROM acc_store_logc WHERE ons_type= 's_store' AND ons_id = ?");
$up_main_fund = $conn->prepare("UPDATE main_fund SET fund_amount = fund_amount - ? WHERE fund_code = 'SOF'");
$up_store_logical_xprofit = $conn->prepare("UPDATE acc_store_logc SET AEP = AEP - ?, last_update = NOW() WHERE ons_type= 's_store' AND ons_id = ?");
$up_store_logical_profit = $conn->prepare("UPDATE acc_store_logc SET ASE = ASE - ?, last_update = NOW() WHERE ons_type= 's_store' AND ons_id = ?");
$up_store_logical_buying = $conn->prepare("UPDATE acc_store_logc SET ACM = ACM - ?, last_update = NOW() WHERE ons_type= 's_store' AND ons_id = ?");

// ************************* select query ****************************************
$sel_fixed_exp->execute(array($g_ons_exp_id));
$row = $sel_fixed_exp->fetchAll();
foreach ($row as $value) {
    $db_month = $value['month'];
    $db_year = $value['year'];
    $monthName = date("F", mktime(0, 0, 0, $db_month, 10));
    $db_monthlytotal = $value['ons_monthly_total'];
}

if(isset($_POST['submit']))
{
    $sel_onsID = $conn->prepare("SELECT idons_relation FROM ons_relation WHERE add_ons_id = ? AND catagory=?");
    $sel_onsID->execute(array($logedinOfficeId,$logedInOfficeType));
    $offrow = $sel_onsID->fetchAll();
    foreach ($offrow as $value) {
       $office_ons_id = $value['idons_relation'];
    }
    
    $p_total = $_POST['total'];
    
    $conn->beginTransaction();
    
    if($logedInOfficeType == 'office')
    {
        $sel_main_fund->execute();
        $fundrow = $sel_main_fund->fetchAll();
        foreach ($fundrow as $value) {
            $fundamount = $value['fund_amount'];
        }
        $sel_ledger->execute(array($currentMonth,$currentYear,$office_ons_id));
        $ledgerrow = $sel_ledger->fetchAll();
        foreach ($ledgerrow as $value) {
            $ledgeramount = $value['total_amount'];
        }
        if(($fundamount >= $p_total) && ($ledgeramount >= $p_total))
        {
            $sqlrslt1= $sql_fixed_expenditure->execute(array($g_ons_exp_id ));
            $sqlrslt5 = $up_main_fund->execute(array($p_total));
        }
        else {
               $sqlrslt1 = 0;
           }
    }
    
else 
    {
        $sel_store_logical->execute(array($logedinOfficeId));
        $storerow = $sel_store_logical->fetchAll();
        foreach ($storerow as $value) {
            $db_profit = $value['ASE'];
            $db_xtraProfit = $value['AEP'];
            $db_buying = $value['ACM'];
            $db_total = $db_profit + $db_xtraProfit + $db_buying;
        }
        if($db_total > $p_total)
        {
            if($p_total > $db_profit)
            {
                $upsql = $up_store_logical_profit->execute(array($db_profit,$logedinOfficeId));
                $updated_totalsalary = $p_total - $db_profit;
                
                if($updated_totalsalary > $db_xtraProfit)
                {
                     $up_store_logical_xprofit->execute(array($db_xtraProfit,$logedinOfficeId));
                     $updated_totalsalary = $updated_totalsalary - $db_xtraProfit;
                     $up_store_logical_buying->execute(array($updated_totalsalary,$logedinOfficeId));
                }
                else 
                {
                     $upsql = $up_store_logical_xprofit->execute(array($updated_totalsalary,$logedinOfficeId));
                }
            }
            else
            {
                $upsql = $up_store_logical_profit->execute(array($p_total,$logedinOfficeId));
            }
            $sqlrslt1= $sql_fixed_expenditure->execute(array($g_ons_exp_id ));
        }
    else 
        {
            $sqlrslt1 = 0;
        }    
    }
       
    $status = 'complete';
    $sqlrslt3 = $sql_update_notification->execute(array($status,$g_nfcid));
    $insert = $ins_daily_inout->execute(array($office_ons_id,$p_total));
    
     if($sqlrslt1 && $sqlrslt3 && $insert)
        {
            $conn->commit();
            echo "<script>alert('খরচ করা হল');
                window.location = 'main_account_management.php';</script>";
        }
        else {
            $conn->rollBack();
            echo "<script>alert('দুঃখিত,খরচ করা' যায়নি)</script>";
        }
}
?>
<style type="text/css"> @import "css/bush.css";</style>

<div class="columnSld" style=" padding-left: 50px;">
    <div class="main_text_box">
        <div style="padding-left: 9px;"><a href="notification.php"><b>ফিরে যান</b></a></div>
        <div>           
            <form method="POST" action="">	
                <table  class="formstyle" style="width: 90%; margin: 1px 1px 1px 1px;">          
                    <tr><th colspan="2" style="text-align: center;font-size: 22px;">মাসিক খরচের টাকা গ্রহন</th></tr>
                    <tr>
                        <td colspan="2" style="text-align: center;font-size: 16px;"><input type="hidden" name="total" value="<?php echo $db_monthlytotal;?>" />
                            <?php echo $monthName." , ".$db_year?>-এর মাসিক খরচ বাবদ <?php echo $db_monthlytotal?> টাকা গ্রহন ও খরচ করা হল
                        </td>          
                    </tr>
                    <tr>                    
                        <td colspan="2" style="text-align: center; " ><input class="btn" style =" font-size: 12px; " type="submit" name="submit" value="ঠিক আছে" /></td>                           
                    </tr>    
                </table>
                </fieldset>
            </form>
        </div>
    </div>
</div>
<?php include 'includes/footer.php'; ?>
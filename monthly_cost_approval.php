<?php
//include 'includes/session.inc';
error_reporting(0);
include_once 'includes/header.php';
include_once 'includes/MiscFunctions.php';
$loginUSERid = $_SESSION['userIDUser'] ;
$g_acc_ofc_physc_in = $_GET['id'];
 $g_nfcid = $_GET['nfcid'];

$sql_update_notification = $conn->prepare("UPDATE notification SET nfc_status=? WHERE idnotification=? ");
$sql_fixed_expenditure = $conn->prepare("UPDATE ons_fixed_expenditure SET status='approved' WHERE idfixexp=? ");
$insert_notification = $conn->prepare("INSERT INTO notification (nfc_senderid,nfc_receiverid,nfc_message,nfc_actionurl,nfc_date,nfc_status, nfc_type, nfc_catagory) 
                                                            VALUES (?,?,?,?,NOW(),?,?,?)");
////$sel_select_acc_ofc = $conn->prepare("SELECT * FROM acc_ofc_physc_in LEFT JOIN bank_list ON idbank = bank_id WHERE idofcphysin= ?");
//$up_acc_ofc_physc_in = $conn->prepare("UPDATE acc_ofc_physc_in SET receving_date = NOW(), rceiver_id = ? WHERE idofcphysin = ?");
//
//$sel_select_acc_ofc->execute(array($g_acc_ofc_physc_in));
//$row = $sel_select_acc_ofc->fetchAll();
//foreach ($row as $value) {
//    $db_inamount = $value['inamount'];
//    $db_bank = $value['bank_name'];
//    $db_cheque = $value['cheque_number'];
//    $db_sendingDate = $value['sending_date'];
//    if($db_cheque == '0')
//    {
//        $intype = "ক্যাশ";
//    }
//    else {
//           $intype = "চেক";
//       }
//}
if(isset($_POST['submit']))
{
     $conn->beginTransaction(); 
    echo $sqlrslt1= $sql_fixed_expenditure->execute(array($g_acc_ofc_physc_in ));
    $status = 'complete';
    $sqlrslt2 = $sql_update_notification->execute(array($status,$g_nfcid));
    $url = "monthly_cost_paid.php?id=".$g_acc_ofc_physc_in;
    $status1 = "unread";
    $type="action";
    $nfc_catagory="official";
    $msg = "মাসিক খরচ অনুমোদন";
    $onsID = 50;
    $sqlrslt3 = $insert_notification->execute(array($loginUSERid,$onsID,$msg,$url,$status1,$type,$nfc_catagory));
     if($sqlrslt1 && $sqlrslt2 && $sqlrslt3)
        {
            $conn->commit();
            echo "<script>alert('টাকা গ্রহন করা হল')</script>";
            header('location: main_account_management.php');
        }
        else {
            $conn->rollBack();
            echo "<script>alert('দুঃখিত,টাকা গ্রহন করা' যায়নি)</script>";
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
                    <tr><th colspan="2" style="text-align: center;font-size: 22px;">রিপড হেড অফিস হতে টাকা গ্রহন</th></tr>
<!--                    <tr>
                        <td >গ্রহনকৃত মোট টাকা</td>
                        <td>: <input class="box" type="text" style="text-align: right;" readonly="" value="<?php echo $db_inamount;?>" /> টাকা</td>          
                    </tr>
                    <tr>
                        <td >পদ্ধতি</td>
                        <td>: <input class="box" type="text" readonly="" value="<?php echo $intype;?>" /></td> 
                    </tr>
                    <tr>
                        <td >ব্যাংকের নাম</td>
                        <td>: <input class="box" type="text" readonly="" value="<?php echo $db_bank;?>" /></td> 
                    </tr>
                    <tr>
                        <td >চেক নং</td>
                        <td>: <input class="box" type="text" readonly="" value="<?php echo $db_cheque;?>" /></td> 
                    </tr>
                    <tr>
                        <td >টাকা প্রেরনের তারিখ</td>
                        <td>: <input class="box" type="text" readonly="" value="<?php echo date("d/m/Y",  strtotime($db_sendingDate));?>" /></td> 
                    </tr> -->
                    <tr>                    
                        <td colspan="2" style="text-align: center; " ><input class="btn" style =" font-size: 12px; " type="submit" name="submit" value="গ্রহন করা হল" /></td>                           
                    </tr>    
                </table>
                </fieldset>
            </form>
        </div>
    </div>
</div>
<?php
include 'includes/footer.php';
?>
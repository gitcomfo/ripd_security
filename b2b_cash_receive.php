<?php
//include 'includes/session.inc';
include_once 'includes/header.php';

 $loginUSERid = $_SESSION['userIDUser'] ;
 $g_acc_ofc_physc_in = $_GET['id'];
 $g_nfcid = $_GET['nfcid'];
 
$sql_update_notification = $conn->prepare("UPDATE notification SET nfc_status=? WHERE idnotification=? ");
$sel_select_acc_ofc = $conn->prepare("SELECT * FROM acc_ofc_physc_in, office, ons_relation WHERE sender_office = idons_relation 
                                                                AND catagory = 'office' AND add_ons_id= idOffice AND idofcphysin= ?");
$up_acc_ofc_physc_in = $conn->prepare("UPDATE acc_ofc_physc_in SET receving_date = NOW(), rceiver_id = ? WHERE idofcphysin = ?");

$sel_select_acc_ofc->execute(array($g_acc_ofc_physc_in));
$row = $sel_select_acc_ofc->fetchAll();
foreach ($row as $value) {
    $db_inamount = $value['inamount'];
    $db_sendingDate = $value['sending_date'];
    $db_office_acc = $value['account_number'];
    $db_office_name = $value['office_name'];
}

if(isset($_POST['submit']))
{
     $conn->beginTransaction(); 
    $sqlrslt1= $up_acc_ofc_physc_in->execute(array($loginUSERid,$g_acc_ofc_physc_in ));
    $status = 'complete';
    $sqlrslt3 = $sql_update_notification->execute(array($status,$g_nfcid));
     if($sqlrslt1 && $sqlrslt3)
        {
            $conn->commit();
            echo "<script>alert('টাকা গ্রহন করা হল'); 
                window.location = 'main_account_management.php';</script>";

        }
        else {
            $conn->rollBack();
            echo "<script>alert('দুঃখিত,টাকা গ্রহন করা যায়নি)</script>";
        }
}
?>
<style type="text/css"> @import "css/bush.css";</style>

<div class="columnSld" style=" padding-left: 50px;">
    <div class="main_text_box">
        <div style="padding-left: 9px;"><a href="notification.php"><b>ফিরে যান</b></a></div>
        <div>           
            <form method="POST"  action="">	
                <table  class="formstyle" style="width: 90%; margin: 1px 1px 1px 1px;">          
                    <tr><th colspan="2" style="text-align: center;font-size: 22px;">অন্য অফিস হতে টাকা গ্রহন</th></tr>
                    <tr>
                        <td >প্রেরনকৃত অফিসের একাউন্ট নাম্বার</td>
                        <td>: <input class="box" type="text" id="acNo" name="acNo" readonly="" value="<?php echo $db_office_acc;?>" /></td>          
                    </tr>
                    <tr>
                        <td >প্রেরনকৃত অফিসের  নাম</td>
                        <td>: <input class="box" type="text" id="acNo" name="acNo" readonly="" value="<?php echo $db_office_name;?>" /></td>          
                    </tr>
                    <tr>
                        <td >গ্রহনকৃত মোট টাকা</td>
                        <td>: <input class="box" type="text" id="t_in_amount" name="t_in_amount" readonly="" value="<?php echo $db_inamount;?>" /> TK</td>          
                    </tr>
                    <tr>
                        <td >টাকা প্রেরনের তারিখ</td>
                        <td>: <input class="box" type="text" id="acNo" name="acNo" readonly="" value="<?php echo date('d/m/Y',  strtotime($db_sendingDate));?>" /></td> 
                    </tr> 
                    <tr>                    
                        <td colspan="2" style="text-align: center; " ><input class="btn" style =" font-size: 12px; " type="submit" name="submit" value="গ্রহন করা হল" /></td>                           
                    </tr>    
                </table>
                </fieldset>
            </form>
        </div>
    </div>
</div>
<?php include 'includes/footer.php';?>
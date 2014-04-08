<?php
error_reporting(0);
include_once 'includes/header.php';
include_once 'includes/columnViewAccount.php';
$loginUSERid = $_SESSION['userIDUser'];
$sql_update_notification = $conn->prepare("UPDATE notification SET nfc_status='read' WHERE idnotification=?");
?>

<style type="text/css">@import "css/bush.css";</style>
<link rel="stylesheet" href="css/tinybox.css" type="text/css" media="screen" charset="utf-8"/>
<script src="javascripts/tinybox.js" type="text/javascript"></script>
<script type="text/javascript">
    function send_message()
    {
        TINY.box.show({iframe:'send_message.php',width:650,height:300,opacity:30,topsplit:3,animate:true,close:true,maskid:'bluemask',maskopacity:50,boxid:'success'});
    }
</script>
 
 <div class="columnSubmodule" style="font-size: 14px;">
            <table class="formstyle" style ="width: 100%; margin-left: 0px; font-family: SolaimanLipi !important;" cellspacing="0">        
                <tr><th colspan="3">ক্ষুদে বার্তা</th></tr>
                <tr>
                    <td colspan="2">
                            <fieldset style="border: #686c70 solid 3px;width: 98%;margin-left:1%;">
                                <legend style="color: brown">সার্চ</legend>
                                <form method="POST"  action="">	
                                <table>
                                    <tr>
                                        <td>শুরু :<input class="box" type="date" name="startdate" /></td>
                                        <td >শেষ :<input class="box" type="date" name="enddate" /></td>
                                        <td><input class="btn" style="width: 50px;" type="submit" name="submit" value="সার্চ" /></td>
                                    </tr>
                                </table>
                                </form>
                            </fieldset>
                        </td>
                        <td style="text-align: center;"><a onclick="send_message();" style="cursor: pointer;"><img src="images/mail_send.png" style="width: 50px;height: 50px;" /><br/>বার্তা পাঠান</a></td>
                </tr>
                <tr><td colspan="3" style="text-align: center"><br/><font style="color: green;"><b>প্রাপ্ত ক্ষুদে বার্তা</b></font><hr><br/></td></tr>
                <tr id="table_row_odd">
                    <td style="width: 20%;text-align: center;"><b><?php echo "তারিখ";?></b></td>  
                    <td style="width: 40%;text-align: center;"><b><?php echo "প্রাপক";?></b></td>
                    <td style="width: 40%;text-align: center;"><b><?php echo "বার্তা";?></b></td>        
                </tr>
                <tbody>
                    <?php        
                        $db_slNo = 1;
                        $catagory='personal';
                        $sel_personal_notification = $conn->prepare("SELECT * FROM notification WHERE nfc_receiverid = ? 
                            AND nfc_status !='complete' AND nfc_catagory =? ORDER BY nfc_date DESC");
                        $sel_personal_notification ->execute(array($loginUSERid,$catagory));
                        $notificationrow = $sel_personal_notification->fetchAll();
                        $countrow = count($notificationrow);
                        if($countrow == 0)
                        {
                            echo "<tr><td colspan = '3' style='color:red;text-align:center;'> এই মুহূর্তে আপনার কোন নোটিফিকেশন নেই</td></tr>";
                        }
                        else 
                        {
                            foreach ($notificationrow as $value)
                                 {
                                    $db_nfc_id = $value['idnotification'];
                                    $db_msg = $value['nfc_message'];
                                    $db_status = $value['nfc_status'];
                                    $db_date = $value['nfc_date'];
                                    if($db_status == 'unread')
                                    {
                                        echo "<tr style='background-color:#ffcc99'>";
                                    }
                                    else {
                                     echo "<tr>";   
                                    }
                                    echo "<td>".english2bangla($db_slNo)."</td>";
                                    echo "<td>$db_msg</td>";
                                    echo "<td>".  english2bangla(date('d/m/Y',  strtotime($db_date)))."</td>";
                                        $sql_update_notification->execute(array($db_nfc_id));
                                        echo "</tr>";
                                    $db_slNo++;
                                    }
                        }
                    ?>
                </tbody>          
            </table>
    </div>
<?php include_once 'includes/footer.php'; ?> 
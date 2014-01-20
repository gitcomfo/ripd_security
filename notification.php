<?php
include_once 'includes/header.php';
$logedinOfficeId = $_SESSION['loggedInOfficeID'];
$logedinOfficeType = $_SESSION['loggedInOfficeType'];
$arr_notification_status = array('unread'=>'দেখা হয়নি', 'read'=>'দেখা হয়েছে', 'complete'=>'সম্পূর্ণ');
?>
<div class="page_header_div">
    <div class="page_header_title">অফিসিয়াল নোটিফিকেশন</div>
</div>
<div>
    <table id="office_info_filter" border="1" align="center" width= 98%" cellpadding="5px" cellspacing="0px" style="margin-left: 10px;">
                    <thead>
                        <tr align="left" id="table_row_odd">
                            <th><?php echo "ক্রম";?></th>
                            <th><?php echo "নোটিফিকেশন";?></th>
                            <th><?php echo "অবস্থা";?></th>
                            <th><?php echo "করনীয়";?></th>                   
                        </tr>
                    </thead>
                    <tbody>
<?php        
                    $db_slNo = 1;
                    $catagory='official';
                    $sel_official_notification = $conn->prepare("SELECT * FROM ons_relation, notification WHERE catagory=? AND add_ons_id=?
                       AND idons_relation=nfc_receiverid AND nfc_status !='complete' AND nfc_catagory =?");
                    $sel_official_notification ->execute(array($logedinOfficeType,$logedinOfficeId,$catagory));
                    $notificationrow = $sel_official_notification->fetchAll();                    
                    foreach ($notificationrow as $value)
                         {
                            $db_msg = $value['nfc_message'];
                            $db_status = $value['nfc_status'];
                            $db_url = $value['nfc_actionurl'];
                            $db_type = $value['nfc_type'];
                            $status = $arr_notification_status[$db_status];
                            echo "<tr>";
                            echo "<td>".english2bangla($db_slNo)."</td>";
                            echo "<td>$db_msg</td>";
                            echo "<td>$status</td>";
                            if($db_type == 'action')
                            {
                                echo "<td><a href='$db_url' >দেখুন</a></td>";
                            }
                            else
                            {
                                echo "<td></td>";
                            }
                            echo "</tr>";
                            $db_slNo++;
                         }          
?>
                    </tbody>
            </table>                        
            </div>

<?php include_once 'includes/footer.php';?>
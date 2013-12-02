<?php
error_reporting(0);
include_once 'includes/header.php';
include_once 'includes/columnViewAccount.php';
include_once 'includes/selectQueryPDO.php';
include_once 'includes/MiscFunctions.php';

session_start();

$session_user_id = $_SESSION['userIDUser'];
$sql_select_cfs_user_all->execute(array($session_user_id));
$arr_cfs_user = $sql_select_cfs_user_all->fetchAll();
foreach ($arr_cfs_user as $acu) 
        {
        $aab_account_name = $acu['account_name'];
        $aab_account_number = $acu['account_number'];
        $aab_open_date = english2bangla($acu['account_open_date']);
        $aab_mobile = english2bangla($acu['mobile']);
        $aab_email = $acu['email'];
        $aab_user_type = $acu['user_type'];
        $cfs_user_id = $acu['idUser'];
        }
$sql_select_cust_basic->execute(array($cfs_user_id));
$arr_cust_basic = $sql_select_cust_basic->fetchAll();
foreach ($arr_cust_basic as $aab) 
        {
        $aab_designation_name = $aab['designation_name'];
        $aab_designation_star = english2bangla($aab['designation_star']);
        $aab_picture = $aab['scanDoc_picture'];
        $aab_referrer_id = $aab['referer_id'];
        }
$sql_select_cfs_user_all->execute(array($aab_referrer_id));
$arr_referrer = $sql_select_cfs_user_all->fetchAll();
foreach ($arr_referrer as $ar) $ar_referrer = $ar['account_name'];
if(!file_exists($aab_picture)) $aab_picture = "pic/default_profile.jpg";
?>

<title>প্রোফাইল ম্যানেজমেন্ট</title>
<style type="text/css">@import "css/domtab.css";</style>


<div class="columnSubmodule">
        <table class="formstyle">    
                <tr>
                    <th colspan="2" style="font-size: 15px;">একাউন্ট নম্বরঃ <?php echo $aab_account_number;?></th>
                </tr>
                <tr>
                    <?php
                    if($aab_user_type == "customer"){
                    ?>
                    <td>
                        <table>
                            <tr>
                                <td style='font-size: 20px; text-align:center;' colspan="2"><b>আপনার একাউন্টে স্বাগতম</b></td>
                            </tr>                            
                            <tr>
                                <td><b>রেফারার নামঃ </b></td>
                                <td><?php echo $ar_referrer;?></td>
                            </tr>
                            <tr>
                                <td><b>একাউন্ট খোলার তারিখঃ </b></td>
                                <td><?php echo $aab_open_date;?></td>
                            </tr>
                            <tr>
                                <td><b>ডেজিগনেশনঃ </b></td>
                                <td><?php echo "$aab_designation_name ($aab_designation_star স্টার)";?></td>
                            </tr>
                            <tr>
                                <td><b>একাউন্ট টাইপঃ </b></td>
                                <td>সেটেল একাউন্ট</td>
                            </tr>
                            <tr>
                                <td><b>এমাউন্টঃ </b></td>
                                <td>৫৪৮৭ টাকা</td>
                            </tr>
                        </table>
                    </td>
                    <?php
                    }
                    else echo "<td style='font-size: 20px; text-align:center;'><b>আপনার একাউন্টে স্বাগতম</b></td>";
                    ?>
                    <td style="width: 35%; text-align: center;">
                        <table >
                            <tr>
                                <td style="font-size: 16px; text-align: center;"><b><?php echo $aab_account_name;?></b></td>
                            </tr>
                            <tr>
                                <td style="text-align: center;"><img src="<?php echo $aab_picture;?>" width='120px' height='120px'/></td>
                            </tr>
                            <tr>
                                <td style="text-align: center;"><?php echo $aab_mobile;?></td>
                            </tr>
                            <tr>
                                <td style="text-align: center;"><?php echo $aab_email;?></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <?php
                if($aab_user_type == "customer"){
                ?>
                <tr>
                    <td colspan="2"><hr style="height: 4px;"></hr></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <table>
                            here some PV report will be kept
                        </table>
                    </td>
                </tr>
                <?php
                    }
                ?>
        </table>
</div>

<?php
include_once 'includes/footer.php';
?>
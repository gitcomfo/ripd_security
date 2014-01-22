<?php
include_once './connectionPDO.php';
$g_accountNo = $_GET['acNo'];
$sel_cfs_user = $conn->prepare("SELECT * FROM cfs_user WHERE account_number= ? ");
$sel_cfs_user->execute(array($g_accountNo));
$row = $sel_cfs_user->fetchAll();
$countrow = count($row);
if($countrow == 0)
{
    echo "<font style='color:red'>দুঃখিত, এই একাউন্ট নাম্বারটি সঠিক নয়</font>";
}
 else {
    foreach ($row as $value) {
        echo '<table>
                    <tr>
                        <td style="padding-left: 8px !important;width:29.5%;">একাউন্টধারীর নাম</td>
                        <td>: <input class="box" type="text" id="acName" name="acName" readonly="" value="'.$value['account_name'].'" /></td>
                    </tr>
                    <tr>
                        <td style="padding-left: 8px !important;">মোবাইল নাম্বার</td>
                        <td>: <input class="box" type="text" id="mobile" name="mobile" readonly="" value="'.$value['mobile'].'" /></td>
                    </tr>
                </table>';
    }
}


?>

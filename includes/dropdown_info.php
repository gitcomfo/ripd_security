<?php
include_once './connectionPDO.php';
$g_id = $_GET['cfsid'];
$sql= $conn->prepare("SELECT * FROM cfs_user,customer_account WHERE cfs_user_idUser = idUser AND  idUser = ?");
    $sql->execute(array($g_id));
    $cfs_row = $sql->fetchAll();
    foreach ($cfs_row as $row) {
        $db_number = $row['account_number'];
        $db_mbl = $row['mobile'];
        $db_pic = $row['scanDoc_picture'];
    }
    echo '<table>
                <tr><td colspan="2" style="border:1px solid black;"><img src="'.$db_pic.'" width="50px" height="50px"/></td></tr>
                <tr><td colspan="2" style="border:1px solid black;">স্টেপ পজিসন</td></tr>
                <tr><td colspan="2" style="border:1px solid black;"><a href="#" style="width:100%; background-color:none;">ইন</a></td></tr>
                <tr><td style="border:1px solid black;">অ্যাকাউন্ট নং </td><td style="border:1px solid black;">'.$db_number.'</td></tr>
                <tr><td style="border:1px solid black;">মোবাইল নং </td><td style="border:1px solid black;">'.$db_mbl.'</td></tr>
                <tr><td colspan="2" style="border:1px solid black;">রেফারকারির নাম </td></tr>
                <tr><td style="border:1px solid black;">আর ১</td><td style="border:1px solid black;">৭</td></tr>
                <tr><td style="border:1px solid black;">আর ২</td><td style="border:1px solid black;">৩৪</td></tr>
                <tr><td style="border:1px solid black;">আর ৩</td><td style="border:1px solid black;">৫৩২</td></tr>
                <tr><td style="border:1px solid black;">আর ৪</td><td style="border:1px solid black;">১৩৪৩</td></tr>
                <tr><td style="border:1px solid black;">আর ৫</td><td style="border:1px solid black;">৩৫৪৩১৩৪</td></tr>
            </table>';
?>

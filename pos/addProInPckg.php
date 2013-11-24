<?php
error_reporting(0);
include 'session.php';
include 'includes/connectionPDO.php';
$sql = "INSERT INTO package_temp(pckg_name ,pckg_code ,pckg_infoid, pckg_prochart_id ,pckg_pro_code, pckg_pro_name ,pckg_pro_qty) VALUES (?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);

    $P_pckgname=$_POST['pckg_name'];
     $P_pckgcode=$_POST['pckg_code'];
    $P_pckgid=$_SESSION['pckgid'];
     $P_prochartid=$_POST['proChartID'];
     $P_procode=$_POST['pcode'];
     $P_proname=$_POST['pname'];
     $P_QTY=$_POST['QTY'];
     
   $stmt->execute(array($P_pckgname, $P_pckgcode,$P_pckgid,  $P_prochartid, $P_procode, $P_proname, $P_QTY));
 header("location: create_package.php");

?>

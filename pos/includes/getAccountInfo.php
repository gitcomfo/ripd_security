<?php
//error_reporting(0);
include 'connectionPDO.php';
if($_GET['type']=='cust')
{
    $G_account = $_GET['acno'];
    $sql = "SELECT * FROM cfs_user WHERE account_number = ? AND cfs_account_status = 'active' ";
    $selectstmt = $conn ->prepare($sql);
    $selectstmt->execute(array($G_account));
    $all = $selectstmt->fetchAll();
    foreach($all as $row)
    {echo $row['account_name'];} 
}
elseif($_GET['type']=='emp')
{
    $G_account = $_GET['acno'];
    $sql = "SELECT * FROM cfs_user WHERE account_number = ? AND cfs_account_status = 'active' ";
    $selectstmt = $conn ->prepare($sql);
    $selectstmt->execute(array($G_account));
    $all = $selectstmt->fetchAll();
    foreach($all as $row)
    {echo $row['account_name'];}
}
elseif($_GET['type']=='store')
{
    $G_account = $_GET['acno'];
    $sql = "SELECT * FROM sales_store WHERE account_number = ? ";
    $selectstmt = $conn ->prepare($sql);
    $selectstmt->execute(array($G_account));
    $all = $selectstmt->fetchAll();
    foreach($all as $row)
    {echo $row['salesStore_name'];}
}
elseif($_GET['type']=='off')
{
    $G_account = $_GET['acno'];
    $sql = "SELECT * FROM office WHERE account_number = ? ";
    $selectstmt = $conn ->prepare($sql);
    $selectstmt->execute(array($G_account));
    $all = $selectstmt->fetchAll();
    foreach($all as $row)
    {echo $row['office_name'];}
}

?>

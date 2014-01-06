<?php
error_reporting(0);
session_start();
include_once './includes/connectionPDO.php';
$cfsID = $_SESSION['userIDUser'];
$storeID = $_SESSION['loggedInOfficeID'];
$scatagory =$_SESSION['loggedInOfficeType'];

$ins_replace_sum = $conn->prepare("INSERT INTO replace_product_summary(reprosum_store_type,reprosum_storeid,reprosum_replace_date , reprosum_replace_time ,reprosum_total_amount ,reprosum_invoiceno,cfs_userid) 
                                                            VALUES (?,?,CURDATE(), CURTIME(), ?, ?,?)");
$ins_replace = $conn->prepare("INSERT INTO replace_product(reppro_quantity ,reppro_amount ,inventory_idinventory ,replace_product_summary_idreproductsum) 
                                                    VALUES (?, ?, ?, ?)");
$sel_sales_summary = $conn->prepare("SELECT * FROM `sales_summary` WHERE sal_invoiceno=? ");
$up_sales_summary = $conn->prepare("UPDATE sales_summary SET status = 'replaced' WHERE sal_invoiceno = ? ");

$G_sellingType = $_GET['selltype'];
$str_recipt= "RIPD";
$forwhileloop = 1;
while($forwhileloop==1)
{
    for($i=0;$i<3;$i++)
        {
            $str_random_no=(string)mt_rand (0 ,9999 );
            $str_recipt_random= str_pad($str_random_no,4, "0", STR_PAD_LEFT);
            $str_recipt =$str_recipt."-".$str_recipt_random;
        }
        $sel_sales_summary->execute(array($str_recipt));
       $result= $sel_sales_summary->fetchAll();
        if (count($result)<1)
        {
            $forwhileloop = 0;
            break;
        }
}   
$_SESSION['SESS_MEMBER_ID']=$str_recipt;

if($G_sellingType==1)
{
    header("location: auto.php");
}
elseif($G_sellingType==2)
{
    header("location: wholesale.php");
}
elseif($G_sellingType==3)
{
     $prevRecipt = $_SESSION['recipt'];
     $db_totalamount = $_SESSION['repMoney'];   
     $conn->beginTransaction();
     $sqlresult1=$ins_replace_sum->execute(array($scatagory,$storeID,$db_totalamount,$prevRecipt,$cfsID));
     $replace_pro_sum_id= $conn->lastInsertId();
     foreach ($_SESSION['arrRepTemp'] as $replaceRow)
        {
            $repro_qty=$replaceRow[9];
            $repro_amount=$replaceRow[10];
            $repro_id = $replaceRow[4];
            $sqlresult2 = $ins_replace->execute(array($repro_qty,$repro_amount,$repro_id,$replace_pro_sum_id));
       }
       $sqlresult3 = $up_sales_summary->execute(array($prevRecipt));
     if($sqlresult1 && $sqlresult2 && $sqlresult3)
        {
            $conn->commit();
            unset($_SESSION['arrRepTemp']);
            header("location: sellAfterReplace.php");
        }
     else {
                $conn->rollBack();
                echo "<script>alert('দুঃখিত,প্রোডাক্ট রিপ্লেস হয়নি')</script>";
            }
}
?>
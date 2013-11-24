<?php
error_reporting(0);
include 'includes/ConnectDB.inc';
include 'includes/connectionPDO.php';

$selectsql = "SELECT * FROM `cfs_user` WHERE user_name=? AND password=? ";
$stmt = $conn->prepare($selectsql);
$errormsg = "";
//Function to sanitize values received from the form. Prevents SQL injection
	function clean($str) {
		$str = @trim($str);
		if(get_magic_quotes_gpc()) {
			$str = stripslashes($str);
		}
		return mysql_real_escape_string($str);
	}
//Sanitize the POST values
// Generate Guid 
	$login = clean($_POST['username']);
	$pass = clean($_POST['password']);
                    $password = md5($pass);
$stmt->execute(array($login,$password));
$row = $stmt->fetch();
if( count($row) > 1) 
    {
            $db_cfsID = $row['idUser'];
           $sql2="SELECT * FROM employee WHERE cfs_user_idUser=?";
           $stmt2= $conn->prepare($sql2);
           $stmt2->execute(array($db_cfsID));
           $row2 = $stmt2->fetch();
          // print_r($row2);
           //echo count($row2);
       if(count($row2)>1)
       {
         if($row2['employee_type'] == 'employee')
         {
             $db_onsid =$row2['emp_ons_id'];
            session_start();
            $_SESSION['onsid'] =$db_onsid;
            $_SESSION['cfsid']= $db_cfsID;
            header("location: welcome.php");
         }
       }
       else
       {
           $errormsg = "দুঃখিত, আপনি এই সার্ভিস এক্সেস করতে পারবেন না" ;
           header("location: index.php?msg=$errormsg");
           break;
       }
    }
    else
    {
        $errormsg = "ইউজার-এর নাম অথবা পাসওয়ার্ড ম্যাচ হয় নাই";
        header("location: index.php?msg=$errormsg");
    }
?>
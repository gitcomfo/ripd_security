<?php
session_start();

$dbhost = "192.168.1.100";
$dbname = "ripd_db_comfosys";
<<<<<<< HEAD
$dbuser = "cfs_ibrahim";
$dbpass = "ibrahim4321";
=======
$dbuser = "cfs_smriti";
$dbpass = "";
>>>>>>> branch 'master' of https://github.com/gitcomfo/ripd_security.git

// database connection
$conn = new PDO("mysql:host=$dbhost;dbname=$dbname",$dbuser,$dbpass);
$conn->exec("set names utf8");
?>

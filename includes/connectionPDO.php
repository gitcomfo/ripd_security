<?php
session_start();

$dbhost = "192.168.1.100";
$dbname = "ripd_db_comfosys";
$dbuser = "cfs_iftee";
$dbpass = "";

//$dbhost = "localhost";
//$dbname = "ripd_db_comfosys";
//$dbuser = "root";
//$dbpass = "";

// database connection
$conn = new PDO("mysql:host=$dbhost;dbname=$dbname",$dbuser,$dbpass);
$conn->exec("set names utf8");
?>

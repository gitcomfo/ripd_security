<?php
session_start();

$dbhost = "192.168.1.100";
$dbname = "ripd_db_comfosys";
$dbuser = "cfs_jessy";
$dbpass = "jesy4321";

//$dbhost = 'localhost';
//$dbuser = 'root';
//$dbpass = '';
//$dbname = 'ripd_db_comfosys';

// database connection
$conn = new PDO("mysql:host=$dbhost;dbname=$dbname",$dbuser,$dbpass);
$conn->exec("set names utf8");
?>

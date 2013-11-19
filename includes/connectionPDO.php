<?php
session_start();

$dbhost = "localhost";
$dbname = "ripd_db_comfosys";
$dbuser = "root";
$dbpass = "";

//$host = "localhost";
//$dbname = "ripd_db_comfosys";
//$dbuser = "root";
//$dbpassword = "";

// database connection
$conn = new PDO("mysql:host=$dbhost;dbname=$dbname",$dbuser,$dbpass);
$conn->exec("set names utf8");
?>

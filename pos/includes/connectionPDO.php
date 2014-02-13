<?php

$dbhost = "localhost";
$dbname = "ripd_db_comfosys";
$dbuser = "root";
$dbpass = "";

//$dbhost = "localhost";
//$dbname = "ripd_db_comfosys";
//$dbuser = "root";
//$dbpass = "";



// database connection
$conn = new PDO("mysql:host=$dbhost;dbname=$dbname",$dbuser,$dbpass);
$conn->exec("set names utf8");
?>

<?php

 $dbhost     = "192.168.1.100";
$dbname     = "ripd_db_comfosys";
$dbuser     = "cfs_iftee";
$dbpass     = "";



// database connection
$conn = new PDO("mysql:host=$dbhost;dbname=$dbname",$dbuser,$dbpass);
$conn->exec("set names utf8");
?>

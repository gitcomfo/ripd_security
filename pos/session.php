<?php 
session_start();
if(!isset($_SESSION['onsid']))
{
header( 'Location: index.php' ) ;
}

?>
<?php
$message_get = $_GET['msg'];
$mobile = $_GET['mob'];
//$message_get = "Hello Jesy.......$mobile";
$message_url = urlencode($message_get);
$message_final = substr($message_url, 0, 159);

//fixed parameter
$host = "121.241.242.114";
$port = "8080";
$username = "mfn-demo";
$password = "demo321";
$sender = "RIPD";
$msgtype = "0";
$dlr ="1";

$live_url = "http://$host:$port/bulksms/bulksms?username=$username&password=$password&type=$msgtype&dlr=$dlr&destination=$mobile&source=$sender&message=$message_final";

$parse_url=file_get_contents($live_url);
echo $parse_url;
?>



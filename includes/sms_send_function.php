<?php
function SendSMSFuntion($to, $txt) {
    //--------------------------
$message_get = $txt;
$mobile = $to;
//$message_get = "Hello Jesy.......$mobile";
$message_url = urlencode($message_get);
$message_final = substr($message_url, 0, 159);

//fixed parameter
$host = "121.241.242.114";
//$port = "8080";
$username = "mfn-demo";
$password = "demo321";
$sender = "RIPD";
$msgtype = "0";
$dlr ="1";

//$live_url = "http://$host:$port/bulksms/bulksms?username=$username&password=$password&type=$msgtype&dlr=$dlr&destination=$mobile&source=$sender&message=$message_final";
//$directURl = "http://121.241.242.114:8080/bulksms/bulksms?username=mfn-demo&password=demo321&type=0&dlr=0&destination=8801823146626&source=TSMTS&message=This+is+test";
      $ch = curl_init("http://$host/bulksms/bulksms?");
      //echo "CH= ".$ch. "<br/>";
      curl_setopt($ch, CURLOPT_POST, True);
      curl_setopt($ch, CURLOPT_POSTFIELDS,"username=$username&password=$password&type=0&dlr=1&destination=$mobile&source=$sender&message=$message_final");
      curl_setopt($ch, CURLOPT_TIMEOUT,60);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, True);

      $contents = curl_exec ($ch);

      //var_dump(curl_getinfo($ch));

      curl_close ($ch);
      return $contents;
    //---------------------------
}
?>


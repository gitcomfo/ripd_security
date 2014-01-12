<?php
error_reporting(0);
include_once 'includes/ConnectDB.inc';
include_once 'includes/connectionPDO.php';
include_once 'includes/MiscFunctions.php';
include_once 'includes/areaSearchForProduct.php';
$url = end(explode("/",urldecode($_GET['url'])));

$receiver_office_sstore_email = $_GET['office_sstore_mail'];

if (isset($_POST['submit_email'])) {
    $sender_name = $_POST['name'];
    $sender_email = $_POST['email'];
    $sender_mobile = $_POST['mobile'];
    $sender_message = $_POST['message'];
    $sender_msg_subject = $_POST['subject'];
    $receiver_email = $_POST['office_store_email'];

    $affiliation = "Dear Admin,";
    $sender_moblie_number = "My Contact Number: " . $sender_mobile;

    //echo "Sender Name: " . $sender_name . " Email: " . $sender_email . "Mobile " . $sender_mobile . "Subject " . $sender_msg_subject . "Message " . $sender_message . "R-email: " . $receiver_email . "<br/>";
    //mail($receiver_email, "Subject: $sender_msg_subject", $sender_message, "From: $sender_email");
    //$headers .= 'MIME-Version: 1.0' . "\r\n";
    //$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    //$sendMailValue = mail($receiver_email, $sender_msg_subject, $sender_message, "$headers \r\n From: $sender_email");

    $sendMailValue = mail($receiver_email, $sender_msg_subject, "$affiliation \n $sender_moblie_number \n\n $sender_message", "From: $sender_email");
    if ($sendMailValue) {
        $msg = "আপনার মেসেজটি সফলভাবে পাঠানো হয়েছে";
    } else {
        $msg = "দুঃখিত, আপনার মেসেজটি পাঠানো যাচ্ছে না।";
    }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<style type="text/css"> @import "css/bush.css";</style>
<script type="text/javascript" src="javascripts/area3.js"></script>
<script>
function validateForm()
{
    var account_id=document.forms["account_close_restart_form"]["account_number"].value;
    if (account_id==null || account_id=="")
    {
        alert("You Should Give An Account Number");
        return false;
    }
    var action_type = "";
    var len=document.forms["account_close_restart_form"]["acc_action_type"].length;
    for (i = 0; i < len; i++) {
        if ( document.forms["account_close_restart_form"].acc_action_type[i].checked ) {

            action_type = document.forms["account_close_restart_form"].acc_action_type[i].value;
            break;
        }
    }        
    if(action_type==null || action_type==""){
        //document.write(action_type);
        alert("যে কোনো একটি ধরন সিলেক্ট করুন");
        return false;
    }
    var fup = document.getElementById('scan_document_action');
    var fileName = fup.value;
    if(fileName==null || fileName==""){
        alert("আপনি কোনো স্ক্যান ডকুমেন্ট আপলোড করেন নাই। Please, Upload pdf, doc, Gif or Jpg content");
        fup.focus();
        return false;
    }else{
        var ext = fileName.substring(fileName.lastIndexOf('.') + 1);
        if(ext == "gif" || ext == "GIF" || ext == "JPEG" || ext == "jpeg" || ext == "jpg" || ext == "JPG" || ext == "doc" || ext == "pdf")
        {
            return true;
        } 
        else
        {
            alert("Please, Upload pdf, doc, Gif or Jpg content");
            fup.focus();
            return false;
        }
    }
}
function getOnSpost(typeNid)
{
    var xmlhttp;
    if (window.XMLHttpRequest)
    {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
    }
    else
    {// code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange=function()
    {
        if (xmlhttp.readyState==4 && xmlhttp.status==200)
        {
            document.getElementById('postTable').innerHTML=xmlhttp.responseText;
        }
    }
    xmlhttp.open("GET","includes/postListByOnS.php?typeNid="+typeNid,true);
    xmlhttp.send();
}
</script>
</head>
<body>

    <form action="<?php echo $url?>" method="post" name="uploadnew" target="parentWindow" onsubmit="setTimeout('self.close()',1000)">
    <table  class="formstyle" style="margin: 5px 10px 15px 10px; width: 100%; font-family: SolaimanLipi !important;">          
        <tr><th colspan="3" style="text-align: center;">সিলেক্ট অফিস এন্ড পোস্ট</th></tr>
        <tr>
            <td>
                <fieldset style="border:3px solid #686c70;width: 99%;">
                    <legend style="color: brown;font-size: 14px;">সার্চ করুন</legend>
                    <table>
                              <tr>
                               <td><?php getAreaOffice(); ?></td>
                               <td><select class="box" id="offNsales" name="offNsales" style="width: 200px;font-family: SolaimanLipi !important;" onchange="getOnSpost(this.value)" >
                                        <option value="0">-- অফিস / সেলসস্টোর --</option>
                                        </select>
                               </td>
                               </tr>
                      </table>
                  </fieldset>
                  </td> 
               </tr>
                <tr>
                    <td>
                        <fieldset style="border:3px solid #686c70;width: 99%;">
                            <legend style="color: brown;font-size: 14px;">অফিস নাম পোস্ট</legend>
                            <table style="width: 96%;margin: 0 auto;" cellspacing="0" cellpadding="0">
                                <thead>
                                    <tr id="table_row_odd">
                                        <td  style="border: solid black 1px;"><div align="center"><strong>পোস্টের নাম</strong></div></td>
                                        <td  style="border: solid black 1px;"><div align="center"><strong>পোস্টের সংখ্যা</strong></div></td>
                                        <td style="border: solid black 1px;"><div align="center"><strong>খালি পোস্ট</strong></div></td>
                                        <td style="border: solid black 1px;"><div align="center"><strong></strong></div></td>
                                    </tr>
                                </thead>
                                <tbody style="background-color: #FCFEFE" id="postTable"></tbody>
                            </table>
                            <input class="btn" style =" font-size: 12px; margin-left: 400px" type="submit" name="submitPost" value="সাবমিট" />
                        </fieldset>
                    </td> 
                </tr>
                </table>
</form>
</body>
</html>


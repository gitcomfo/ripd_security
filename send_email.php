<?php
error_reporting(0);
include_once 'includes/ConnectDB.inc';
include_once 'includes/MiscFunctions.php';

$msg = "";
$receiver_office_sstore_email = $_GET['emailAddress'];

if (isset($_POST['submit_email'])) {
    $sender_name = $_POST['name'];
    $sender_email = $_POST['email'];
    $sender_mobile = $_POST['mobile'];
    $sender_message = $_POST['message'];
    $sender_msg_subject = $_POST['subject'];
    $receiver_email = $receiver_office_sstore_email;

    //echo "Sender Name: " . $sender_name . " Email: " . $sender_email . "Mobile " . $sender_mobile . "Subject " . $sender_msg_subject . "Message " . $sender_message . "R-email: " . $receiver_email . "<br/>";

    //mail($receiver_email, "Subject: $sender_msg_subject", $sender_message, "From: $sender_email");
    //$headers .= 'MIME-Version: 1.0' . "\r\n";
    //$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    //$sendMailValue = mail($receiver_email, $sender_msg_subject, $sender_message, "$headers \r\n From: $sender_email");
    
    $sendMailValue = mail($receiver_email, $sender_msg_subject, $sender_message, "From: $sender_email");
    if ($sendMailValue){
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
        <script src="javascripts/tinybox.js" type="text/javascript"></script>
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
        </script>
    </head>
    <body>

        <form method="POST" onsubmit="" name="" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">	
            <table  class="formstyle" style="margin: 5px 10px 15px 10px; width: 100%; font-family: SolaimanLipi !important;">          
                <tr><th colspan="3" style="text-align: center;">Send Your Message in Mail</th></tr>
                <?php
                if ($msg == "") {
                    ?>
                    <tr>
                        <td style="width: 20%">Name</td>
                        <td style="width: 1%">:</td>
                        <td style="width: 55%">
                            <input type="text"  name="name" value="<?php echo $sender_name; ?>" placeholder="Type your Name"/><em2>*</em2>
                            <input type="hidden" name="account_cfs_user" id="account_cfs_user" value="<?php echo $account_cfs_user; ?>"/>
                        </td>                                      
                    </tr>
                    <tr>
                        <td>E-mail</td>
                        <td>:</td>
                        <td><input type="text"  name="email" value="<?php echo $sender_email; ?>" placeholder="Type your email address"/><em2>*</em2></td>
                    </tr>                
                    <tr>
                        <td>Mobile</td>
                        <td>:</td>
                        <td> <input type="text"  name="mobile" value="<?php echo $sender_mobile; ?>" placeholder="Type your mobile number"/></td>
                    </tr>
                    <tr>
                        <td>Subject</td>
                        <td>:</td>
                        <td><input type="text"  name="subject" value="<?php echo $sender_msg_subject; ?>" placeholder="Type your message Subject"/><em2>*</em2>  </td>                            
                    </tr>
                    <tr>
                        <td>Message</td>
                        <td>:</td>
                        <td style="padding-left: 0px"><textarea id='message' name='message' style='width: 90%;'><?php echo $sender_message; ?></textarea><em2>*</em2>
                    </tr>
                    <tr>                    
                        <td colspan="3" style="padding-left: 25%; " >                            
                              <input class="btn" style =" font-size: 12px; " type="submit" name="submit_email" value="সেন্ড করুন"/>
                            <input class="btn" style =" font-size: 12px" type="reset" name="reset" value="রিসেট করুন" />
                        </td>                        
                    </tr>    
                    <?php
                } else {
                    ?>
                    <tr>
                        <td colspan="2" style="text-align: center; font-size: 16px;color: green;"><?php echo $msg; ?></td>          
                    </tr>
                    <?php
//                                                echo "<script language=\"JavaScript\" type=\"text/javascript\">\n";
//                                                echo "<!--\n";
//                                                //echo "onload=\"javscript:self.parent.location.href = 'close_account.php';\"";
//                                                echo "top.location.href = 'close_account.php';\n";
//                                                echo "//-->\n";
//                                                echo "</script>\n";
                }
                ?>
            </table>
        </form>
    </body>
</html>


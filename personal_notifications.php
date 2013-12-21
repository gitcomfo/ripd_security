<?php
error_reporting(0);
include_once 'includes/ConnectDB.inc';
include_once 'includes/header.php';
include_once 'includes/columnViewAccount.php';
include_once 'includes/connectionPDO.php';

$flag = 'false';
function showMessage($flag, $msg) 
        {
        if (!empty($msg))
                {
                if ($flag == 'true') 
                    {
                    echo '<tr><td colspan="2" height="30px" style="text-align:center;"><b><span style="color:green;font-size:20px;">' . $msg . '</b></td></tr>';
                    }
                else 
                    {
                    echo '<tr><td colspan="2" height="30px" style="text-align:center;"><b><span style="color:red;font-size:20px;"><blink>' . $msg . '</blink></b></td></tr>';
                    }
                }
        }
if(isset($_POST['save']))
        {

        }
?>

<title>নোটিফিকেশন</title>
<style type="text/css">@import "css/bush.css";</style>
 
 <div class="columnSubmodule" style="font-size: 14px;">
    <form  action="" id="amountTransForm" method="post" style="font-family: SolaimanLipi !important;">
            <table class="formstyle" style ="width: 100%; margin-left: 0px; font-family: SolaimanLipi !important;">        
                <tr>
                    <th colspan="3">নোটিফিকেশন</th>
                </tr>
                <?php showMessage($flag, $msg);?>
                <tr>
                 <td style="text-align: center; width: 100%;">এই মুহূর্তে আপনার কোনো নোটিফিকেশন নাই</td>
                </tr>
                
            </table>
        </form>
    </div>

<?php include_once 'includes/footer.php'; ?> 
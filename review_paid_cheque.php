<?php
include 'includes/header.php';
include_once 'includes/MiscFunctions.php';

if(isset($_POST['check']))
{
    $p_chequeNo = $_POST['chequeNo'];
}
?>

<style type="text/css"> @import "css/bush.css";</style>

    <div class="main_text_box">
        <div id="noprint" style="padding-left: 110px;"><a href="accounting_sys_management.php"><b>ফিরে যান</b></a></div>
        <div>           
            <form method="POST" onsubmit="" name="cheque" action="">	
                <table  class="formstyle" style="width: 80%;font-family: SolaimanLipi !important; font-size: 14px;">          
                    <tr ><th colspan="4" style="text-align: center;font-size: 16px;">রিভিউ পেইড চেক</th></tr>
                    <tr>
                        <td colspan="2" style="text-align: right;width: 50%;">চেক নাম্বার</td>
                        <td colspan="2" style="text-align: left;width: 50%;"> : <input class="box" type="text" name='chequeNo' /> </td>
                    </tr>
                    <tr>
                        <td  colspan="4" style="text-align: center;" ></br><input class="btn" style =" font-size: 12px; " name='check' type="submit" value="যাচাই করুন" /></td>
                    </tr>
                    <?php if(isset($_POST['check'])) {?>
                    <tr>
                        <td colspan="2" style="width: 50%; text-align: right">চেক নাম্বার </td>
                        <td colspan="2" style="width: 50%; text-align: left"> : </td>
                    </tr>
                    <tr>
                        <td style=" width: 25%; text-align: right">চেক তৈরির দিন </td>
                        <td style="width: 25%; text-align: left"> : </td>
                        <td style="width: 25%; text-align: right">সময় </td>
                        <td style="width: 25%; text-align: left"> : </td>
                    </tr>
                    
                    <tr>
                        <td colspan="2" style="width: 50%; text-align: right">একাউন্টধারীর নাম </td>
                        <td colspan="2" style="width: 50%; text-align: left"> : </td>
                    </tr>
                    
                    <tr>
                        <td colspan="2" style="width: 50%; text-align: right">একাউন্ট নাম্বার</td>
                        <td colspan="2" style="width: 50%; text-align: left"> : </td>
                    </tr>
                    <tr>
                        <td colspan="2" style="width: 50%; text-align: right">চেক এমাউন্ট </td>
                        <td colspan="2" style="width: 50%; text-align: left"> : </td>
                    </tr>
                    <tr>
                        <td colspan="2" style="width: 50%; text-align: right">চেক স্ট্যাটাস</td>
                        <td colspan="2" style="width: 50%; text-align: left"> : </td>
                    </tr>
                    
                    <tr>
                        <td style="width: 25%; text-align: right">টাকা উত্তোলন / স্থগিতের তারিখ</td>
                        <td style="width: 25%;text-align: left"> : </td>
                         <td style="width: 25%;text-align: right">সময় </td>
                        <td style="width: 25%;text-align: left"> : </td>
                    </tr>
                    
                    <tr>
                        <td style="width: 25%; text-align: right">অফিসের নাম</td>
                        <td style="width: 25%; text-align: left"> : </td>
                         <td style="width: 25%; text-align: right">সময় </td>
                        <td style="width: 25%; text-align: left"> : </td>
                    </tr>
                   
                    <?php }?>
                </table>
                
            </form>
        </div>
    </div>
<?php include 'includes/footer.php'; ?>

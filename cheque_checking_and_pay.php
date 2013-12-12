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
        <div id="noprint" style="padding-left: 110px;"><a href=""><b>ফিরে যান</b></a></div>
        <div>           
            <form method="POST" onsubmit="" name="cheque" action="">	
                <table  class="formstyle" style="width: 80%;font-family: SolaimanLipi !important; font-size: 14px;">          
                    <tr ><th colspan="2" style="text-align: center;font-size: 16px;">চেক-এর বৈধতা যাচাই এবং টাকা প্রদান </th></tr>
                    <tr>
                        <td style="text-align: right;width: 50%;">চেক নাম্বার :</td>
                        <td style="text-align: left;width: 50%;"><input class="box" type="text" name='chequeNo' /> </td>
                    </tr>
                    <tr>
                        <td  colspan="2" style="text-align: center;" ></br><input class="btn" style =" font-size: 12px; " name='check' type="submit" value="যাচাই করুন" /></td>
                    </tr>
                    <?php if(isset($_POST['check'])) {?>
                    <tr>
                        <td colspan="2" style="text-align: center;" id="viewCheque">
                            </br><div id='cheque' style='width: 574px; height: 320px; font-size:12px; border: blue solid 1px; margin: 0 auto; background-image: url(images/cheque.gif);background-repeat: no-repeat;background-size:100% 320px;'>
                                    <div style='width: 558px;height: 70px;float: left;padding-left: 15px; background-image: url(images/background.gif);background-repeat: no-repeat;background-size:100% 70px;'></div>
                                    <div id='cheque_body' style='width: 570px;float: left;padding-left: 2px;'>
                                           <div style='width: 570px;float: left;'>
                                                  <div id='cheque_dateTime' style='text-align:left; width: 280px;float: left'>তারিখঃ <?php echo date("d.m.y"); ?>&nbsp;&nbsp;&nbsp;&nbsp;সময়ঃ <?php print date('g:i a', strtotime('+4 hour')) ?></div>
                                                  <div id='cheque_no' style='text-align: right;width: 290px;float: left;'>চেক নাম্বার : <input type='text'readonly='' style='width: 200px;' value='<?php echo $str_checque_no; ?>' /></div>
                                            </div></br></br>
                                             <div style='text-align: left;'><span>টাকার পরিমাণ : <input type='text' readonly='' style='width:200px;text-align:right;padding:0px 2px;' value='<?php echo $P_totalTaka; ?>' /> TK</span></div>
                                             <div id='amount_in_words' style='text-align: left;'><span>টাকার পরিমাণ (কথায়) :</span><?php echo $totalTaka_inWords; ?> Taka only.</div></br>
                                             <div style='text-align: left;'><span>অ্যাকাউন্ট নং  : </span><input type='text' readonly style='width:200px;padding:0px 2px;' value='<?php echo $accountnumber ?>' /></div></br>
                                                 <div style='text-align: left;'><span>অ্যাকাউন্টের নাম: </span><input type='text' readonly style='width:200px;padding:0px 2px;' value='<?php echo $accountname ?>' /></div>
                                             <div style='float: right;height: 20px;padding-top: 10px;text-align: right;'><input type='text' readonly style='width:230px;' /><hr style='width:230px; height: 2px; background-color: black;'/> এখানে স্বাক্ষর করুন&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>
                                     </div>
                                </div></br>
                        </td>
                    </tr>
                    <tr>
                        <td style="text-align: right;width: 50%;">চেক স্ট্যাটাস :</td>
                        <td style="text-align: left;width: 50%;"><input class="box" type="text" name='chequeStatus' /> </td>
                    </tr>
                    <tr>
                        <td style="text-align: right;width: 50%;">এডমিনের পাসওয়ার্ড:</td>
                        <td style="text-align: left;width: 50%;"><input class="box" type="text" name='pass' /> </td>
                    </tr>
                    <tr>                    
                        <td id="noprint" colspan="2" style="text-align: center; " ><input class="btn" style =" font-size: 12px; width: 150px;" type="submit" name="pay" value="ঠিক আছে" /></td>                           
                    </tr>
                    <?php }?>
                </table>
                </fieldset>
            </form>
        </div>
    </div>
<?php include 'includes/footer.php'; ?>

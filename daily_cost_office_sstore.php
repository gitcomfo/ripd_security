<?php
include_once 'includes/session.inc';
include_once 'includes/header.php';
include_once './includes/selectQueryPDO.php';
$ins_ons_exp = $conn->prepare("INSERT INTO ons_operational_exp(exp_total_amount ,exp_date ,exp_ons_id, exp_maker_id,exp_making_date) 
                                                         VALUES (?,?,?,?,NOW())");
$ins_ons_exp_details = $conn->prepare("INSERT INTO ons_opexp_details(onsexp_sector ,onsexp_amount, onsexp_description ,onsexp_scandoc, fk_onsopexp_idonsopexp) 
                                                                    VALUES (?,?,?,?,?)");
$ins_daily_inout = $conn->prepare("INSERT INTO acc_ofc_daily_inout (daily_date, daily_onsid, out_amount) VALUES (NOW(),?,?)");
$sel_main_fund = $conn->prepare("SELECT fund_amount FROM main_fund WHERE fund_code= 'SOF'");
$sel_store_logical = $conn->prepare("SELECT * FROM acc_store_logc WHERE ons_type= 's_store' AND ons_id = ?");
$up_main_fund = $conn->prepare("UPDATE main_fund SET fund_amount = fund_amount - ? WHERE fund_code = 'SOF'");
$up_store_logical_xprofit = $conn->prepare("UPDATE acc_store_logc SET AEP = AEP - ?, last_update = NOW() WHERE ons_type= 's_store' AND ons_id = ?");
$up_store_logical_profit = $conn->prepare("UPDATE acc_store_logc SET ASE = ASE - ?, last_update = NOW() WHERE ons_type= 's_store' AND ons_id = ?");
$up_store_logical_buying = $conn->prepare("UPDATE acc_store_logc SET ACM = ACM - ?, last_update = NOW() WHERE ons_type= 's_store' AND ons_id = ?");

$allowedExts = array("gif", "jpeg", "jpg", "png", "JPG", "JPEG", "GIF", "PNG");
if (isset($_POST['submit'])) {
    $exp_ons_type = $_SESSION['loggedInOfficeType'];
    $exp_ons_id = $_SESSION['loggedInOfficeID'];
    $exp_maker_id = $_SESSION['userIDUser'];
    
    $sql_select_id_ons_relation->execute(array($exp_ons_type,$exp_ons_id));
    $row = $sql_select_id_ons_relation->fetchAll();
    foreach ($row as $onsrow) {
        $db_onsID = $onsrow['idons_relation'];
    }
    $total_exp = $_POST['totalamount'];
    $indate = $_POST['exp_date'];
    $sub = $_POST['sub'];
    $quan1 = $_POST['quantity1'];
    $desc = $_POST['desc'];
    $n = count($sub);
    
    $conn->beginTransaction();
    
    if($exp_ons_type == 'office')
    {
        $sel_main_fund->execute();
        $fundrow = $sel_main_fund->fetchAll();
        foreach ($fundrow as $value) {
            $fundamount = $value['fund_amount'];
        }
        if($fundamount >= $total_exp)
        {
            $sqlresult1= $ins_ons_exp->execute(array($total_exp,$indate,$db_onsID,$exp_maker_id));
            $ons_exp_id = $conn->lastInsertId();
            $sqlrslt5 = $up_main_fund->execute(array($total_exp));
        }
        else {
               $sqlresult1 = 0;
           }
    }
     else 
    {
        $sel_store_logical->execute(array($exp_ons_id));
        $storerow = $sel_store_logical->fetchAll();
        foreach ($storerow as $value) {
            $db_profit = $value['ASE'];
            $db_xtraProfit = $value['AEP'];
            $db_buying = $value['ACM'];
            $db_total = $db_profit + $db_xtraProfit + $db_buying;
        }
        if($db_total > $total_exp)
        {
            if($total_exp > $db_profit)
            {
                $upsql = $up_store_logical_profit->execute(array($db_profit,$exp_ons_id));
                $updated_totalsalary = $total_exp - $db_profit;
                
                if($updated_totalsalary > $db_xtraProfit)
                {
                     $upsql = $up_store_logical_xprofit->execute(array($db_xtraProfit,$exp_ons_id));
                     $updated_totalsalary = $updated_totalsalary - $db_xtraProfit;
                     $upsql =  $up_store_logical_buying->execute(array($updated_totalsalary,$exp_ons_id));
                }
                else 
                {
                     $upsql = $up_store_logical_xprofit->execute(array($updated_totalsalary,$exp_ons_id));
                }
            }
            else
            {
                $upsql = $up_store_logical_profit->execute(array($total_exp,$exp_ons_id));
            }
            $sqlresult1= $ins_ons_exp->execute(array($total_exp,$indate,$db_onsID,$exp_maker_id));
            $ons_exp_id = $conn->lastInsertId();
        }
    else 
        {
            $sqlresult1 = 0;
        }
        
    }
    
    for ($i = 0; $i < $n; $i++) 
    { 
        $namevalue = "cost_scandoc$i";
        $extension = end(explode(".", $_FILES["$namevalue"]["name"]));
        $image_name = "ons-exp-".$indate."-".$_FILES["$namevalue"]["name"];
        $image_path = "scaned/" .$image_name;
        if (($_FILES["$namevalue"]["size"] < 999999999999) && in_array($extension, $allowedExts)) 
                {
                    move_uploaded_file($_FILES["$namevalue"]["tmp_name"], "scaned/" .$image_name);
                } 
        $sqlresult2 = $ins_ons_exp_details ->execute(array($sub[$i],$quan1[$i],$desc[$i],$image_path,$ons_exp_id));
    }
    
    $insert = $ins_daily_inout->execute(array($db_onsID,$total_exp));
    
    if($sqlresult1  && $sqlresult2 && $insert)
        {
            $conn->commit();
            echo "<script>alert('দৈনিক অফিস খরচ দেয়া হল')</script>";
        }
        else {
            $conn->rollBack();
            echo "<script>alert('দুঃখিত, দৈনিক অফিস খরচ দেয়া হয়নি')</script>";
        }
}
?>
<style type="text/css">@import "css/bush.css";</style>
<link rel="stylesheet" type="text/css" media="all" href="javascripts/jsDatePick_ltr.min.css" />
<script type="text/javascript" src="javascripts/jsDatePick.min.1.3.js"></script>
<script type="text/javascript" src="javascripts/jquery-1.4.3.min.js"></script>
<script type="text/javascript">
    $('.del').live('click',function(){
        $(this).parent().parent().remove();
    });
    $('.add').live('click',function()
    {
        var appendTxt= "<tr><td ><input id='sub' name='sub[]' type='text' style=' width: 135px;border: 1px inset darkblue;padding-left: 1px;-moz-border-radius: 2px;border-radius: 2px;' /><em2> *</em2></td><td><input class='inbox' style='text-align: right;width: 135px;border: 1px inset darkblue;padding-left: 1px;-moz-border-radius: 2px;border-radius: 2px;' id='quantity1' name='quantity1[]' type='text' onkeypress='return numbersonly(event)' onkeyup='calculateTotal()' />\n\
                                        <em2> *</em2> TK</td>\n\
                                         <td><textarea class='textfield' type='text' id='desc' name='desc[]' ></textarea></td><td ><input class='box5' type='file' id='cost_scandoc' name='cost_scandoc' style='font-size:10px;''/></td><td ><input type='button' class='del' /></td><td><input type='button' class='add' /></td>\n\
</tr>";
        $("#container_others:last").after(appendTxt);
    })

window.onclick = function()
    {
        new JsDatePick({
            useMode: 2,
            target: "date",
            dateFormat: "%Y-%m-%d"
        });
    }
    
function checkIt(evt) // float value-er jonno***********************
    {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode ==8 || (charCode >47 && charCode <58) || charCode==46) {
        return true;
    }
    return false;
}
function calculateTotal()
{
    var total= 0;
        $(".inbox").filter(function() {
         var val = parseFloat($(this).val());
         total = parseFloat(total) + val;
    });
    $('#totalamount').val(total);
}
function validate() {
        var notOK= 0;
        $(".inbox").filter(function() {
         var val = $(this).val();
        if((val == "") || (val == 0))
            {
                 notOK++;
            }
    });
    return notOK;
 }
function beforeSubmit()
{
    var blank = validate();
    if ((document.getElementById('date').value !="") && blank == 0)
        { return true; }
    else {
        alert("ফর্মের * বক্সগুলো সঠিকভাবে পূরণ করুন");
        return false; 
    }
}
</script>
<div class="column6">
    <div class="main_text_box">
        <div style="padding-left: 110px;"><a href="office_sstore_management.php"><b>ফিরে যান</b></a></div>
        <div>
            <form method="POST" enctype="multipart/form-data" action="" id="off_form" name="off_form" onsubmit="return beforeSubmit()">
                <table class="formstyle"  style=" width: 92%;" > 
                    <tr><th colspan="6" style="text-align: center" colspan="4"><h1>অফিস / সেলসস্টোর খরচ (দৈনিক)</h1></th></tr>
                    <tr>
                        <td colspan="6"><b>খরচের তারিখঃ </b><input class="box" type="text" id="date" placeholder="Date" name="exp_date"/><em2> *</em2></td>     
                    </tr>               
                    <tr>
                        <td><b>বিষয় :</b></td>
                        <td><b>পরিমান :</b></td>
                        <td><b>ব্যাখ্যা :</b></td>
                        <td><b>স্ক্যান ডকুমেন্টস :</b></td>
                    </tr>
                    <tr id="container_others">
                        <td><input id="sub" name="sub[]"  type="text" style=" width: 135px;border: 1px inset darkblue;padding-left: 1px;-moz-border-radius: 2px;border-radius: 2px;" /><em2> *</em2></td>
                        <td><input class="inbox" style="text-align: right;width: 135px;border: 1px inset darkblue;padding-left: 1px;-moz-border-radius: 2px;border-radius: 2px;" id="quantity1" name="quantity1[]" type="text" onkeypress="return checkIt(event)" onkeyup="calculateTotal();" /><em2> *</em2> TK</td>
                        <td><textarea class="textfield" type="text" id="desc" name="desc[]" ></textarea></td>
                        <td><input class="box5" type="file" id="cost_scandoc0" name="cost_scandoc0" style="font-size:10px;"/></td>
                        <td ></td>
                        <td><input type="button" class="add" /></td>
                    </tr>
                    <tr>
                        <td colspan="2" ><hr /></td>
                    </tr>
                    <tr>
                        <td style="text-align: right"><b>মোট :</b></td>
                        <td><input class="textfield" id="totalamount" name="totalamount"  type="text" readonly="" style="text-align: right;" value="0" /> TK</td>
                    </tr>
                    <tr>                    
                        <td colspan="4" style="padding-left: 320px; " >
                            <br/><input class="btn" style =" font-size: 12px " type="submit" name="submit" id="submit" value="সেভ করুন" readonly="" />
                        </td>                           
                    </tr>
                </table>
            </form>                          
        </div>
    </div>  
</div>    
<?php include_once 'includes/footer.php'; ?>
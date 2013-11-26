<?php
include_once 'includes/session.inc';
include_once 'includes/header.php';

$sql_officeTable = "SELECT * from " . $dbname . ".office ORDER BY office_name ASC";
$rs = mysql_query($sql_officeTable);
$row_officeNcontact = mysql_fetch_assoc($rs);
$db_offID = $row_officeNcontact['idOffice'];

$onsq = "SELECT * FROM " . $dbname . ".`ons_relation` WHERE add_ons_id=$db_offID AND catagory= 'office' ";
$onssql = mysql_query($onsq);
while ($ons_row = mysql_fetch_assoc($onssql)) {
    $idons = $ons_row['idons_relation'];
}

$cost = "SELECT * FROM " . $dbname . ".`ons_cost` WHERE ons_relation_idons_relation=$idons";
$costsql = mysql_query($cost);
while ($cost_row = mysql_fetch_assoc($costsql)) {
    $costid = $cost_row['idons_cost'];
    $rent = $cost_row['rent'];
    $rentINT = (int) $rent;
    list($before_dot, $after_dot) = explode('.', $rent);
    $rentDeci = substr($after_dot, 0, 2);
    $current = $cost_row['current_bill'];
    $currentINT = (int) $current;
    list($before_dot, $after_dot) = explode('.', $current);
    $currentDeci = substr($after_dot, 0, 2);
    $water = $cost_row['water_bill'];
    $waterINT = (int) $water;
    list($before_dot, $after_dot) = explode('.', $water);
    $waterDeci = substr($after_dot, 0, 2);
    $idcost = $cost_row['idons_cost'];
}
$count = 0;
$othercost = "SELECT * FROM " . $dbname . ".`ons_cost_others` WHERE ons_cost_idons_cost=$costid";
$othercostsql = mysql_query($othercost);

while ($othercost_row = mysql_fetch_assoc($othercostsql)) {
    $sub[$count] = $othercost_row['cost_type'];
    $quan[$count] = $othercost_row['cost_amount'];
    $quanINT[$count] = (int) $quan[$count];
    list($before_dot, $after_dot) = explode('.', $quan[$count]);
    $quanDeci = substr($after_dot, 0, 2);
    $count++;
}
$otherID = $othercost_row['idons_cost_others'];

if (isset($_POST['submit'])) {
    $month = $_POST['month'];
    $year = $_POST['year'];
    $rent1 = $_POST['office_rent1'];
    $rent2 = $_POST['office_rent2'];
    $ons_rent = $rent1 . "." . $rent2;
    $e_bill1 = $_POST['electicity_bill1'];
    $e_bill2 = $_POST['electicity_bill2'];
    $ons_current_bill = $e_bill1 . "." . $e_bill2;
    $w_bill1 = $_POST['water_bill1'];
    $w_bill2 = $_POST['water_bill2'];
    $ons_water_bill = $w_bill1 . "." . $w_bill2;
    $costup = "INSERT INTO $dbname.`ons_fixed_expenditure` ( `month`,`year`,`ons_rent`,`ons_current_bill`,`ons_water_bill`) VALUES( '$month','$year','$ons_rent','$ons_current_bill','$ons_water_bill');";
    $costsql = mysql_query($costup);
    $sub = $_POST['sub'];
    $quan1 = $_POST['quantity1'];
    $quan2 = $_POST['quantity2'];
    $n = count($sub);
    for ($i = 0; $i < $n; $i++) {
        $quan[$i] = $quan1[$i] . "." . $quan2[$i];
        $osql = "INSERT INTO $dbname.`ons_fixed_exp_others`(`ons_cost_type` ,`ons_cost_amount` ,`idexp_fixed_cost`) VALUES ( '$sub[$i]',  '$quan[$i]', '$costid');";
        $oreslt = mysql_query($osql);
    }
}
?>
<style type="text/css">
    @import "css/bush.css";
</style>
<link rel="stylesheet" type="text/css" media="all" href="javascripts/jsDatePick_ltr.min.css" />
<script type="text/javascript" src="javascripts/jsDatePick.min.1.3.js"></script>
<script type="text/javascript" src="javascripts/jquery-1.4.3.min.js"></script>
<script type="text/javascript">
    $('.del').live('click',function(){
        $(this).parent().parent().remove();
       
    });
    $('.add').live('click',function()
    {
        var appendTxt= "<tr><td colspan='2'><input class='textfield'  id='sub' name='sub[]' type='text' /></td><td colspan='2'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <input class='textfield' style='text-align: right' id='quantity1' name='quantity1[]' type='text' onkeypress='return numbersonly(event)' />\n\
                                        . <input class='boxTK' id='quantity2' name=quantity2[]' type='text' onkeypress='return numbersonly(event)'/> TK <em> (ইংরেজিতে লিখুন)</em></td></td></tr>";
        $("#container_others:last").after(appendTxt);
    })
    
    function numbersonly(e)
    {
        var unicode=e.charCode? e.charCode : e.keyCode
        if (unicode!=8)
        { //if the key isn't the backspace key (which we should allow)

            if (unicode<48||unicode>57) //if not a number
                return false //disable key press
        }
    }

</script>
<div class="column6">
    <div class="main_text_box">
        <div style="padding-left: 110px;"><a href="office_sstore_management.php"><b>ফিরে যান</b></a></div>
        <div>
            <form method="POST" action="" id="off_form" name="off_form">
                <table class="formstyle"  > 
                    <tr><th colspan="4" style="text-align: center" colspan="2"><h1>অফিস খরচ (মাসিক)</h1></th></tr>                      
                    <tr>                    
                        <td>
                            <b>মাসঃ </b>
                            <select class='box2' name='month'>
                                <?php
                                $inc = 1;
                                $month_array = array('সিলেক্ট করুন'=>'সিলেক্ট করুন','জানুয়ারি'=>'জানুয়ারি', 'ফেব্রুয়ারি'=>'ফেব্রুয়ারি', 'মার্চ' =>'মার্চ', 'এপ্রিল'=>'এপ্রিল', 'মে'=>'মে', 'জুন'=> 'জুন', 'জুলাই'=> 'জুলাই', 'আগষ্ট'=>'আগষ্ট', 'সেপ্টেম্বর'=> 'সেপ্টেম্বর','অক্টোবর'=> 'অক্টোবর','নভেম্বর'=> 'নভেম্বর','ডিসেম্বর'=> 'ডিসেম্বর');
                                while (list ($inc, $val) = each($month_array))
                                    echo "<option value=$inc>$val</option>";
                                ?>
                            </select>
                        </td>                                    
                        <td>
                            <b>বছরঃ </b>
                            <select class='box2' name='year'>
                                <?php
                                for ($inc_year = 2013; $inc_year <= 2099; $inc_year = $inc_year + 1)
                                    echo "<option value='$inc_year'>$inc_year</option>";
                                ?>
                            </select>
                        </td>  
                    </tr>     
                    <tr>
                        <td>ভাড়া</td>
                        <td >: <input readonly="" class="textfield" style="text-align: right" type="text" id="office_rent1" name="office_rent1" onkeypress="return numbersonly(event)" value="<?php echo $rentINT; ?>" />
                            . <input readonly="" class="boxTK" type="text" maxlength="2"  id="office_rent2" name="office_rent2"  onkeypress=" return numbersonly(event)" value="<?php echo $rentDeci; ?>"/>TK
                        </td>
                    </tr>
                    <tr>
                        <td  >কারেন্ট বিল</td>
                        <td >:   <input class="textfield" style="text-align: right" type="text" id="electicity_bill1" name="electicity_bill1" onkeypress="return numbersonly(event)" value="<?php echo $currentINT; ?>"/>
                            . <input class="boxTK" type="text" maxlength="2"  id="electicity_bill2" name="electicity_bill2" onkeypress="return numbersonly(event)" value="<?php echo $currentDeci; ?>"/>TK<em> (ইংরেজিতে লিখুন)</em></td>
                    </tr>
                    <tr>
                        <td >পানি বিল</td>
                        <td>:   <input class="textfield" style="text-align: right" type="text" id="water_bill1" name="water_bill1" onkeypress="return numbersonly(event)" value="<?php echo $waterINT; ?>"/>
                            . <input class="boxTK" type="text" maxlength="2" id="water_bill2" name="water_bill2" onkeypress="return numbersonly(event)" value="<?php echo $waterDeci; ?>"/>TK<em> (ইংরেজিতে লিখুন)</em> </td>
                    </tr>                     
                    <tr>
                        <td colspan="2" ><hr /></td>
                    </tr>
                    <tr>
                        <td style="padding-top: 14px;vertical-align: top; width: 25%;"><b>অন্যান্য</b></td>
                    </tr>
                    <tr>
                        <td id="container_others" colspan="2">
                                <?php
                                for ($i = 0; $i < $count; $i++) {
                                    echo "<tr>";
                                    echo "<td><input type='hidden'  id='sub' name='sub[]' value='$sub[$i]' />$sub[$i]</td>";
                                    echo"<td>: <input class='textfield' style='text-align: right' id='quantity1' name='quantity1[]' type='text' onkeypress='return numbersonly(event)' value='$quanINT[$i]' />
                                                            . <input class='boxTK' maxlength='2' id='quantity2' name='quantity2[]' type='text' onkeypress='return numbersonly(event)' value='$quanDeci[$i]' /> TK<em> (ইংরেজিতে লিখুন)</em></td>";
                                    echo "</tr>";
                                }
                                ?>
                        </td>
                    </tr>                 
                    </td>
                    </tr>  
                    <tr>                    
                        <td colspan="4" style="padding-left: 250px; " >
                            </br><input class="btn" style =" font-size: 12px " type="submit" name="submit" id="submit" value="সেভ করুন" />
                        </td>                           
                    </tr>
                </table>
            </form>                          
        </div>
    </div>  
</div>    
<?php 
include_once 'includes/footer.php'; 
?>
<?php
include_once 'includes/session.inc';
include_once 'includes/header.php';

if (isset($_POST['submit'])) {
   // print_r($_FILES);
    $exp_ons_type = $_SESSION['loggedInOfficeType'];
    $exp_ons_id = $_SESSION['loggedInOfficeID'];
    $exp_maker_id = $_SESSION['userIDUser'];
    $indate = $_POST['exp_date'];
    $sub = $_POST['sub'];
    $quan1 = $_POST['quantity1'];
    $quan2 = $_POST['quantity2'];
    $desc = $_POST['desc'];
    $n = count($sub);
    for ($i = 0; $i < $n; $i++) {
    $allowedExts = array("gif", "jpeg", "jpg", "png", "JPG", "JPEG", "GIF", "PNG");
    $namevalue = "cost_scandoc$i";
    $extension = end(explode(".", $_FILES["$namevalue"]["name"]));
    $image_name = "_" . $_FILES["$namevalue"]["name"];
    $image_path = "scaned/" .$image_name;
    if (($_FILES["$namevalue"]["size"] < 999999999999) && in_array($extension, $allowedExts)) {
        move_uploaded_file($_FILES["$namevalue"]["tmp_name"], "scaned/" .$image_name);
    } else {
        echo "Invalid file format.";
    }
        $quan[$i] = $quan1[$i] . "." . $quan2[$i];
        //$osql = "INSERT INTO $dbname.`ons_operational_exp`(`exp_date` ,`exp_sector` ,`exp_amount`,`exp_desc`,`exp_scandoc`,`exp_ons_type`,`exp_ons_id`,`exp_maker_id`) VALUES ('$indate','$sub[$i]', '$quan[$i]', '$desc[$i]', '$image_path', 1, 1);";
        $osql = "INSERT INTO ons_operational_exp(`exp_date` ,`exp_sector` ,`exp_amount`,`exp_desc`,`exp_scandoc`,`exp_ons_type`,`exp_ons_id`,`exp_maker_id`) 
            VALUES ('$indate','$sub[$i]', '$quan[$i]', '$desc[$i]', '$image_path', '$exp_ons_type', '$exp_ons_id', '$exp_maker_id');";
        $oreslt = mysql_query($osql) or exit(mysql_error());
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
        var appendTxt= "<tr><td ><input class='textfield'  id='sub' name='sub[]' type='text' /></td><td><input class='textfield' style='text-align: right' id='quantity1' name='quantity1[]' type='text' onkeypress='return numbersonly(event)' />\n\
                                        . <input class='boxTK' id='quantity2' name=quantity2[]' type='text' onkeypress='return numbersonly(event)'/> TK</td>\n\
                                         <td><textarea class='textfield' type='text' id='desc' name='desc[]' ></textarea></td><td ><input class='box5' type='file' id='cost_scandoc' name='cost_scandoc' style='font-size:10px;''/></td><td ><input type='button' class='del' /></td><td><input type='button' class='add' /></td><?php
$new++;
echo $new;
?></tr>";
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
            <form method="POST" enctype="multipart/form-data" action="" id="off_form" name="off_form">
                <table class="formstyle"  style=" width: 92%;" > 
                    <tr><th colspan="6" style="text-align: center" colspan="4"><h1>অফিস খরচ (দৈনিক)</h1></th></tr>
                    <tr>
                        <td colspan="6"><b>খরচের তারিখঃ </b><input class="box" type="text" id="date" placeholder="Date" name="exp_date"/></td>     
                    </tr>               
                    <tr >
                        <td>
                    <tr>
                        <td>বিষয়  :</td>
                        <td>পরিমান : <em> (ইংরেজিতে লিখুন)</em></td>
                        <td>ব্যাখ্যা  :</td>
                        <td>স্ক্যান ডকুমেন্টস  :</td>
                    </tr>
                    <tr id="container_others">
                        <td><input class="textfield" id="sub" name="sub[]"  type="text" /></td>
                        <td ><input class="textfield" style="text-align: right" id="quantity1" name="quantity1[]" type="text" onkeypress="return numbersonly(event)" />  
                            . <input class="boxTK" maxlength="2" id="quantity2" name="quantity2[]" type="text" onkeypress="return numbersonly(event)" /> TK</td>
                        <td><textarea class="textfield" type="text" id="desc" name="desc[]" ></textarea></td>
                        <td><input class="box5" type="file" id="cost_scandoc0" name="cost_scandoc0" style="font-size:10px;"/></td>
                        <td ></td>
                        <td><input type="button" class="add" /></td>
                    </tr>
                    </td>
                    </tr>  
                    <tr>                    
                        <td colspan="4" style="padding-left: 320px; " >
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
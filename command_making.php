<?php
include_once 'includes/session.inc';
include_once 'includes/header.php';
?>
<?php
$flag = 'false';
function showMessage($flag, $msg) {
    if (!empty($msg)) {
        if ($flag == 'true') {
            echo '<tr><td colspan="2" height="30px" style="text-align:center;"><b><span style="color:green;font-size:20px;">' . $msg . '</b></td></tr>';
        } else {
            echo '<tr><td colspan="2" height="30px" style="text-align:center;"><b><span style="color:red;font-size:20px;"><blink>' . $msg . '</blink></b></td></tr>';
        }
    }
}

if (isset($_POST['submit']) && ($_GET['action'] == 'new')) {
    $division = $_POST ['new_division'];
    $sql = "insert into division (division_name) values('$division')";
    if (mysql_query($sql)) {
        $msg = "আপনি সফলভাবে " . $division . " নামে নতুন বিভাগটি তৈরি করেছেন";
        $flag = 'true';
    } else {
        $msg = "দুঃখিত, আবার চেষ্টা করুন";
        $flag = 'false';
    }
}
if (isset($_POST['submit']) && ($_GET['action'] == 'edit')) {
    $division_id = $_GET['id'];
    $division_name = $_POST ['division_name'];
    $sql = "update division set division_name='$division_name' where idDivision='$division_id'";
    if (mysql_query($sql)) {
        $msg = "আপনি সফলভাবে " . $division_name . " বিভাগ নামে তথ্য পরিবর্তন করেছেন";
        $flag = 'true';
    } else {
        $msg = "দুঃখিত, আবার চেষ্টা করুন";
        $flag = 'false';
    }
}
?>
<title>কমান্ড</title>
<style type="text/css">
    @import "css/bush.css";
</style>
<script type="text/javascript">
    function  isBlankDivision_new()
    {
        var y=document.forms["division"]["division_name_new"].value;
        if (y == null || y == "")
        {
            alert("বিভাগের নাম পূরন করুন");
            return false;
        }
    }
    function isBlankDivision_edit()
    {
        var x=document.forms["division"]["division_name_edit"].value;
        if (x== null || x== "")
        {
            alert("বিভাগের নাম পূরন করুন");
            return false;
        }
       
    }
</script>
<?php
if ($_GET['action'] == 'edit') {
    ?>
    <div style="padding-top: 10px;">    
        <div style="padding-left: 110px; width: 63%; float: left"><a href="command_system_management.php"><b>ফিরে যান</b></a></div>
        <div ><a href="command_making.php?action=new"> নতুন কমান্ড  </a>&nbsp;&nbsp;<a href="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>"> কমান্ড লিস্ট</a></div>
    </div>
    <div>
        <form  name="division" action="" onsubmit="return isBlankDivision_edit()" method="post">
             <table class="formstyle" style =" width:78%;">        
                    <tr>
                        <th colspan="2">কমান্ড তৈরি করুন</th>
                    </tr>
                    <tr>
                        <td style="text-align: right; width: 40%;">কমান্ড নম্বর</td>
                        <td>: <input  class="box" type="text" name="command_no"/></td>   
                    </tr>
                    <tr>
                        <td style="text-align: right; width: 40%;">কমান্ড বর্ণনা</td>
                        <td><textarea  class="box" name="command_desc"></textarea></td>   
                    </tr>
                    <tr>
                        <td style="text-align: right; width: 40%;">১০০ টাকা </td>
                        <td>=<input  class="box" type="text" name="pv_100" /> পি,ভি</td>   
                    </tr>     
                    <tr>
                        <td style="text-align: right; width: 40%;">১ টাকা </td>
                        <td>=<input  class="box" type="text" name="pv_1" /> পি,ভি</td>   
                    </tr>             
                    <tr>
                        <td colspan="2" style="text-align: center;"></br><input type="submit" class="btn" name="submit_command" id="submit_command" value="ঠিক আছে">&nbsp;<input type="reset" class="btn" name="reset" value="রিসেট"></td>
                    </tr>
                </table>
        </form>
    </div>

    <?php
} elseif ($_GET['action'] == 'new') {
    ?>
    <div style="font-size: 12px;">
        <form  name="division" action="" onsubmit="return isBlankDivision_new()" method="post">
            <div style="padding-top: 10px;">    
                <div style="padding-left: 110px; width: 63%; float: left"><a href="command_system_management.php"><b>ফিরে যান</b></a></div>
                <div  ><a href="command_making.php?action=new"> নতুন কমান্ড </a>&nbsp;&nbsp;<a href="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>">কমান্ড লিস্ট</a></div>
            </div>
             <table class="formstyle" style =" width:78%;">        
                    <tr>
                        <th colspan="2">কমান্ড তৈরি করুন</th>
                    </tr>
                    <tr>
                        <td style="text-align: right; width: 40%;">কমান্ড নম্বর</td>
                        <td>: <input  class="box" type="text" name="command_no"/></td>   
                    </tr>
                    <tr>
                        <td style="text-align: right; width: 40%;">কমান্ড বর্ণনা</td>
                        <td><textarea  class="box" name="command_desc"></textarea></td>   
                    </tr>
                    <tr>
                        <td style="text-align: right; width: 40%;">১০০ টাকা </td>
                        <td>=<input  class="box" type="text" name="pv_100" /> পি,ভি</td>   
                    </tr>     
                    <tr>
                        <td style="text-align: right; width: 40%;">১ টাকা </td>
                        <td>=<input  class="box" type="text" name="pv_1" /> পি,ভি</td>   
                    </tr>             
                    <tr>
                        <td colspan="2" style="text-align: center;"></br><input type="submit" class="btn" name="submit_command" id="submit_command" value="ঠিক আছে">&nbsp;<input type="reset" class="btn" name="reset" value="রিসেট"></td>
                    </tr>
                </table>
        </form>
    </div>
    <?php
} else {
    ?>
    <div style="padding-top: 10px;">    
        <div style="padding-left: 110px; width: 63%; float: left"><a href="command_system_management.php"><b>ফিরে যান</b></a></div>
        <div><a href="command_making.php?action=new"> নতুন কমান্ড </a>&nbsp;&nbsp;<a href="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>">কমান্ড লিস্ট</a></div>
    </div>
    <div>
        <form method="POST">
            <table class="formstyle" style =" width:90%" >
                <tr>
                    <th>  কমান্ড </th>
                </tr>
                <tr>
                    <td>
                        <table style="width: 80%; padding-left: 140px">                         
                            <tr id = "table_row_odd">
                                <td style="background-color: #89C2FA; width: 25%;" >কমান্ড নং</td>
                                <td style="background-color: #89C2FA; width: 30%;">কমান্ড বর্ণনা</td>
                                <td style="background-color: #89C2FA; width: 25%;">১ টাকা সমমূল্য পিভি</td>
                                <td style="background-color: #89C2FA; width: 20%;"></td>
                            </tr>
                            <?php
                            $result = mysql_query("select * from division");
                            while ($row = mysql_fetch_array($result)) {
                                $division_id = $row['idDivision'];
                                $division_name = $row['division_name'];
                                echo "  <tr>
                        <td>$division_name</td>
                            <td>$division_name</td>
                                <td>$division_name</td>
                        <td style='text-align: center ' > <a href='command_making.php?action=edit&id=$division_id'> এডিট কমান্ড </a></td>  
                    </tr>";
                            }
                            ?>
                        </table>
                    </td>
                </tr>
            </table>
        </form>
    </div>

    <?php
}
include_once 'includes/footer.php';
?> 


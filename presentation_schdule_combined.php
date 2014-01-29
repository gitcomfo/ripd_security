<?php
error_reporting(0);
include 'includes/header.php';
include_once 'includes/MiscFunctions.php';

$arr_presenter = array();
$type=$_GET['type'];
$typeinbangla = getProgramType($type);
$whoinbangla =  getProgramer($type);
$whoType = getProgramerType($type);

$sql_cfs_emp_sel = $conn->prepare("SELECT idEmployee FROM cfs_user, employee WHERE cfs_user_idUser = idUser AND account_number= ?");
$sql_program_ins = $conn->prepare("INSERT INTO program (program_no, program_name, program_location, program_date, program_time, program_type, Office_idOffice) 
              VALUES (?, ?, ?, ?, ?, ?, ?)");
 $sql_presenterlist_ins = $conn->prepare("INSERT INTO presenter_list (fk_idprogram, fk_Employee_idEmployee) VALUES (?, ?)");

 if (($_POST['new_submit'])) {
    $P_prstn_name = $_POST['presentation_name'];
    $P_prstn_date = $_POST['presentation_date'];
    $P_prstn_location = $_POST['place'];
     $str_random_no=(string)mt_rand (0 ,9999 );
     $str_program_random= str_pad($str_random_no,4, "0", STR_PAD_LEFT);
    $prstn_number_final = $type."-".$str_program_random;
    $P_prstn_time = $_POST['presentation_time'];
    $arr_presenter = $_POST['p_acno'];
    $no_ofpresenters = count($arr_presenter);
    $P_officeID = $_POST['parent_id'];

    $conn->beginTransaction();
        $y1 = $sql_program_ins->execute(array($prstn_number_final,$P_prstn_name,$P_prstn_location, $P_prstn_date, $P_prstn_time, $type, $P_officeID ));
        $db_last_insert_id = $conn->lastInsertId();
      for($i=0;$i<$no_ofpresenters;$i++)
      {
          $account = $arr_presenter[$i];
          $sql_cfs_emp_sel->execute(array($account));
          $get =  $sql_cfs_emp_sel->fetchAll();
          foreach ($get as $value) {
              $empid = $value['idEmployee'];
          }
          $y = $sql_presenterlist_ins->execute(array($db_last_insert_id,$empid));
      }
    if ($y1 && $y) {
        $conn->commit();
        $msg = "<font style='color:green'>তথ্য সংরক্ষিত হয়েছে</font>";
    } else {
        $conn->rollBack();
        $msg = "<font style='color:red''>ভুল হয়েছে</font>";
    }
}
//###################UPDATE QUERY#######################
elseif (isset($_POST['submit1'])) {
    $P_prstn_id = $_POST['pesentation_id'];
    $P_prstn_unumber = $_POST['presentation_number'];
    $P_prstn_uname = $_POST['presentation_name'];
    $P_prstn_location = $_POST['place'];
    $P_prstn_udate = $_POST['presentation_date'];
    $P_prstn_utime = $_POST['presentation_time'];
    $P_presenter_name = $_POST['presenters'];
     $str_presenter_list = substr($P_presenter_name, 0, -2);
    $arr_presenter = explode(", ", $str_presenter_list);
    $no_ofpresenters = count($arr_presenter);
     mysql_query("START TRANSACTION");
    $sql_up = mysql_query("UPDATE program 
                                 SET program_name='$P_prstn_uname', program_date='$P_prstn_udate', 
                                 program_time='$P_prstn_utime' ,program_location= '$P_prstn_location'
                                 WHERE program_no='$P_prstn_unumber'");
    $del_prsnterlist = mysql_query("DELETE FROM presenter_list WHERE fk_idprogram='$P_prstn_id' ");
     for($i=0;$i<$no_ofpresenters;$i++)
             {
                 $account = $arr_presenter[$i];
                 $sql = mysql_query("SELECT idEmployee FROM cfs_user, employee WHERE cfs_user_idUser = idUser AND account_number= '$account'");
                 $getrow = mysql_fetch_assoc($sql);
                 $empid = $getrow['idEmployee'];
                 $y =mysql_query("INSERT INTO presenter_list (fk_idprogram, fk_Employee_idEmployee) VALUES ($P_prstn_id,$empid)");
             }
    if ($sql_up && $del_prsnterlist && $y) {
        mysql_query("COMMIT");
        $msgi = "<font style='color:green'>তথ্য সংরক্ষিত হয়েছে</font>";
    } else {
         mysql_query("ROLLBACK");
        $msgi = "<font style='color:red'>ভুল হয়েছে</font>";
    }
}
?>
<title><?php echo $typeinbangla;?> শিডিউল</title>
<script type="text/javascript" src="javascripts/external/mootools.js"></script>
<script type="text/javascript" src="javascripts/dg-filter.js"></script>
<link rel="stylesheet" type="text/css" media="all" href="javascripts/jsDatePick_ltr.min.css" />
<script type="text/javascript" src="javascripts/jsDatePick.min.1.3.js"></script>
<script type="text/javascript" src="javascripts/jquery.js"></script>
<script type="text/javascript" src="javascripts/jquery.autocomplete.js"></script>
<script type="text/javascript" src="javascripts/area.js"></script>
<link rel="stylesheet" type="text/css" href="css/jquery.autocomplete.css"/>
<script type="text/javascript" src="javascripts/jquery-1.4.3.min.js"></script>
<style type="text/css">@import "css/bush.css";</style>
<script type="text/javascript">
$('.del').live('click',function(){
	$(this).parent().parent().remove();
        });
        $('.add').live('click',function()
        {
            var appendTxt= "<tr><td><input class='box' id='p_acno' name='p_acno[]' /></td><td><input class='box' id='p_name'  />\n\
                                        <td><input class='box' id='p_mbl' /></td>\n\
                                         <td style='text-align:right;'><input type='button' class='del' />&nbsp;<input type='button' class='add' /></td></tr>";
            $("#container_others:last").after(appendTxt);
        })
window.onclick = function()
    {
        new JsDatePick({
            useMode: 2,
            target: "presentation_date",
            dateFormat: "%Y-%m-%d"
        });
    };
    
function setOffice(office,offid)
{
        document.getElementById('off_name').value = office;
        document.getElementById('parent_id').value = offid;
        document.getElementById('parentResult').style.display = "none";
        setLocation(offid);
}
function beforeSave()
    {
        if (document.getElementById('presenters').value != "")
        {
            document.getElementById('submit1').readonly = false;
            return true;
        }
        else {
            document.getElementById('submit1').readonly = true;
            return false;
        }
    }
</script>
<script>
function getOffice(str_key) // for searching parent offices
{
    var xmlhttp;
       if (window.XMLHttpRequest)
        {
            xmlhttp=new XMLHttpRequest();
        }
        else
        {// code for IE6, IE5
            xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange=function()
        {
            if(str_key.length ==0)
                {
                   document.getElementById('parentResult').style.display = "none";
               }
                else
                    {document.getElementById('parentResult').style.visibility = "visible";
                document.getElementById('parentResult').setAttribute('style','position:absolute;top:40%;left:54%;width:250px;z-index:10;border: 1px inset black; overflow:auto; height:105px; background-color:#F5F5FF;');
                    }
                document.getElementById('parentResult').innerHTML=xmlhttp.responseText;
        }
        xmlhttp.open("GET","includes/getParentOffices.php?search="+str_key+"&office=1",true);
        xmlhttp.send();	
}

function setLocation(offid)
{     
       var xmlhttp;
        if (window.XMLHttpRequest) xmlhttp=new XMLHttpRequest();
        else xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
        xmlhttp.onreadystatechange=function()
        {
            if (xmlhttp.readyState==4 && xmlhttp.status==200) 
                document.getElementById('place').value=xmlhttp.responseText;
        }
        xmlhttp.open("GET","includes/getParentOffices.php?office="+offid,true);
        xmlhttp.send();
}
    function infoFromThana()
    {
        var type = '<?php echo $whoType;?>';
        var xmlhttp;
        if (window.XMLHttpRequest) xmlhttp=new XMLHttpRequest();
        else xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
        xmlhttp.onreadystatechange=function()
        {
            if (xmlhttp.readyState==4 && xmlhttp.status==200) 
                document.getElementById('plist').innerHTML=xmlhttp.responseText;
        }
        var division_id, district_id, thana_id;
        division_id = document.getElementById('division_id').value;
        district_id = document.getElementById('district_id').value;
        thana_id = document.getElementById('thana_id').value;
        xmlhttp.open("GET","includes/updatePresentersFromThana.php?dsd="+district_id+"&dvd="+division_id+"&ttid="+thana_id+"&type="+type,true);
        xmlhttp.send();
    }
    
     function beforeSubmit(){
    if ((document.getElementById('presentation_name').value !="")
    && (document.getElementById('presenters').value !="")
    && (document.getElementById('off_name').value !="")
    && (document.getElementById('place').value !="")
    && (document.getElementById('presentation_date').value !="")
    && (document.getElementById('presentation_time').value !=""))
        { return true; }
    else {
        alert("ফর্মের * বক্সগুলো সঠিকভাবে পূরণ করুন");
        return false; 
    }
}
</script>

<!--*********************Presentation List****************** -->
<?php
if ($_GET['action'] == 'first') {
    ?>
    <div style="padding-top: 10px;">    
        <div style="padding-left: 110px; width: 49%; float: left"><a href="program_management.php"><b>ফিরে যান</b></a></div>
        <div><a href="presentation_schdule_combined.php?action=first&type=<?php echo $type;?>"><?php echo $typeinbangla;?> লিস্ট</a>&nbsp;&nbsp;<a href="presentation_schdule_combined.php?action=new&type=<?php echo $type;?>">মেইক <?php echo $typeinbangla;?></a>&nbsp;&nbsp;<a href="presentation_schdule_combined.php?action=list&type=<?php echo $type;?>"><?php echo $whoinbangla?>-এর  লিস্ট</a></div>
    </div>
    <div>
        <form method="POST" onsubmit="">	
            <table  class="formstyle" style =" width:78%" id="make_presentation_fillter">      
                <thead>
                    <tr>
                        <th colspan="8" ><?php echo $typeinbangla;?> সিডিউল</th>                        
                    </tr>          
                    <tr>
                        <td colspan="8" style="text-align: right">খুঁজুন:  <input type="text" class="box" id="search_filter" /></td>
                    </tr>
                    <tr id = "table_row_odd">
                        <td ><?php echo $typeinbangla;?> নাম্বার</td>
                        <td ><?php echo $typeinbangla;?> নাম</td>
                        <td ><?php echo $whoinbangla?>-এর নাম</td>
                        <td >রিপড ই মেইল</td>
                        <td >তারিখ</td>
                        <td>বার</td>
                        <td > সময় </td>     
                        <td>অপশন</td>
                    </tr>
                </thead>
                <tbody> 

                    <!--######################SELECT QUERY########################## -->
                    <?php
                    $db_result_presenter_name = mysql_query("SELECT * FROM program WHERE program_type = '$type' AND program_date >= NOW() ORDER BY program_no ");
                    while ($row_prstn = mysql_fetch_array($db_result_presenter_name)) {
                        $str_presenter_list = "";
                        $str_presenter_email_list = "";
                        $db_programID = $row_prstn['idprogram'];
                        $db_rl_prstn_number = $row_prstn['program_no'];
                        $db_rl_prstn_name = $row_prstn['program_name'];
                        $db_rl_prstn_date = $row_prstn['program_date'];
                        $db_rl_prstn_time = $row_prstn['program_time'];
                        $sql_prsntr_list = mysql_query("SELECT * FROM presenter_list, employee, cfs_user 
                                                                             WHERE idUser=cfs_user_idUser AND idEmployee= fk_Employee_idEmployee AND fk_idprogram=$db_programID ");
                         while ($row_prsnter = mysql_fetch_array($sql_prsntr_list)) {
                             $str_presenter_list = $row_prsnter['account_name'].",\n".$str_presenter_list;
                             $str_presenter_email_list = $row_prsnter['email'].",\n".$str_presenter_email_list;
                         }
                        ?>
                        <tr>
                            <td><?php echo $db_rl_prstn_number; ?></td>
                            <td><?php echo $db_rl_prstn_name; ?></td>
                            <td><?php echo $str_presenter_list; ?></td>
                            <td><?php echo $str_presenter_email_list; ?></td>
                            <td><?php echo $db_rl_prstn_date; ?></td>
                            <td>
                                <?php
                                $timestamp = strtotime($db_rl_prstn_date);
                                $day = date('D', $timestamp);
                                if ($day == 'Wed') {
                                    echo "বুধ";
                                } elseif ($day == 'Thu') {
                                    echo "বৃহস্পতি";
                                } elseif ($day == 'Fri') {
                                    echo "শুক্র";
                                } elseif ($day == 'Sat') {
                                    echo "শনি";
                                } elseif ($day == 'Sun') {
                                    echo "রবি";
                                } elseif ($day == 'Mon') {
                                    echo "সোম";
                                } elseif ($day == 'Tue') {
                                    echo "মঙ্গল";
                                }
                                ?>
                            </td>
                            <td><?php echo $db_rl_prstn_time; ?></td>
                            <td style="text-align: center " > <a href="presentation_schdule_combined.php?action=edit&id=<?php echo $db_programID; ?>&type=<?php echo $type;?>"> এডিট সিডিউল </a></td>  
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </form>
    </div>
    <script type="text/javascript">
        var filter = new DG.Filter({
            filterField : $('search_filter'),
            filterEl : $('make_presentation_fillter'),
            colIndexes : [1,2]
        }); 
    </script>
    <!--******************Make Presentation************** -->
    <?php
} else if ($_GET['action'] == 'new') {
    ?>
    <div style="padding-top: 10px;">    
        <div style="padding-left: 110px; width: 49%; float: left"><a href="program_management.php"><b>ফিরে যান</b></a></div>
        <div> <a href="presentation_schdule_combined.php?action=first&type=<?php echo $type;?>"><?php echo $typeinbangla;?>লিস্ট</a>&nbsp;&nbsp;<a href="presentation_schdule_combined.php?action=new&type=<?php echo $type;?>">মেইক <?php echo $typeinbangla;?></a>&nbsp;&nbsp;<a href="presentation_schdule_combined.php?action=list&type=<?php echo $type;?>"><?php echo $whoinbangla?>-এর  লিস্ট</a></div>
    </div>

    <div>
        <form method="POST" autocomplete="off" aciton="presentation_schdule_combined.php?action=first" onsubmit="return beforeSubmit()">
            <table class="formstyle" style =" width:78%">
                <tr>
                    <th colspan="5">  মেইক <?php echo $typeinbangla;?></th>
                </tr>
                <?php
               if ($msg != "") {
                    echo "<tr>
                    <td colspan='2' style='text-align: center;font-size:16px;'>$msg </td>
                </tr>";
                }
                ?>
                <tr>
                    <td ><?php echo $typeinbangla;?>-এর নাম</td>               
                    <td colspan="3">: <input  class="box" type="text" name="presentation_name" id="presentation_name" value="" /><em2> *</em2></td>   
                </tr>      
                <tr>
                    <td>অফিস</td>               
                    <td colspan="3">: <input class="box" id="off_name" name="offname" onkeyup="getOffice(this.value);" /><em2> *</em2><em> (অ্যাকাউন্ট নাম্বার)</em>
                       <div id="parentResult"></div><input type="hidden" name="parent_id" id="parent_id"/>
                    </td>
                </tr>
                <tr>
                    <td>স্থান</td>
                    <td colspan="3">: <input  class="box" type="text" id="place" name="place" value=""/><em2> *</em2></td>            
                </tr>
                <tr>
                    <td >তারিখ </td>
                    <td colspan="3">: <input class="box"type="text" id="presentation_date" placeholder="Date"  style="" name="presentation_date" value=""/><em2> *</em2></td>   
                    </td>   
                </tr>
                <tr>
                    <td > সময় </td>
                    <td colspan="3">: <input  class="box" type="time" id="presentation_time" name="presentation_time" value=""/><em2> *</em2></td>  
                </tr>
                <tr>
                    <td colspan="4" style="text-align: center;"></br><?php echo $whoinbangla?> সিলেক্ট করুন<em2> *</em2></td>               
                </tr>
                <tr>
                    <td>একাউন্ট নাম্বার</td>
                    <td>নাম</td>
                    <td>মোবাইল নং</td>
                    <td></td>
                </tr>
                <tr id="container_others">
                    <td><input class="box" id="p_acno" name="p_acno[]" /></td>
                    <td><input class="box" id="p_name"  /></td>
                    <td><input class="box" id="p_mbl"  /></td>
                    <td style="text-align: right"><input type="button" class="add" /></td>
                </tr>
                <tr>
                    <td colspan="2" style="text-align: center"></br><input type="submit" class="btn" name="new_submit" value="সেভ" >
                        &nbsp;
                        <input type="reset" class="btn" name="reset" value="রিসেট"></td>
                </tr>
            </table>
        </form>
    </div>
    <!--***************Edit Schedule****************** -->
    <?php
} elseif ($_GET['action'] == 'edit') {
    ?>
    <div style="padding-top: 10px;">    
        <div style="padding-left: 110px; width: 49%; float: left"><a href="presentation_schdule_combined.php?action=first&type=<?php echo $type;?>">ফিরে যান</b></a></div>
        <div> <a href="presentation_schdule_combined.php?action=first&type=<?php echo $type;?>"><?php echo $typeinbangla;?> লিস্ট</a>&nbsp;&nbsp;<a href="presentation_schdule_combined.php?action=new&type=<?php echo $type;?>">মেইক <?php echo $typeinbangla;?></a>&nbsp;&nbsp;<a href="presentation_schdule_combined.php?action=list&type=<?php echo $type;?>"><?php echo $whoinbangla?>-এর  লিস্ট</a></div>
    </div>
    <div>
        <!--PHP coding for SHOWING THE DATA IN EDIT SCHEDULE -->     
        <?php
        $G_presentation_id = $_GET['id'];
        $sql_edit = "SELECT * FROM program WHERE idprogram =$G_presentation_id ";
        $db_result_edit = mysql_query($sql_edit);
        $row_edit = mysql_fetch_array($db_result_edit);
        $db_rl_presentation_number = $row_edit['program_no'];
        $db_rl_presentation_name = $row_edit['program_name'];
        $db_rl_presentation_date = $row_edit['program_date'];
        $db_rl_presentation_time = $row_edit['program_time'];
        $db_rl_presentation_location = $row_edit['program_location'];
      
        ?>
        <form method="POST"> <!--Redirect from one page to another -->
            <table class="formstyle" style =" width:78%" id="presentation_fillter">       
                <tr>
                    <th colspan="5">  এডিট সিডিউল </th>
                </tr>
              <?php
                if ($msgi != "") {
                    echo "<tr>
                    <td colspan='2' style='text-align: center;font-size:16px;'>$msgi</font> 
                </tr>";
                }
                ?>
                <tr>
                    <td style="width:40%" ><?php echo $typeinbangla;?> নাম্বার</td>
                    <td>: <input  class="box" type="text" name="presentation_number" readonly  value="<?php echo $db_rl_presentation_number; ?>"/></td>   
                </tr>
                <tr>
                    <td ><?php echo $typeinbangla;?> নাম</td>               
                    <td>: <input  class="box" type="text" name="presentation_name" value="<?php echo $db_rl_presentation_name; ?>"/>
                        <input type="hidden" name="pesentation_id" value="<?php echo $G_presentation_id;?>"</td>   
                </tr>
                <tr>
                    <td>স্থান</td>
                    <td>:    <input  class="box" type="text" id="place" name="place" value="<?php echo $db_rl_presentation_location;?>"/></td>            
                </tr>
                <tr>
                    <td >তারিখ</td>
                    <td>: <input class="box" type="text" id="presentation_date" placeholder="Date"  style="" name="presentation_date" value="<?php echo $db_rl_presentation_date; ?>"/></td>
                    </td>   
                </tr>
                <tr>
                    <td > সময় </td>
                    <td>: <input  class="box" type="time" name="presentation_time" value="<?php echo $db_rl_presentation_time; ?>"/></td>
                </tr>
                <tr>
                    <td colspan="4" style="text-align: center;"></br><?php echo $whoinbangla?> সিলেক্ট করুন<em2> *</em2></td>               
                </tr>
                <tr>
                    <td>একাউন্ট নাম্বার</td>
                    <td>নাম</td>
                    <td>মোবাইল নং</td>
                    <td></td>
                </tr>
                <tr id="container_others">
                    <td><input class="box" id="p_acno" name="p_acno[]" /></td>
                    <td><input class="box" id="p_name"  /></td>
                    <td><input class="box" id="p_mbl"  /></td>
                    <td style="text-align: right"><input type="button" class="add" /></td>
                </tr>
                <tr>
                    <td colspan="2" style="text-align: center"><input type="submit" class="btn" name="submit1" id="submit1" readonly="" onclick="return beforeSave();" value="সেভ" > 
                        &nbsp;<input type="reset" class="btn" name="reset" value="রিসেট"></td>
                </tr>
            </table>
        </form>
    </div>
    <!--***************########### Presenters list 00000000000000000****************** -->
    <?php
} elseif ($_GET['action'] == 'list') {
    ?>
    <div style="padding-top: 10px;">    
        <div style="padding-left: 110px; width: 49%; float: left"><a href="program_management.php"><b> ফিরে যান</b></a></div>
        <div><a href="presentation_schdule_combined.php?action=first&type=<?php echo $type;?>"><?php echo $typeinbangla;?> লিস্ট</a>&nbsp;&nbsp;<a href="presentation_schdule_combined.php?action=new&type=<?php echo $type;?>">মেইক <?php echo $typeinbangla;?></a>&nbsp;&nbsp;<a href="presentation_schdule_combined.php?action=list&type=<?php echo $type;?>"><?php echo $whoinbangla?>-এর  লিস্ট</a> </div> 
    </div> 

    <form method="POST" onsubmit="">	
        <table  class="formstyle" style =" width:85%"id="presentation_fillter">          
            <thead>
                <tr>
                    <th colspan="10" ><?php echo $whoinbangla?>-এর  লিস্ট </th>                        
                </tr>             
                <tr >
                    <td colspan="10">
                     <?php include_once 'includes/areaSearch.php';
                                    getArea("infoFromThana()");
                    ?>
                    <input type="hidden" id="method" value="infoFromThana()">
                    </td>
                </tr>
                <tr id = "table_row_odd">
                    <td><?php echo $whoinbangla?>-এর নাম </td>
                    <td >একাউন্ট নাম্বার</td>
                    <td >সেল নাম্বার</td>
                    <td >ইমেইল</td>
                    <td >প্রকার</td>
                    <td> থানা</td>
                    <td>জেলা</td>
                    <td>বিভাগ</td>
                    <td>অপশন</td>
                </tr>
            </thead>
            <tbody id="plist">
                <!--Presenter List Query -->
                <?php
                $arrayEmpStatus = array('posting' => 'কর্মচারী', 'contract' => 'চুক্তিবদ্ধ');
                $db_result_presenter_info = mysql_query("SELECT * FROM cfs_user, employee WHERE idUser=employee.cfs_user_idUser 
                                                                                    AND employee.employee_type='$whoType' "); 
                while ($row_prstn = mysql_fetch_array($db_result_presenter_info)) {
                    $db_rl_presenter_name = $row_prstn['account_name'];
                    $db_rl_presenter_acc = $row_prstn['account_number'];
                    $db_rl_presenter_mobile = $row_prstn['mobile'];
                    $db_rl_presenter_email = $row_prstn['email'];
                    $db_rl_presenter_id = $row_prstn['idEmployee'];
                    $db_rl_presenter_status = $row_prstn['status'];
                    $sql_list_address= mysql_query("SELECT * FROM employee, address, thana, district, division WHERE idEmployee=$db_rl_presenter_id AND adrs_cepng_id= idEmployee 
                                                                            AND address_type='Present' AND address_whom='emp' 
                                                                            AND Thana_idThana=idThana AND District_idDistrict = idDistrict AND Division_idDivision=idDivision ");
                  $addressrow = mysql_fetch_assoc($sql_list_address);                    
                        $db_thana = $addressrow['thana_name'];
                        $db_district = $addressrow['district_name'];
                        $db_division = $addressrow['division_name'];
                    ?>
                    <tr>
                        <td ><?php echo $db_rl_presenter_name; ?></td>
                        <td><?php echo $db_rl_presenter_acc; ?></td>
                        <td><?php echo $db_rl_presenter_mobile; ?></td>
                        <td><?php echo $db_rl_presenter_email; ?></td>
                        <td><?php echo $arrayEmpStatus[$db_rl_presenter_status]; ?></td>
                        <td><?php echo $db_thana; ?></td>
                        <td><?php echo $db_district; ?></td>
                        <td><?php echo $db_division; ?></td>
                        <td style="text-align: center " > <a href="presentation_schdule_combined.php?action=sedule&id=<?php echo $db_rl_presenter_id; ?>&type=<?php echo $type;?>">সিডিউল </a></td>  
                    </tr>
                <?php }?>
            </tbody>
        </table>
    </form>
<!--   ****************************** Presenter's schedule ****************************-->
    <?php
} elseif ($_GET['action'] == 'sedule') {
    ?>
    <div style="padding-top: 10px;">    
        <div style="padding-left: 110px; width: 49%; float: left"><a href="presentation_schdule_combined.php?action=list&type=<?php echo $type;?>"><b>ফিরে যান</b></a></div>
        <div><a href="presentation_schdule_combined.php?action=first&type=<?php echo $type;?>"><?php echo $typeinbangla;?> লিস্ট</a>&nbsp;&nbsp;<a href="presentation_schdule_combined.php?action=new&type=<?php echo $type;?>">মেইক <?php echo $typeinbangla;?></a>&nbsp;&nbsp;<a href="presentation_schdule_combined.php?action=list&type=<?php echo $type;?>"><?php echo $whoinbangla?>-এর  লিস্ট</a></div>
    </div>
    <form method="POST" onsubmit="">	
        <table  class="formstyle" style =" width:78%" id="presentation_fillter">          
            <thead>
            <tr>
                <th colspan="100" >সিডিউল  </th>                        
            </tr>
            <tr id = "table_row_odd">
                <td><?php echo $typeinbangla?>-এর নাম </td>
                <td >তারিখ</td>
                <td >সময়</td>
                <td >ভেন্যু</td>                
            </tr>
            </thead>
            <!--Sql query for showing the data of a presenter-->
            <?php
                    $G_presenter_id = $_GET['id'];
                    $sql_sedule = "SELECT * FROM  program, presenter_list WHERE  idprogram = fk_idprogram AND fk_Employee_idEmployee = $G_presenter_id";
                    $db_result_sql_sedule = mysql_query($sql_sedule);
                    while ($row_sedule = mysql_fetch_array($db_result_sql_sedule)) {
                        $db_sedule_presentation_name = $row_sedule['program_name'];
                        $db_sedule_presentaiton_date = $row_sedule['program_date'];
                        $db_sedule_presentation_time = $row_sedule['program_time'];
                        $db_sedule_presentation_venue = $row_sedule['program_location'];
                ?>
            <tbody>
                 <tr>
                    <td ><?php echo $db_sedule_presentation_name; ?></td>
                    <td><?php echo $db_sedule_presentaiton_date; ?></td>                    
                    <td><?php echo $db_sedule_presentation_time; ?></td>
                    <td><?php echo $db_sedule_presentation_venue; ?></td>                    
                </tr>
            </tbody>
            <?php } ?>
        </table>
    </form>
    <?php
}
include_once 'includes/footer.php';
?> 

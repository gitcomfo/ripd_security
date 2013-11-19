<?php
include 'includes/header.php';
include_once 'includes/MiscFunctions.php';

$json_object = null;
$arr_presenter = array();
$type=$_GET['type'];
$typeinbangla = getProgramType($type);
$whoinbangla =  getProgramer($type);
$whoType = getProgramerType($type);

$sql_cfs_emp_sel = $conn->prepare("SELECT idEmployee FROM cfs_user, employee WHERE cfs_user_idUser = idUser AND account_number= ?");
$sql_program_ins = $conn->prepare("INSERT INTO  $dbname .program (program_no, program_name, program_date, program_time, program_type, Office_idOffice) 
              VALUES (?, ?, ?, ?, ?, ?)");
 $sql_presenterlist_ins = $conn->prepare("INSERT INTO presenter_list (fk_idprogram, fk_Employee_idEmployee) VALUES (?, ?)");

 if (($_POST['new_submit'])) {
    $P_prstn_name = $_POST['presentation_name'];
    $P_prstn_date = $_POST['presentation_date'];
     $str_random_no=(string)mt_rand (0 ,9999 );
     $str_program_random= str_pad($str_random_no,4, "0", STR_PAD_LEFT);
    $prstn_number_final = $type."-".$str_program_random;
    $P_prstn_time = $_POST['presentation_time'];
    $P_presenter_name = $_POST['presenters'];
     $str_presenter_list = substr($P_presenter_name, 0, -2);
    $arr_presenter = explode(", ", $str_presenter_list);
     $no_ofpresenters = count($arr_presenter);
    $P_officeID = $_POST['parent_id'];

    $conn->beginTransaction();
               $sql_program_ins->execute(array($prstn_number_final,$P_prstn_name,$P_prstn_date, $P_prstn_time, $type, $P_officeID ));
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
                $conn->commit();
                
    if ($y==1) {
        $msg = "তথ্য সংরক্ষিত হয়েছে";
    } else {
        $msg = "ভুল হয়েছে";
    }
}
//###################UPDATE QUERY#######################
elseif (isset($_POST['submit1'])) {
    $P_prstn_unumber = $_POST['presentation_number'];
    $P_prstn_uname = $_POST['presentation_name'];
    $P_prstn_udate = $_POST['presentation_date'];
    //echo $prstn_udate;
    $P_prstn_utime = $_POST['presentation_time'];
    $P_presenter_uname = $_POST['user_name'];
    
    $sql_up = mysql_query("UPDATE $dbname.program 
                                 SET program_name='$P_prstn_uname', program_date='$P_prstn_udate', 
                                 program_time='$P_prstn_utime', Employee_idEmployee='$P_presenter_uname'
                                 WHERE program_no='$P_prstn_unumber'");
    if ($sql_up) {
        $msgi = "তথ্য সংরক্ষিত হয়েছে";
    } else {
        $msgi = "ভুল হয়েছে";
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
<link rel="stylesheet" type="text/css" href="css/jquery.autocomplete.css"/>
<style type="text/css">@import "css/bush.css";</style>
<?php
  $name_row = array();
                $sql_query = $conn->prepare("SELECT * FROM cfs_user WHERE user_type='$whoType' ;");
                $sql_query->execute();
                $row = $sql_query->fetchAll();
                foreach ($row as $k)
                        {
                        $name_temp = $k["account_name"];
                        $account_temp = $k["account_number"];
                        $str_presenter_list = "{name: '$name_temp', to: '$account_temp'}";
                        $name_row[] = $str_presenter_list;
                        }
                $json_object .=  implode(",", $name_row);
                $json_object = "[$json_object]";
?>
<!--######################Style Script for calender *********************-->
<script type="text/javascript">

window.onclick = function()
    {
        new JsDatePick({
            useMode: 2,
            target: "presentation_date",
            dateFormat: "%Y-%m-%d"
        });
    };
    
var emails = <?php echo $json_object;?>;
            $().ready(function() {

                $("#presenters").autocomplete(emails, {
                    minChars: 0,
                    width: 310,
                    matchContains: "word",
                    multiple: true,
                    mustMatch: true,
                    autoFill: true,
                    formatItem: function(row, i, max) {
                        return i + "/" + max + ": \"" + row.name + "\" [" + row.to + "]";
                    },
                    formatMatch: function(row, i, max) {
                        return row.name + " " + row.to;
                    },
                    formatResult: function(row) {
                        return row.to;
                    }
                });
            });

function setOffice(office,offid)
{
        document.getElementById('off_name').value = office;
        document.getElementById('parent_id').value = offid;
        document.getElementById('parentResult').style.display = "none";
}
</script>
<script>
function getOffice(str_key) // for searching parent offices
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
            if(str_key.length ==0)
                {
                   document.getElementById('parentResult').style.display = "none";
               }
                else
                    {document.getElementById('parentResult').style.visibility = "visible";
                document.getElementById('parentResult').setAttribute('style','position:absolute;top:41%;left:37.5%;width:250px;z-index:10;border: 1px inset black; overflow:auto; height:105px; background-color:#F5F5FF;');
                    }
                document.getElementById('parentResult').innerHTML=xmlhttp.responseText;
        }
        xmlhttp.open("GET","includes/getParentOffices.php?search="+str_key+"&office=1",true);
        xmlhttp.send();	
}
</script>

<!--*********************Presentation List****************** -->
<?php
if ($_GET['action'] == 'first') {
    ?>
    <div style="padding-top: 10px;">    
        <div style="padding-left: 110px; width: 49%; float: left"><a href="program_management.php"><b>ফিরে যান</b></a></div>
        <div><a href="presentation_schdule.php?action=first&type=<?php echo $type;?>"><?php echo $typeinbangla;?> লিস্ট</a>&nbsp;&nbsp;<a href="presentation_schdule.php?action=new&type=<?php echo $type;?>">মেইক <?php echo $typeinbangla;?></a>&nbsp;&nbsp;<a href="presentation_schdule.php?action=list&type=<?php echo $type;?>"><?php echo $whoinbangla?>-এর  লিস্ট</a></div>
    </div>
    <div>
        <form method="POST" onsubmit="">	
            <table  class="formstyle" style =" width:78%"id="make_presentation_fillter">      
                <thead>
                    <tr>
                        <th colspan="8" ><?php echo $typeinbangla;?> সিডিউল</th>                        
                    </tr>          
                    <tr>
                        <td colspan="8" style="text-align: right">খুঁজুন:  <input type="text" class="box"id="search_filter" name="search" /></td>
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
                    $sql = "SELECT * FROM $dbname.program WHERE program_type = '$type'";
                    $str_presenter_list = "";
                    $str_presenter_email_list = "";
                    $db_result_presenter_name = mysql_query($sql);
                    while ($row_prstn = mysql_fetch_array($db_result_presenter_name)) {
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
                            <td style="text-align: center " > <a href="presentation_schdule.php?action=edit&id=<?php echo $db_programID; ?>&type=<?php echo $type;?>"> এডিট সিডিউল </a></td>  
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </form>
    </div>
    <!--******************Make Presentation************** -->
    <?php
} else if ($_GET['action'] == 'new') {
    ?>
    <div style="padding-top: 10px;">    
        <div style="padding-left: 110px; width: 49%; float: left"><a href="program_management.php"><b>ফিরে যান</b></a></div>
        <div> <a href="presentation_schdule.php?action=first&type=<?php echo $type;?>"><?php echo $typeinbangla;?>লিস্ট</a>&nbsp;&nbsp;<a href="presentation_schdule.php?action=new&type=<?php echo $type;?>">মেইক <?php echo $typeinbangla;?></a>&nbsp;&nbsp;<a href="presentation_schdule.php?action=list&type=<?php echo $type;?>"><?php echo $whoinbangla?>-এর  লিস্ট</a></div>
    </div>

    <div>
        <form method="POST" autocomplete="off" aciton="presentation_schdule.php?action=first">
            <table class="formstyle" style =" width:78%">

                <tr>
                    <th colspan="2">  মেইক <?php echo $typeinbangla;?></th>
                </tr>

                <tr>
                    <td ><?php echo $typeinbangla;?> নাম</td>               
                    <td>: <input  class="box" type="text" name="presentation_name" value="" /></td>   
                </tr>
                <tr>
                    <td ><?php echo $whoinbangla?>-এর নাম</td>               
                    <td>: <input class="box" id="presenters" name="presenters" />
                    </td>
                </tr>          
                <tr>
                    <td>অফিস</td>               
                    <td>: <input class="box" id="off_name" name="offname" onkeyup="getOffice(this.value);" /><em> (অ্যাকাউন্ট নাম্বার)</em>
                       <div id="parentResult"></div><input type="hidden" name="parent_id" id="parent_id"/>
                    </td>
                </tr>          
                <tr>
                    <td >তারিখ </td>
                    <td>: <input class="box"type="text" id="presentation_date" placeholder="Date"  style="" name="presentation_date" value=""/></td>   
                    </td>   
                </tr>
                <tr>
                    <td > সময় </td>
                    <td>: <input  class="box" type="time" name="presentation_time" value=""/></td>  
                </tr>
                <?php
               if ($msg != "") {
                    echo "<tr>
                    <td colspan='2' style='text-allign: center;font-size:16px;'> <font color='green'>$msg</font> </td>
                </tr>";
                }
                ?>
                <tr>
                    <td colspan="2" style="text-align: center"><input type="submit" class="btn" name="new_submit" value="সেভ" >
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
        <div style="padding-left: 110px; width: 49%; float: left"><a href="program_management.php">ফিরে যান</b></a></div>
        <div> <a href="presentation_schdule.php?action=first&type=<?php echo $type;?>"><?php echo $typeinbangla;?> লিস্ট</a>&nbsp;&nbsp;<a href="presentation_schdule.php?action=new&type=<?php echo $type;?>">মেইক <?php echo $typeinbangla;?></a>&nbsp;&nbsp;<a href="presentation_schdule.php?action=list&type=<?php echo $type;?>"><?php echo $whoinbangla?>-এর  লিস্ট</a></div>
    </div>
    <div>
        <!--PHP coding for SHOWING THE DATA IN EDIT SCHEDULE -->     
        <?php
        $G_presentation_id = $_GET['id'];
        $sql_edit = "SELECT * FROM $dbname.program WHERE program_type = '$type'";
        $db_result_edit = mysql_query($sql_edit);
        $row_edit = mysql_fetch_array($db_result_edit);
        $db_rl_presentation_number = $row_edit['program_no'];
        $db_rl_presentation_name = $row_edit['program_name'];
        $db_rl_prstnr_name = $row_edit['user_name'];
        $db_rl_presentation_date = $row_edit['program_date'];
        $db_rl_presentation_time = $row_edit['program_time'];
        $sql_prsntr_list = mysql_query("SELECT * FROM presenter_list, employee, cfs_user 
                            WHERE idUser=cfs_user_idUser AND idEmployee= fk_Employee_idEmployee AND fk_idprogram=$db_programID ");
                         while ($row_prsnter = mysql_fetch_array($sql_prsntr_list)) {
                             $str_presenter_list = $row_prsnter['account_name'].",\n".$str_presenter_list;
                             $str_presenter_email_list = $row_prsnter['email'].",\n".$str_presenter_email_list;
                         }
        ?>
        <form method="POST"> <!--Redirect from one page to another -->
            <table class="formstyle" style =" width:78%" id="presentation_fillter">       
                <tr>
                    <th colspan="2">  এডিট সিডিউল </th>
                </tr>
                <tr>
                    <td style="width:40%" ><?php echo $typeinbangla;?> নাম্বার</td>
                    <td>: <input  class="box" type="text" name="presentation_number" readonly  value="<?php echo $db_rl_presentation_number; ?>"/></td>   
                </tr>
                <tr>
                    <td ><?php echo $typeinbangla;?> নাম</td>               
                    <td>: <input  class="box" type="text" name="presentation_name" value="<?php echo $db_rl_presentation_name; ?>"/></td>   
                </tr>
                <tr>
                    <td ><?php echo $whoinbangla?>-এর নাম</td>   <!--Writing query for drop-down list -->            
                    <td>: <input class="box" id="presenters" name="presenters" value="<?php echo $str_presenter_list;?>" />
                    </td>

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
                <?php
                if ($msgi != "") {
                    echo "<tr>
                    <td colspan=\"2\" style=\"text-allign: center\"> <font color='green'>$msgi</td></font> 
                </tr>";
                }
                ?>

                <tr>
                    <td colspan="2" style="text-align: center"><input type="submit" class="btn" name="submit1" value="সেভ" > 
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
        <div><a href="presentation_schdule.php?action=first&type=<?php echo $type;?>"><?php echo $typeinbangla;?> লিস্ট</a>&nbsp;&nbsp;<a href="presentation_schdule.php?action=new&type=<?php echo $type;?>">মেইক <?php echo $typeinbangla;?></a>&nbsp;&nbsp;<a href="presentation_schdule.php?action=list&type=<?php echo $type;?>"><?php echo $whoinbangla?>-এর  লিস্ট</a> </div> 
    </div> 

    <form method="POST" onsubmit="">	
        <table  class="formstyle" style =" width:78%"id="presentation_fillter">          
            <thead>
                <tr>
                    <th colspan="8" ><?php echo $whoinbangla?>-এর  লিস্ট </th>                        
                </tr>             
                <tr >
                    <td colspan="8" style="text-align: right"> খুঁজুন:  <input type="text" class="box"id="search_box_filter" name="search" /></td>
                </tr>
                <tr id = "table_row_odd">
                    <td><?php echo $whoinbangla?>-এর নাম </td>
                    <td >একাউন্ট নাম্বার</td>
                    <td >গ্রেড</td>
                    <td >সেল নাম্বার</td>
                    <td> থানা</td>
                    <td>জেলা</td>
                    <td>বিভাগ</td>
                    <td>অপশন</td>
                </tr>
            </thead>
            <tbody>
                <!--Presenter List Query -->
                <?php
                $sql_list = "SELECT * FROM cfs_user, employee, pay_grade  
                             WHERE cfs_user.idUser=employee.cfs_user_idUser AND pay_grade_id=idpaygrade 
                             AND employee.employee_type='$whoType'";
                $db_result_presenter_info = mysql_query($sql_list); //Saves the query of Presenter Infromation
                while ($row_prstn = mysql_fetch_array($db_result_presenter_info)) {
                    $db_rl_presenter_name = $row_prstn['user_name'];
                    $db_rl_presenter_acc = $row_prstn['account_number'];
                    $db_rl_presenter_mobile = $row_prstn['mobile'];
                    $db_rl_presenter_grade = $row_prstn['grade_name'];
                    $db_rl_presenter_id = $row_prstn['idEmployee'];
                    
                    $sql_sel_adrs = mysql_query("SELECT * FROM address,thana,district,division WHERE address_type= 'Present' AND address_whom= 'emp' AND adrs_cepng_id='$db_rl_presenter_id' AND idThana=Thana_idThana AND idDistrict= District_idDistrict AND idDivision=Division_idDivision ");
                    $adrsrow = mysql_fetch_assoc($sql_sel_adrs);
                    $db_rl_presenter_division = $adrsrow['division_name'];
                    $db_rl_presenter_district = $adrsrow['district_name'];
                    $db_rl_presennter_thana = $adrsrow['thana_name'];
                    ?>
                    <tr>
                        <td ><?php echo $db_rl_presenter_name; ?></td>
                        <td><?php echo $db_rl_presenter_acc; ?></td>
                        <td><?php echo $db_rl_presenter_grade; ?></td>
                        <td><?php echo $db_rl_presenter_mobile; ?></td>
                        <td><?php echo $db_rl_presennter_thana; ?></td>
                        <td><?php echo $db_rl_presenter_district; ?></td>
                        <td><?php echo $db_rl_presenter_division; ?></td>
                        <td style="text-align: center " > <a href="presentation_schdule.php?action=sedule&id=<?php echo $db_rl_presenter_id; ?>&type=<?php echo $type;?>">সিডিউল </a></td>  
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </form>
    <script type="text/javascript">
    var filter = new DG.Filter({
        filterField: $('search_box_filter'),
        filterEl: $('presentation_fillter')
    });
    </script>
<!--   ****************************** Presenter's schedule ****************************-->
    <?php
} elseif ($_GET['action'] == 'sedule') {
    ?>
    <div style="padding-top: 10px;">    
        <div style="padding-left: 110px; width: 49%; float: left"><a href="presentation_schdule.php?action=list&type=<?php echo $type;?>"><b>ফিরে যান</b></a></div>
        <div><a href="presentation_schdule.php?action=first&type=<?php echo $type;?>"><?php echo $typeinbangla;?> লিস্ট</a>&nbsp;&nbsp;<a href="presentation_schdule.php?action=new&type=<?php echo $type;?>">মেইক <?php echo $typeinbangla;?></a>&nbsp;&nbsp;<a href="presentation_schdule.php?action=list&type=<?php echo $type;?>"><?php echo $whoinbangla?>-এর  লিস্ট</a></div>
    </div>
    <form method="POST" onsubmit="">	
        <table  class="formstyle" style =" width:78%"id="presentation_fillter">          
            <tr>
                <th colspan="100" >সিডিউল  </th>                        
            </tr>             
            <tr id = "table_row_odd">
                <td><?php echo $typeinbangla?>-এর নাম </td>
                <td >তারিখ</td>
                <td >সময়</td>
                <td >ভেন্যু</td>                
            </tr>

            <!--Sql query for showing the data of a presenter-->
            <?php
            $G_presenter_id = $_GET['id'];
            $sql_sedule = "SELECT *
                              FROM  program, presenter_list
                              WHERE  idprogram = fk_idprogram AND fk_Employee_idEmployee = $G_presenter_id";
            $db_result_sql_sedule = mysql_query($sql_sedule);
            while ($row_sedule = mysql_fetch_array($db_result_sql_sedule)) {
                $db_sedule_presentation_name = $row_sedule['program_name'];
                $db_sedule_presentaiton_date = $row_sedule['program_date'];
                $db_sedule_presentation_time = $row_sedule['program_time'];
                $db_sedule_presentation_venue = $row_sedule['program_location'];
                ?>            
                <tr>
                    <td ><?php echo $db_sedule_presentation_name; ?></td>
                    <td><?php echo $db_sedule_presentaiton_date; ?></td>                    
                    <td><?php echo $db_sedule_presentation_time; ?></td>
                    <td><?php echo $db_sedule_presentation_venue; ?></td>                    
                </tr>
            <?php } ?>
        </table>
    </form>
    
    <script type="text/javascript">
    var filter = new DG.Filter({
        filterField: $('search_filter'),
        filterEl: $('make_presentation_fillter')
    });
    </script>

    <?php
}
include_once 'includes/footer.php';
?> 

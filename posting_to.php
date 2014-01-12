<?php
//error_reporting(0);
include_once 'includes/MiscFunctions.php';
include 'includes/header.php';
include_once './includes/insertQueryPDO.php';
include_once './includes/updateQueryPDO.php';
include_once './includes/selectQueryPDO.php';

if(isset($_POST['submit']))
{
     $p_oldOnSID = $_POST['oldonsID'];
     $p_oldPostingID = $_POST['oldpost'];
     $p_empID = $_POST['empID'];
     $p_newOnSID = $_POST['newonsid'];
     $p_newPostinID = $_POST['newpostID'];
     $p_newPostingDate = $_POST['postingDate'];
     $conn->beginTransaction();
     $empposting =$sql_insert_employee_posting->execute(array($p_newPostingDate, $p_empID, $p_newOnSID,$p_newPostinID));
     if($p_oldPostingID != "")
     {
         $update1=$sql_update_post_in_ons_up->execute(array($p_oldPostingID));
     }
     $update2=$sql_update_post_in_ons_down->execute(array($p_newPostinID));
     if(($empposting && $update2) || $update1)
     {
         $conn->commit();
         echo "<script>alert('পোস্টিং হয়েছে')</script>";
     }
     else {
                $conn->rollBack();
                echo "<script>alert('দুঃখিত,পোস্টিং হয়নি')</script>";
            }
    
}
?>
<style type="text/css">@import "css/bush.css";</style>
<link rel="stylesheet" href="css/tinybox.css" type="text/css">
<script src="javascripts/tinybox.js" type="text/javascript"></script>
<script type="text/javascript">
function selectOffice(url)
{ TINY.box.show({iframe:'select_office.php?url='+url,width:900,height:400,opacity:30,topsplit:3,animate:true,close:true,maskid:'bluemask',maskopacity:50,boxid:'success'}); }
</script>
<script language=javascript>
window.name = "parentWindow";
</script>

<div class="main_text_box">
        <?php
        $back_parent = $_GET['bkprnt'];
        $back_parent_change = str_replace("%%", "&", $back_parent);
        echo "<div style='padding-left: 110px;'><a href='$back_parent_change'><b>ফিরে যান</b></a></div>";
        ?>
        <div>
            <form method="post" style="width: 90%;" action="">
                <?php
                $url= urlencode($_SERVER['REQUEST_URI']);
                $g_officeID = $_GET['ll1i1s0t01%%i010d10'];
                $employee_id = $_GET['0to1o1ff01i0c1e0'];
                $sql_sel_cfsuser = mysql_query("SELECT * FROM cfs_user,employee,employee_information WHERE idUser = cfs_user_idUser AND idEmployee = $employee_id");
                $cfs_row = mysql_fetch_assoc($sql_sel_cfsuser);
                $db_old_onsid = $cfs_row['emp_ons_id'];
                $sql_sel_address = mysql_query("SELECT * FROM address,thana,district,division WHERE 	address_whom = 'emp'
                                                                        AND address_type='Present' AND adrs_cepng_id = $employee_id
                                                                        AND Thana_idThana = idThana AND District_idDistrict=idDistrict AND Division_idDivision= idDivision ");
                $addressrow = mysql_fetch_assoc($sql_sel_address); 
                $sql_employee_grade = mysql_query("SELECT grade_name,employee_salary.insert_date,total_salary  FROM employee_salary,employee,pay_grade WHERE pay_grade_id = idpaygrade AND user_id = $employee_id AND pay_grade_idpaygrade = idpaygrade ORDER BY employee_salary.insert_date DESC LIMIT 1");
                    $arr_grade = mysql_fetch_assoc($sql_employee_grade);
                    $db_salary = $arr_grade['total_salary'];                                       
                    $sql_employee_posting = mysql_query("SELECT * FROM view_emp_post WHERE Employee_idEmployee=$employee_id ORDER BY posting_date DESC LIMIT 1");
                    $arr_row = mysql_fetch_assoc($sql_employee_posting);
                    $db_post = $arr_row['post_name'];
                    $db_idposting = $arr_row['idempposting'];
                    $db_postingDate = $arr_row['posting_date'];                
                echo "<table  class='formstyle'>";
                echo "<tr >
                                <th colspan='4' style='text-align: center'>
                                <div style='width: 80%; float: left; padding-top: 18px;'>
                                    <h1>".$cfs_row['account_name']."</h1>
                                    <h2>".$cfs_row['account_number']."</h2>
                                    <h3>মোবাইলঃ ".$cfs_row['mobile']."</h3>
                                    <h3>বাসা-".$addressrow['house'].",".$addressrow['house_no'].", রোড-".$addressrow['house'].", থানাঃ ".$addressrow['thana_name'].", জেলাঃ".$addressrow['district_name'].", বিভাগঃ".$addressrow['division_name']."</h3>
                                </div>
                                <div style='float: right'><img src='".$cfs_row['emplo_scanDoc_picture']."' style='width:150px;height:150px;' /></div></th>
                            </tr>";
                echo "<tr><td colspan='4'><hr></td></tr>";
                echo '<tr>
                     <td colspan="4">
                     <fieldset style="border:3px solid #686c70;width: 99%;">
                            <legend style="color: brown;font-size: 14px;">বর্তমান অবস্থা</legend>
                            <table>
                            <tr>
                                <td style="width: 25%; text-align:right">গ্রেড</td>
                                <td style="width: 25%; text-align:left">: '.$arr_grade['grade_name'].'</td>
                                <td style="width: 25%; text-align:right">পোস্ট<input type="hidden" name="oldpost" value="'.$db_idposting.'" /></td>
                                <td style="width: 25%; text-align:left">: '.$db_post.'</td>
                            </tr>
                            <tr>
                               <td style="width: 25%; text-align:right">অফিস</td>
                                <td style="width: 25%; text-align:left">: <input type="hidden" name="oldonsID" value="'.$db_old_onsid.'" /></td>
                                <td style="width: 25%; text-align:right">কর্মচারীর ধরন</td>
                                <td style="width: 25%; text-align:left">: কর্মচারী<input type="hidden" name="empID" value="'.$employee_id.'" /></td>
                            </tr>
                            <tr>
                               <td style="width: 25%; text-align:right">যোগদানের তারিখ</td>
                                <td style="width: 25%; text-align:left">: '.english2bangla(date("d/m/Y",  strtotime($db_postingDate))).'</td>
                                <td style="width: 25%; text-align:right">বেতন</td>
                                <td style="width: 25%; text-align:left">: '.english2bangla($db_salary).' টাকা</td>
                            </tr>
                            </table>
                            </filedset></td>
                    </tr>';

                echo '<tr>
                     <td colspan="4">
                     <fieldset style="border:3px solid #686c70;width: 99%;">
                            <legend style="color: brown;font-size: 14px;">সামগ্রিক কর্মজীবন</legend>
                            <table>
                            <tr>
                                <td colspan="2" style="width: 50%; text-align:right">কর্মজীবন</td>
                                <td colspan="2" style="width: 50%; text-align:left">: </td>     
                            </tr>
                            <tr>
                               <td style="width: 25%; text-align:right">উপস্থিতির হার</td>
                                <td style="width: 25%; text-align:left">: </td>
                                <td style="width: 25%; text-align:right">মোট কর্মদিবস</td>
                                <td style="width: 25%; text-align:left">: </td>
                            </tr>
                            <tr>
                               <td style="width: 25%; text-align:right">প্রেজেন্ড ডে</td>
                                <td style="width: 25%; text-align:left">: </td>
                                <td style="width: 25%; text-align:right">অ্যাবসেন্ট</td>
                                <td style="width: 25%; text-align:left">: </td>
                            </tr>
                            <tr>
                                <td colspan="2" style="width: 50%; text-align:right">ছুটি</td>
                                <td colspan="2" style="width: 50%; text-align:left">: </td>     
                            </tr>
                            <tr>
                            <td colspan="4"><div align="center"><a onclick="detailsWithPrice()" style="cursor:pointer;color:blue;">উপস্থিতির বিস্তারিত তথ্য</a></div></td>
                            </tr>
                            </table>
                            </filedset></td>
                    </tr>';
                if(isset($_POST['submitPost']))
                {
                    $p_postingID = $_POST['OnSCheck'];
                    $sel_post = mysql_query("SELECT * FROM post_in_ons,post WHERE idpostinons = $p_postingID AND Post_idPost =idPost ");
                    $postrow = mysql_fetch_assoc($sel_post);
                    $db_postname = $postrow['post_name'];
                    $db_officetype = $postrow['post_onstype'];
                    $db_offid = $postrow['post_onsid'];
                    if($db_officetype == 'office')
                    {
                        $sel_office = mysql_query("SELECT * FROM office WHERE idOffice = $db_offid");
                        $offrow = mysql_fetch_assoc($sel_office);
                        $offname = $offrow['office_name'];
                    }
                    else
                    {
                        $sel_office = mysql_query("SELECT * FROM sales_store WHERE idSales_store = $db_offid");
                        $offrow = mysql_fetch_assoc($sel_office);
                        $offname = $offrow['salesStore_name'];
                    }
                    $sel_ons_relation = mysql_query("SELECT idons_relation FROM ons_relation WHERE catagory='$db_officetype' AND add_ons_id=$db_offid ");
                    $onsrow = mysql_fetch_assoc($sel_ons_relation);
                    $db_onsID = $onsrow['idons_relation'];
                }
                echo '<tr>
                     <td colspan="4">
                     <fieldset style="border:3px solid #686c70;width: 99%;">
                            <legend style="color: brown;font-size: 14px;">পোস্টিং</legend>
                            <table>
                            <tr>
                                <td style="width: 30%; text-align:right">পোস্টিং অফিস</td>
                                <td style="width: 40%"><input type="text" class="box" readonly  value=" '.$offname.' "/><input type="hidden" name="newonsid" value="'.$db_onsID.'" /></td>';
                       echo "<td colspan='2'><div align='center'><a onclick=selectOffice('$url') style='cursor:pointer;color:blue;'>সিলেক্ট অফিস</a></div></td> "; 
                       echo  '</tr>
                            <tr>
                                <td style="width: 30%; text-align:right">পোস্ট</td>
                                <td colspan="3" style="width: 40%"><input type="text" class="box" readonly value="'.$db_postname.'" /><input type="hidden" name="newpostID" value="'.$p_postingID.'" /></td>
                             </tr>
                            <tr>
                                <td style="width: 30%; text-align:right">পোস্টিং তারিখ</td>
                                <td colspan="3" style="width: 40%"><input type="date" class="box" name="postingDate"/></td>
                             </tr>
                            </table>
                            </filedset></td>
                    </tr>';
                echo "<tr><td colspan='4' style='text-align: center' ><input class='btn' style ='font-size: 12px' type='submit' name='submit' value='পোস্টিং' /></td></tr>";
                echo "</table>";
                ?>
            </form>
        </div>
    </div>

    <?php
    include 'includes/footer.php';
    ?>
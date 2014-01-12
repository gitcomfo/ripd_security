<?php
error_reporting(0);
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
                $g_officeID = end(explode("=", $back_parent_change));
                $employee_id = $_GET['0to1o1ff01i0c1e0'];
                $sql_select_office->execute(array($g_officeID));
                        $row9 = $sql_select_office->fetchAll();
                        foreach ($row9 as $offrow) {
                            $offname1 = $offrow['office_name'];
                        } 
                $sql_select_emplyee_cfs->execute(array($employee_id));
                $row1 = $sql_select_emplyee_cfs->fetchAll();
                foreach ($row1 as $cfs_row) {
                    $db_old_onsid = $cfs_row['emp_ons_id'];
                    $db_cfs_name = $cfs_row['account_name'];
                    $db_cfs_account = $cfs_row['account_number'];
                    $db_mobile = $cfs_row['mobile'];
                    $db_picture = $cfs_row['emplo_scanDoc_picture'];
                }
                $sql_select_emp_address->execute(array($employee_id));
                $row2 = $sql_select_emp_address->fetchAll();
                foreach ($row2 as $addressrow) {
                    $db_house = $addressrow['house'];
                    $db_houseno = $addressrow['house_no'];
                    $db_road = $addressrow['house'];
                    $db_thana = $addressrow['thana_name'];
                    $db_district = $addressrow['district_name'];
                    $db_division = $addressrow['division_name'];
                }
                    $sql_select_employee_grade->execute(array($employee_id));
                    $row3 = $sql_select_employee_grade->fetchAll();
                    foreach ($row3 as $arr_grade) {
                        $db_salary = $arr_grade['total_salary'];
                        $db_gradename = $arr_grade['grade_name'];
                    }
                                                           
                    $sql_select_view_emp_post->execute(array($employee_id,$g_officeID));
                    $row4 = $sql_select_view_emp_post->fetchAll();
                    foreach ($row4 as $arr_row) {
                        $db_post = $arr_row['post_name'];
                        $db_idposting = $arr_row['idempposting'];
                        $db_postingDate = $arr_row['posting_date'];
                    }                                  
                echo "<table  class='formstyle'>";
                echo "<tr >
                                <th colspan='4' style='text-align: center'>
                                <div style='width: 80%; float: left; padding-top: 18px;'>
                                    <h1>".$db_cfs_name."</h1>
                                    <h2>".$db_cfs_account."</h2>
                                    <h3>মোবাইলঃ ".$db_mobile."</h3>
                                    <h3>বাসা-".$db_house.",".$db_houseno.", রোড-".$db_road.", থানাঃ ".$db_thana.", জেলাঃ".$db_district.", বিভাগঃ".$db_division."</h3>
                                </div>
                                <div style='float: right'><img src='".$db_picture."' style='width:150px;height:150px;' /></div></th>
                            </tr>";
                echo "<tr><td colspan='4'><hr></td></tr>";
                echo '<tr>
                     <td colspan="4">
                     <fieldset style="border:3px solid #686c70;width: 99%;">
                            <legend style="color: brown;font-size: 14px;">বর্তমান অবস্থা</legend>
                            <table>
                            <tr>
                                <td style="width: 25%; text-align:right">গ্রেড</td>
                                <td style="width: 35%; text-align:left">: '.$db_gradename.'</td>
                                <td style="width: 15%; text-align:right">পোস্ট<input type="hidden" name="oldpost" value="'.$db_idposting.'" /></td>
                                <td style="width: 25%; text-align:left">: '.$db_post.'</td>
                            </tr>
                            <tr>
                               <td style="text-align:right">অফিস</td>
                                <td style=" text-align:left">: '.$offname1.'<input type="hidden" name="oldonsID" value="'.$db_old_onsid.'" /></td>
                                <td style=" text-align:right">কর্মচারীর ধরন</td>
                                <td style=" text-align:left">: কর্মচারী<input type="hidden" name="empID" value="'.$employee_id.'" /></td>
                            </tr>
                            <tr>
                               <td style="text-align:right">যোগদানের তারিখ</td>
                                <td style="text-align:left">: '.english2bangla(date("d/m/Y",  strtotime($db_postingDate))).'</td>
                                <td style="text-align:right">বেতন</td>
                                <td style="text-align:left">: '.english2bangla($db_salary).' টাকা</td>
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
                               <td style="width: 25%; text-align:right">উপস্থিতির হার</td>
                                <td style="width: 25%; text-align:left">: </td>
                                <td style="width: 25%; text-align:right">মোট কর্মদিবস</td>
                                <td style="width: 25%; text-align:left">: </td>
                            </tr>
                            <tr>
                               <td style="width: 25%; text-align:right">উপস্থিত</td>
                                <td style="width: 25%; text-align:left">: দিন</td>
                                <td style="width: 25%; text-align:right">অনুপস্থিত</td>
                                <td style="width: 25%; text-align:left">: দিন</td>
                            </tr>
                            <tr>
                                <td colspan="2" style="width: 50%; text-align:right">ছুটি</td>
                                <td colspan="2" style="width: 50%; text-align:left">: দিন</td>     
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
                    $sql_select_post->execute(array($p_postingID));
                    $row5 = $sql_select_post->fetchAll();
                    foreach ($row5 as $postrow) {
                        $db_postname = $postrow['post_name'];
                        $db_officetype = $postrow['post_onstype'];
                        $db_offid = $postrow['post_onsid'];
                    }
                    if($db_officetype == 'office')
                    {
                        $sql_select_office->execute(array($db_offid));
                        $row6 = $sql_select_office->fetchAll();
                        foreach ($row6 as $offrow) {
                            $offname = $offrow['office_name'];
                        } 
                    }
                    else
                    {
                        $sql_select_sales_store->execute(array($db_offid));
                        $row6 = $sql_select_office->fetchAll();
                        foreach ($row6 as $offrow) {
                            $offname = $offrow['salesStore_name'];
                        } 
                    }
                    $sql_select_id_ons_relation->execute(array($db_officetype,$offname));
                    $row7 = $sql_select_id_ons_relation->fetchAll();
                    foreach ($row7 as $onsrow) {
                        $db_onsID = $onsrow['idons_relation'];
                    }
                }
                echo '<tr>
                     <td colspan="4">
                     <fieldset style="border:3px solid #686c70;width: 99%;">
                            <legend style="color: brown;font-size: 14px;">পোস্টিং</legend>
                            <table>
                            <tr>
                                <td style="width: 30%; text-align:right">পোস্টিং অফিস</td>
                                <td style="width: 40%"><input type="text" class="box" readonly  value=" '.$offname.' "/><input type="hidden" name="newonsid" value="'.$db_onsID.'" /></td>';
                       echo "<td colspan='2'><div align='left'><a onclick=selectOffice('$url') style='cursor:pointer;color:blue;'>সিলেক্ট অফিস</a></div></td> "; 
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
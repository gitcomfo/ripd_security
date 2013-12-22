<?php
include_once 'includes/MiscFunctions.php';
include 'includes/header.php';
?>

<style type="text/css">@import "css/bush.css";</style>
<script type="text/javascript" src="javascripts/area.js"></script>
<script type="text/javascript" src="javascripts/external/mootools.js"></script>
<script type="text/javascript" src="javascripts/dg-filter.js"></script>

<script type="text/javascript">
    function infoFromThana()
    {
        var xmlhttp;
        if (window.XMLHttpRequest) xmlhttp=new XMLHttpRequest();
        else xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
        xmlhttp.onreadystatechange=function()
        {
            if (xmlhttp.readyState==4 && xmlhttp.status==200) 
                document.getElementById('office').innerHTML=xmlhttp.responseText;
        }
        var division_id, district_id, thana_id;
        division_id = document.getElementById('division_id').value;
        district_id = document.getElementById('district_id').value;
        thana_id = document.getElementById('thana_id').value;
        xmlhttp.open("GET","includes/infoSetteleOfficeFromThana.php?dsd="+district_id+"&dvd="+division_id+"&ttid="+thana_id,true);
        xmlhttp.send();
    }
</script>

<div class="column6">
    
    <?php if($_GET['iffimore'] != 'll1i1s0t01'){?>
    <div class="main_text_box">
        <div style="padding-left: 110px;"><a href="hr_employee_management.php"><b>ফিরে যান</b></a></div>
        <div>
            <table  class='formstyle'>       
                <tr><th style='text-align: center;'>সকল অফিসের তালিকা</th></tr>
                <tr><td>
                    <div style="padding-bottom: 10px;">
                        <?php
                        include_once 'includes/areaSearch.php';
                        getArea("infoFromThana()");
                        ?>
                        <input type="hidden" id="method" value="infoFromThana()">
                        সার্চ/খুঁজুন:  <input type="text" id="search_box_filter">
                    </div>
                </td></tr>
                <tr><td>    
                    <span id="office">
                        <div>
                            <table id="office_info_filter" border="1" align="center" width= 99%" cellpadding="5px" cellspacing="0px">
                                <thead>
                                    <tr id="table_row_odd" style="font-weight: bold">
                                        <td>অফিস নং</td>
                                        <td>অফিসের নাম</td>
                                        <td>অফিস নম্বর</td>
                                        <td>একাউন্ট নম্বর</td>
                                        <td>ব্রাঞ্চের নাম</td>
                                        <td>অফিসের ঠিকানা</td>
                                        <td></td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    //officeTableHead();
                                    $sql_setteleOfficeTable = "SELECT * from $dbname.office ORDER BY office_name ASC";
                                    $db_slNo = 0;
                                    $rs = mysql_query($sql_setteleOfficeTable);
                                    //echo mysql_num_rows($rs);
                                    while ($row_setteleOfficeTable = mysql_fetch_array($rs)) 
                                        {
                                        $db_slNo = $db_slNo + 1;
                                        $db_setteleOfficeID = $row_setteleOfficeTable['idOffice'];
                                        $db_setteleOfficeName = $row_setteleOfficeTable['office_name'];
                                        $db_setteleOfficeNumber = $row_setteleOfficeTable['office_number'];
                                        $db_setteleOfficeAN = $row_setteleOfficeTable['account_number'];
                                        $db_setteleOfficeBranch = $row_setteleOfficeTable['branch_name'];
                                        $db_setteleOfficeAddress = $row_setteleOfficeTable['office_details_address'];
                                        echo "<tr>";
                                        echo "<td>$db_slNo</td>";
                                        echo "<td>$db_setteleOfficeName</td>";
                                        echo "<td>$db_setteleOfficeNumber</td>";
                                        echo "<td>$db_setteleOfficeAN</td>";
                                        echo "<td>$db_setteleOfficeBranch</td>";
                                        echo "<td>$db_setteleOfficeAddress</td>";
                                        echo "<td><a href='posting_promotion_fromOffice.php?iffimore=ll1i1s0t01&i010d10=$db_setteleOfficeID'>কর্মচারীদের তালিকা</a></td>";
                                        echo "</tr>";
                                        }
                                    ?>
                                </tbody>
                            </table>                        
                        </div>
                    </span> 
                </td></tr>                
            </table>
        </div>
    </div>       
    <script type="text/javascript">
        var filter = new DG.Filter({
            filterField : $('search_box_filter'),
            filterEl : $('office_info_filter')
        });
    </script>
    <?php     
            }
    else if ($_GET['iffimore']=='ll1i1s0t01')
            {
    ?>
        <div class="main_text_box">
        <div style="padding-left: 110px;"><a href="posting_promotion_fromOffice.php"><b>ফিরে যান</b></a></div>
        <div>
            <?php
            $get_office_id = $_GET['i010d10'];
            $sql = mysql_query("SELECT * FROM $dbname.office WHERE idOffice=$get_office_id");
            $row = mysql_fetch_array($sql);
            $office_name = $row['office_name'];
            echo "<table  class='formstyle'>";          
                echo "<tr><th colspan='10' style='text-align: center;'>$office_name - এ কর্মচারীদের তালিকা</th></tr>";
                echo "<tr align='left' id='table_row_odd'>
                    <td>ক্রম</td>
                    <td>কর্মচারীদের নাম</td>
                    <td>একাউন্ট নাম্বার</td>
                    <td>গ্রেড</td>
                    <td>গ্রেডের স্থায়িত্বকাল</td>
                    <td>দায়িত্ব</td>
                    <td>অফিসে সময়কাল</td>
                    <td colspan='3'></td>
                </tr>";
                echo "<tr>
                    <td>১</td>
                    <td>মোঃ মোখলেসুজ্জামান আরিফ</td>
                    <td>ons-2244189</td>
                    <td>গ্রেড - সি</td>
                    <td>২ বছর ৩ মাস</td>
                    <td>কেয়ারটেকার</td>
                    <td>১৬ মাস</td>
                    <td><a href='posting_to.php?0to1o1ff01i0c1e0=$get_office_id&bkprnt=posting_promotion_fromOffice.php?iffimore=ll1i1s0t01%%i010d10=$get_office_id'>পোস্টিং করুন</a></td>
                    <td><a href='promotion_to.php?0to1o1ff01i0c1e0=$get_office_id&bkprnt=posting_promotion_fromOffice.php?iffimore=ll1i1s0t01%%i010d10=$get_office_id'>প্রোমোশন করুন</a></td>
                    <td><a href='postingNpromotion.php?0to1o1ff01i0c1e0=$get_office_id&bkprnt=posting_promotion_fromOffice.php?iffimore=ll1i1s0t01%%i010d10=$get_office_id'>পোস্টিং এন্ড প্রোমোশন</a></td>
                </tr>"; // give the user id in the the place of $get_office_id
            echo "</table>";
            ?>
        </div>
    </div>
    
    <?php
            }
    ?>
    
<?php
include 'includes/footer.php';?>

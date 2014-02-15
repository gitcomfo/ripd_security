<?php
include_once 'includes/session.inc';
include_once 'includes/header.php';
include_once 'includes/MiscFunctions.php';
include_once 'includes/selectQueryPDO.php';
if (isset($_GET['id'])) {
    $empCfsid = $_GET['id'];
    $selreslt = mysql_query("SELECT * FROM  cfs_user WHERE idUser = $empCfsid");
    $getrow = mysql_fetch_assoc($selreslt);
    $db_empname = $getrow['account_name'];
    $db_empmobile = $getrow['mobile'];
    $db_email = $getrow['email'];
    $db_account_number = $getrow['account_number'];
    $sql_post = mysql_query("SELECT post_name FROM employee, employee_posting, post_in_ons, post
                                              WHERE idPost = Post_idPost AND idpostinons = post_in_ons_idpostinons AND Employee_idEmployee = idEmployee
                                              AND  cfs_user_idUser = $empCfsid");
    $sql_postrow = mysql_fetch_assoc($sql_post);
    $db_empposition = $sql_postrow['post_name'];
    $sql_employee = mysql_query("SELECT * FROM employee WHERE cfs_user_idUser = $empCfsid");
    $emprow = mysql_fetch_assoc($sql_employee);
    $db_paygrdid = $emprow['pay_grade_id'];
    $sql_grade = mysql_query("SELECT * FROM pay_grade WHERE idpaygrade = $db_paygrdid");
    $emgrade = mysql_fetch_assoc($sql_grade);
    $db_paygrd_name = $emgrade['grade_name'];
    $db_empid = $emprow['idEmployee'];
    $sql_empinfo = mysql_query("SELECT * FROM employee_information WHERE Employee_idEmployee = $db_empid");
    $empinforow = mysql_fetch_assoc($sql_empinfo);
    $db_empphoto = $empinforow['emplo_scanDoc_picture'];

    $currentMonth = date('n');
    $currentYear = date('Y');
    if($currentMonth == 1){
        $currentYear = $currentYear - 1;
        $preMonth = 12;
    } else {
        $preMonth = $currentMonth -1;
    }
    // ************** attendance *************************************
    $select_attendance = mysql_query("SELECT COUNT(idempattend) FROM employee,employee_attendance 
        WHERE   year_no ='$currentYear' AND month_no='$preMonth' AND  cfs_user_idUser = $empCfsid AND idEmployee = emp_user_id ");
    $row = mysql_fetch_assoc($select_attendance);
    $workingDays = $row['COUNT(idempattend)'];

    $sql_attend =$conn->prepare("SELECT COUNT(idempattend) FROM employee,employee_attendance WHERE emp_atnd_type=? AND  year_no =? AND month_no=? AND  cfs_user_idUser = ? AND idEmployee = emp_user_id ");
    $status1 = "present";
    $sql_attend->execute(array($status1,$currentYear,$preMonth,$empCfsid));
    $row1 = $sql_attend->fetchAll();
    foreach ($row1 as $value) {
        $presentDays = $value['COUNT(idempattend)'];
    }
    $status2 ="absent";
    $sql_attend->execute(array($status2,$currentYear,$preMonth,$empCfsid));
    $row2 = $sql_attend->fetchAll();
    foreach ($row2 as $value) {
        $absentDays = $value['COUNT(idempattend)'];
    }
    $status3 = "leave";
    $sql_attend->execute(array($status3,$currentYear,$preMonth,$empCfsid));
    $row3 = $sql_attend->fetchAll();
    foreach ($row3 as $value) {
        $leaveDays = $value['COUNT(idempattend)'];
    }
    // ****************************** salary select ***************************************************************
    $select_salary_chart = mysql_query("SELECT * FROM salary_chart WHERE month_no='$preMonth' AND year_no='$currentYear' AND user_id=$empCfsid ");
    $sal_chart_row = mysql_fetch_assoc($select_salary_chart);
    $db_salary = $sal_chart_row['given_amount'];
    $db_deduct = $sal_chart_row['deducted_amount'];
    $db_bonus = $sal_chart_row['bonus_amount'];
    $db_given_salary = $sal_chart_row['total_given_amount'];
}
    ?>
    <style type="text/css"> @import "css/bush.css";</style>
    <script type="text/javascript" src="javascripts/area.js"></script>
    <script type="text/javascript">
        function custInfoFromArea()
        {
            var xmlhttp;
            if (window.XMLHttpRequest) xmlhttp=new XMLHttpRequest();
            else xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
            xmlhttp.onreadystatechange=function()
            {
                if (xmlhttp.readyState==4 && xmlhttp.status==200) 
                    document.getElementById('customer_list').innerHTML=xmlhttp.responseText;
            }
            var division_id, district_id, thana_id,post_id,village_id;
            division_id = document.getElementById('division_id').value;
            district_id = document.getElementById('district_id').value;
            thana_id = document.getElementById('thana_id').value;
            post_id = document.getElementById('post_id').value;
            village_id = document.getElementById('vilg_id').value;
            xmlhttp.open("GET","includes/updateCustFromArea.php?dsd="+district_id+"&dvd="+division_id+"&ttid="+thana_id+"&pid="+post_id+"&vid="+village_id,true);
            xmlhttp.send();
        }
    </script>
    <?php if (isset($_GET['id'])) {?>
    <div class="main_text_box">
        <div style="padding-left: 110px;"><a href="customer_list.php"><b>ফিরে যান</b></a></div>
        <div>
            <form method="POST" onsubmit="" name="" enctype="multipart/form-data" action="">	
                <table  class="formstyle" style="font-family: SolaimanLipi !important;width: 80%;">          
                    <tr><th colspan="2" style="text-align: center;font-size: 18px;">বেতন প্রদানের স্টেটমেন্ট, <?php
                            $last_month = date('F', strtotime('last month'));
                            echo $last_month . "'";
                            $year = date("Y");
                            if ($last_month == "December")
                                echo $year - 1;
                            else
                                echo $year;
                            ?>
                        </th></tr>
                    <tr>
                        <td colspan="2" style=" text-align: right; padding-left: 120px !important; margin: 0px">
                            <table style="border: 1px solid black; width: 80%; ">
                                <tr>
                                    <td style="width: 50%; text-align: right"><b>নাম :</b></td>
                                    <td style="width: 50%; text-align: left"><?php echo $db_empname ?></td>
                                    <td width="40%" style="padding-right: 0px;" rowspan="4"> 
                                        <img src="<?php echo $db_empphoto; ?>" width="128px" height="128px" alt="">
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width: 50%; text-align: right"><b>একাউন্ট নাম্বার :</b></td>
                                    <td style="width: 50%; text-align: left"><?php echo $db_account_number ?></td>
                                </tr>
                                <tr>
                                    <td style="width: 50%; text-align: right"><b>মোবাইল :</b></td>
                                    <td style="width: 50%; text-align: left"><?php echo $db_empmobile ?></td>
                                </tr>
                                <tr>
                                    <td style="width: 50%; text-align: right"><b>ইমেল :</b></td>
                                    <td style="width: 50%; text-align: left"><?php echo $db_email ?></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" style=" text-align: right; padding-left: 120px !important; margin: 0px">
                            <table style="width: 80%; ">
                                <tr>
                                    <td style="width: 50%; text-align: right"><b>অফিস :</b></td>
                                    <td style="width: 50%; text-align: left"><?php echo $_SESSION['loggedInOfficeName']; ?></td>
                                </tr>
                                <tr>
                                    <td style="width: 50%; text-align: right"><b>পোস্ট :</b></td>
                                    <td style="width: 50%; text-align: left"><?php echo $db_empposition;?></td>
                                </tr>
                                <tr>
                                    <td style="width: 50%; text-align: right"><b>গ্রেড :</b></td>
                                    <td style="width: 50%; text-align: left"><?php echo $db_paygrd_name ?></td>
                                </tr>
                                <tr>
                                    <td style="width: 50%; text-align: right"><b>সেলারী :</b></td>
                                    <td style="width: 50%; text-align: left"><?php echo english2bangla($db_salary)." টাকা"?></td>
                                </tr>
                                <tr>
                            </table>
                        </td>
                    </tr> 

                    <tr>
                        <td style=" text-align: left; padding-left: 120px !important; margin: 0px; width: 50%">
                            <fieldset style="border: #686c70 solid 3px;width: 95%;">
                                <legend style="color: brown;">বেতনের শ্রেণী বিন্যাস</legend>
                                <table style=" width: 95%; padding-left: 5%" cellspacing="0">
                                    <tr>
                                        <td style="border: 1px solid black;"><b>শ্রেণী</b></td>
                                        <td style="border: 1px solid black;"><b>এমাউন্ট</b></td>
                                    </tr>
                                    <?php
                                    $criteria_total = 0;
                                    $select_salary_criteria = mysql_query("SELECT * FROM salary_criteria");
                                    while($sal_criteria_row = mysql_fetch_assoc($select_salary_criteria))
                                    {
                                        $db_criteria = $sal_criteria_row['criteria_name'];
                                        $db_percentange = $sal_criteria_row['percentage'];
                                        $salary_part = round((($db_salary * $db_percentange) / 100),2);
                                        $criteria_total+= $salary_part;
                                        echo "<tr><td style='border: 1px solid black;'>$db_criteria</td>";
                                        echo "<td style='border: 1px solid black;'>".english2bangla($salary_part)." টাকা</td></tr>";
                                    }
                                        echo "<tr><td style='border: 1px solid black;'>মূল</td>";
                                        echo "<td style='border: 1px solid black;'>".english2bangla($db_salary-$criteria_total)." টাকা</td></tr>";
                                    ?>
                                </table>
                            </fieldset>
                        </td>
                        <td style=" text-align: left; padding-left: 0px !important; margin: 0px;">
                            <fieldset style="border: #686c70 solid 3px;width: 70%;">
                                <legend style="color: brown;">হাজিরা সারসংক্ষেপ</legend>
                                <table style=" width: 95%; padding-left: 5%" cellspacing="0">
                                    <tr>
                                        <td  ><b>মোট কার্যদিবস</b></td>
                                        <td >: <?php echo english2bangla($workingDays) ?> দিন</td>
                                    </tr>
                                    <tr>
                                        <td  ><b>উপস্থিত</b></td>
                                        <td >: <?php echo english2bangla($presentDays) ?> দিন</td>
                                    </tr>
                                    <tr>
                                        <td  ><b>অনুপস্থিত</b></td>
                                        <td >: <?php echo english2bangla($absentDays) ?> দিন</td>
                                    </tr>
                                    <tr>
                                        <td  ><b>ছুটি</b></td>
                                        <td >: <?php echo english2bangla($leaveDays) ?> দিন</td>
                                    </tr>                                    
                                </table>
                            </fieldset>

                            <fieldset style="border: #686c70 solid 3px;width: 70%;">
                                <legend style="color: brown;">অন্যান্য</legend>
                                <table style=" width: 95%; padding-left: 5%" cellspacing="0">
                                    <tr>
                                        <td  ><b>বোনাস</b></td>
                                        <td >: <?php echo english2bangla($db_bonus) ?> টাকা</td>
                                    </tr>
                                    <tr>
                                        <td  ><b>হ্রাস</b></td>
                                        <td >: <?php echo english2bangla($db_deduct) ?> টাকা</td>
                                    </tr>
                                    <tr>
                                        <td  ><b>পেনশন এমাউন্ট</b></td>
                                        <td >: </td>
                                    </tr>
                                    <tr>
                                        <td  ><b>মোট প্রদেয় বেতন</b></td>
                                        <td >: <?php echo english2bangla($db_given_salary) ?> টাকা</td>
                                    </tr>
                                </table>
                            </fieldset>
                        </td>
                    </tr>
                    <tr >
                        <td style="padding-top: 100px; width: 40%; padding-left: 120px"><hr></td>
                    </tr>
                    <tr>
                        <td style="width: 40%; padding-left: 120px; text-align: center">কর্তৃপক্ষের স্বাক্ষর</td>
                    </tr>
                </table>
            </form>
        </div>           
    </div>
<?php } else {
    ?>
    
    <div class="main_text_box">      
        <div style="padding-left: 10px;">
            <a href="crm_management.php"><b>ফিরে যান</b></a></br>
                <div style="border: 1px solid grey;width: 100%">
                    <table  style=" width: 99%; margin-bottom: 10px;margin-left: 2px;" > 
                        <tr><th style="text-align: center; background-image: radial-gradient(circle farthest-corner at center top , #FFFFFF 0%, #0883FF 100%);height: 45px;padding-bottom: 5px;padding-top: 5px;" colspan="2" ><h1>কাস্টমারের তালিকা</h1></th></tr>
                        <tr>
                            <td></br>
                            <?php
                                include_once 'includes/areaSearchForCustomer.php';
                                getArea("custInfoFromArea()");
                                ?>
                                <input type="hidden" id="method" value="custInfoFromArea()" />
                            </td>
                    </tr>
                    <tr>
                        <td><br/>
                        <table cellpadding="3px" cellspacing="0px" style="margin-left: 2px;width: 99%;">
                                <thead>
                                    <tr id="table_row_odd">
                                        <td style="border: 1px solid black;text-align: center;"><b>কাস্টমারের নাম</b></td>
                                        <td style="border: 1px solid black;text-align: center;"><b>একাউন্ট নং</b></td>
                                        <td style="border: 1px solid black;text-align: center;"><b>মোবাইল</b></td>
                                        <td style="border: 1px solid black;text-align: center;"><b>থানা</b></td>
                                        <td style="border: 1px solid black;text-align: center;"><b>পোস্টঅফিস</b></td>
                                        <td style="border: 1px solid black;text-align: center;"><b>গ্রাম</b></td>
                                        <td style="border: 1px solid black;text-align: center;"></td>
                                    </tr>
                                </thead>
                                <tbody id="customer_list">   
                                    <?php
                                     $sql_officeTable = "SELECT * FROM cfs_user,customer_account WHERE  cfs_user_idUser=idUser AND user_type='customer' ORDER BY account_name ASC";
                                        $rs = mysql_query($sql_officeTable);
                                            while ($row_officeNcontact = mysql_fetch_array($rs)) {
                                            $db_Name = $row_officeNcontact['account_name'];
                                            $db_accNumber = $row_officeNcontact['account_number'];
                                            $db_email = $row_officeNcontact['email'];
                                            $db_mobile = $row_officeNcontact['mobile'];
                                            $db_custID = $row_officeNcontact['idCustomer_account'];
                                            $sql_custAddrss = mysql_query("SELECT * FROM address,thana,post_office,village WHERE  idThana=address.Thana_idThana AND address_whom='cust' 
                                                                                                AND address_type='Permanent' AND adrs_cepng_id= $db_custID
                                                                                                AND post_idpost = idPost_office AND village_idvillage = idvillage");
                                            $addressrow = mysql_fetch_assoc($sql_custAddrss);
                                            $db_thana = $addressrow['thana_name'];
                                            $db_post= $addressrow['post_offc_name'];
                                            $db_village = $addressrow['village_name'];
                                            echo "<tr style='border: 1px solid #969797;'>";
                                            echo "<td style='border: 1px solid #969797;'>$db_Name</td>";
                                            echo "<td style='border: 1px solid #969797;'>$db_accNumber</td>";
                                            echo "<td style='border: 1px solid #969797;'>$db_mobile</td>";
                                            echo "<td style='border: 1px solid #969797;'>$db_thana</td>";
                                            echo "<td style='border: 1px solid #969797;'>$db_post</td>";
                                            echo "<td style='border: 1px solid #969797;'>$db_village</td>";
                                                $v = base64_encode($db_custID);
                                            echo "<td style='border: 1px solid black;'><a href='update_customer_account_inner.php?id=$v'>বিস্তারিত</a></td>";
                                            echo "</tr>";
                                        }
                                    ?>
                                </tbody>
                            </table>                        
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <?php
}
include_once 'includes/footer.php';
?>
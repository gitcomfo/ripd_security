<?php
include_once 'getSelectedThana.php';      
                $joinArray = implode(',', $arr_thanaID);
                echo $type = $_GET['type'];
                $sql_list = "SELECT * FROM cfs_user, employee, pay_grade  
                             WHERE cfs_user.idUser=employee.cfs_user_idUser AND pay_grade_id=idpaygrade 
                             AND employee.employee_type='$type'";
                $db_result_presenter_info = mysql_query($sql_list); //Saves the query of Presenter Infromation
                while ($row_prstn = mysql_fetch_array($db_result_presenter_info)) {
                    $db_rl_presenter_name = $row_prstn['user_name'];
                    $db_rl_presenter_acc = $row_prstn['account_number'];
                    $db_rl_presenter_mobile = $row_prstn['mobile'];
                    $db_rl_presenter_email = $row_prstn['email'];
                    $db_rl_presenter_grade = $row_prstn['grade_name'];
                    $db_rl_presenter_id = $row_prstn['idEmployee'];
                    
                    $sql_sel_adrs = mysql_query("SELECT * FROM address,thana,district,division 
                                                                    WHERE address_type= 'Present' AND address_whom= 'emp' AND adrs_cepng_id='$db_rl_presenter_id' 
                                                                   AND Thana_idThana=idThana AND idThana IN ($joinArray) AND idDistrict= District_idDistrict AND idDivision=Division_idDivision ");
                    $adrsrow = mysql_fetch_assoc($sql_sel_adrs);
                    $db_rl_presenter_division = $adrsrow['division_name'];
                    $db_rl_presenter_district = $adrsrow['district_name'];
                    $db_rl_presennter_thana = $adrsrow['thana_name'];
                    echo "<tr>
                        <td ><?php echo $db_rl_presenter_name; ?></td>
                        <td><?php echo $db_rl_presenter_acc; ?></td>
                        <td><?php echo $db_rl_presenter_grade; ?></td>
                        <td><?php echo $db_rl_presenter_mobile; ?></td>
                        <td><?php echo $db_rl_presenter_email; ?></td>
                        <td><?php echo $db_rl_presennter_thana; ?></td>
                        <td><?php echo $db_rl_presenter_district; ?></td>
                        <td><?php echo $db_rl_presenter_division; ?></td>
                        <td style='text-align: center ' > <a href='presentation_schdule_combined.php?action=sedule&id= $db_rl_presenter_id&type=$type'>সিডিউল </a></td>  
                    </tr>";
                }
?>
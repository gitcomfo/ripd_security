<?php
include_once 'getSelectedThana.php';      
                $joinArray = implode(',', $arr_thanaID);
           //   print_r($joinArray);
                $type = $_GET['type'];
                $sql_list = "SELECT * FROM cfs_user, employee, pay_grade, ons_relation,office, thana, district, division  
                             WHERE idUser=employee.cfs_user_idUser AND pay_grade_id=idpaygrade 
                             AND employee.employee_type='$type' AND emp_ons_id = idons_relation AND idOffice= add_ons_id 
                             AND Thana_idThana=idThana AND idThana IN ($joinArray) AND idDistrict= District_idDistrict AND idDivision=Division_idDivision ";
                $db_result_presenter_info = mysql_query($sql_list); //Saves the query of Presenter Infromation
                while ($row_prstn = mysql_fetch_array($db_result_presenter_info)) {
                    $db_rl_presenter_name = $row_prstn['user_name'];
                    $db_rl_presenter_acc = $row_prstn['account_number'];
                    $db_rl_presenter_mobile = $row_prstn['mobile'];
                    $db_rl_presenter_email = $row_prstn['email'];
                    $db_rl_presenter_grade = $row_prstn['grade_name'];
                    $db_rl_presenter_id = $row_prstn['idEmployee'];

                    $db_rl_presenter_office = $row_prstn['office_name'];
                    $db_rl_presenter_division = $row_prstn['division_name'];
                    $db_rl_presenter_district = $row_prstn['district_name'];
                    $db_rl_presennter_thana = $row_prstn['thana_name'];
                    echo "<tr>
                        <td >$db_rl_presenter_name</td>
                        <td>$db_rl_presenter_acc</td>
                        <td>$db_rl_presenter_grade</td>
                        <td>$db_rl_presenter_mobile</td>
                        <td>$db_rl_presenter_email</td>
                        <td>$db_rl_presenter_office</td>
                        <td>$db_rl_presennter_thana</td>
                        <td>$db_rl_presenter_district</td>
                        <td>$db_rl_presenter_division</td>
                        <td style='text-align: center ' > <a href='presentation_schdule_combined.php?action=sedule&id= $db_rl_presenter_id&type=$type'>সিডিউল </a></td>  
                    </tr>";
                }
?>
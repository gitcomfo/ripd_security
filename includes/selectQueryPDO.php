<?php
include_once 'connectionPDO.php';
$sql_select_award_all = $conn->prepare("SELECT * FROM  ripd_award ORDER BY awd_date DESC");
$sql_select_award_id = $conn->prepare("SELECT * FROM  ripd_award WHERE idaward=?");
$sql_select_command = $conn->prepare("SELECT * FROM command ORDER BY commandno ASC");
$sql_select_commandEdit = $conn->prepare("SELECT * FROM command WHERE idcommand = ?");
$sql_select_account_type = $conn->prepare("SELECT idAccount_type, account_name FROM account_type LIMIT 5");
$sql_pv_view = $conn->prepare("SELECT cust_type, sales_type, store_type, less_amount, selling_earn, patent_nh,
                                                                    pv_ripd_income, direct_sales_cust, account_name, Rone, Rtwo, Rthree, Rfour, Rfive,
                                                                    office, staff, shariah, charity, presentation, training, program, travel, patent, leadership, transport, research, server, bag, brochure, form, money_receipt, pad, box, extra
                                                                    FROM view_pv_view WHERE idcommand=? ORDER BY cust_type ASC");
$sql_current_command = $conn->prepare("SELECT * FROM running_command LIMIT 1");
$sql_select_login = $conn->prepare("SELECT * FROM cfs_user WHERE user_name=? AND password=?");
$sql_select_cfs_user_all = $conn->prepare("SELECT * FROM cfs_user WHERE idUser = ?");
$sql_select_cust_basic = $conn->prepare("SELECT designation_name, designation_star, scanDoc_finger_print, scanDoc_picture, referer_id
                                                                    FROM customer_account, designation
                                                                    WHERE idDesignation=Designation_idDesignation AND cfs_user_idUser = ?");
$sql_select_employee_basic = $conn->prepare("SELECT * FROM employee,employee_information WHERE Employee_idEmployee= idEmployee AND cfs_user_idUser = ?");
$sql_select_propritor_basic = $conn->prepare("SELECT * FROM proprietor_account WHERE cfs_user_idUser = ?");
$sql_genology_tree = $conn->prepare("SELECT account_name, cfs_user_idUser FROM cfs_user, customer_account WHERE idUser=cfs_user_idUser AND referer_id = ?");
$sql_select_accountType = $conn->prepare("SELECT account_name FROM account_type");
$sql_select_office = $conn->prepare("SELECT * FROM office WHERE idOffice = ?");
$sql_select_sales_store = $conn->prepare("SELECT * FROM sales_store WHERE idSales_store = ?");
$sql_select_emp_post = $conn->prepare("SELECT post_name FROM employee, employee_posting, post_in_ons, post
                                                                    WHERE idPost = Post_idPost AND idpostinons = post_in_ons_idpostinons AND Employee_idEmployee = idEmployee
                                                                    AND  cfs_user_idUser =? ");
$sql_select_pay_grade = $conn->prepare("SELECT * FROM pay_grade WHERE idpaygrade = ?");
// ******************* for master chart ***********************************************************
$sql_select_all_catagory = $conn->prepare("SELECT DISTINCT pro_catagory, pro_cat_code FROM product_catagory ORDER BY pro_catagory");
$sql_select_all_brand = $conn->prepare("SELECT DISTINCT pro_brand_or_grp, pro_brnd_or_grp_code FROM product_chart ORDER BY pro_brand_or_grp");
$sql_select_type = $conn->prepare("SELECT * FROM product_catagory WHERE pro_cat_code = ? ORDER BY pro_type ");
$sql_select_cat_by_brand = $conn->prepare ("SELECT DISTINCT pro_catagory, pro_cat_code  FROM product_catagory,product_chart WHERE idproduct_catagory = product_catagory_idproduct_catagory AND pro_brnd_or_grp_code=? ");
$sql_select_type_by_brand = $conn->prepare("SELECT DISTINCT pro_type,idproduct_catagory FROM product_catagory,product_chart WHERE  idproduct_catagory = product_catagory_idproduct_catagory AND pro_brnd_or_grp_code=? AND pro_cat_code= ?");
$sql_select_all_type_by_cat = $conn ->prepare("SELECT * FROM product_catagory WHERE pro_cat_code = 
                                                                                ANY(SELECT pro_cat_code FROM product_catagory WHERE idproduct_catagory = ?)");
$sql_select_product_by_type = $conn->prepare("SELECT * FROM product_chart WHERE product_catagory_idproduct_catagory = ?");
$sql_select_product_by_brand = $conn->prepare("SELECT * FROM product_chart WHERE pro_brnd_or_grp_code = ?");
$sql_select_product = $conn->prepare("SELECT * FROM product_chart WHERE idproductchart = ? ");
$sql_select_product_from_inventory = $conn->prepare("SELECT * FROM inventory WHERE ins_productid = ? AND ins_product_type='general' ");
// *********************************** for Accounting *************************************************************
$sql_last_userAmountTransfer = $conn->prepare("SELECT trans_date_time FROM acc_user_amount_transfer WHERE trans_type=? AND trans_senderid=? ORDER BY trans_date_time DESC LIMIT 1");
$sql_userBalance = $conn->prepare("SELECT * FROM acc_user_balance WHERE cfs_user_iduser = ?");
$sql_select_charge = $conn->prepare("SELECT charge_amount, charge_type FROM charge WHERE charge_status = 'active' AND charge_code = ?");
$sql_select_balace_check = $conn->prepare("SELECT total_balanace FROM acc_user_balance WHERE cfs_user_iduser = ?");
$sql_select_random = $conn->prepare("SELECT * FROM acc_user_amount_transfer WHERE send_amt_pin = ?");
// ********************************** for get id_ons_relation form office_type and office_id ************************
$sql_select_id_ons_relation = $conn->prepare("SELECT idons_relation FROM  ons_relation WHERE catagory =  ? AND add_ons_id = ?");
// ********************************************* posting & promotion ******************************************************
$sql_select_ons_relation = $conn->prepare("SELECT * FROM ons_relation WHERE idons_relation=? ");
$sel_office_employee = $conn->prepare("SELECT * FROM cfs_user,employee,ons_relation WHERE catagory='office' 
                                                                  AND add_ons_id=? AND idons_relation=emp_ons_id 
                                                                  AND employee.employee_type='employee' AND cfs_user_idUser = idUser");
$sql_select_employee_grade = $conn->prepare("SELECT grade_name,employee_salary.insert_date,total_salary FROM employee_salary,employee,pay_grade
                                                                                WHERE pay_grade_id = idpaygrade AND user_id = ? 
                                                                               AND pay_grade_idpaygrade = idpaygrade ORDER BY employee_salary.insert_date DESC LIMIT 1");
$sql_select_view_emp_post = $conn->prepare("SELECT * FROM view_emp_post 
                                                                            WHERE Employee_idEmployee=? AND add_ons_id= ? ORDER BY posting_date DESC LIMIT 1");
$sql_select_emplyee_cfs = $conn->prepare("SELECT * FROM cfs_user,employee,employee_information WHERE idUser = cfs_user_idUser AND idEmployee = ?");
$sql_select_emp_address = $conn->prepare("SELECT * FROM address,thana,district,division WHERE address_whom = 'emp'
                                                                        AND address_type='Present' AND adrs_cepng_id = ?
                                                                        AND Thana_idThana = idThana AND District_idDistrict=idDistrict AND Division_idDivision= idDivision ");
$sql_select_post = $conn->prepare("SELECT * FROM post_in_ons,post WHERE idpostinons = ? AND Post_idPost =idPost ");

?>

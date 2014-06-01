<?php
include_once './connectionPDO.php';
if(isset($_GET['amount']))
{
        $g_accountNo = $_GET['acNo'];
        $g_amount = $_GET['amount'];
        $sel_onsID = $conn->prepare("SELECT idons_relation FROM ons_relation LEFT JOIN office ON add_ons_id = idOffice 
                                                WHERE catagory='office' AND account_number = ?");
        $sel_onsID->execute(array($g_accountNo));
        $row = $sel_onsID->fetchAll();
        foreach ($row as $value) {
            $office_ons_id = $value['idons_relation'];
         }
         $cur_month = date('n');
         $cur_year = date('Y');
         if($cur_month == 1)
         {
             $prev_month = 12;
             $prev_year = $cur_year-1;
         }
         else
         {
             $prev_month = $cur_month -1;
             $prev_year = $cur_year;
         }
         
          $sel_acc_amount = $conn->prepare("SELECT total_amount FROM acc_ofc_physc_ledger WHERE  ripd_office_id = ? 
                                                                    AND month_no = ? AND year_no= ?");
         $sel_acc_amount->execute(array($office_ons_id,$cur_month, $cur_year));
         $amount_row = $sel_acc_amount->fetchAll();
         
         if(count($amount_row) == 0)
         {
             $sel_acc_amount->execute(array($office_ons_id,$prev_month, $prev_year));
                $amount_row = $sel_acc_amount->fetchAll();
                foreach ($amount_row as $value) {
                    $db_amount = $value['total_amount'];
                }
         }
        else {
            foreach ($amount_row as $value) {
                           $db_amount = $value['total_amount'];
                       }
        }
         
            if($g_amount > $db_amount)
            {
                echo "0";
            }
             else {
                 echo "";
             }
}
?>

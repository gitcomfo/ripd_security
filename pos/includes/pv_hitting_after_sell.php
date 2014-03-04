<?php
session_start();
include_once 'connectionPDO.php';

$store_type = $_SESSION['loggedInOfficeType'];
function pv_hitting($custID, $cust_type, $sumID)
{
    $up_acc_user_balance = $conn->prepare("UPDATE acc_user_balance SET pv_balance = pv_balance + ?, total_balanace = total_balanace + ? WHERE cfs_user_iduser = ? ");
    $up_main_fund = $conn->prepare("UPDATE main_fund SET fund_amount = fund_amount + ?, last_update = NOW() WHERE fund_code = ? ");
    $ins_cust_hitting = $conn->prepare("INSERT INTO sales_customer_hitting (selling_earn,soft_costing,own,Rone,Rtwo,Rthree,Rfour,Rfive,ripd_income,borkot,sales_summery_idsalessummery) VALUES(?,?,?,?,?,?,?,?,?,?,?)");
    $sel_summary = $conn->prepare("SELECT selling_type,sal_total_profit FROM sales_summary WHERE idsalessummary = ?");
    $sel_referer = $conn->prepare("SELECT * FROM view_usertree WHERE ut_customerid = ?");
    $sel_pv_view = $conn->prepare("SELECT * FROM view_pv_view WHERE cust_type = ? AND sales_type= ? AND store_type='both' AND account_type_id=?");
    $sel_cust_pkg = $conn->prepare("SELECT Account_type_idAccount_type FROM customer_account WHERE cfs_user_idUser = ?");
    
    if($cust_type == 'unregcustomer')
    {
        $type = 'no_acc';
    }
    else { $type = 'account'; }
    // select sales summary ***********************88
    $sel_summary->execute(array($sumID));
    $summaryrow = $sel_summary->fetchAll();
        foreach ($summaryrow as $row) {
            $db_selling_type = $row['selling_type'];
            $db_total_profit = $row['sal_total_profit'];
        }
        
    if($type == 'account')
    {
        // select referers *************************************
        $sel_referer->execute(array($custID));
        $refererrow = $sel_referer->fetchAll();
        foreach ($refererrow as $row) {
            $one = $row['ut_first_parentid'];
            $two = $row['ut_second_parentid'];
            $three = $row['ut_third_parentid'];
            $four = $row['ut_fourth_parentid'];
            $five = $row['ut_fifth_parentid'];
        }
        // select customer pkg ******************************
        $sel_cust_pkg->execute(array($custID));
        $pkgrow = $sel_cust_pkg->fetchAll();
        foreach ($pkgrow as $row) {
            $pkgtype = $row['Account_type_idAccount_type'];
        }
    }
    // select view pv view **************************
    $sel_pv_view->execute(array($type,$db_selling_type,$pkgtype));
    $viewpvrow = $sel_pv_view->fetchAll();
    foreach ($viewpvrow as $row) {
            $less_amount = $row['less_amount'];
            $pnh = $row['patent_nh'];
            $se = $row['selling_earn'];
            $ri = $row['pv_ripd_income'];
            $direct_sales = $row['direct_sales_cust'];
            $Rone = $row['Rone'];
            $Rtwo = $row['Rtwo'];
            $Rthree = $row['Rthree'];
            $Rfour = $row['Rfour'];
            $Rfive = $row['Rfive'];
            $office = $row['office'];
            $staff = $row['staff'];
            $shariah = $row['shariah'];
            $charity = $row['charity'];
            $presentation = $row['presentation'];
            $training = $row['training'];
            $program = $row['program'];
            $travel = $row['travel'];
            $patent = $row['patent'];
            $leadership = $row['leadership'];
            $transport = $row['transport'];
            $research = $row['research'];
            $server = $row['server'];
            $bag = $row['bag'];
            $brochure = $row['brochure'];
            $form = $row['form'];
            $moneyrcpt = $row['money_receipt'];
            $pad = $row['pad'];
            $box = $row['box'];
            $extra = $row['extra'];
        }
        // calculate hitting amount *************************************8
        $office_hit = ($db_total_profit * $office) / 100;
        $staff_hit = ($db_total_profit * $staff) / 100;
        $shariah_hit = ($db_total_profit * $shariah) / 100;
        $charity_hit = ($db_total_profit * $charity) / 100;
        $presentation_hit = ($db_total_profit * $presentation) / 100;
        $training_hit = ($db_total_profit * $training) / 100;
        $program_hit = ($db_total_profit * $program) / 100;
        $travel_hit = ($db_total_profit * $travel) / 100;
        $patent_hit = ($db_total_profit * $patent) / 100;
        $leadership_hit = ($db_total_profit * $leadership) / 100;
        $transport_hit = ($db_total_profit * $transport) / 100;
        $research_hit = ($db_total_profit * $research) / 100;
        $server_hit = ($db_total_profit * $server) / 100;
        $bag_hit = ($db_total_profit * $bag) / 100;
        $brochure_hit = ($db_total_profit * $brochure) / 100;
        $form_hit = ($db_total_profit * $form) / 100;
        $moneyrcpt_hit = ($db_total_profit * $moneyrcpt) / 100;
        $pad_hit = ($db_total_profit * $pad) / 100;
        $box_hit = ($db_total_profit * $box) / 100;
        $extra_hit = ($db_total_profit * $extra) / 100;
        $arr_softcost = array('SOF'=>$office_hit,'SWO'=>$staff_hit,'SSC'=>$shariah_hit,'SCR'=>$charity_hit,'SPR'=>$presentation_hit,'STR'=>$training_hit,'SPG'=>$program_hit,'STL'=>$travel_hit,'SLD'=>$leadership_hit,'SJT'=>$transport_hit,'SGR'=>$research_hit,'SSV'=>$server_hit,'SBG'=>$bag_hit,'SBR'=>$brochure_hit,'SFR'=>$form_hit,'SMR'=>$moneyrcpt_hit,'SPD'=>$pad_hit,'SBX'=>$box_hit,'SER'=>$extra_hit,'SPT'=>$patent_hit);
        
        $total_softcost = 0;
        $borkot = 0;
        $conn->beginTransaction();
        if($one != 0)
        {
            $one_hit = ($db_total_profit * $Rone) / 100;
            $sql1 = $up_acc_user_balance->execute(array($one_hit,$one_hit,$one));
        }
        else { $borkot = $borkot + (($db_total_profit * $Rone) / 100); $one_hit = 0;  }
        if($two != 0)
        {
            $two_hit = ($db_total_profit * $Rtwo) / 100;
            $sql1=$up_acc_user_balance->execute(array($two_hit,$two_hit,$two));
        }
        else { $borkot = $borkot + (($db_total_profit * $Rtwo) / 100); $two_hit = 0;  }
        if($three != 0)
        {
            $three_hit = ($db_total_profit * $Rthree) / 100;
            $sql1 = $up_acc_user_balance->execute(array($three_hit,$three_hit,$three));
        }
        else { $borkot = $borkot + (($db_total_profit * $Rthree) / 100); $three_hit = 0;  }
        if($four != 0)
        {
            $four_hit = ($db_total_profit * $Rfour) / 100;
            $sql1 = $up_acc_user_balance->execute(array($four_hit,$four_hit,$four));
        }
        else { $borkot = $borkot + (($db_total_profit * $Rfour) / 100); $four_hit = 0;  }
        if($five != 0)
        {
            $five_hit = ($db_total_profit * $Rfive) / 100;
            $sql1 = $up_acc_user_balance->execute(array($five_hit,$five_hit,$five));
        }
        else { $borkot = $borkot + (($db_total_profit * $Rfive) / 100); $five_hit = 0;  }
   // calculate total soft cost ****************************     
  foreach ($arr_softcost as $key => $value) {
      $sql2 = $up_main_fund->execute(array($value,$key));
      $total_softcost =$total_softcost+$value;
  }
  $se_hit = ($db_total_profit * $se) / 100;
  $ri_hit = ($db_total_profit * $ri) / 100;
  $own_hit = ($db_total_profit * $direct_sales) / 100;
  $sql3 = $ins_cust_hitting->execute(array($se_hit,$total_softcost,$own_hit,$one_hit,$two_hit,$three_hit,$four_hit,$five_hit,$ri_hit,$borkot,$sumID));
  if($sql1 && $sql2 && $sql3)
  {
       $conn->commit();
       $flag = 1;
  }
 else {
      $conn->rollBack();
      $flag = 0;
  }
  return $flag;
}

?>

<?php
include_once 'ConnectDB.inc';

function pv_hitting($custID, $cust_type, $sumID,$selling_type,$total_profit)
{
    if($cust_type == 'unregcustomer')
    {
        $type = 'no_acc';
    }
    else { $type = 'account'; }
      
    if($type == 'account')
    {
        // select referers *************************************
        $sel_referer = mysql_query("SELECT * FROM view_usertree WHERE ut_customerid = $custID");
        while($row = mysql_fetch_assoc($sel_referer)) {
            $one = $row['ut_first_parentid'];
            $two = $row['ut_second_parentid'];
            $three = $row['ut_third_parentid'];
            $four = $row['ut_fourth_parentid'];
            $five = $row['ut_fifth_parentid'];
        }
        // select customer pkg ******************************
        $sel_cust_pkg = mysql_query("SELECT Account_type_idAccount_type FROM customer_account WHERE cfs_user_idUser = $custID");
        while($row = mysql_fetch_assoc($sel_cust_pkg)) {
            $pkgtype = $row['Account_type_idAccount_type'];
        }
    }
    // select view pv view **************************
     $sel_pv_view = mysql_query("SELECT * FROM view_pv_view WHERE cust_type = '$type' AND sales_type= '$selling_type' AND store_type='both' AND account_type_id=$pkgtype");
    while($row = mysql_fetch_assoc($sel_pv_view)) {
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
        $office_hit = ($total_profit * $office) / 100;
        $staff_hit = ($total_profit * $staff) / 100;
        $shariah_hit = ($total_profit * $shariah) / 100;
        $charity_hit = ($total_profit * $charity) / 100;
        $presentation_hit = ($total_profit * $presentation) / 100;
        $training_hit = ($total_profit * $training) / 100;
        $program_hit = ($total_profit * $program) / 100;
        $travel_hit = ($total_profit * $travel) / 100;
        $patent_hit = ($total_profit * $patent) / 100;
        $leadership_hit = ($total_profit * $leadership) / 100;
        $transport_hit = ($total_profit * $transport) / 100;
        $research_hit = ($total_profit * $research) / 100;
        $server_hit = ($total_profit * $server) / 100;
        $bag_hit = ($total_profit * $bag) / 100;
        $brochure_hit = ($total_profit * $brochure) / 100;
        $form_hit = ($total_profit * $form) / 100;
        $moneyrcpt_hit = ($total_profit * $moneyrcpt) / 100;
        $pad_hit = ($total_profit * $pad) / 100;
        $box_hit = ($total_profit * $box) / 100;
        $extra_hit = ($total_profit * $extra) / 100;
        $arr_softcost = array('SOF'=>$office_hit,'SWO'=>$staff_hit,'SSC'=>$shariah_hit,'SCR'=>$charity_hit,'SPR'=>$presentation_hit,'STR'=>$training_hit,'SPG'=>$program_hit,'STL'=>$travel_hit,'SLD'=>$leadership_hit,'SJT'=>$transport_hit,'SGR'=>$research_hit,'SSV'=>$server_hit,'SBG'=>$bag_hit,'SBR'=>$brochure_hit,'SFR'=>$form_hit,'SMR'=>$moneyrcpt_hit,'SPD'=>$pad_hit,'SBX'=>$box_hit,'SER'=>$extra_hit,'SPT'=>$patent_hit);
        
        $total_softcost = 0;
        $borkot = 0;
        mysql_query("START TRANSACTION");
        if($one != 0)
        {
            $one_hit = ($total_profit * $Rone) / 100;
            $sql1 = mysql_query("UPDATE acc_user_balance SET pv_balance = pv_balance + $one_hit, total_balanace = total_balanace + $one_hit WHERE cfs_user_iduser = $one ");
        }
        else { $borkot = $borkot + (($total_profit * $Rone) / 100); $one_hit = 0;  }
        if($two != 0)
        {
            $two_hit = ($total_profit * $Rtwo) / 100;
            $sql1=mysql_query("UPDATE acc_user_balance SET pv_balance = pv_balance + $two_hit, total_balanace = total_balanace + $two_hit WHERE cfs_user_iduser = $two ");
        }
        else { $borkot = $borkot + (($total_profit * $Rtwo) / 100); $two_hit = 0;  }
        if($three != 0)
        {
            $three_hit = ($total_profit * $Rthree) / 100;
            $sql1 = mysql_query("UPDATE acc_user_balance SET pv_balance = pv_balance + $three_hit, total_balanace = total_balanace + $three_hit WHERE cfs_user_iduser = $three ");
        }
        else { $borkot = $borkot + (($total_profit * $Rthree) / 100); $three_hit = 0;  }
        if($four != 0)
        {
            $four_hit = ($total_profit * $Rfour) / 100;
            $sql1 = mysql_query("UPDATE acc_user_balance SET pv_balance = pv_balance + $four_hit, total_balanace = total_balanace + $four_hit WHERE cfs_user_iduser = $four ");
        }
        else { $borkot = $borkot + (($total_profit * $Rfour) / 100); $four_hit = 0;  }
        if($five != 0)
        {
            $five_hit = ($total_profit * $Rfive) / 100;
            $sql1 = mysql_query("UPDATE acc_user_balance SET pv_balance = pv_balance + $five_hit, total_balanace = total_balanace + $five_hit WHERE cfs_user_iduser = $five ");
        }
        else { $borkot = $borkot + (($total_profit * $Rfive) / 100); $five_hit = 0;  }
   // calculate total soft cost ****************************     
  foreach ($arr_softcost as $key => $value) {
      $sql2 = mysql_query("UPDATE main_fund SET fund_amount = fund_amount + $value, last_update = NOW() WHERE fund_code = '$key' ");
      $total_softcost =$total_softcost+$value;
  }
  $se_hit = ($total_profit * $se) / 100;
  $ri_hit = ($total_profit * $ri) / 100;
  $own_hit = ($total_profit * $direct_sales) / 100;
  
  $sql4 = mysql_query("UPDATE acc_user_balance SET pv_balance = pv_balance + $own_hit, total_balanace = total_balanace + $own_hit WHERE cfs_user_iduser = $custID ");
  
  $sql3 = mysql_query("INSERT INTO sales_customer_hitting (selling_earn,soft_costing,own,Rone,Rtwo,Rthree,Rfour,Rfive,ripd_income,borkot,sales_summery_idsalessummery) 
                                    VALUES($se_hit,$total_softcost,$own_hit,$one_hit,$two_hit,$three_hit,$four_hit,$five_hit,$ri_hit,$borkot,$sumID)");
  
  if($sql1 && $sql2 && $sql3 && $sql4)
  {
       mysql_query("COMMIT");
       $flag = 1;
  }
 else {
      mysql_query("ROLLBACK");
      $flag = 0;
  }
  return $flag;
}

?>

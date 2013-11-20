<?php
include 'ConnectDB.inc';
if($_GET['selltype']=='1')
{
    $G_type= $_GET['type'];
    switch($G_type)
    {
        case 1:
            echo "<label style='margin-left:200px;'><b>টাকা গ্রহন&nbsp;&nbsp;:</b>
	  <input name='cash' id='cash' type='text' onkeypress='return checkIt(event)' onkeyup='minus()' /> টাকা</label>
	<label style='margin-left: 63px;'><b>টাকা ফেরত : </b>
	  <input name='change' id='change' type='text' readonly/> টাকা</label>";
        break;
        case 2:
            echo "<label style='margin-left:200px;'><b>অ্যাকাউন্ট নং&nbsp;&nbsp;:</b>
	  <input name='accountNo' id='accountNo' type='text' /></label>
	<label style='margin-left: 63px;'><b>টাকার পরিমাণ : </b>
	  <input name='amount' id='amount' onkeypress='return checkIt(event)'  type='text'/> টাকা</label>";
       break;
   case 3:
            echo "<label style='margin-left:200px;'><b>অ্যাকাউন্ট নং&nbsp;&nbsp;:</b>
	  <input name='accountNo' id='accountNo' type='text' /></label>
	<label style='margin-left: 63px;'><b>টাকার পরিমাণ : </b>
	  <input name='amount' id='amount' onkeypress='return checkIt(event)' type='text'/> টাকা</label>";
       break;
    }
}
elseif($_GET['selltype']=='2')
{
    $G_type= $_GET['type'];
    switch($G_type)
    {
      case 1:
            echo "<label style='margin-left:200px;'><b>টাকা গ্রহন&nbsp;&nbsp;:</b>
	  <input name='cash' id='cash' type='text' onkeypress='return checkIt(event)' onkeyup='minus()' /> টাকা</label>
	<label style='margin-left: 63px;'><b>টাকা ফেরত : </b>
	  <input name='change' id='change' type='text' readonly/> টাকা</label>";
        break;
        case 2:
            echo "<label style='margin-left:200px;'><b>অ্যাকাউন্ট নং&nbsp;&nbsp;:</b>
	  <input name='accountNo' id='accountNo' type='text' /></label>
	<label style='margin-left: 63px;'><b>টাকার পরিমাণ : </b>
	  <input name='amount' id='amount' type='text' onkeypress='return checkIt(event)'  /> টাকা</label>";
       break;
    }
}
?>
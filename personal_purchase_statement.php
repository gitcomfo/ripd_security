<?php
//include 'includes/session.inc';
include_once 'includes/header.php';
$userID = $_SESSION['userIDUser'];
$select_refered = $conn->prepare("SELECT cfs_user.account_name, account_name FROM pin_makingused, cfs_user,customer_account,account_type 
                                                        WHERE sales_summery_idsalessummery = ? AND pin_state='newaccount' AND pin_usedby_cfsuserid= idUser
                                                        AND idUser = cfs_user_idUser AND Account_type_idAccount_type = idAccount_type ");
?>
<style type="text/css">@import "css/bush.css";</style>
<link rel="stylesheet" href="css/tinybox.css" type="text/css">
<script type="text/javascript" src="javascripts/tinybox.js"></script>
<script type="text/javascript">
function details_show(id){
           TINY.box.show({url:'includes/personal_purchase_details.php?sum_id='+id,width:900,height:400,opacity:30,topsplit:3,animate:true,close:true,maskid:'bluemask',maskopacity:50,boxid:'success'}); }
</script>

<div class="main_text_box">
    <div style="padding-left: 112px;"><a href="personal_reporting.php"><b>ফিরে যান</b></a></div>
    <div>           
            <table class="formstyle"  style="font-family: SolaimanLipi !important;width: 80%;">          
                <tr><th style="text-align: center" colspan="2"><h1>পার্সোনাল পারচেজ স্টেটমেন্ট</h1></th></tr>
                <tr>
                    <td>
                        <fieldset style="border:3px solid #686c70;width: 99%;">
                            <legend style="color: brown;font-size: 14px;">সার্চ</legend>
                            <form method="POST" action="">	
                            <table>
                                <tr>
                                    <td style="padding-left: 0px; text-align: left;" >শুরুর তারিখঃ</td>
                                    <td style="text-align: left"><input class="box" type="date" name="startDate" /></td>	 
                                    <td style="padding-left: 0px; text-align: left;"  >শেষের তারিখঃ</td>
                                    <td style=" text-align: left"><input class="box" type="date" name="lastDate" /></td>
                                    <td style="padding-left: 50px; " ><input class="btn" style =" font-size: 12px; " type="submit" name="submit" value="সার্চ" /></td>
                                </tr>
                            </table>
                           </form>
                        </fieldset>
                    </td> 
                </tr>
                <tr>
                    <td>
                        <fieldset style="border: 3px solid #686c70 ; width: 99%;font-family: SolaimanLipi !important;">
                            <legend style="color: brown;font-size: 14px;">পার্সোনাল পারচেজ স্টেটমেন্ট</legend>
                            <div id="resultTable">
                                <table style="width: 98%;margin: 0 auto;" cellspacing="0" cellpadding="0">
                                    <thead>
                                        <tr id="table_row_odd">
                                            <td width="16%" style="border: solid black 1px;"><div align="center"><strong>তারিখ</strong></div></td>
                                            <td width="12%"  style="border: solid black 1px;"><div align="center"><strong>সময়</strong></div></td>
                                            <td width="25%"  style="border: solid black 1px;"><div align="center"><strong>রশিদ নং</strong></div></td>
                                            <td width="11%"  style="border: solid black 1px;"><div align="center"><strong>মূল্য(টাকা)</strong></div></td>
                                            <td width="12%" style="border: solid black 1px;"><div align="center"><strong>মোট পিভি</strong></div></td>
                                            <td width="20%" style="border: solid black 1px;"><div align="center"><strong>রেফার্ড</strong></div></td>
                                            <td width="12%" style="border: solid black 1px;"><div align="center"><strong>প্যাকেজ</strong></div></td>
                                            
                                        </tr>
                                    </thead>
                                    <tbody style="background-color: #FCFEFE">
                                        <?php
                                        if(isset($_POST['submit']))
                                        {
                                            $p_startdate = $_POST['startDate'];
                                            $p_lastDate = $_POST['lastDate'];
                                            $slNo = 1;
                                            $userID = $_SESSION['userIDUser'];
                                            $result = mysql_query("SELECT * FROM sales_summary WHERE sal_buyerid = $userID 
                                                                                AND sal_salesdate BETWEEN '$p_startdate' AND '$p_lastDate' ORDER BY sal_salesdate");
                                            while ($row = mysql_fetch_assoc($result)) {
                                                $db_sal_salesdate = $row["sal_salesdate"];
                                                $db_sal_salestime = $row["sal_salestime"];
                                                $db_sal_totalamount = $row["sal_totalamount"];
                                                $db_sal_invoiceno = $row["sal_invoiceno"];
                                                $db_sal_totalpv = $row['sal_totalpv'];
                                                $db_salsumid = $row['idsalessummary'];
                                                $select_refered->execute(array($db_salsumid));
                                                $row1 = $select_refered->fetchAll();
                                                foreach ($row1 as $value) {
                                                    $db_refered = $value['cfs_user.account_name'];
                                                    $db_package = $value['account_name'];
                                                }
                                                echo '<tr>';
                                                echo '<td  style="border: solid black 1px;"><div align="center">' . english2bangla(date("d/m/Y",  strtotime($db_sal_salesdate))) . '</div></td>';
                                                echo '<td  style="border: solid black 1px;"><div align="left">' . english2bangla(date('g:i a' , strtotime($db_sal_salestime))) . '</div></td>';
                                                echo "<td  style='border: solid black 1px;'><a onclick=details_show('$db_salsumid') style='color:green;cursor:pointer;'><u>$db_sal_invoiceno<u><a></td>";
                                                echo '<td  style="border: solid black 1px;"><div align="center">' . $db_sal_totalamount . '</div></td>';
                                                echo '<td  style="border: solid black 1px;"><div align="center">' . $db_sal_totalpv . '</div></td>';
                                                echo '<td  style="border: solid black 1px;"><div align="center">'.$db_refered.'</div></td>';
                                                echo '<td  style="border: solid black 1px;"><div align="center">'.$db_package.'</div></td>';                                                
                                                echo '</tr>';
                                                $slNo++;
                                            }
                                        }
                                        else
                                        {
                                            $slNo = 1;                                            
                                            $result = mysql_query("SELECT * FROM sales_summary WHERE sal_buyerid = $userID ORDER BY sal_salesdate");
                                            while ($row = mysql_fetch_assoc($result)) {
                                                $db_sal_salesdate = $row["sal_salesdate"];
                                                $db_sal_salestime = $row["sal_salestime"];
                                                $db_sal_totalamount = $row["sal_totalamount"];
                                                $db_sal_invoiceno = $row["sal_invoiceno"];
                                                $db_sal_totalpv = $row['sal_totalpv'];
                                                $db_salsumid = $row['idsalessummary'];
                                                $select_refered->execute(array($db_salsumid));
                                                $row1 = $select_refered->fetchAll();
                                                foreach ($row1 as $value) {
                                                    $db_refered = $value['cfs_user.account_name'];
                                                    $db_package = $value['account_name'];
                                                }
                                                echo '<tr>';
                                                echo '<td  style="border: solid black 1px;"><div align="center">' . english2bangla(date("d/m/Y",  strtotime($db_sal_salesdate))) . '</div></td>';
                                                echo '<td  style="border: solid black 1px;"><div align="left">' . english2bangla(date('g:i a' , strtotime($db_sal_salestime))) . '</div></td>';
                                                echo "<td  style='border: solid black 1px;'><a onclick=details_show('$db_salsumid') style='color:green;cursor:pointer;'><u>$db_sal_invoiceno<u><a></td>";
                                                echo '<td  style="border: solid black 1px;"><div align="center">' . $db_sal_totalamount . '</div></td>';
                                                echo '<td  style="border: solid black 1px;"><div align="center">' . $db_sal_totalpv . '</div></td>';
                                                echo '<td  style="border: solid black 1px;"><div align="center">'.$db_refered.'</div></td>';
                                                echo '<td  style="border: solid black 1px;"><div align="center">'.$db_package.'</div></td>';                                              
                                                echo '</tr>';
                                                $slNo++;
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </fieldset>
                    </td>
                </tr>
            </table>
        
    </div>
</div>   

<?php include_once 'includes/footer.php'; ?>
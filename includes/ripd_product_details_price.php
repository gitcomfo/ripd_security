<?php
include_once 'ConnectDB.inc';
?>
<style type="text/css">@import "css/bush.css";</style>
<div class="main_text_box">
    <div>           
        <form method="POST" onsubmit="" >	
            <table class="formstyle"  style="font-family: SolaimanLipi !important;width: 80%;">          
                <tr><th style="text-align: center" colspan="2"><h1>বিভিন্ন অফিসে পণ্যটির মূল্য</h1></th></tr>
                <tr>
                    <td>
                        <table style="width: 98%;margin: 0 auto;" cellspacing="0" cellpadding="0">
                            <thead>
                                <tr id="table_row_odd">
                                    <td width="11%" style="border: solid black 1px;"><div align="center"><strong>ক্রমিক নং</strong></div></td>
                                    <td width="20%"  style="border: solid black 1px;"><div align="center"><strong>অফিস / সেলসস্টোর</strong></div></td>
                                    <td width="30%"  style="border: solid black 1px;"><div align="center"><strong>মূল্য</strong></div></td>
                                 </tr>
                            </thead>
                            <tbody style="background-color: #FCFEFE">
                                <?php
                                //if (isset($_GET['code']))
                                //     	{	
                                //                    $G_summaryID = $_GET['code'];
                                $slNo = 1;
                                $result = mysql_query("SELECT * FROM product_chart ORDER BY pro_code ");
                                while ($row = mysql_fetch_assoc($result)) {
                                    $db_proname = $row["pro_productname"];
                                    $db_unit = $row["pro_unit"];
                                    $db_article = $row["pro_article"];
                                    $db_procode = $row["pro_code"];
                                    echo '<tr>';
                                    echo '<td  style="border: solid black 1px;"><div align="center">' . english2bangla($slNo) . '</div></td>';
                                    echo '<td  style="border: solid black 1px;"><div align="left">' . $db_procode . '</div></td>';
                                    echo '<td  style="border: solid black 1px;"><div align="left">&nbsp;&nbsp;&nbsp;' . $db_proname . '</div></td>';
                                    echo '</tr>';
                                    $slNo++;
                                }
                                ?>
                            </tbody>
                        </table>
                </tr>
            </table>
        </form>
    </div>
</div>   
<?php
include_once './ConnectDB.inc';
$g_str =$_GET['typeNid'];
$arr_str = explode(",", $g_str);
$type = $arr_str[0];
$id = $arr_str[1];
$slNo = 1;

$result = mysql_query("SELECT * FROM inventory WHERE ins_ons_id = $id AND ins_how_many = 0
                                      AND ins_ons_type='$type' AND ins_product_type='general' ORDER BY ins_productname ");
    while ($row = mysql_fetch_assoc($result))
    {
        $db_proname=$row["ins_productname"];
        $db_procode=$row["ins_product_code"];
        $db_lastsell = $row['ins_lastupdate'];
        $db_inventID = $row['idinventory'];
        echo '<tr>';
        echo '<td  style="border: solid black 1px;">' .  english2bangla($slNo). '</td>';
        echo '<td  style="border: solid black 1px;">' . $db_proname . '</td>';
        echo '<td  style="border: solid black 1px;">' . $db_procode . '</td>';
        echo '<td  style="border: solid black 1px;"><div align="center">??</div></td>';
        echo '<td  style="border: solid black 1px;"><div align="center">' . english2bangla(date("d/m/Y",  strtotime($db_lastsell))) . '</div></td>';
        echo '<td style="border: solid black 1px;"><div align="center"><a onclick="previousProductDetails('.$db_inventID.')" style="cursor:pointer;color:blue;">বিস্তারিত</a></div></td>';
        echo '</tr>';
          $slNo++;
    }
?>
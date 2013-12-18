<?php
error_reporting(0);
include_once './ConnectDB.inc';
include_once './selectQueryPDO.php';
 if(isset($_GET['catcode']))
 {
     $g_code = $_GET['catcode'];
     $g_name = $_GET['catname'];
     echo '<div class="toggler" style="margin: 0 auto; ">
                            <h3 class="ui-state-default ui-corner-all button" style="text-align: center;width: 200px;">'.$g_name.'</h3>
                           <div  class="ui-widget-content ui-corner-all effect">';
                                    $sql_select_type->execute(array($g_code));
                                    $arr_type_rslt = $sql_select_type->fetchAll();
                                    foreach ($arr_type_rslt as $typerow) {
                                        $db_typeName = $typerow['pro_type'];
                                        $db_catagoryID = $typerow['idproduct_catagory'];
                                        echo "<a class='innerLinks' href='masterChart_part_2.php?type=$db_catagoryID'> $db_typeName </a>";
                                    }
           echo  '</div></div>';
 }
elseif(isset($_GET['brand']))
 {
     $g_brand = $_GET['brand'];
     $sql_select_cat_by_brand->execute(array($g_brand));
     $arr_catagory = $sql_select_cat_by_brand->fetchAll();
     foreach ($arr_catagory as $value) {
         $db_catcode = $value['pro_cat_code'];
         $db_catname = $value['pro_catagory'];
     echo '<div class="toggler" style="float:left ">
                            <h3 class="ui-state-default ui-corner-all button">'.$db_catname.'</h3>
                           <div  class="ui-widget-content ui-corner-all effect">';
                                    $sql_select_type_by_brand->execute(array($g_brand,$db_catcode));
                                    $arr_type_rslt = $sql_select_type_by_brand->fetchAll();
                                    foreach ($arr_type_rslt as $typerow) {
                                        $db_typeName = $typerow['pro_type'];
                                        $db_catagoryID = $typerow['idproduct_catagory'];
                                        echo "<a class='innerLinks' href='masterChart_part_2.php?type=$db_catagoryID'> $db_typeName </a>";
                                    }
           echo  '</div></div>';
     }
 }
?>

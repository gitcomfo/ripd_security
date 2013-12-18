<?php 
    include_once 'includes/header.php';
    include_once './includes/selectQueryPDO.php';
    $g_catID = $_GET['type'];

    function showType($sql,$id)
    {
         echo  "<option value=0> -সিলেক্ট করুন- </option>";
        $sql->execute(array($id));
        $arr_catagoryRslt = $sql->fetchAll();
        foreach ($arr_catagoryRslt as $catrow) {
            echo  "<option value=".$catrow['pro_type_code'].">".$catrow['pro_type']."</option>";
        }
    }
 function showBrand($sql,$id)
    {
         echo  "<option value=0> -সিলেক্ট করুন- </option>";
        $sql->execute(array($id));
        $arr_brandRslt = $sql->fetchAll();
        foreach ($arr_brandRslt as $brandrow) {
            echo  "<option value=".$brandrow['pro_brnd_or_grp_code'].">".$brandrow['pro_brand_or_grp']."</option>";
        }
    }
?>
<style type="text/css">@import "css/bush.css";</style>
<link rel="stylesheet" href="css/jquery-ui.css">
<script src="javascripts/jquery-1.9.1.js"></script>
<script src="javascripts/jquery-ui.js"></script>
<style type="text/css">
.toggler {
width: 200px;
height: auto;
margin: 5px 10px;
}
.effect {
position: relative;
width: 200px;
height: 135px;
padding: 0.4em;
}
.innerLinks {
    display:block;
    text-decoration: none;
    text-align:center;
    cursor:pointer;
    color:green;
    background-color:#fcefa1;
    margin:3px 0px;
    border:1px solid green;
}
h3 {
    text-align: center;
    width: 200px;
    cursor: pointer;
}
</style>
<script type="text/javascript">
$(function() {
$( ".effect" ).hide();
$( ".button" ).click(function() {
var selectedEffect = 'blind';
var content = $(this).next();
  $(content).toggle( selectedEffect, 500 );
  $(content).next().toggle( selectedEffect, 500 );
return false;
    });
});
</script>
<div class="page_header_div">
    <div class="page_header_title">মূল পণ্য তালিকা (মাস্টার চার্ট) ধাপ -২</div>
</div>
<div style="padding-left: 10px;"><a href="masterChart_part_1.php" style="width: 50px;height: 30px;"><img src="images/go_previous_blue.png" style="width: 50px;height:30px;" /></a></div>
<div>
    <table>
        <tr>
            <td style="text-align: right;">টাইপ :
                <select class="box">
                    <?php showType($sql_select_all_type_by_cat,$g_catID)?>
                </select>
            </td>
            <td style="text-align: center;"> <b> অথবা </b></td>
            <td>ব্র্যান্ড / গ্রুপ :
                <select class="box">
                    <?php showBrand($sql_select_brand_by_type,$g_catID)?>
                </select>            
            </td>
        </tr>
        <tr>
            <td colspan="3" style="border: 1px inset #555;">
                        <div id="catagoryShowcage" style="width: 100%;height: auto;" >
                            <?php
                                    // ******************************** catagory ****************************
//                                    $sql_select_all_catagory->execute();
//                                    $arr_catagory = $sql_select_all_catagory->fetchAll();
//                                    foreach ($arr_catagory as $value) {
//                                    $db_catName = $value['pro_catagory'];
//                                    $db_catCode = $value['pro_cat_code'];
                            ?>
                        <div class="toggler" style="float: left; ">
                                <h3 class="ui-state-default ui-corner-all button" style="text-align: center;width: 200px;"><?php echo $db_catName;?></h3>
                               <div  class="ui-widget-content ui-corner-all effect">
                                   <?php
                                        // ********************************* type ******************************
//                                        $sql_select_type->execute(array($db_catCode));
//                                        $arr_type_rslt = $sql_select_type->fetchAll();
//                                        foreach ($arr_type_rslt as $typerow) {
//                                            $db_typeName = $typerow['pro_type'];
//                                            $db_catagoryID = $typerow['idproduct_catagory'];
//                                            echo "<a class='innerLinks' href='masterChart_part_2.php?type=$db_catagoryID'> $db_typeName </a>";
//                                        }
                                   ?>
                               </div>
                           </div>
                                <?php// }?>
                </div>
            </td>
        </tr>
    </table>
</div>
<?php include_once 'includes/footer.php';?>



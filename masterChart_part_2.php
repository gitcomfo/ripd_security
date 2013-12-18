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
 function showBrand($sql)
    {
         echo  "<option value=0> -সিলেক্ট করুন- </option>";
        $sql->execute(array());
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
width: 250px;
height: auto;
margin: 5px 10px;
}
.effect {
position: relative;
width: 250px;
height: 135px;
padding: 0.4em;
}
.detailsLinks {
    display:block;
    text-decoration: none;
    text-align:center;
    cursor:pointer;
    color:green;
    background-color:greenyellow;
    margin:3px 0px;
    border:1px solid black;
    border-radius: 5px;
}
h3 {
    text-align: center;
    width: 250px !important;
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
                    <?php showBrand($sql_select_all_brand)?>
                </select>            
            </td>
        </tr>
        <tr>
            <td colspan="3" style="border: 1px inset #555;">
                        <div id="catagoryShowcage" style="width: 100%;height: auto;" >
                            <?php
                                    // ******************************** type ****************************
                                    $sql_select_product_by_type->execute(array($g_catID));
                                    $arr_product = $sql_select_product_by_type->fetchAll();
                                    foreach ($arr_product as $value) {
                                    $db_proName = $value['pro_productname'];
                                    $db_proCode = $value['pro_code'];
                                    $db_proBrand = $value['pro_brand_or_grp'];
                                    $db_proArticle = $value['pro_article'];
                                    $db_proUnit = $value['pro_unit'];
                            ?>
                        <div class="toggler" style="float: left; ">
                                <h3 class="ui-state-default ui-corner-all button" ><?php echo $db_proName;?></h3>
                               <div  class="ui-widget-content ui-corner-all effect">
                                   <table style="margin-left: 0px;">
                                       <tr>
                                           <td>ব্র্যান্ড</td>
                                           <td>: <?php echo $db_proBrand;?></td>
                                       </tr>
                                       <tr>
                                           <td>একক</td>
                                           <td>: <?php echo $db_proUnit;?></td>
                                       </tr>
                                       <tr>
                                           <td>কোড</td>
                                           <td>: <?php echo $db_proCode;?></td>
                                       </tr>
                                       <tr>
                                           <td>আর্টিকেল</td>
                                           <td>: <?php echo $db_proArticle;?></td>
                                       </tr>
                                       <tr>
                                           <td colspan="2" style="text-align: center"><a class='detailsLinks'>বিস্তারিত</a></td>
                                       </tr>
                                   </table>
                               </div>
                           </div>
                                <?php }?>
                </div>
            </td>
        </tr>
    </table>
</div>
<?php include_once 'includes/footer.php';?>



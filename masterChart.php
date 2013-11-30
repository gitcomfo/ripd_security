<?php
include_once 'includes/header.php';
?>
<div class="page_header_div">
    <div class="page_header_title">মূল পণ্য তালিকা (মাস্টার চার্ট)</div>
</div>
<div>
    <table id="master_chart">
    <tbody>
        <?php
        $sql_productCategory = "SELECT * from $dbname.product_catagory";
        $rs_productCategory = mysql_query($sql_productCategory);
        echo "<tr>";
        $loopValue = 0;
        while ($row_productCategory = mysql_fetch_array($rs_productCategory)) {
            if (($loopValue % 3) == 0) {
                echo "</tr><tr>";
            }
            $db_categoryId = $row_productCategory['idproduct_catagory'];
            $db_categoryName = $row_productCategory['pro_catagory'];
            $db_pro_type = $row_productCategory['pro_type'];
            
            echo "<td id = \"master-chart_column\">";
            echo "<table border = \"1\" id = \"master_chart_category\"><tr><th>$db_categoryName - $db_pro_type</th></tr>";
            $sql_productName = "SELECT * from $dbname.product_chart where product_catagory_idproduct_catagory = $db_categoryId ORDER BY pro_classification ASC";
            $rs_productName = mysql_query($sql_productName);
            while ($row_productName = mysql_fetch_array($rs_productName)) {
                $db_pro_classification = $row_productName['pro_classification'];
                echo "<tr><td>$db_pro_classification</td></tr>";
            }
            echo "</table></td>";
            $loopValue = $loopValue + 1;
        }
        echo "</tr>";
        ?>
    </tbody>
</table>       
<script type="text/javascript">
    var filter = new DG.Filter({
        filterField : $('office_filter'),
        filterEl : $('office_info')
        //colIndexes : [0,2]
    });
</script>

</div>

<?php 
include_once 'includes/footer.php';
?>



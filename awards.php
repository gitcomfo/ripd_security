<?php
include_once 'includes/header.php';
include_once 'includes/showTables.php';
?>
<script type="text/javascript" src="javascripts/external/mootools.js"></script>
<script type="text/javascript" src="javascripts/dg-filter.js"></script>

<div class="page_header_div">
    <div class="page_header_title">এওয়ার্ডসমূহ</div>
</div>
<fieldset id="award_fieldset_style">
    <div style="text-align: right;padding-right: 1%;margin-bottom: 5px;">সার্চ/খুঁজুন:<input type = "text" id ="search_box_filter"><br /></div>
    <span id="office">
        <div>
            <table id="office_info_filter" border="1" align="center" width= 99%" cellpadding="5px" cellspacing="0px">                    
                <thead>
                    <tr align="left" id="table_row_odd">
                        <th><?php echo "ক্রম"; ?></th>
                        <th><?php echo "এওয়ার্ড টাইপ"; ?></th>
                        <th><?php echo "এওয়ার্ড বর্ণনা"; ?></th>
                        <th><?php echo "তারিখ"; ?></th>
                        <th><?php echo "এওয়ার্ড হোল্ডার"; ?></th>
                    </tr>
                </thead>
                <tbody>

                    <?php
                    $sql_awards = "SELECT * from ripd_award ORDER BY awd_date ASC";
                    $rs_awards = mysql_query($sql_awards);
                    //echo "Heloo".mysql_num_rows($rs_awards);


                    while ($row_awards = mysql_fetch_array($rs_awards)) {
                        $db_slNo = $db_slNo + 1;
                        $serial = english2bangla($db_slNo);
                        $db_awardId = $row_awards['idaward'];
                        $db_awardType = getAwardType($row_awards['awd_type']);
                        $db_awardDescription = $row_awards['awd_description'];
                        $db_awardDate = english2bangla($row_awards['awd_date']);
                        $db_awardReceiver_name = $row_awards['awd_receivername'];
                        echo "<tr>";
                        echo "<td>$serial</td>";
                        echo "<td>$db_awardType</td>";
                        echo "<td>$db_awardDescription</td>";
                        echo "<td>$db_awardDate</td>";
                        echo "<td>$db_awardReceiver_name</td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>                       
        </div>
    </span>          
</fieldset>

<script type="text/javascript">
    var filter = new DG.Filter({
        filterField : $('search_box_filter'),
        filterEl : $('office_info_filter')
        //colIndexes : [0,2]
    });
</script>
<?php
include_once 'includes/footer.php';
?>
            


<?php
include_once 'includes/header.php';
include_once 'includes/showTables.php';
?>
<script type="text/javascript" src="javascripts/external/mootools.js"></script>
<script type="text/javascript" src="javascripts/dg-filter.js"></script>
<div class="main_text_box">
    <div style="padding-left: 5px;"><a href="personal_reporting.php"><b>ফিরে যান</b></a></div>
    <div>
<div class="page_header_div">
    <div class="page_header_title">ইন ডেসক্রিপশন</div>
</div>

<fieldset id="award_fieldset_style">
    <div style="text-align: right;padding-right: 1%;margin-bottom: 5px;">সার্চ/খুঁজুন:<input type = "text" id ="search_box_filter"><br /></div>
    <span id="office">
        <div>
            <table id="office_info_filter" border="1" align="center" width= 99%" cellpadding="5px" cellspacing="0px">                    
                <thead>
                    <tr align="left" id="table_row_odd">
                        <th><?php echo "ক্রম"; ?></th>
                        <th><?php echo "তারিখ"; ?></th>
                        <th><?php echo "সময়"; ?></th>
                        <th><?php echo "এমাউন্ট"; ?></th>
                        <th><?php echo "মাধ্যম"; ?></th>
                        <th><?php echo "ট্যাক্স / চার্জ"; ?></th>
                    </tr>
                </thead>
                <tbody>

                    <tr>
                        <td>111111111</td>
                        <td>111111111</td>
                        <td>111111111</td>
                        <td>111111111</td>
                        <td>111111111</td>
                        <td>111111111</td>
                    </tr>
                </tbody>
            </table>                       
        </div>
    </span>          
</fieldset>
</div>
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
            


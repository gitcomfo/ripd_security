<?php

//87
include_once 'includes/header.php';
include_once 'includes/showTables.php';
?>
<script type="text/javascript" src="javascripts/external/mootools.js"></script>
<script type="text/javascript" src="javascripts/dg-filter.js"></script>

<div class="page_header_div">
    <div class="page_header_title">total buying description</div>
</div>

<fieldset id="award_fieldset_style">
    <span id="office">
        <div>
            <table id="office_info_filter" border="1" align="center" width= 99%" cellpadding="5px" cellspacing="0px">                    
                <thead>
                    <tr align="left" id="table_row_odd">
                        <th>তারিখ</th>
                        <th colspan="2">ব্যাক্তিগত ক্রয়</th>
                        <th colspan="2">R1</th>
                        <th colspan="2">R2</th>
                        <th colspan="2">R3</th>
                        <th colspan="2">R4</th>
                        <th colspan="2">R5</th>
                        <th colspan="2">মোট</th>
                    </tr>
                </thead>
                <tr>
                    <td></td>
                    <td>PV</td>
                    <td>TK</td>
                    <td>PV</td>
                    <td>TK</td>
                    <td>PV</td>
                    <td>TK</td>
                    <td>PV</td>
                    <td>TK</td>
                    <td>PV</td>
                    <td>TK</td>
                    <td>PV</td>
                    <td>TK</td>
                    <td>PV</td>
                    <td>TK</td>
                </tr>
                <tr>
                    <td colspan="13" style="text-align: right">সর্বমোট</td>
                    <td></td>
                    <td></td>
                </tr>
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
            


<?php include_once 'includes/header.php'; ?>
<style type="text/css">
    @import "css/bush.css";
    @import "css/expand_collapse.css";
</style>
<script type="text/javascript" src="javascripts/expand_collapse01.js"></script>
<script type="text/javascript" src="javascripts/expand_collapse02_ui.js"></script>
<script>    
    $(function() {
        $( "#accordion" ).accordion();
    });
</script>
<div class="page_header_div">
    <div class="page_header_title">মূল পণ্য তালিকা (মাস্টার চার্ট)</br> ধাপ -২</div>
</div>
<div>
    <table>
        <tr>
            <td>টাইপ :
                <select class="box">
                    <option></option>
                </select>
            </td>
            <td>ব্র্যান্ড / গ্রুপ :
                <select class="box">
                    <option></option>
                </select>            
            </td>
        </tr>
        <tr>
            <td colspan="2">
                    <div id="accordion" style="width: 80%;margin: 0 auto;">
                        <?php
                            for($i=0;$i<5;$i++) {
                        ?>
                        <h3>অনলাইন মিডিয়া</h3>
                                    <div>	
                                        <table style="width: 98%">                                         
                                            <tr>    
                                                <td>
                                                    
                                                </td>

                                                <td>
                                                   
                                                </td>
                                            </tr>
                                        </table>
                                </div>
                            <?php }?>
                          </div>
            </td>
        </tr>
    </table>
</div>
<script type="text/javascript">
    var filter = new DG.Filter({
        filterField : $('office_filter'),
        filterEl : $('office_info')
        //colIndexes : [0,2]
    });
</script>
<?php include_once 'includes/footer.php';?>



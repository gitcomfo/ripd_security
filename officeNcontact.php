<?php
include_once 'includes/header.php';
include_once 'includes/showTables.php';
?>
<script type="text/javascript" src="javascripts/area.js"></script>
<script type="text/javascript" src="javascripts/external/mootools.js"></script>
<script type="text/javascript" src="javascripts/dg-filter.js"></script>

<script type="text/javascript">
    function infoFromThana()
    {
        var xmlhttp;
        if (window.XMLHttpRequest) xmlhttp=new XMLHttpRequest();
        else xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
        xmlhttp.onreadystatechange=function()
        {
            if (xmlhttp.readyState==4 && xmlhttp.status==200) 
                document.getElementById('office').innerHTML=xmlhttp.responseText;
        }
        var division_id, district_id, thana_id;
        division_id = document.getElementById('division_id').value;
        district_id = document.getElementById('district_id').value;
        thana_id = document.getElementById('thana_id').value;
        xmlhttp.open("GET","includes/infoOfficeFromThana.php?dsd="+district_id+"&dvd="+division_id+"&ttid="+thana_id,true);
        xmlhttp.send();
    }
</script>

<fieldset id="award_fieldset_style">

    <div id="table_header_style">
        <table border="0" style="width: 100%; height: 100%;font-size: 17px" align="center">
            <tr align="center">
                <td><b>অফিস টেবিল</b></td>
            </tr>
        </table>
    </div>

    <?php
    include_once('includes/areaSearch.php');
    getArea("infoFromThana()");
    ?>

    <input type="hidden" id="method" value="infoFromThana()">

    সার্চ/খুঁজুন:  <input type = "text" id ="search_box_filter">

    <span id="office">
        <?php
        officeTableHead();
        $sql_officeTable = "SELECT * from $dbname.office ORDER BY office_name ASC";
        officeNcontactTable($sql_officeTable);
        officeTableEnd();
        ?>
    </span>          
</fieldset>

<script type="text/javascript">
    var filter = new DG.Filter({
        filterField : $('search_box_filter'),
        filterEl : $('office_info_filter')
    });
</script>

<?php
include_once 'includes/footer.php';
?>


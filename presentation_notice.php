<?php
include_once 'includes/header.php';
?>
<script type="text/javascript" src="javascripts/area.js"></script>
<script type="text/javascript" src="javascripts/external/mootools.js"></script>
<script type="text/javascript" src="javascripts/dg-filter.js"></script>
<link rel="stylesheet" type="text/css" media="all" href="javascripts/jsDatePick_ltr.min.css" />
<script type="text/javascript" src="javascripts/jsDatePick.min.1.3.js"></script>
<script type="text/javascript">
    window.onclick = function()
    {
        new JsDatePick({
            useMode:2,
            target:"date_from",
            dateFormat:"%Y-%m-%d"
        });
    };
    window.onload = function()
    {
        new JsDatePick({
            useMode:2,
            target:"date_to",
            dateFormat:"%Y-%m-%d"
        });
    };
</script>

<script type="text/javascript">
    function infoPresentationFromThana()
    {
        var xmlhttp;
        if (window.XMLHttpRequest) xmlhttp=new XMLHttpRequest();
        else xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
        xmlhttp.onreadystatechange=function()
        {
            if (xmlhttp.readyState==4 && xmlhttp.status==200) 
                document.getElementById('office').innerHTML=xmlhttp.responseText;
        }
        var division_id, district_id, thana_id, date_from, date_to;
        division_id = document.getElementById('division_id').value;
        district_id = document.getElementById('district_id').value;
        thana_id = document.getElementById('thana_id').value;
        date_from = document.getElementById('date_from').value;
        date_to = document.getElementById('date_to').value;
        xmlhttp.open("GET","includes/infoPresentationFromThana.php?dsd="+district_id+"&dvd="+division_id+"&ttid="+thana_id+"&df="+date_from+"&dt="+date_to,true);
        xmlhttp.send();
    }
</script>

<fieldset id="award_fieldset_style">

    <div id="table_header_style">
        <table border="0" style="width: 100%; height: 100%;font-size: 17px" align="center">
            <tr align="center">
                <td><b>প্রেজেন্টেশন সিডিউল</b></td>
            </tr>
        </table>
    </div>
    <div style="padding-bottom: 10px;">
        <?php
        include_once 'includes/areaSearch.php';
        getArea("infoPresentationFromThana()");
        ?>
        সার্চ/খুঁজুন:  <input type="text" id="search_box_filter">
    </div>
    <div style="padding-bottom: 10px;">
        <b>Date From: </b><input type="text" name="date_from" id="date_from" placeholder="Date From"  style="">
        <b>Date To: </b> <input type="text" name="date_to" id="date_to" placeholder="Date To"  onclick="infoPresentationFromThana()">
        <input type="hidden" id="method" value="infoPresentationFromThana()">
        <input type="submit" onclick="infoPresentationFromThana()" value="Submit">
    </div>    

    <span id="office">
        <div>
            <table id="office_info_filter" border="1" align="center" width= 99%" cellpadding="5px" cellspacing="0px">
                <thead>
                    <tr align="left" id="table_row_odd">
                        <th><?php echo "ক্রম"; ?></th>
                        <th><?php echo "প্রেজেন্টেশন নাম"; ?></th>
                        <th><?php echo "প্রেজেন্টেশন নম্বর"; ?></th>
                        <th><?php echo "উপস্থাপক"; ?></th>                            
                        <th><?php echo "লোকেশন"; ?></th>
                        <th><?php echo "বিষয়" ?></th>
                        <th><?php echo "তারিখ"; ?></th>
                        <th><?php echo "সময়"; ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql_salesStoreTable = "SELECT * from $dbname.program where program_type = 'presentation' AND program_date between curdate() and '2099-12-31' ORDER BY program_date ASC";
                    $db_slNo = 0;
                    $rs = mysql_query($sql_salesStoreTable);

                    while ($row = mysql_fetch_array($rs)) {
                        $db_slNo = $db_slNo + 1;
                        $db_programName = $row['program_name'];
                        $db_programNumber = $row['program_no'];
                        $db_program_host_id = $row['Employee_idEmployee'];
                        $db_programLocationId = $row['program_location'];
                        $db_programDate = $row['program_date'];
                        $db_programTime = $row['program_time'];
                        ///////////////////////////////////
                        $sql_program_host_name = "SELECT employee_name FROM $dbname.employee_information WHERE Employee_idEmployee = $db_program_host_id ";
                        $rs_host_name = mysql_query($sql_program_host_name);
                        $rowName = mysql_fetch_array($rs_host_name);
                        $db_program_host_name = $rowName['employee_name'];
                        ///////////////////////////////////
                        $sql_location = "SELECT office_name, office_details_address FROM $dbname.office where idOffice = $db_programLocationId";
                        $rs_location = mysql_query($sql_location);
                        $row_location = mysql_fetch_array($rs_location);
                        $db_program_location = $row_location['office_details_address'];
                        ///////////////////////////////////
                        $db_programSubject = $row['subject'];
                        echo "<tr>";
                        echo "<td>$db_slNo</td>";
                        echo "<td>$db_programName</td>";
                        echo "<td>$db_programNumber</td>";
                        echo "<td>$db_program_host_name</td>";
                        echo "<td>$db_program_location</td>";
                        echo "<td>$db_programSubject</td>";
                        echo "<td>$db_programDate</td>";
                        echo "<td>$db_programTime</td>";
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
    });
</script>

<?php
include_once 'includes/footer.php';
?>

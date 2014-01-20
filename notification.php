<?php
include_once 'includes/header.php';
include_once 'includes/showTables.php';
$logedinOfficeId = $_SESSION['loggedInOfficeID'];
$logedinOfficeType = $_SESSION['loggedInOfficeType'];
?>
<script type="text/javascript" src="javascripts/area.js"></script>
<script type="text/javascript" src="javascripts/external/mootools.js"></script>
<script type="text/javascript" src="javascripts/dg-filter.js"></script>
<link rel="stylesheet" href="css/tinybox.css" type="text/css" media="screen" charset="utf-8"/>
<script src="javascripts/tinybox.js" type="text/javascript"></script>

<script type="text/javascript">
    function send_mail(emailAddress)
    {
        TINY.box.show({iframe:'send_email.php?office_sstore_mail='+emailAddress,width:600,height:300,opacity:30,topsplit:3,animate:true,close:true,maskid:'bluemask',maskopacity:50,boxid:'success'});
    }
</script>

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

<div class="page_header_div">
    <div class="page_header_title">অফিসিয়াল নোটিফিকেশন</div>
</div>
<div>
                <table id="office_info_filter" border="1" align="center" width= 99%" cellpadding="5px" cellspacing="0px">
                    <thead>
                        <tr align="left" id="table_row_odd">
                            <th><?php echo "ক্রম";?></th>
                            <th><?php echo "নোটিফিকেশন";?></th>
                            <th><?php echo "অবস্থা";?></th>
                            <th><?php echo "করনীয়";?></th>                   
                        </tr>
                    </thead>
                    <tbody>
<?php        
                    $db_slNo = 1;
                    $sel_official_notification = $conn->prepare("SELECT * FROM ons_relation, notification WHERE catagory=? AND add_ons_id=?
                       AND  nfc_receiverid= ? AND nfc_status != ? AND nfc_catagory = ?  AND ");
                    $sel_official_notification ->execute(array());
                    while($row_officeNcontact = mysql_fetch_assoc($rs_officeNcontact))
                         {
                         $db_slNo = $db_slNo + 1;
                         $db_officeName = $row_officeNcontact['office_name'];
                         $db_officeType = $row_officeNcontact['office_type'];
                         $db_officeBranch = $row_officeNcontact['branch_name'];
                         $db_officeAddress = $row_officeNcontact['office_details_address'];
                         $db_officeEmail = $row_officeNcontact['office_email'];
                         echo "<tr>";
                         echo "<td>".  english2bangla($db_slNo)."</td>";
                         echo "<td>$db_officeType</td>";
                         echo "<td>$db_officeBranch</td>";
                         echo "<td><a onclick=send_mail('$db_officeEmail') style='cursor:pointer;color:blue;'>ই-মেইল করুন</a></td>";
                         echo "</tr>";
                         }          
?>
                    </tbody>
            </table>                        
            </div>

<?php include_once 'includes/footer.php';?>
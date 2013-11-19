function getDistrict()
{
    var xmlhttp;
    if (window.XMLHttpRequest)
    {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
    }
    else
    {// code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange=function()
    {
        if (xmlhttp.readyState==4 && xmlhttp.status==200)
        {
            document.getElementById('did').innerHTML=xmlhttp.responseText;
        }
    }
    var division_id;
    division_id = document.getElementById('division_id').value;
    xmlhttp.open("GET","includes/getDistrict2.php?did="+division_id,true);
    xmlhttp.send();
}

function getThana()
{
    var xmlhttp;
    if (window.XMLHttpRequest)
    {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
    }
    else
    {// code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange=function()
    {
        if (xmlhttp.readyState==4 && xmlhttp.status==200)
        {
            document.getElementById('tid').innerHTML=xmlhttp.responseText;
        }
    }
    var division_id, district_id;
    division_id = document.getElementById('division_id').value;
    district_id = document.getElementById('district_id').value;
    xmlhttp.open("GET","includes/getThana2.php?tDsId="+district_id+"&tDfId="+division_id,true);
    xmlhttp.send();
}

function getPostOffice()
{
    var xmlhttp;
    if (window.XMLHttpRequest)
    {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
    }
    else
    {// code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange=function()
    {
        if (xmlhttp.readyState==4 && xmlhttp.status==200)
        {
            document.getElementById('pid').innerHTML=xmlhttp.responseText;
        }
    }
    var thana_id = document.getElementById('thana_id').value;
    xmlhttp.open("GET","includes/getPostOffice.php?ThId="+thana_id,true);
    xmlhttp.send();
}

function getVillage()
{
    var xmlhttp;
    if (window.XMLHttpRequest)
    {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
    }
    else
    {// code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange=function()
    {
        if (xmlhttp.readyState==4 && xmlhttp.status==200)
        {
            document.getElementById('vid').innerHTML=xmlhttp.responseText;
        }
    }
    var post_id = document.getElementById('post_id').value;
    xmlhttp.open("GET","includes/getVillage.php?PoId="+post_id,true);
    xmlhttp.send();
}
//**************###########****************##########********************###############******************
function getDistrict1()
{
    var xmlhttp;
    if (window.XMLHttpRequest)
    {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
    }
    else
    {// code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange=function()
    {
        if (xmlhttp.readyState==4 && xmlhttp.status==200)
        {
            document.getElementById('did1').innerHTML=xmlhttp.responseText;
        }
    }
    var division_id;
    division_id = document.getElementById('division_id1').value;
    xmlhttp.open("GET","includes/getDistrict21.php?did="+division_id,true);
    xmlhttp.send();
}

function getThana1()
{
    var xmlhttp;
    if (window.XMLHttpRequest)
    {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
    }
    else
    {// code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange=function()
    {
        if (xmlhttp.readyState==4 && xmlhttp.status==200)
        {
            document.getElementById('tid1').innerHTML=xmlhttp.responseText;
        }
    }
    var division_id, district_id;
    division_id = document.getElementById('division_id1').value;
    district_id = document.getElementById('district_id1').value;
    xmlhttp.open("GET","includes/getThana21.php?tDsId="+district_id+"&tDfId="+division_id,true);
    xmlhttp.send();
}

function getPostOffice1()
{
    var xmlhttp;
    if (window.XMLHttpRequest)
    {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
    }
    else
    {// code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange=function()
    {
        if (xmlhttp.readyState==4 && xmlhttp.status==200)
        {
            document.getElementById('pid1').innerHTML=xmlhttp.responseText;
        }
    }
    var thana_id = document.getElementById('thana_id1').value;
    xmlhttp.open("GET","includes/getPostOffice1.php?ThId="+thana_id,true);
    xmlhttp.send();
}

function getVillage1()
{
    var xmlhttp;
    if (window.XMLHttpRequest)
    {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
    }
    else
    {// code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange=function()
    {
        if (xmlhttp.readyState==4 && xmlhttp.status==200)
        {
            document.getElementById('vid1').innerHTML=xmlhttp.responseText;
        }
    }
    var post_id = document.getElementById('post_id1').value;
    xmlhttp.open("GET","includes/getVillage1.php?PoId="+post_id,true);
    xmlhttp.send();
}
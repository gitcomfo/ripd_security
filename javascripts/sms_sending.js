function sendsms(mob)
        {  
        var xmlhttp;
        alert("hello world");
        if (window.XMLHttpRequest) xmlhttp=new XMLHttpRequest();
        else xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
        xmlhttp.onreadystatechange=function()
			{
            if (xmlhttp.readyState==4 && xmlhttp.status==200)       
				document.getElementById('response').innerHTML=xmlhttp.responseText;
			}
        xmlhttp.open("GET", "includes/sms_host_info.php?mob="+mob, true);
        xmlhttp.send();
        }

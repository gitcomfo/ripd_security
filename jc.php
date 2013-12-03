<!--<script type="text/css">
    .rotare {
-webkit-transform: rotate(-90deg); 
-moz-transform: rotate(-90deg);	
    }


</script>-->
<?php
include_once 'includes/header.php';
$firstname = "jesy";
$lastname= "";

function show($value)
{
    if($value!="")
    {
        $string =  " ' ".$value." ' readonly";
    }
 else {
        $string =  "'".$value."'";
    }
    echo $string;
}
?>
<form>
    <input type="text" name="firstname" value=<?php show($firstname);?> /></br></br>
    <input type="text" name="lastname" value=<?php show($lastname);?>  />
</form>
</br>
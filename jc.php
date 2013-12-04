<?php
function show()
{
for($i=0;$i<5;$i++)
{
    echo "
        <div>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam sed magna vehicula, viverra mauris a, porttitor tellus. Sed placerat convallis tempor. Cras sed magna commodo, placerat urna sit amet, suscipit tellus. 
        Proin iaculis dolor lectus, vel eleifend lorem vehicula ac. 
        Fusce varius consequat neque sed suscipit. Aenean sed porttitor elit. Etiam porttitor nibh et sollicitudin interdum. 
        Maecenas risus est, varius sed dapibus in, fermentum in nibh. Morbi dictum mi est, vitae rutrum velit blandit at. Aliquam ac dictum magna.
        </div>
        <DIV style='page-break-after:always'></DIV>
        ";
}
}
?>
<body>
    <table>
        <tr>
            <td>
                <?php show(); ?>
            </td>
        </tr>
    </table>
</body>

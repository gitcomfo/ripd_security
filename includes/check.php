<?php
    if (preg_match('/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/',$_GET['x']))
                { 
                    echo "<span style='color: green; font-weight: bold'>Valid Email Address</span>";
                    
                 }
                    else
                        {
                        echo "<span style='color: red; font-weight: bold'>Invalid Email Address</span>";
    
                        }
    
?>
<?php
error_reporting(0);
include_once 'ConnectDB.inc';
session_start();

?>
<div class="column1">
    <div class="left_box">
        <div class="top_left_box">
        </div>
        <div class="center_left_box">
            <div class="box_title"><span>প্রধান</span> কার্যক্রম</div>
            <div class="navbox">
                <ul class="nav">

                    <?php
                    //$i=0;
                    if(!empty($_SESSION['modSubModPageArray'])) {  
                    foreach ($_SESSION['modSubModPageArray'] as $key => $value) {
                        /*if (!isset($_SESSION['Module']) OR $_SESSION['Module'] == '') {
                            $_SESSION['Module'] = $key;
                        }
                        if ($key == $_SESSION['Module']) {
                            $module_key = $key;
                            echo '<li><a href="' . $key . '" class="current">' . $moduleArrayList[$module_key] . '</a></li>';
                            //if($key == 'PK') tourPackages ();
                        } else {
                            echo '<li><a href="' . $key . '">' . $moduleArrayList[$module_key] . '</a></li>';
                            //if($key == 'PK') tourPackages ();
                        }*/
                       $module_key = $key;
                       echo '<li><a href="' . $key . '">' . $_SESSION['moduleArray'][$module_key] . '</a></li>';
                    }
                    
                    }  else {
                        echo "দুঃখিত, আপনাকে কোনো প্রধান কার্যক্রম দেওয়া নাই।";}
                    ?>


                </ul>
            </div>
        </div>
        <div class="bottom_left_box">
        </div>
    </div> 

</div>

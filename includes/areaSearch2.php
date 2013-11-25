<?php
function getArea($dv,$d,$t,$p,$v) 
    {
    $dbname = $_SESSION['DatabaseName'];
    ?>            
    বিভাগ &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <select name="division_id" id="division_id" class="box2" onChange="getDistrict(); getThana();getPostOffice();getVillage();" >
        <option value="all" selected="selected">-বিভাগ-</option>
        <?php
        $division_sql = mysql_query("SELECT * FROM " . $dbname . ".division ORDER BY division_name ASC");
        while ($division_rows = mysql_fetch_array($division_sql)) {
            $db_division_id = $division_rows['idDivision'];
            $db_division_name = $division_rows['division_name'];
            if($db_division_id==$dv)
            {
                echo "<option value='$db_division_id' selected>$db_division_name</option>";
            }
            else {echo "<option value='$db_division_id'>$db_division_name</option>";}          
        }
        ?>
    </select></br>
    জেলা &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp: <span id="did">
        <select name="district_id"  id="district_id" onChange="getThana();getPostOffice();getVillage();" class="box2" >
            <option value="all">-জেলা-</option>
            <?php
            $district_sql = mysql_query("SELECT * FROM " . $dbname . ".district ORDER BY district_name ASC");
            while ($district_rows = mysql_fetch_array($district_sql)) {
                $db_district_id = $district_rows['idDistrict'];
                $db_district_name = $district_rows['district_name'];
                if($db_district_id==$d)
                {
                    echo "<option value='$db_district_id' selected>$db_district_name</option>";
                }
                else {echo "<option value='$db_district_id'>$db_district_name</option>";}
                }
            ?>
        </select>
    </span></br>
    থানা &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <span id="tid">
        <select name='thana_id' id='thana_id' class="box2" onchange="getPostOffice();getVillage();" >
            <option value="all">-থানা-</option>
            <?php
            $thana_sql = mysql_query("SELECT * FROM " . $dbname . ".thana ORDER BY thana_name ASC");
            while ($thana_rows = mysql_fetch_array($thana_sql)) {
                $db_thana_id = $thana_rows['idThana'];
                $db_thana_name = $thana_rows['thana_name'];
                    if($db_thana_id==$t)
                {
                    echo "<option value='$db_thana_id' selected>$db_thana_name</option>";
                }
                else {echo "<option value='$db_thana_id'>$db_thana_name</option>";}          
                }
            ?>
        </select>
    </span></br>
        পোস্টঅফিস  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <span id="pid">
            <select name='post_id' id='post_id' class="box2" onchange="getVillage();" >
            <option value="all">-পোস্টঅফিস-</option>
            <?php
            $post_sql = mysql_query("SELECT * FROM " . $dbname . ".post_office ORDER BY post_offc_name ASC");
            while ($post_rows = mysql_fetch_array($post_sql)) {
                $db_post_id = $post_rows['idPost_office'];
                $db_post_name = $post_rows['post_offc_name'];
                if($db_post_id==$p)
                {
                    echo "<option value='$db_post_id' selected>$db_post_name</option>";
                }
                else {echo "<option value='$db_post_id'>$db_post_name</option>";}
            }
            ?>
        </select>
    </span></br>
    গ্রাম &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : <span id="vid">
        <select name='vilg_id' id='vilg_id' class="box2" >
            <option value="all">-গ্রাম-</option>
            <?php
            $vilg_sql = mysql_query("SELECT * FROM " . $dbname . ".village ORDER BY village_name ASC");
            while ($vilg_rows = mysql_fetch_array($vilg_sql)) {
                $db_vilg_id = $vilg_rows['idvillage'];
                $db_vilg_name = $vilg_rows['village_name'];
                if($db_vilg_id==$v)
                {
                    echo "<option value='$db_vilg_id' selected>$db_vilg_name</option>";
                }
                else {echo "<option value='$db_vilg_id'>$db_vilg_name</option>";}
            }
            ?>
        </select>
    </span> &nbsp;&nbsp;
<?php
    }
?>
<!--    *************************################******************##############################********************************************** -->
<?php
function getArea2($dv,$d,$t,$p,$v) 
    {
    $dbname = $_SESSION['DatabaseName'];
    ?>            
    বিভাগ &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <select name="division_id1" id="division_id1" class="box2" onChange="getDistrict1(); getThana1();getPostOffice1();getVillage1();" >
        <option value="all" selected="selected">-বিভাগ-</option>
        <?php
        $division_sql = mysql_query("SELECT * FROM " . $dbname . ".division ORDER BY division_name ASC");
        while ($division_rows = mysql_fetch_array($division_sql)) {
            $db_division_id = $division_rows['idDivision'];
            $db_division_name = $division_rows['division_name'];
            if($db_division_id==$dv)
            {
                echo "<option value='$db_division_id' selected>$db_division_name</option>";
            }
            else {echo "<option value='$db_division_id'>$db_division_name</option>";}          
        }
        ?>
    </select></br>
    জেলা &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp: <span id="did1">
        <select name="district_id1"  id="district_id1" onChange="getThana1();getPostOffice1();getVillage1();" class="box2" >
            <option value="all">-জেলা-</option>
            <?php
            $district_sql = mysql_query("SELECT * FROM " . $dbname . ".district ORDER BY district_name ASC");
            while ($district_rows = mysql_fetch_array($district_sql)) {
                $db_district_id = $district_rows['idDistrict'];
                $db_district_name = $district_rows['district_name'];
                if($db_district_id==$d)
                {
                    echo "<option value='$db_district_id' selected>$db_district_name</option>";
                }
                else {echo "<option value='$db_district_id'>$db_district_name</option>";}
                }
            ?>
        </select>
    </span></br>
    থানা &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <span id="tid1">
        <select name='thana_id1' id='thana_id1' class="box2" onchange="getPostOffice1();getVillage1();" >
            <option value="all">-থানা-</option>
            <?php
            $thana_sql = mysql_query("SELECT * FROM " . $dbname . ".thana ORDER BY thana_name ASC");
            while ($thana_rows = mysql_fetch_array($thana_sql)) {
                $db_thana_id = $thana_rows['idThana'];
                $db_thana_name = $thana_rows['thana_name'];
                    if($db_thana_id==$t)
                {
                    echo "<option value='$db_thana_id' selected>$db_thana_name</option>";
                }
                else {echo "<option value='$db_thana_id'>$db_thana_name</option>";}          
                }
            ?>
        </select>
    </span></br>
        পোস্টঅফিস  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <span id="pid1">
            <select name='post_id1' id='post_id1' class="box2" onchange="getVillage1();" >
            <option value="all">-পোস্টঅফিস-</option>
            <?php
            $post_sql = mysql_query("SELECT * FROM " . $dbname . ".post_office ORDER BY post_offc_name ASC");
            while ($post_rows = mysql_fetch_array($post_sql)) {
                $db_post_id = $post_rows['idPost_office'];
                $db_post_name = $post_rows['post_offc_name'];
                if($db_post_id==$p)
                {
                    echo "<option value='$db_post_id' selected>$db_post_name</option>";
                }
                else {echo "<option value='$db_post_id'>$db_post_name</option>";}
            }
            ?>
        </select>
    </span></br>
    গ্রাম &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : <span id="vid1">
        <select name='vilg_id1' id='vilg_id1' class="box2" >
            <option value="all">-গ্রাম-</option>
            <?php
            $vilg_sql = mysql_query("SELECT * FROM " . $dbname . ".village ORDER BY village_name ASC");
            while ($vilg_rows = mysql_fetch_array($vilg_sql)) {
                $db_vilg_id = $vilg_rows['idvillage'];
                $db_vilg_name = $vilg_rows['village_name'];
                if($db_vilg_id==$v)
                {
                    echo "<option value='$db_vilg_id' selected>$db_vilg_name</option>";
                }
                else {echo "<option value='$db_vilg_id'>$db_vilg_name</option>";}
            }
            ?>
        </select>
    </span> &nbsp;&nbsp;
<?php
    }
?>
<!--    *************************################******************##############################********************************************** -->
<?php
function getArea3($dv,$d,$t,$p,$v) 
    {
    $dbname = $_SESSION['DatabaseName'];
    ?>            
    বিভাগ &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <select name="division_id2" id="division_id2" class="box2" onChange="getDistrict2(); getThana2();getPostOffice2();getVillage2();" >
        <option value="all" selected="selected">-বিভাগ-</option>
        <?php
        $division_sql = mysql_query("SELECT * FROM " . $dbname . ".division ORDER BY division_name ASC");
        while ($division_rows = mysql_fetch_array($division_sql)) {
            $db_division_id = $division_rows['idDivision'];
            $db_division_name = $division_rows['division_name'];
            if($db_division_id==$dv)
            {
                echo "<option value='$db_division_id' selected>$db_division_name</option>";
            }
            else {echo "<option value='$db_division_id'>$db_division_name</option>";}          
        }
        ?>
    </select></br>
    জেলা &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp: <span id="did2">
        <select name="district_id2"  id="district_id2" onChange="getThana2();getPostOffice2();getVillage2();" class="box2" >
            <option value="all">-জেলা-</option>
            <?php
            $district_sql = mysql_query("SELECT * FROM " . $dbname . ".district ORDER BY district_name ASC");
            while ($district_rows = mysql_fetch_array($district_sql)) {
                $db_district_id = $district_rows['idDistrict'];
                $db_district_name = $district_rows['district_name'];
                if($db_district_id==$d)
                {
                    echo "<option value='$db_district_id' selected>$db_district_name</option>";
                }
                else {echo "<option value='$db_district_id'>$db_district_name</option>";}
                }
            ?>
        </select>
    </span></br>
    থানা &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <span id="tid2">
        <select name='thana_id2' id='thana_id2' class="box2" onchange="getPostOffice2();getVillage2();" >
            <option value="all">-থানা-</option>
            <?php
            $thana_sql = mysql_query("SELECT * FROM " . $dbname . ".thana ORDER BY thana_name ASC");
            while ($thana_rows = mysql_fetch_array($thana_sql)) {
                $db_thana_id = $thana_rows['idThana'];
                $db_thana_name = $thana_rows['thana_name'];
                    if($db_thana_id==$t)
                {
                    echo "<option value='$db_thana_id' selected>$db_thana_name</option>";
                }
                else {echo "<option value='$db_thana_id'>$db_thana_name</option>";}          
                }
            ?>
        </select>
    </span></br>
        পোস্টঅফিস  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <span id="pid2">
            <select name='post_id2' id='post_id2' class="box2" onchange="getVillage2();" >
            <option value="all">-পোস্টঅফিস-</option>
            <?php
            $post_sql = mysql_query("SELECT * FROM " . $dbname . ".post_office ORDER BY post_offc_name ASC");
            while ($post_rows = mysql_fetch_array($post_sql)) {
                $db_post_id = $post_rows['idPost_office'];
                $db_post_name = $post_rows['post_offc_name'];
                if($db_post_id==$p)
                {
                    echo "<option value='$db_post_id' selected>$db_post_name</option>";
                }
                else {echo "<option value='$db_post_id'>$db_post_name</option>";}
            }
            ?>
        </select>
    </span></br>
    গ্রাম &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : <span id="vid2">
        <select name='vilg_id2' id='vilg_id2' class="box2" >
            <option value="all">-গ্রাম-</option>
            <?php
            $vilg_sql = mysql_query("SELECT * FROM " . $dbname . ".village ORDER BY village_name ASC");
            while ($vilg_rows = mysql_fetch_array($vilg_sql)) {
                $db_vilg_id = $vilg_rows['idvillage'];
                $db_vilg_name = $vilg_rows['village_name'];
                if($db_vilg_id==$v)
                {
                    echo "<option value='$db_vilg_id' selected>$db_vilg_name</option>";
                }
                else {echo "<option value='$db_vilg_id'>$db_vilg_name</option>";}
            }
            ?>
        </select>
    </span> &nbsp;&nbsp;
<?php
    }
?>

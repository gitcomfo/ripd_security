<?php
$logedInUserType = $_SESSION['userType'];
if($logedInUserType == 'customer') $view_link = "view_customer_account.php";
elseif ($logedInUserType == 'owner') $view_link = "view_proprietor_account.php";
else $view_link = "view_employee_account.php"; 
?>
<div class="column1">
    <div class="left_box">
        <div class="top_left_box">
        </div>
        <div class="center_left_box">
            <div class="box_title"><span>প্রোফাইল</span> ম্যানেজমেন্ট</div>
            <div class="navbox">
                <ul class="nav">
                    <li><a href="<?php echo $view_link;?>">ভিউ একাউন্ট</a></li>
                    <li><a href="amount_transfer.php">এমাউন্ট ট্রান্সফার</a></li>
                    <li><a href="#">চেক মেকিং</a></li>
                    <?php if($logedInUserType == 'customer') echo '<li><a href="systemtree.php">সিস্টেম ট্রি</a></li>';?>
                    <li><a href="password_change.php">পাসওয়ার্ড পরিবর্তন</a></li>
                    <li><a href="">ই-মেইল</a></li>
                </ul>
            </div>
        </div>
        <div class="bottom_left_box">
        </div>
    </div> 

</div>

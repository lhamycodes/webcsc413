<?php
include './helper/active.php';
?>

<header>
    <div class="row">
        <div class="col-auto">
            <a href="index.php"><img src="./asset/icons/alumni-donation-logo-1.svg" alt="" /></a>
        </div>
        <div class="col">
            <div class="navi">
                <ul>
                    <li class="<?php active('index.php'); ?>"><a href="index.php">Home</a></li>
                    <li class="<?php active('donations.php'); ?>"><a href="donations.php">History</a></li>
                    <li class="<?php active('reviews.php'); ?>"><a href="reviews.php">Reviews</a></li>
                    <li class="<?php active('help.php'); ?>"><a href="help.php">Help</a></li>
                </ul>
            </div>
        </div>
        <div class="col-auto">
            <div class="header-right">
                <div>
                    <img src="./asset/icons/notification.svg" alt="notification" />
                </div>
                <div class="dp">
                    <img src="./asset/images/dp-image.png" alt="dp" />
                </div>
                <div class="d-name">
                    <p><?php echo $_SESSION['user_name'] ?></p>
                </div>
            </div>
        </div>
    </div>
</header>
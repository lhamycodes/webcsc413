<?php
require_once 'helper/orm.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("location: login.php");
}

$orm = new ORM();

$students = $orm->query(
    table: 'users',
    params: "role = 'student'",
    fields: "COUNT(*) as count",
)[1][0]['count'];

$donations = $orm->query(
    table: 'donations',
    params: "`user_id` IS NOT NULL",
    fields: "COUNT(*) as count",
)[1][0]['count'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="./bootstrap.min.css" />
    <link rel="stylesheet" href="./asset/styles.css" />
    <title>Donate</title>
</head>

<body>
    <div class="container">
        <?php include './helper/incl/header.php'; ?>

        <main class="main row">
            <div class="col-md-6">
                <img src="./asset/images/share-text.png" alt="share" class="d-md-none d-block" style="max-width: 100%" />
                <h3 class="H_text d-md-block d-none">
                    <span class="share">Share to</span> support students today!
                </h3>
                <h5 class="p_txt">Every donation you make, helps one student</h5>

                <?php if ($_SESSION['user_role'] == 'alumni') { ?>
                    <a class="btn d_link" href="donate-item.php" rel="noopener noreferrer">
                        Donate an item→
                    </a>
                <?php } else { ?>
                    <a class="btn d_link" href="donations.php" rel="noopener noreferrer">
                        View Items→
                    </a>
                <?php } ?>

                <div class="stat_bar row">
                    <div class="col">
                        <h5>
                            <img src="./asset/icons/HVector.png" alt="" />
                            <?php echo number_format($donations); ?>
                        </h5>
                        <p>Donations Received</p>
                    </div>

                    <div class="col">
                        <img src="./asset/icons/LVector.png" alt="" />
                    </div>

                    <div class="col">
                        <h5>
                            <img src="./asset/icons/SVector.png" alt="" />
                            <?php echo number_format($students); ?>
                        </h5>
                        <p>Students signed up</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="img_cont">
                    <img src="./asset/icons/RFrame.svg" alt="" class="right" />
                    <img class="left" src="./asset/icons/LFrame.svg" alt="" />
                    <img class="top" src="./asset/icons/TFrame.svg" alt="" srcset="" />
                    <img src="./asset/icons/Ellipse 13.svg" alt="" />
                    <div class="d_rec">
                        <p class="b_txt">Donation recieved</p>
                        <h5 class="a_txt"><?php echo number_format($donations); ?></h5>
                        <img src="./asset/images/Group 1.png" alt="" />
                    </div>
                    <div class="s_sig">
                        <p class="b_txt">Students signed</p>
                        <h5 class="a_txt"><?php echo number_format($students); ?></h5>
                        <img src="./asset/images/Group 2.png" alt="" />
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>

</html>
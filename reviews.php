<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("location: login.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="./bootstrap.min.css" />
    <link rel="stylesheet" href="./asset/styles.css" />
    <title>Reviews</title>
</head>

<body class="appreciation-page">
    <div class="container">
        <?php include './helper/incl/header.php'; ?>
    </div>
    <div class="container-fluid">
        <main class="main mt-0">
            <div class="">
                <div></div>
                <div class="hero">
                    <img class="hero d-block d-sm-none" src="./asset/images/thanks-hero.png" alt="thanks" style="max-width: 100%" />
                    <h3 class="hero d-sm-block d-none">
                        <span class="thanks" class="d-sm-block d-none thnaks">Thank</span>
                        you for your Donation
                    </h3>
                    <p>See how effective your items have been to students.</p>
                </div>
                <div class="quotes row">
                    <div class="quote">
                        <div class="q-pics">
                            <img src="./asset/images/avatar2.png" alt="" />
                        </div>
                        <h5>Omojolowo Specter</h5>
                        <h6>University of Lagos, Nigeria</h6>
                        <p>
                            “Lorem ipsu dolor sit amet, consectetur adipiscg elit, sed do
                            eiusmod tempor incididunt ut labor et magna aliqua. Ut enim ad
                            minim veniam, quis nostrud exercitation ullamco laboris nisi ut
                            aliquip ex commodo consequat.”
                        </p>
                    </div>

                    <div class="quote">
                        <div class="q-pics">
                            <img src="./asset/images/dp-image.png" alt="" />
                        </div>
                        <h5>Endurance</h5>
                        <h6>University of Lagos, Nigeria</h6>
                        <p>
                            “Lorem ipsu dolor sit amet, consectetur adipiscg elit, sed do
                            eiusmod tempor incididunt ut labor et magna aliqua. Ut enim ad
                            minim veniam, quis nostrud exercitation ullamco laboris nisi ut
                            aliquip ex commodo consequat.”
                        </p>
                    </div>

                    <div class="quote">
                        <div class="q-pics">
                            <img src="./asset/images/quote1.png" alt="" />
                        </div>
                        <h5>King-David Sanda</h5>
                        <h6>Delhi, India</h6>
                        <p>
                            “Lorem ipsu dolor sit amet, consectetur adipiscg elit, sed do
                            eiusmod tempor incididunt ut labor et magna aliqua. Ut enim ad
                            minim veniam, quis nostrud exercitation ullamco laboris nisi ut
                            aliquip ex commodo consequat.”
                        </p>
                    </div>

                    <div class="quote">
                        <div class="q-pics">
                            <img src="./asset/images/dp-image.png" alt="" />
                        </div>
                        <h5>Adedeji Rotibi</h5>
                        <h6>University of Lagos, Nigeria</h6>
                        <p>
                            “Lorem ipsu dolor sit amet, consectetur adipiscg elit, sed do
                            eiusmod tempor incididunt ut labor et magna aliqua. Ut enim ad
                            minim veniam, quis nostrud exercitation ullamco laboris nisi ut
                            aliquip ex commodo consequat.”
                        </p>
                    </div>

                    <div class="quote">
                        <div class="q-pics">
                            <img src="./asset/images/quote1.png" alt="" />
                        </div>
                        <h5>Osy Idibia</h5>
                        <h6>University of Lagos, Nigeria</h6>
                        <p>
                            “Lorem ipsu dolor sit amet, consectetur adipiscg elit, sed do
                            eiusmod tempor incididunt ut labor et magna aliqua. Ut enim ad
                            minim veniam, quis nostrud exercitation ullamco laboris nisi ut
                            aliquip ex commodo consequat.”
                        </p>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>

</html>
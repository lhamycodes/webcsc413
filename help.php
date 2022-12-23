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
    <title>questions or compliants</title>
</head>

<body class="questions">
    <div class="container">
        <?php include './helper/incl/header.php'; ?>
    </div>

    <main class="main">
        <section class="first-section"></section>
        <section class="second-section">
            <div class="container">
                <div class="row main-content">
                    <div class="col-lg-6 col-md-6 left-side">
                        <div>
                            <form action="">
                                <div>
                                    <label for="email">E-mail</label>
                                    <input type="text" id="email" />
                                </div>
                                <div>
                                    <label for="help">How can we help you today?</label>
                                    <textarea name="help" id="help" rows="6"></textarea>
                                </div>
                                <div class="pt-lg-4 pt-3">
                                    <button type="submit">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 right-side">
                        <h3>Have questions, or <span class="compl">complaints?</span></h3>
                    </div>
                </div>
            </div>

        </section>
    </main>
</body>

</html>
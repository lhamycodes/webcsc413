<?php
session_start();
require_once 'helper/orm.php';

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'alumni') {
    header("location:index.php");
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
    <title>Create Item</title>
</head>

<body>
    <div class="container create-page">
        <header>
            <div class="row">
                <div class="col-auto">
                    <img src="./asset/icons/alumni-donation-logo-1.svg" alt="" />
                </div>
                <div class="col">
                    <div class="navi">
                        <ul>
                            <li class="active"><a href="./home.html">Home</a></li>
                            <li><a href="#">History</a></li>
                            <li><a href="#">Reviews</a></li>
                            <li><a href="./help.html">Help</a></li>
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
                            <p>Amandaco3</p>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <main class="main">
            <div class="subheader">
                <h3 class="">Create an Item</h3>
                <p class="">Upload a new item for Donation</p>

                <form action="" class="create-form">
                    <div>
                        <label for="uploadFile">Image of your Item</label>
                        <div class="upload">
                            <input type="file" id="uploadFile" class="upload-file" />
                            <img src="./asset/images/upload-img.png" alt="upload image" class="upload-img" />
                        </div>
                    </div>

                    <div>
                        <label for="">Name of Item</label>
                        <input type="text" placeholder="Name of Item" />
                    </div>

                    <div>
                        <label for="descrption">Item Description</label>
                        <textarea name="descrption" id="descrption" cols="100%" rows="6"></textarea>
                    </div>

                    <div>
                        <button type="submit" class="submit">Donate Item →</button>
                    </div>
                </form>
            </div>
        </main>
    </div>
</body>

</html>
<?php
session_start();
require_once 'helper/orm.php';
extract(array_map("htmlspecialchars", $_POST));

$noticeType = null;
$message = null;

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'alumni') {
    header("location:index.php");
}

if (isset($_POST['name'])) {
    $orm = new ORM();

    $image = null;
    $path = "asset/uploads/";

    $img = $_FILES['file']['name'];
    $tmp = $_FILES['file']['tmp_name'];

    $ext = strtolower(pathinfo($img, PATHINFO_EXTENSION));

    $finalImage = rand(1000, 1000000) . "-" . time() . "-" . $img;

    if (in_array($ext, ['jpg', 'jpeg', 'png'])) {
        $path = $path . strtolower($finalImage);
        if (move_uploaded_file($tmp, $path)) {
            $image = $finalImage;
        }
    }

    if ($image == null) {
        $message = 'An error occurred while uploading your image';
        $noticeType = 'danger';
    } else {
        [$status, $data] = $orm->insert(
            table: 'donations',
            data: [
                'user_id' => $_SESSION['user_id'],
                'name' => $name,
                'description' => $description,
                'image' => $image,
            ],
            errorMessage: 'An error occurred while creating your item',
        );

        if ($status == 'success') {
            $message = 'Item created successfully';
            $noticeType = 'primary';
            echo "
            <script>
                setTimeout(() => {
                    window.location.href = 'index.php';
                }, 2000);
            </script>";
        } else {
            $message = $data;
            $noticeType = 'danger';
        }
    }
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
        <?php include './helper/incl/header.php'; ?>

        <main class="main">
            <div class="subheader">
                <h3>Create an Item</h3>
                <p>Upload a new item for Donation</p>

                <?php
                if ($message != null) {
                    echo '<div class="my-5 alert alert-' . $noticeType . ' role="alert">
                        ' . $message . '
                    </div>';
                }
                ?>

                <form action="" method="POST" class="create-form" enctype="multipart/form-data">
                    <div>
                        <label for="file">Image of your Item</label>
                        <input type="file" name="file" required accept="image/png, image/jpeg" />
                    </div>

                    <div>
                        <label for="">Name of Item</label>
                        <input type="text" placeholder="Name of Item" name="name" />
                    </div>

                    <div>
                        <label for="descrption">Item Description</label>
                        <textarea name="description" cols="100%" rows="6"></textarea>
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
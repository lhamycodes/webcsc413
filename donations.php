<?php
require_once 'helper/orm.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("location: login.php");
}

$orm = new ORM();

if ($_SESSION['user_role'] == 'student') {
    $params = "won_by IS NULL";
} else {
    $params = "user_id = " . $_SESSION['user_id'];
}

[$status, $items] = $orm->queryRelationship(
    table: 'donations',
    join: 'users ON users.id = donations.user_id',
    fields: 'users.name AS user_name, donations.id, donations.name, donations.description, donations.image, donations.won_by',
    params: $params
);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="./bootstrap.min.css" />
    <link rel="stylesheet" href="./asset/styles.css" />
    <title>All Items</title>
</head>

<body>
    <div class="container">
        <?php include './helper/incl/header.php'; ?>

        <main class="main" style="margin-top: 20px;">
            <div class="subheader">
                <h3>All Items</h3>
                <p>
                    <?php if ($_SESSION['user_role'] == 'student') {
                        echo "A view of all presently donated items by various alumni";
                    } else {
                        echo "A view of all items you have given out or are available for donation";
                    }
                    ?>
                </p>
            </div>

            <div class="row items-row">
                <?php
                foreach ($items as $item) {
                    echo '<div class="col-lg-4 col-md-6">
                        <div class="item">
                            <div>
                                <img src=' . $item['image'] . ' alt=' . $item['name'] . ' />
                            </div>
                            <div class="items-heading">
                                <a href="donation-item.php?id=' . $item['id'] . '" class="our-green h4">' . $item['name'] . '</a>
                                <h5>by ' . $item['user_name'] . '</h5>
                            </div>
                            <p>' . $item['description'] . '</p>
                        </div>
                    </div>
                    ';
                }
                ?>
            </div>
        </main>
    </div>
</body>

</html>
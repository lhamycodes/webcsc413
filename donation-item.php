<?php
require_once 'helper/orm.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("location: login.php");
}

$orm = new ORM();

[$status, $item] = $orm->queryRelationship(
    table: 'donations',
    join: 'users ON users.id = donations.user_id',
    fields: 'users.name AS user_name, donations.id, donations.user_id, donations.name, donations.description, donations.image, donations.won_by',
    params: "donations.id = " . $_GET['id']
);

if (count($item) == 0) {
    header("location: donations.php");
}
$item = $item[0];

[$stat, $bids] = $orm->queryRelationship(
    table: 'bids',
    join: 'users ON users.id = bids.user_id',
    fields: 'users.name AS user_name, users.address AS user_location, bids.id, bids.user_id, bids.item_id, bids.status',
    params: "bids.id = " . $item['id'],
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
    <title>Place a Bid</title>
</head>

<body class="place-bid-page">
    <div class="container">
        <?php include './helper/incl/header.php'; ?>

        <main class="main" style="margin-top: 0px;">
            <div class="row place-bid pb-2">
                <div class="col-md-6">
                    <img src="<?php echo $item['image'] ?>" style="height:570px" alt="bid" class="slow-mo" />
                    <h4 class="pt-2"><?php echo count($bids) ?> Bid(s)</h4>
                </div>

                <div class="col-md-6">
                    <div class="details ms-md-3">
                        <h3><?php echo $item['name'] ?></h3>
                        <p>
                            <?php echo $item['description'] ?>
                        </p>

                        <p class="pt-3">
                            Donated by <span class="our-green"><?php echo $item['user_name'] ?></span>
                        </p>

                        <?php if ($_SESSION['user_role'] == 'student' && $item['won_by'] == null) { ?>
                            <div>
                                <a href="#" class="slow-mo button-type">Place a Bid →</a>
                            </div>
                        <?php } ?>

                    </div>
                </div>

                <?php if ($_SESSION['user_role'] == 'alumni' && $_SESSION['user_id'] == $item['user_id']) { ?>
                    <div class="col-12">
                        <h6 class="table-header">Select one of the Bids below.</h6>
                        <div class="table-wrapper">
                            <?php
                            foreach ($bids as $bid) {
                                echo "<div class='rows'>
                                    <div class='name'>
                                        <img src='./asset/images/students-img.png' alt='student pics' class='student-pics' />
                                        {$bid['user_name']}
                                    </div>
                                    <div class='level'>
                                        <img src='./asset/icons/level.svg' alt='level' class='me-md-2 me-1' />
                                        400L
                                    </div>
                                    <div class='location'>
                                        <img src='./asset/icons/pin.svg' alt='location' class='me-1' />
                                        {$bid['user_location']}
                                    </div>
                                    <div class='pe-2'>
                                        <button class='slow-mo2'>Select</button>
                                    </div>
                                </div>";
                            }
                            ?>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </main>
    </div>
</body>

</html>
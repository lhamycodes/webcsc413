<?php
session_start();

require_once 'helper/orm.php';

if (!isset($_SESSION['user_id'])) {
    header("location: login.php");
}

if ($_SESSION['user_role'] != 'student') {
    header("location: index.php");
}

$orm = new ORM();

[$stat, $bids] = $orm->queryRelationship(
    table: 'bids',
    join: 'donations ON donations.id = bids.item_id',
    fields: 'donations.name AS item_name, donations.id AS item_id, donations.won_by AS item_won_by, bids.id, bids.user_id, bids.item_id, bids.status',
    params: "bids.user_id = " . $_SESSION['user_id'],
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
    <title>History</title>
</head>

<body class="history-page">
    <div class="container">
        <?php include './helper/incl/header.php' ?>

        <main class="main clearTopSpacing">
            <div class="row history">
                <?php foreach ($bids as $bid) {
                    $link = "donation-item.php?id={$bid['item_id']}";
                ?>
                    <?php if ($bid['status'] == "won") { ?>
                        <div class="col-12 d-flex justify-content-between history-row">
                            <div class="col-auto info">
                                <div>
                                    <img src="./asset/icons/history-success.svg" alt="Successful" />
                                </div>
                                <div>
                                    <h6>Success!</h6>
                                    <p>You won a <?php echo $bid['item_name'] ?> Bid</p>
                                </div>
                            </div>
                            <div class="col-auto">
                                <a href="<?php echo $link; ?>">
                                    <img src="./asset/icons/chevron-right.svg" alt="go" class="px-2" />
                                </a>
                            </div>
                        </div>
                    <?php } else if ($bid['status'] == "lost") { ?>
                        <div class="col-12 d-flex justify-content-between history-row">
                            <div class="col-auto info">
                                <div>
                                    <img src="./asset/icons/history-denied.svg" alt="denied" />
                                </div>
                                <div>
                                    <h6>Oops!</h6>
                                    <p>You lost the <?php echo $bid['item_name'] ?> Bid, Better luck next time.</p>
                                </div>
                            </div>
                            <div class="col-auto">
                                <a href="<?php echo $link; ?>">
                                    <img src="./asset/icons/chevron-right.svg" alt="go" class="px-2" />
                                </a>
                            </div>
                        </div>
                    <?php } else { ?>
                        <div class="col-12 d-flex justify-content-between history-row">
                            <div class="col-auto info">
                                <div>
                                    <img src="./asset/icons/history-waiting.svg" alt="Waiting" />
                                </div>
                                <div>
                                    <h6>Placed a Bid</h6>
                                    <p>
                                        Waiting for the alumni to select the recipient of the <?php echo $bid['item_name'] ?>
                                    </p>
                                </div>
                            </div>
                            <div class="col-auto">
                                <a href="<?php echo $link; ?>">
                                    <img src="./asset/icons/chevron-right.svg" alt="go" class="px-2" />
                                </a>
                            </div>
                        </div>
                    <?php } ?>
                <?php } ?>
            </div>
        </main>
    </div>
</body>

</html>
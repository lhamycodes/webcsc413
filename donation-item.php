<?php
session_start();

require_once 'helper/orm.php';
extract(array_map("htmlspecialchars", $_POST));

$noticeType = null;
$message = null;

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
    fields: 'users.name AS user_name, users.phone AS user_phone, users.address AS user_location, bids.id, bids.user_id, bids.item_id, bids.status',
    params: "bids.item_id = " . $item['id'],
);

if (isset($_POST['placeBid'])) {
    [$stat, $check] = $orm->query(
        table: 'bids',
        fields: 'id',
        params: "user_id = {$_SESSION['user_id']} AND item_id = {$item['id']}"
    );

    if (count($check) > 0) {
        $message = 'You have already placed a bid for this item';
        $noticeType = 'danger';
        echo "
            <script>
                setTimeout(() => {
                    window.location.href = 'donation-item.php?id={$item['id']}';
                }, 2000);
            </script>";
    } else {
        $input = [
            'user_id' => $_SESSION['user_id'],
            'item_id' => $item['id'],
            'status' => 'pending'
        ];

        [$status, $data] = $orm->insert(
            table: 'bids',
            data: $input,
            errorMessage: 'An error occurred while placing your bid',
        );

        if ($status == 'success') {
            $message = 'Bid placed successfully';
            $noticeType = 'primary';
            echo "
            <script>
                setTimeout(() => {
                    window.location.href = 'donation-item.php?id={$item['id']}';
                }, 2000);
            </script>";
        } else {
            $message = $data;
            $noticeType = 'danger';
        }
    }
}

if (isset($_POST['selectBid'])) {
    [$status, $data] = $orm->update(
        table: 'donations',
        data: ['won_by' => $_POST['bid_user_id']],
        params: "id = {$item['id']}",
        errorMessage: 'An error occurred while selecting the bid',
    );

    if ($status == 'success') {
        // update bid status table
        [$l_, $dtl] = $orm->update(
            table: 'bids',
            data: ['status' => 'lost'],
            params: "item_id = {$item['id']} AND id != {$_POST['bid_id']}",
            errorMessage: 'An error occurred while selecting the bid',
        );

        [$w_, $dtw] = $orm->update(
            table: 'bids',
            data: ['status' => 'won'],
            params: "id = {$_POST['bid_id']}",
            errorMessage: 'An error occurred while selecting the bid',
        );

        $message = 'Bid selected successfully';
        $noticeType = 'primary';
        echo "
            <script>
                setTimeout(() => {
                    window.location.href = 'donation-item.php?id={$item['id']}';
                }, 2000);
            </script>";
    } else {
        $message = $data;
        $noticeType = 'danger';
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

                        <?php
                        if ($message != null) {
                            echo "<div class='my-5 alert alert-{$noticeType}' role='alert'>{$message}</div>";
                        }
                        ?>

                        <?php if ($_SESSION['user_role'] == 'student' && $item['won_by'] == null) { ?>
                            <form action="" method="POST">
                                <button type="submit" name="placeBid" class="slow-mo button-type">Place a Bid →</button>
                            </form>
                        <?php } ?>

                    </div>
                </div>

                <?php if ($_SESSION['user_role'] == 'alumni' && $_SESSION['user_id'] == $item['user_id']) { ?>
                    <div class="col-12">
                        <h6 class="table-header"><?php echo ($item['won_by'] == null) ? "Select one of the Bids below." : "View Bids"; ?></h6>
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
                                        {$bid['user_phone']}
                                    </div>
                                    <div class='location'>
                                        <img src='./asset/icons/pin.svg' alt='location' class='me-1' />
                                        {$bid['user_location']}
                                    </div>";
                                if ($item['won_by'] == null) {
                                    echo "<form method='POST' action='' id='form{$bid['id']}' class='pe-2'>
                                            <input type='hidden' name='bid_id' value='{$bid['id']}'>
                                            <input type='hidden' name='bid_user_id' value='{$bid['user_id']}'>
                                            <button type='submit' name='selectBid' class='slow-mo2'>Select</button>
                                        </form>";
                                } else {
                                    $color = $bid['status'] == 'lost' ? 'red' : 'green';
                                    echo "<button style='background: $color'>{$bid['status']}</button>";
                                }
                                echo "</div>";
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
<?php
session_start();
require_once 'helper/orm.php';
extract(array_map("htmlspecialchars", $_POST));

$noticeType = null;
$message = null;
$role = $_GET['type'] ?? null;

if (isset($_POST['email'])) {
    $errorMsg = 'A user already exists with this email address';
    $orm = new ORM();

    [$checkStatus, $checkData] = $orm->query(
        table: 'users',
        params: "email = '$email'",
        errorMessage: $errorMsg
    );

    if ($checkStatus != 'error') {
        $message = $errorMsg;
        $noticeType = 'danger';
    } else {
        $input = [
            'name' => $name,
            'email' => $email,
            'role' => $role,
            'password' => md5($password)
        ];

        if ($role == "student") {
            $input['phone'] = $phone;
            $input['address'] = $address;
        }

        [$status, $data] = $orm->insert(
            table: 'users',
            data: $input,
            errorMessage: 'An error occurred while creating your account',
        );

        if ($status == 'success') {
            $message = 'Account created successfully';
            $noticeType = 'primary';
            echo "
                <script>
                    setTimeout(() => {
                        window.location.href = 'login.php';
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
    <title>Sign Up</title>
</head>

<body>
    <div class="container-fliud signup-page">
        <div class="row">
            <div class="col-md-6 py-4 cream-bg d-md-block d-none">
                <div class="my-3 mb-5 logo">
                    <img src="./asset/icons/alumni-donation-logo-1.svg" alt="logo" />
                </div>
                <div class="left-banner">
                    <img src="./asset/images/welcome-pics.png" alt="happy" />
                </div>
            </div>
            <div class="col-md-6 right-side">
                <?php if ($role == null) { ?>
                    <div class="welcome-details row justify-content-center px-2">
                        <div class="mb-5 text-center">
                            <img class="" src="./asset/icons/alumni-donation-logo-1.svg" alt="logo" />
                        </div>

                        <a class="bg-dark-blue" href="signup.php?type=alumni">Sign up as an Alumni →</a>

                        <a class="bg-light-green" href="signup.php?type=student">Sign up as a Student →</a>

                        <div class="pt-2">
                            <p class="text-center login">
                                Have an account? <a href="login.php">Login →</a>
                            </p>
                        </div>
                    </div>
                <?php } else { ?>
                    <div class="sign-up px-2 mx-auto" style="padding-top: 80px;">
                        <h4 class="our-green">Sign up as <?php echo $role; ?></h4>

                        <?php
                        if ($message != null) {
                            echo '<div class="alert alert-' . $noticeType . ' role="alert">
                        ' . $message . '
                        </div>';
                        }
                        ?>

                        <form action="" method="POST">
                            <div>
                                <label for="fullname">Full Name:</label>
                                <input type="text" name="name" placeholder="fullname" required />
                            </div>

                            <div>
                                <label for="email">Email:</label>
                                <input type="email" name="email" placeholder="email" required />
                            </div>

                            <?php
                            if ($role == 'student') {
                                echo '<div>
                                <label for="phone">Phone No:</label>
                                <input type="tel" name="phone" placeholder="phone no" maxlength="11" required />
                            </div>

                            <div>
                                <label for="address">Address:</label>
                                <input type="text" name="address" placeholder="address" required />
                            </div>';
                            }
                            ?>

                            <div>
                                <label for="password">Password:</label>
                                <input type="password" name="password" placeholder="Password" required />
                            </div>

                            <button type="submit" name="submit" class="welcome-linking bg-light-green d-block mt-5">
                                Sign up as <?php echo $role; ?> →
                            </button>

                            <div class="pt-2">
                                <p class="text-center login our-blue">
                                    Have an account? <a href="login.php">Login →</a>
                                </p>
                            </div>
                        </form>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</body>

</html>
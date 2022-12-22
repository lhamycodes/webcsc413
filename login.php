<?php
session_start();
require_once 'helper/orm.php';
extract(array_map("htmlspecialchars", $_POST));

$error = null;

if (isset($_POST['email'])) {
    $email = $email;
    $password = md5($password);

    $orm = new ORM();

    [$status, $data] = $orm->query(
        table: 'users',
        params: "email = '$email' AND password = '$password'",
        errorMessage: 'Invalid email or password'
    );

    if ($status == 'success') {
        $result = $data[0];
        $_SESSION['user_id'] = $result['id'];
        $_SESSION['user_name'] = $result['name'];
        $_SESSION['user_email'] = $result['email'];
        $_SESSION['user_phone'] = $result['phone'];
        $_SESSION['user_address'] = $result['address'];
        $_SESSION['user_role'] = $result['role'];

        header("Location: index.php");
    } else {
        $error = $data;
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
    <title>Login</title>
</head>

<body>
    <div class="container-fliud login-page">
        <div class="row">
            <div class="col-md-6 py-4 cream-bg d-md-block d-none">
                <div class="my-3 mb-5 logo">
                    <img src="./asset/icons/alumni-donation-logo-1.svg" alt="logo" />
                </div>
                <div class="left-banner">
                    <img src="./asset/images/login-pics.png" alt="happy" />
                </div>
            </div>
            <div class="col-md-6 sign-up px-2 mx-auto right-side">
                <h4 class="our-blue">Login</h4>

                <?php
                if ($error != null) {
                    echo '<div class="alert alert-danger" role="alert">
                    ' . $error . '
                    </div>';
                }
                ?>

                <form action="" method="POST">
                    <div>
                        <label for="email">Email:</label>
                        <input type="email" name="email" placeholder="email" required />
                    </div>

                    <div>
                        <label for="password">Password:</label>
                        <input type="password" name="password" placeholder="password" required />
                    </div>

                    <button type="submit" name="submit" class="welcome-linking bg-dark-blue d-block mt-5">Login →</button>

                    <div class="pt-2">
                        <p class="text-center login our-green">
                            Not a User? <a href="signup.php">Sign up →</a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>
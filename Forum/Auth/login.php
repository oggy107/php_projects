<?php
require('../Database/connect.php');
mysqli_select_db($conn, 'Forum');

$loginGeneralError = false;
$loginUserError = false;
$loginPasswordError = false;
$loginSuccess = false;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (!$res = mysqli_query($conn, "SELECT 1 FROM credentials WHERE user='$username'")) {
        $loginGeneralError = true;
        $error = mysqli_error($conn);
        echo "<script>console.error(`[ERROR]: $error`)</script>";
    } else {
        if (mysqli_fetch_row($res) == NULL) {
            $loginUserError = true;
            echo "<script>console.error(`username is invalid!`)</script>";
        } else {
            if (!$res = mysqli_query($conn, "SELECT * FROM credentials WHERE user='$username'")) {
                $loginGeneralError = true;
                $error = mysqli_error($conn);
                echo "<script>console.error(`[ERROR]: $error`)</script>";
            } else {
                $data = mysqli_fetch_assoc($res);

                $hash = $data['password'];
                $userId = $data['user_id'];

                if(!password_verify($password, $hash)) {
                    $loginPasswordError = true;
                    echo "<script>console.error(`password is invalid!`)</script>";
                }
                else {
                    $loginSuccess = true;
                    echo "<script>console.log(`success you are logged in`)</script>";

                    session_start();
                    $_SESSION['loggedin'] = true;
                    $_SESSION['username'] = $username;
                    $_SESSION['userId'] = $userId;

                    sleep(2);
                    header('Location: ../App');
                }
            }
        }
    }
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
    <link rel="stylesheet" href="../style.css">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj" crossorigin="anonymous"></script>

    <!-- jquery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" referrerpolicy="no-referrer" require_once></script>

    <title>Forum login</title>
</head>

<body>
    <?php require('../Components/navbar.php'); ?>

    <div class="alert-container">
        <?php require('../Alert/login_alert.php'); ?>
    </div>

    <div class="main-container">
        <h1 class="title">Login to continue</h1>

        <div class="form-container">
            <form action="./login.php" method="post">
                <div class="mb-3">
                    <label for="username" class="form-label">User name</label>
                    <input type="text" class="form-control" id="username" name="username" required maxlength="20">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required maxlength="255">
                </div>
                <div class="btn-container">
                    <button type="submit" class="btn btn-primary">Login</button>
                    <a href="./signup.php" class="btn btn-primary">signup</a>
                </div>
            </form>
        </div>
    </div>

    <!-- For Alerts -->
    <script>
        $(document).ready(function() {
            $(".alert").fadeTo(2000, 500).slideUp(500, function() {
                $(".alert").slideUp(500);
            });
        });
    </script>

    <!-- Footer -->
    <?php require('../Components/footer.php'); ?>
</body>

</html>
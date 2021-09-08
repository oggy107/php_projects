<?php
require('../Database/connect.php');
mysqli_select_db($conn, 'Forum');

$signupSuccess = false;
$signupGeneralError = false;
$signupAccountExistsError = false;
$signupPasswordError = false;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];

    if (!$res = mysqli_query($conn, "SELECT 1 FROM credentials WHERE user='$username'")) {
        $signupGeneralError = true;
        $error = mysqli_error($conn);
        echo "<script>console.error(`[ERROR]: $error`)</script>";
    } else {
        if (mysqli_fetch_row($res) != NULL) {
            $signupAccountExistsError = true;
            echo "<script>console.error(`Unable to create account: An account with given username address already exists!`)</script>";
        } else {
            if ($password != $confirmPassword) {
                $signupPasswordError = true;
                echo "<script>console.error(`Unable to create account: passwords do not match!`)</script>";
            } else {
                $password = password_hash($password, PASSWORD_DEFAULT);
                if (!mysqli_query($conn, "INSERT INTO credentials(user, password) VALUES('$username', '$password')")) {
                    $signupGeneralError = true;
                    $error = mysqli_error($conn);
                    echo "<script>console.error(`[ERROR]: $error`)</script>";
                } else {

                    if (!$res = mysqli_query($conn, "SELECT * FROM credentials WHERE user='$username'")) {
                        $signupGeneralError = true;
                        $error = mysqli_error($conn);
                        echo "<script>console.error(`[ERROR]: $error`)</script>";
                    } else {
                        $userId = mysqli_fetch_assoc($res)['user_id'];
                        $signupSuccess = true;

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

    <title>Forum signup</title>
</head>

<body>
    <?php require('../Components/navbar.php') ?>

    <div class="alert-container">
        <?php require('../Alert/signup_alert.php'); ?>
    </div>

    <div class="main-container">
        <h1 class="title">Signup to continue</h1>

        <div class="form-container">
            <form action="./signup.php" method="post">
                <div class="mb-3">
                    <label for="username" class="form-label">User name</label>
                    <input type="text" class="form-control" id="username" name="username" maxlength="20" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" maxlength="255" required>
                </div>
                <div class="mb-3">
                    <label for="confirm-password" class="form-label">Reenter Password</label>
                    <input type="password" class="form-control" id="confirm-password" name="confirmPassword" maxlength="255" required>
                </div>
                <div class="btn-container">
                    <button type="submit" class="btn btn-primary">signup</button>
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
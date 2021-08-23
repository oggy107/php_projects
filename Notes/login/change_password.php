<?php
session_start();

$changePasswordSuccess = false;
$changePasswordError = false;

require('../database/connection.php');
mysqli_select_db($conn, 'user_data');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_SESSION["user_email"];
    $password = $_POST["password"];
    $password_reenter = $_POST["password_reenter"];

    if ($password != $password_reenter) {
        echo "<h1>Passwords do no match</h1>";
        die();
    }

    if (!mysqli_query($conn, "UPDATE credentials SET password='$password' WHERE email='$email'")) {
        $error = mysqli_error($conn);
        echo "<script>console.error(`Unable to update your password: $error`)</script>";

        $changePasswordError = true;
    } else {
        $changePasswordSuccess = true;
    }
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj" crossorigin="anonymous"></script>

    <title>Change password</title>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#"><img src="../logo.svg" id="logo" alt="svg-logo"></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true"></a>
                    </li>
                </ul>
                <form class="d-flex">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form>
            </div>
        </div>
    </nav>

    <h1 class="title">Change password</h1>

    <div class="form-container">
        <form action="./updatepass.php" method="post">
            <div class="mb-3">
                <label for="password" class="form-label">Enter new password</label>
                <input type="password" class="form-control" id="password" name="password">
            </div>
            <div class="mb-3">
                <label for="password-reenter" class="form-label">Re-Enter new password</label>
                <input type="password" class="form-control" id="password-reenter" name="password_reenter">
            </div>
            <div class="btn-container">
                <button type="submit" class="btn btn-primary">Change password</button>
                <button type="button" class="btn btn-primary home-btn"><a href="../Notes_app/">Home</a></button>
            </div>
        </form>
    </div>

    <!-- Handeling Alerts -->
    <div class="alert-container">
        <?php require('./alerts.php'); ?>
    </div>


</body>

</html>
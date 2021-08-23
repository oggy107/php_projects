<?php
session_start();
$_SESSION['logged_in'] = false;

$emailLoginError = false;
$passwordLoginError = false;
$successLogin = false;

require('../database/connection.php');
require('../database/init.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    
    $sql = "SELECT * FROM credentials WHERE email='$email'";
    
    $res = mysqli_query($conn, $sql);
    if (!$res) {
        $error = mysqli_error($conn);
        echo "<script>console.error(`Unable to retrive data from database: $error`)</script>";
        die();
    }
    
    $data = $res->fetch_all(MYSQLI_ASSOC);
    
    if (!$data) {
        $emailLoginError = true;
    }
    else
    {
        $entered_password = $data[0]["password"];
        $name = $data[0]["name"];
        
        if ($password != $entered_password) {
            $passwordLoginError = true;
        }
    }
    
    if (!$emailLoginError && !$passwordLoginError)
    {
        $successLogin = true;
        $_SESSION['user_name'] = $name;
        $_SESSION['user_email'] = $email;
        $_SESSION["logged_in"] = true;
        header('Location: ../Notes_app');
    }
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
    <link rel="stylesheet" href="./style.css">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj" crossorigin="anonymous"></script>

    <title>Notes App</title>
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

    <!-- Handeling Alerts -->
    <div class="alert-container">
        <?php require('./alerts.php');?>
    </div>

    <h1 class="title">Welcome to Notes App</h1>
    <h2 class="title">Login to continue</h2>

    <div class="form-container">
        <form action="./index.php" method="post">
            <div class="mb-3">
                <label for="email" class="form-label">Email address</label>
                <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp" required>
                <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="btn-container">
                <button type="submit" class="btn btn-primary">Login</button>
                <button type="button" class="btn btn-primary"><a href="./signup.php">Sign up</a></button>
            </div>
        </form>
    </div>

    <?php
    
    if ($emailLoginError || $passwordLoginError)
    {
        die();
    }

    if ($_SESSION['logged_in']) {
        echo '<div class="btn-container">
                  <button type="button" class="btn btn-primary"><a href="./updatepass.php">Change password</a></button>
                  <button type="button" class="btn btn-danger"><a href="./acc_delete.php">Delete Account</a></button>
              </div>';
    }
    ?>
</body>

</html>
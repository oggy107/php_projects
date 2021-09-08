<?php
    require('./Database/connect.php');

    // 3 TABLES ARE NOT BEING ADDED AUTOMATICALLY
    // category
    // questions
    // replies

    if(!mysqli_query($conn, 'CREATE DATABASE IF NOT EXISTS Forum'))
    {
        $error = mysqli_error($conn);
        echo "<script>console.error(`[ERROR]: $error`)</script>";
        die;
    }

    mysqli_select_db($conn, 'Forum');

    if(!mysqli_query($conn, "CREATE TABLE IF NOT EXISTS credentials(user_id INT AUTO_INCREMENT PRIMARY KEY, user VARCHAR(20) UNIQUE, password VARCHAR(255))"))
    {
        $error = mysqli_error($conn);
        echo "<script>console.error(`[ERROR]: $error`)</script>";
        die;
    }

    header('Location: ./Auth/login.php');
?>
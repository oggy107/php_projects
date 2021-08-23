<?php
    if (!mysqli_query($conn, "CREATE DATABASE IF NOT EXISTS User_data"))
    {
        $error = mysqli_error($conn);
        echo "<script>console.error(`[ERROR]: $error`)</script>";
        die();
    }

    mysqli_select_db($conn, 'User_data');

    if (!mysqli_query($conn, "CREATE TABLE IF NOT EXISTS notes(sno INT AUTO_INCREMENT PRIMARY KEY, title VARCHAR(50), `desc` TEXT, email VARCHAR(50))"))
    {
        $error = mysqli_error($conn);
        echo "<script>console.error(`[ERROR]: $error`)</script>";
        die();
    }

    if(!mysqli_query($conn, "CREATE TABLE IF NOT EXISTS credentials (sno INT AUTO_INCREMENT PRIMARY KEY, name VARCHAR(30), email VARCHAR(50), password VARCHAR(25))"))
    {
        $error = mysqli_error($conn);
        echo "<script>console.error(`[ERROR]: $error`)</script>";
        die();
    }
?>
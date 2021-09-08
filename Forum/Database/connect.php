<?php
    define('SERVER', 'localhost');
    define('USERNAME', 'root');
    define('USERPASS', '');

    $conn = mysqli_connect(SERVER, USERNAME, USERPASS);

    if(!$conn)
    {
        echo "<script>console.error(Unable to connect to database at the moment.)</script>";
        die;
    }
?>
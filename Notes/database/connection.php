<?php
    define('SERVERNAME', 'localhost');
    define('USERNAME', 'root');
    define('USERPASS', '');

    $conn = mysqli_connect(SERVERNAME, USERNAME, USERPASS);

    if (!$conn)
    {
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Error!</strong> We are facing some technical problems. Sorry for the inconvenience.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>';
        echo "<script>console.error('[ERROR]: Unable to connect to database at the moment')</script>";
        die();
    }
?>
<?php
    if (isset($_GET['del']))
    {
        $sno = $_GET['del'];

        if (!mysqli_query($conn, "DELETE FROM notes WHERE sno=$sno"))
        {
            $error = mysqli_error($conn);
            echo "<script>console.error(`[ERROR]: $error`)</script>";
            die();
        }

        $delete = true;
    }
    $userEmail = $_SESSION['user_email'];

    if (isset($_GET['del-all']))
    {
        if (!mysqli_query($conn, "DELETE FROM notes WHERE email='$userEmail'"))
        {
            $error = mysqli_error($conn);
            echo "<script>console.error(`[ERROR]: $error`)</script>";
            die();
        }

        $deleteAll = true;
    }

    if (isset($_GET['del-acc']))
    {
        if (!mysqli_query($conn, "DELETE FROM credentials WHERE email='$userEmail'") || !mysqli_query($conn, "DELETE FROM notes WHERE email='$userEmail'"))
        {
            $error = mysqli_error($conn);
            echo "<script>console.error(`Unable to delete account: $error`)</script>";
            die();
        }
    
        $deleteAcc = true;
        sleep(3);
        header('Location: ../login');
    }
?>
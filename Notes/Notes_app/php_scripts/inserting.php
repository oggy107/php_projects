<?php
    if ($_SERVER["REQUEST_METHOD"] == 'POST') {
        if (isset($_POST['note_sno_edit'])) {
            $title = $_POST['note_title_edit'];
            $desc = $_POST['note_desc_edit'];
            $sno = $_POST['note_sno_edit'];

            if (!mysqli_query($conn, "UPDATE notes SET title='$title', `desc`='$desc' WHERE sno=$sno")) {
                $error = mysqli_error($conn);
                echo '<script>console.error("[ERROR]: ' . $error . '")</script>';
                die();
            }

            $update = true;
        } else {
            $title = $_POST['note_title'];
            $desc = $_POST['note_desc'];
            $email = $_SESSION['user_email'];

            if (!mysqli_query($conn, "INSERT INTO notes(title, `desc`, email) VALUES('$title', '$desc', '$email')")) {
                $error = mysqli_error($conn);
                echo "<script>console.error(`[ERROR]: $error`)</script>";
                die();
            }

            $insert = true;
        }
    }
?>

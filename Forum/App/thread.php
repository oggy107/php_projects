<?php
require('../Auth/authenticate.php');

require('../Database/connect.php');
mysqli_select_db($conn, 'Forum');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $reply = $_POST['reply'];

    $reply = str_replace('<', '&lt;', $reply);
    $reply = str_replace('>', '&gt;', $reply);
    $reply = str_replace('\'', '"', $reply);

    $threadId = $_GET['threadId'];
    $userId = $_SESSION['userId'];

    if (!$res = mysqli_query($conn, "INSERT INTO replies (thread_id, user_id, reply) VALUES($threadId, $userId, '$reply')")) {
        $error = mysqli_error($conn);
        echo "<script>console.error(`[ERROR]: $error`)</script>";
        die;
    }
}

?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
    <link rel="stylesheet" href="../../style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj" crossorigin="anonymous"></script>

    <!-- jquery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" referrerpolicy="no-referrer" require_once></script>

    <title>Forum Thread</title>
</head>

<body>
    <?php require('../Components/navbar.php'); ?>

    <!-- REPLY MODAL -->
    <div class="modal fade" id="reply-modal" tabindex="-1" aria-labelledby="reply-modal-label" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ask-question-modal-label">Reply</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post">
                        <div class="mb-3">
                            <label for="reply" class="form-label"></label>
                            <div class="form-floating">
                                <textarea class="form-control" id="reply" name="reply" style="height: 150px;"></textarea>
                                <label for="qestion-desc">your reply</label>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- <div class="alert-container">
        <?php  ?>
    </div> -->

    <div class="thread-list-header thread-header mb-5">
        <?php
        $threadId = $_GET['threadId'];

        if (!$res = mysqli_query($conn, "SELECT * FROM threads WHERE thread_id=$threadId")) {
            $error = mysqli_error($conn);
            echo "<script>console.error(`[ERROR]: $error`)</script>";
            die;
        }

        $data = mysqli_fetch_assoc($res);
        $userId = $data['user_id'];

        if (!$resOfUser = mysqli_query($conn, "SELECT * FROM credentials WHERE user_id=$userId")) {
            $error = mysqli_error($conn);
            echo "<script>console.error(`[ERROR]: $error`)</script>";
            die;
        }

        echo '<div class="thread-card-img">
                <i class="fa fa-user fa-3x"></i>
            </div>
            <div>
                <h1 class="thread-card-title">' . $data['thread_title'] . '</h1>
                <h6>' . mysqli_fetch_assoc($resOfUser)['user'] . ', ' . $data['time'] . '</h6>
                <div class="thread-card-desc">' . $data['thread_desc'] . '</div>
            </div>
                <button type="button" class="btn btn-primary btn-reply" data-bs-toggle="modal" data-bs-target="#reply-modal">Reply</button>
            ';
        ?>
    </div>

    <div class="main-container">
        <?php
        $threadId = $_GET['threadId'];

        if (!$res = mysqli_query($conn, "SELECT * FROM replies WHERE thread_id=$threadId")) {
            $error = mysqli_error($conn);
            echo "<script>console.error(`[ERROR]: $error`)</script>";
            die;
        }

        if (!mysqli_num_rows($res)) {
            echo '<h2> No replies yet </h2>';
        }

        while ($data = mysqli_fetch_assoc($res)) {
            $reply = $data['reply'];
            $userId = $data['user_id'];
            $time = $data['time'];

            if (!$resOfUser = mysqli_query($conn, "SELECT * FROM credentials WHERE user_id=$userId")) {
                $error = mysqli_error($conn);
                echo "<script>console.error(`[ERROR]: $error`)</script>";
                die;
            }

            echo '<div class="thread-card reply-thread-card mb-4">
                    <div class="thread-card-img">
                        <i class="fa fa-user fa-lg ia"></i>
                    </div>
                    <div>
                        <h6>' . mysqli_fetch_assoc($resOfUser)['user'] . ', ' . $time . '</h6>
                        <div class="thread-card-desc">' . $reply . '</div>
                    </div>
                </div>';
        }
        ?>

    </div>

    <!-- For Alerts -->
    <script>
        $(document).ready(function() {
            $(".alert").fadeTo(2000, 500).slideUp(500, function() {
                $(".alert").slideUp(500);
            });
        });
    </script>

    <!-- My Script -->
    <script src="../script.js"></script>

    <!-- Footer -->
    <?php require('../Components/footer.php'); ?>
</body>

</html>
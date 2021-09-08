<?php
require('../Auth/authenticate.php');

require('../Database/connect.php');
mysqli_select_db($conn, 'Forum');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $threadTitle = $_POST['askedQuestionTitle'];
    $threadDesc = $_POST['askedQuestionDesc'];

    $threadTitle = str_replace('<', '&lt;', $threadTitle);
    $threadTitle = str_replace('>', '&gt;', $threadTitle);
    $threadTitle = str_replace('\'', '"', $threadTitle);

    $threadDesc = str_replace('<', '&lt;', $threadDesc);
    $threadDesc = str_replace('>', '&gt;', $threadDesc);
    $threadDesc = str_replace('\'', '"', $threadDesc);

    $categoryId = $_GET['categoryId'];
    $userId = $_SESSION['userId'];

    if (!$res = mysqli_query($conn, "INSERT INTO threads (user_id, category_id, thread_title, thread_desc) VALUES($userId, $categoryId, '$threadTitle', '$threadDesc')")) {
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

    <title>Froums App</title>
</head>

<body>
    <?php require('../Components/navbar.php'); ?>

    <!-- ASK QUESTION MODAL -->
    <div class="modal fade" id="ask-question-modal" tabindex="-1" aria-labelledby="ask-question-modal-label" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ask-question-modal-label">Ask Question</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post">
                        <div class="mb-3">
                            <label for="question-title" class="form-label">Question Title</label>
                            <input type="text" class="form-control" id="question-title" name="askedQuestionTitle" maxlength="100" required>
                        </div>
                        <div class="mb-3">
                            <label for="question-desc" class="form-label"></label>
                            <div class="form-floating">
                                <textarea class="form-control" id="question-desc" name="askedQuestionDesc" style="height: 150px"></textarea>
                                <label for="qestion-desc">Question Description</label>
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

    <div class="thread-list-header">
        <?php
        $categoryId = $_GET['categoryId'];

        if (!$res = mysqli_query($conn, "SELECT * FROM category WHERE category_id=$categoryId")) {
            $error = mysqli_error($conn);
            echo "<script>console.error(`[ERROR]: $error`)</script>";
            die;
        }

        $data = mysqli_fetch_assoc($res);

        $categoryTitle = $data['category_title'];
        $categoryDesc = $data['category_desc'];

        echo '<h1 class="title thread-title">Welcome to ' . $categoryTitle . ' forum</h1>';
        echo '<p class="thread-desc">' . $categoryDesc . '</P>';

        echo '<button class="btn btn-primary btn-ask-question" data-bs-toggle="modal" data-bs-target="#ask-question-modal">Ask A Question</button>';
        ?>
    </div>

    <div class="main-container">
        <h1 class="my-4">Browser Questions</h1>

        <?php
        $categoryId = $_GET['categoryId'];

        if (!$res = mysqli_query($conn, "SELECT * FROM threads WHERE category_id=$categoryId")) {
            $error = mysqli_error($conn);
            echo "<script>console.error(`[ERROR]: $error`)</script>";
            die;
        }

        if (!mysqli_num_rows($res)) {
            echo '<h2> No questions yet </h2>';
        }

        while ($data = mysqli_fetch_assoc($res)) {
            $threadTitle = $data['thread_title'];
            $threadDesc = $data['thread_desc'];
            $threadId = $data['thread_id'];
            $userId = $data['user_id'];
            $time = $data['time'];

            if (!$resOfUser = mysqli_query($conn, "SELECT * FROM credentials WHERE user_id=$userId")) {
                $error = mysqli_error($conn);
                echo "<script>console.error(`[ERROR]: $error`)</script>";
                die;
            }

            echo '<div class="thread-card mb-4">
                    <div class="thread-card-img">
                        <i class="fa fa-user fa-lg"></i>
                    </div>
                    <div>
                        <h4 class="thread-card-title">' . $threadTitle . '</h4>
                        <h6>' . mysqli_fetch_assoc($resOfUser)['user'] . ', ' . $time . '</h6>
                        <div class="thread-card-desc">' . $threadDesc . '</div>
                    </div>
                    <button type="button" class="btn btn-primary btn-view-thread" data-id=' . $threadId . '>view</button>
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
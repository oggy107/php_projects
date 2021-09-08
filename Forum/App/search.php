<?php
require('../Auth/authenticate.php');

?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
    <link rel="stylesheet" href="../style.css">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj" crossorigin="anonymous"></script>

    <!-- jquery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" referrerpolicy="no-referrer" require_once></script>

    <title>Froum Search results</title>
</head>

<body>
    <?php require('../Components/navbar.php'); ?>

    <div class="alert-container">
        <?php  ?>
    </div>

    <div class="main-container">
        <h1 class="title mb-5">Search Results</h1>

        <div class="category-container">
            <?php
            require('../Database/connect.php');
            mysqli_select_db($conn, 'Forum');

            $query = $_GET['search'];

            if (!$res = mysqli_query($conn, "SELECT * FROM category WHERE category_title='$query'")) {
                $error = mysqli_error($conn);
                echo "<script>console.error(`[ERROR]: $error`)</script>";
            }

            if (!mysqli_num_rows($res)) {

                echo '<h2 class="title" style="margin: auto;">no category found!</h2>';
                echo '<a class="btn btn-primary" href="./" style="flex-basis: 100%;">Home</a>';
            }
            else {
                while ($data = mysqli_fetch_assoc($res)) {
                    $categoryTitle = $data['category_title'];
                    $categoryDesc = $data['category_desc'];
                    $categoryId = $data['category_id'];

                    echo '
                    <div class="card" style="width: 18rem;">
                        <img src="https://source.unsplash.com/1920x1080/?code, ' . $categoryTitle . '" class="card-img-top category-img" alt="img">
                        <div class="card-body">
                            <h5 class="card-title">' . $categoryTitle .  '</h5>
                            <p class="card-text">' . $categoryDesc . '</p>
                            <button class="btn btn-primary btn-card btn-open-category" data-id="' . $categoryId . '">Open</button>
                        </div>
                    </div>
                ';
                }
            }
            ?>
        </div>
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
    <script src="./script.js"></script>

    <!-- Footer -->
    <?php require('../Components/footer.php'); ?>
</body>

</html>
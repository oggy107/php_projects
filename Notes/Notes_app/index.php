<?php
        session_start();
        if(!$_SESSION['logged_in'])
        {
            die("you are not logged in!");
        }

        $insert = false;
        $update = false;
        $delete = false;
        $deleteAll = false;
        $deleteAcc = false;
        $error = false;
        
        require('../database/connection.php');
        mysqli_select_db($conn, "user_data");

        $userEmail = $_SESSION["user_email"];
        $res = mysqli_query($conn, "SELECT 1 FROM credentials WHERE email='$userEmail'");
        if(!mysqli_fetch_row($res)[0])
        {
            die("We can not authenticate you!");
        }

        require('./php_scripts/inserting.php');
        require('./php_scripts/deleting.php');
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
    
    <link rel="stylesheet" href="./style.css">

    <!-- jquery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" referrerpolicy="no-referrer" require_once></script>

    <title>Notes App</title>
</head>

<body>

    <!-- Edit modal -->
    <div class="modal fade" id="edit-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="./index.php" method="post">
                        <input type="hidden" id="note_sno_edit" name="note_sno_edit">
                        <div class="mb-3">
                            <label for="note-title-edit" class="form-label">Note Title</label>
                            <input type="text" class="form-control" id="note_title_edit" name="note_title_edit" required>
                        </div>
                        <div class="form-floating">
                            <p>Note Description</p>
                            <textarea class="form-control" name="note_desc_edit" id="note_desc_edit" style="height: 100px"></textarea>
                        </div>
                        <div class="modal-footer">
                            <div class="btn-container">
                                <button type="submit" class="btn btn-primary">Save changes</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

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
                        <a class="nav-link" href="../login/">Log out</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../login/change_password.php">Change Password</a>
                    </li>
                    <li class="nav-item">
                        <button class="btn btn-link nav-link del-acc-btn">Delete Account</button>
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
        <?php require('./php_scripts/alerts.php'); ?>
    </div>

    <div class="main-container">
        <h1 class="title">Add a Note to Notes App</h1>

        <form action="./index.php" method="post">
            <div class="mb-3">
                <label for="note-title" class="form-label">Note Title</label>
                <input type="text" class="form-control" id="note-title" name="note_title" required>
                <div class="invalid-feedback">
                    please provide title for your note
                </div>
            </div>
            <div class="form-floating">
                <p>Note Description</p>
                <textarea class="form-control" name="note_desc" style="height: 100px"></textarea>
            </div>
            <div class="btn-container">
                <button type="submit" class="btn btn-primary add-note-btn">Add Note</button>
                <button type="button" class="btn btn-primary del-all-btn">Delete All</button>
            </div>
        </form>

        <div class="table-container">
            <table class="table" id="myTable">
                <thead>
                    <tr>
                        <th>S.No</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $userEmail = $_SESSION['user_email'];

                    $res = mysqli_query($conn, "SELECT * FROM notes WHERE email='$userEmail'");
                    if (!$res) {
                        $error = mysqli_error($conn);
                        echo "<script>console.error(`[ERROR]: $error`)</script>";
                        die();
                    }

                    $sno = 1;
                    while ($data = mysqli_fetch_assoc($res)) {
                        echo "<tr>
                            <td>" . $sno . "</td>" .
                            "<td>" . $data["title"] . "</td>" .
                            "<td>" . $data["desc"] . "</td>" .
                            "<td>
                                <button type='button' class='btn btn-primary edit-btn' id=" . $data['sno'] . " data-bs-toggle='modal' data-bs-target='#edit-modal'>Edit</button>
                                <button type='button' class='btn btn-primary del-btn' id=d" . $data['sno'] . ">Delete</button>
                            </td>" .
                            "</tr>";

                        $sno++;
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="./script.js"></script>

    <!-- Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj" crossorigin="anonymous"></script>

    <!-- For Alerts -->
    <script>
        $(document).ready(function() {
            $(".alert-success").fadeTo(2000, 500).slideUp(500, function() {
                $(".alert-success").slideUp(500);
            });
        });
    </script>

    <!-- Datatable -->
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#myTable').DataTable();
        });
    </script>
</body>

</html>
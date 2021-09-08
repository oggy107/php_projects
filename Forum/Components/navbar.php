<?php
$scriptName =  basename($_SERVER["SCRIPT_NAME"]);

$logoutPage = 'httP://' . $_SERVER['HTTP_HOST'] . '/php_projects/Forum/Auth/logout.php';
$homePage = 'http://' . $_SERVER['HTTP_HOST'] . '/php_projects/Forum/App/';
$searchPage = 'http://' . $_SERVER['HTTP_HOST'] . '/php_projects/Forum/App/search.php';

if ($scriptName == 'index.php' || $scriptName == 'thread.php' || $scriptName == 'thread_list.php') {
    echo '<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
          <a class="navbar-brand" href="' . $homePage . '">Forum</a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
              <li class="nav-item">
                <a class="nav-link" href="' . $homePage . '">Home</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="' . $logoutPage . '">Logout</a>
                </li>
            </ul>
            <form class="d-flex" action="' . $searchPage . '" method="get">
              <input class="form-control me-2" type="search" placeholder="Search Categories" name="search" aria-label="Search">
              <button class="btn btn-outline-success" type="submit">Search</button>
            </form>
          </div>
        </div>
      </nav>';
}
else {
    echo '<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
          <a class="navbar-brand" href="#">Forum</a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
              <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="#">Home</a>
              </li>
            <form class="d-flex" action="' . $searchPage . '" method="get">
              <input class="form-control me-2" type="search" placeholder="Search categories" name="search" aria-label="Search">
              <button class="btn btn-outline-success" type="submit">Search</button>
            </form>
          </div>
        </div>
      </nav>';
}

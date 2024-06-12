<?php
require_once '../models/Movie.php';

$isLoggedIn = true;
if (!isset($_SESSION['user_id']) || !isset($_SESSION['islogin']) || $_SESSION['islogin'] !== true) {
    $isLoggedIn = false;
}

$movie = new Movie();
$moviesG = $movie->getMovieGenres()['genres'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Filmlane - Best movie collections</title>

    <link rel="shortcut icon" href="../public/favicon.svg" type="image/svg+xml">

    <script defer src="../public/js/script.js"></script>

    <link rel="stylesheet" href="/public/css/style.css">

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap"
      rel="stylesheet"
    />

</head>

<body>
    <header class="header" data-header>
        <div class="container">
            <div class="overlay" data-overlay></div>

            <a href="/pages/home.php" class="logo">
                <img src="../public/images/logo.svg" alt="Filmlane logo" />
            </a>

            <nav class="navbar" data-navbar>
                <div class="navbar-top">
                    <a href="/pages/home.php" class="logo">
                        <img src="../public/images/logo.svg" alt="Filmlane logo" />
                    </a>

                    <button class="menu-close-btn" data-menu-close-btn>
                        <ion-icon name="close-outline"></ion-icon>
                    </button>
                </div>

                <ul class="navbar-list">
                    <li>
                        <a href="/pages/home.php" class="navbar-link">Home</a>
                    </li>

                    <li>
                        <a href="#">
                            <div class="dropdown">
                                <button class="dropbtn navbar-link">Genre</button>
                                <div class="dropdown-content">
                                    <?php foreach ($moviesG as $genre): ?>
                                        <a href="/pages/genre.php?id=<?php echo $genre['id']; ?>"><?php echo $genre['name']; ?></a>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </a>
                    </li>

                    <li>
                        <a href="/pages/movies.php" class="navbar-link">Movies</a>
                    </li>

                    <li>
                        <a href="/pages/tv_shows.php" class="navbar-link">Tv Show</a>
                    </li>

                    <li>
                        <a href="#" class="navbar-link">Top IMDB</a>
                    </li>
                </ul>
            </nav>

            <div class="header-actions">
                <form action="/pages/search.php" method="GET">
                    <div class="input-container">
                        <input type="text" name="search" placeholder="Search..." required />
                        <button type="submit">Search</button>
                    </div>
                </form>
            </div>

            <?php if ($isLoggedIn): ?>
                <li><a href="/pages/update_account.php" class="btn btn-primary"><span class="glyphicon glyphicon-user"></span>
                        Profile</a></li>
            <?php else: ?>
                <li><a href="/pages/login.php" class="btn btn-primary"><span class="glyphicon glyphicon-log-in"></span>
                        Login</a></li>
            <?php endif; ?>
            <button class="menu-open-btn" data-menu-open-btn>
                <ion-icon name="reorder-two"></ion-icon>
            </button>

        </div>


        </div>
    </header>
    
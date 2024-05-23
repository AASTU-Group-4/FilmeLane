<?php
session_start();
require_once '../views/header.php';
require_once '../models/Movie.php';
require_once '../includes/function.php';
$movie = new Movie();
$Popularmovies = $movie->getMovieListDetails(($movie->getPopularMovies())['results']);
$upcomingMovies = $movie->getMovieListDetails($movie->getUpcomingMovies()['results']);
$topRatedMovies = $movie->getMovieListDetails($movie->getTopRatedMovies()['results']);
$topRatedTVShows = $movie->getTvshowListDetails($movie->getTopRatedTVShows()['results']);
$rand = rand(0, 19);
$pMoviesDetails = $movie->getMovie($Popularmovies[$rand]['id']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Filmlane - Best movie collections</title>

    <link rel="stylesheet" href="/public/css/style.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        .hero {
            background: url('<?php echo "https://image.tmdb.org/t/p/original/" . $pMoviesDetails["poster_path"]; ?>') no-repeat;
            background-size: cover;
            background-position: center;
            min-height: 750px;
            height: 100vh;
            max-height: 1000px;
            display: flex;
            justify-content: flex-start;
            align-items: center;
            padding-block: var(--section-padding);
        }
    </style>
</head>

<body id="top">


    <main>
        <article>

            <section class="hero">
                <div class="container">

                    <div class="hero-content">

                        <p class="hero-subtitle">Filmlane</p>

                        <h1 class="h1 hero-title">
                            Unlimited <strong>Movie</strong>, TVs Shows, & More.
                        </h1>

                        <div class="meta-wrapper">

                            <div class="badge-wrapper">
                                <div class="badge badge-fill">PG 18</div>

                                <div class="badge badge-outline">HD</div>
                            </div>

                            <div class="ganre-wrapper">
                                <a href="#"><?php echo "{$pMoviesDetails['genres'][0]['name']}"; ?></a>

                                <a href="#"><?php echo "{$pMoviesDetails['genres'][1]['name']}"; ?></a>
                            </div>

                            <div class="date-time">

                                <div>
                                    <ion-icon name="calendar-outline"></ion-icon>

                                    <time datetime="2022"><?php echo "{$pMoviesDetails['release_date']}"; ?></time>
                                </div>

                                <div>
                                    <ion-icon name="time-outline"></ion-icon>

                                    <time datetime="PT128M"><?php echo "{$pMoviesDetails['runtime']}"; ?> min</time>
                                </div>

                            </div>

                        </div>

                        <button class="btn btn-primary">
                            <ion-icon name="play"></ion-icon>

                            <span>Watch now</span>
                        </button>

                    </div>

                </div>
            </section>



            <section class="upcoming">
                <div class="container">

                    <div class="flex-wrapper">

                        <div class="title-wrapper">
                            <p class="section-subtitle">Online Streaming</p>

                            <h2 class="h2 section-title">Upcoming Movies</h2>
                        </div>

                        <ul class="filter-list">

                            <li>
                                <button class="filter-btn">Movies</button>
                            </li>

                            <li>
                                <button class="filter-btn">TV Shows</button>
                            </li>

                            <li>
                                <button class="filter-btn">Anime</button>
                            </li>

                        </ul>

                    </div>

                    <ul class="movies-list  has-scrollbar">

                        <?php
                        foreach ($upcomingMovies as $movie) {
                            echo "<li>" . createDynamicMovieCard($movie) . "</li>";
                        }
                        ?>
                </div>
            </section>

            <section class="top-rated">
                <div class="container">

                    <p class="section-subtitle">Online Streaming</p>

                    <h2 class="h2 section-title">Top Rated Movies</h2>

                    <ul class="filter-list">

                        <li>
                            <button class="filter-btn">Movies</button>
                        </li>

                        <li>
                            <button class="filter-btn">TV Shows</button>
                        </li>

                        <li>
                            <button class="filter-btn">Documentary</button>
                        </li>

                        <li>
                            <button class="filter-btn">Sports</button>
                        </li>

                    </ul>

                    <ul class="movies-list">

                        <?php
                        foreach ($topRatedMovies as $movie) {
                            echo "<li>" . createDynamicMovieCard($movie) . "</li>";
                        }
                        ?>

                    </ul>

                </div>
            </section>



            <section class="tv-series">
                <div class="container">

                    <p class="section-subtitle">Best TV Series</p>

                    <h2 class="h2 section-title">World Best TV Series</h2>

                    <ul class="movies-list">

                        <?php
                        foreach ($topRatedTVShows as $movie) {
                            echo "<li>" . createDynamicTvshowCard($movie) . "</li>";
                        }
                        ?>
                    </ul>

                </div>
            </section>

        </article>
    </main>




    <footer class="footer">

        <div class="footer-top">
            <div class="container">

                <div class="footer-brand-wrapper">

                    <a href="./index.html" class="logo">
                        <img src="/public/images/logo.svg" alt="Filmlane logo">
                    </a>

                    <ul class="footer-list">

                        <li>
                            <a href="./index.html" class="footer-link">Home</a>
                        </li>

                        <li>
                            <a href="#" class="footer-link">Movie</a>
                        </li>

                        <li>
                            <a href="#" class="footer-link">TV Show</a>
                        </li>

                        <li>
                            <a href="#" class="footer-link">Web Series</a>
                        </li>

                    </ul>

                </div>

                <div class="divider"></div>

                <div class="quicklink-wrapper">

                    <ul class="social-list">

                        <li>
                            <a href="#" class="social-link">
                                <ion-icon name="logo-facebook"></ion-icon>
                            </a>
                        </li>

                        <li>
                            <a href="#" class="social-link">
                                <ion-icon name="logo-twitter"></ion-icon>
                            </a>
                        </li>

                        <li>
                            <a href="#" class="social-link">
                                <ion-icon name="logo-pinterest"></ion-icon>
                            </a>
                        </li>

                        <li>
                            <a href="#" class="social-link">
                                <ion-icon name="logo-linkedin"></ion-icon>
                            </a>
                        </li>

                    </ul>

                </div>

            </div>
        </div>

    </footer>



    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

</body>

</html>
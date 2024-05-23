<?php
session_start();
require_once '../views/header.php';
require_once '../models/Movie.php';
require_once '../includes/function.php';

$searchResults = [];
$Searchmovie = [];
$Searchtv = [];
$query = '';
if ($_GET['search']) {
    $movie = new Movie();
    $searchResults = $movie->search($_GET['search']);
    if (!empty($searchResults['movie']) && !empty($searchResults['tv'])) {
        $Searchmovie = $movie->getMovieListDetails($searchResults['movie']);
        $Searchtv = $movie->getTvshowListDetails($searchResults['tv']);
        $query = $_GET['search'];
    }
}
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

    <head>

    <body>
        <main>
            <section class="top-rated" style="min-height: 100vh;">
                <div class="container">

                    <h2 class="h2 section-title">Search Resault: <?php echo $query; ?></h2>

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

                    </ul>

                    <ul class="movies-list">

                        <?php
                        foreach ($Searchmovie as $movie) {
                            echo "<li>" . createDynamicMovieCard($movie) . "</li>";
                        }
                        ?>
                        <?php
                        foreach ($Searchtv as $tvshow) {
                            echo "<li>" . createDynamicTvshowCard($tvshow) . "</li>";
                        }
                        ?>

                    </ul>

                </div>
            </section>
        </main>
    </body>
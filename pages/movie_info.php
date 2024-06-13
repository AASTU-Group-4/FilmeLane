<?php
session_start();

if (!isset($_GET['id'])) {
    header('Location: ./home.php');
    exit;
}
$movie_id = $_GET['id'];



require_once '../models/Movie.php';
require_once '../models/UserHistory.php';
require_once '../models/UserWatchlist.php';
require_once '../includes/function.php';
require_once '../views/header.php';

if (isset($_GET['watch'])) {
    if ($isLoggedIn) {
        $userHistoryModel = new UserHistory();
        if (!$userHistoryModel->isMovieInHistory($_SESSION['user_id'], $movie_id)) {
            $userHistoryModel->create($_SESSION['user_id'], $movie_id, date('Y-m-d H:i:s'), 'movie');
        }
    }
    $url = "https://moviesapi.club/movie/" . $movie_id;
    $watch = true;
} else {
    $watch = false;
}

$userWatchListModel = new UserWatchList();
if(isset($_GET['fav']) and $isLoggedIn){
    if ($_GET['fav'] == 'add') {
        $userWatchListModel->addToWatchlist($_SESSION['user_id'], $movie_id, 'movie');
    } else {
        $userWatchListModel->clearMovieFromWatchlist($_SESSION['user_id'], $movie_id);
    }
}


$movieModel = new Movie();
$movie = $movieModel->getMovie($movie_id);
$movieRecommendations = $movieModel->getMovieListDetails($movieModel->getMovieSimilar($movie_id)['results']);

if (!empty($movieModel->getMovieVideos($movie_id)['results'])) {
    $trailer_key = $movieModel->getMovieVideos($movie_id)['results'][0]['key'];
    $trailer_url = "https://www.youtube.com/watch?v=$trailer_key";
} else {
    $trailer_url = "https://www.youtube.com/";
}









require_once '../views/movie_info_view.php';

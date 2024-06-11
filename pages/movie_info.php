<?php
session_start();
if (!isset($_GET['id'])) {
    header('Location: ./home.php');
    exit;
}
$movie_id = $_GET['id'];

if (isset($_GET['watch'])) {
    $url = "https://moviesapi.club/movie/" . $movie_id;
    $watch = true;
} else {
    $watch = false;
}

require_once '../models/Movie.php';
require_once '../includes/function.php';
require_once '../views/header.php';


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

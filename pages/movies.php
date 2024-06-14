<?php
session_start();
require_once '../views/header.php';
require_once '../models/Movie.php';
require_once '../includes/function.php';

$type = isset($_GET['type']) ? $_GET['type'] : 'movie';
$page = isset($_GET['page']) ? $_GET['page'] : 1;

$movieModel = new Movie();

$Name = 'Popular ' . $type;

$SearchResults = [];
if ($type == 'movie') {
    $results = $movieModel->getPopularMovies($page);
    $SearchResults = $movieModel->getMovieListDetails($results['results']);
} else {
    $results = $movieModel->getPopularTVShows($page);
    $SearchResults = $movieModel->getTvshowListDetails($results['results']);

}

require_once '../views/movies_view.php';

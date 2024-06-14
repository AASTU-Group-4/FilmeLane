<?php
session_start();
require_once '../views/header.php';
require_once '../models/Movie.php';
require_once '../includes/function.php';

$id = isset($_GET['id']) ? $_GET['id'] : 18;
$type = isset($_GET['type']) ? $_GET['type'] : 'movie';
$page = isset($_GET['page']) ? $_GET['page'] : 1;

$movieModel = new Movie();

$genreName = $movieModel->getGenreNameById($id);
$moviesG = $movieModel->getMovieGenres()['genres'];
$tvShowG = $movieModel->getTVShowGenres()['genres'];

$SearchResults = [];
if ($type == 'movie') {
    $results = $movieModel->getMovieByGenre($id, $page);
    $SearchResults = $movieModel->getMovieListDetails($results['results']);
} else {
    $results = $movieModel->getTVShowByGenre($id, $page);
    $SearchResults = $movieModel->getTvshowListDetails($results['results']);
}

require_once '../views/genre_view.php';

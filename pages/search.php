<?php
session_start();
require_once '../views/header.php';
require_once '../models/Movie.php';
require_once '../includes/function.php';

$query = isset($_GET['search']) ? $_GET['search'] : '';
$type = isset($_GET['type']) ? $_GET['type'] : 'movie';
$page = isset($_GET['page']) ? $_GET['page'] : 1;

$movieModel = new Movie();


$SearchResults = [];
if ($type == 'movie') {
    $results = $movieModel->searchMovie($query, $page);
    $SearchResults = $movieModel->getMovieListDetails($results['results']);
} else {
    $results = $movieModel->searchTVShow($query, $page);
    $SearchResults = $movieModel->getTvshowListDetails($results['results']);
}

require_once '../views/search_view.php';

<!-- movies list page -->
<?php
session_start();
require_once '../views/header.php';
require_once '../models/Movie.php';
require_once '../includes/function.php';
$movie = new Movie();
$pMoviesDetails = $movie->getMovie(($movie->getPopularMovies())['results'][rand(0, 19)]['id']);
$upcomingMovies = $movie->getMovieListDetails($movie->getTopRatedMovies()['results']);
$currentYear = date('Y');
// Assuming $movie is an instance of a class with a method getMovieByYear
if (isset($_GET['year']) && is_numeric($_GET['year'])) {
    $selectedYear = intval($_GET['year']);
} else {
    $selectedYear = $currentYear;
}

$Movies = $movie->getMovieByYear($movie->getMovieByYear($currentYear)['results']);

require '../views/movies_view.php';


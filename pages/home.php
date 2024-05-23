<?php
session_start();
require_once '../views/header.php';
require_once '../models/Movie.php';
require_once '../includes/function.php';
$movie = new Movie();
$pMoviesDetails = $movie->getMovie(($movie->getPopularMovies())['results'][rand(0, 19)]['id']);
$upcomingMovies = $movie->getMovieListDetails($movie->getUpcomingMovies()['results']);
$topRatedMovies = $movie->getMovieListDetails($movie->getTopRatedMovies()['results']);
$topRatedTVShows = $movie->getTvshowListDetails($movie->getTopRatedTVShows()['results']);
require '../views/home_view.php';


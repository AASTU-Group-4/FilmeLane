<!-- tv shows list page -->
<?php
session_start();
require_once '../views/header.php';
require_once '../models/Movie.php';
require_once '../includes/function.php';
$tvshow = new Movie();
$pTvshowDetails = $movie->getTVShow(($movie->getPopularTVShows())['results'][rand(0, 19)]['id']);
$trendingTvshows = $movie->getTvshowListDetails($movie->getTrendingTVShows()['results']);
$currentYear = date('Y');
if (isset($_GET['year']) && is_numeric($_GET['year'])) {
    $selectedYear = intval($_GET['year']);
} else {
    $selectedYear = $currentYear;
}
$Tvshows = $movie->getTvshowByYear($movie->getTVShowByYear($selectedYear)['results']);

require '../views/tvShows_view.php';


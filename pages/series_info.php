<?php
session_start();
if(!isset($_GET['id'])) {
    header('Location: ./home.php');
    exit;
}
$tv_id = $_GET['id'];





require_once '../models/Movie.php';
require_once '../models/UserHistory.php';
require_once '../models/UserWatchlist.php';
require_once '../includes/function.php';
require_once '../views/header.php';



$movieModel = new Movie();
$tvShow = $movieModel->getTVShow($tv_id);
$movieRecommendations = $movieModel->getTvshowListDetails($movieModel->getTVShowSimilar($tvShow['id'])['results']);

$season = isset($_GET['season']) ? $_GET['season'] : $tvShow['seasons'][0]['season_number'];
$seasonDetails = $movieModel->getSeasonDetail($tv_id, $season);



if(isset($_GET['eps'])) {
    if ($isLoggedIn) {
        $userHistoryModel = new UserHistory();
        if (!$userHistoryModel->isMovieInHistory($_SESSION['user_id'], $tv_id)) {
            $userHistoryModel->create($_SESSION['user_id'], $tv_id, date('Y-m-d H:i:s'), 'series');
        }
    }
    $url = "https://moviesapi.club/tv/" . $tv_id .'-'.$season.'-'.$_GET['eps'];
    $eps =$_GET['eps'];
    $watch = true;
} else {
    $eps =-1;
    $watch = false;
}

$userWatchListModel = new UserWatchList();
if(isset($_GET['fav']) and $isLoggedIn){
    if ($_GET['fav'] == 'add') {
        $userWatchListModel->addToWatchlist($_SESSION['user_id'], $tv_id, 'series');
    } else {
        $userWatchListModel->clearMovieFromWatchlist($_SESSION['user_id'], $tv_id);
    }
}

if(!empty($movieModel->getMovieVideos($tv_id)['results'])) {
    $trailer_key = $movieModel->getMovieVideos($tv_id)['results'][0]['key'];
    $trailer_url = "https://www.youtube.com/watch?v=$trailer_key";
} else {
    $trailer_url = "https://www.youtube.com/";
}


require_once '../views/series_info_view.php';






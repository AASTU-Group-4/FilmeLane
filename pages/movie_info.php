<?php
require_once '../models/Movie.php';

$movie_id = $_GET['id'];
$movieModel = new Movie();
$movie = $movieModel->getMovie($movie_id);

if ($movie !== false) {
    echo '<pre>';
    print_r($movie);
    echo '</pre>';
}

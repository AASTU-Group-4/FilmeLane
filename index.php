<?php
	require_once 'includes/db_connection.php';
	require_once 'models/Movie.php';
	Session_start();
	get_connection();

	$movie = new Movie();
	$movies = $movie->search('The Matrix', 2);
	echo '<pre>';
	print_r($movies);
	echo '</pre>';


?>
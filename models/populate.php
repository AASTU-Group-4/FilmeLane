<?php
require_once ('../includes/db_connection.php');
require_once ('User.php');
require_once ('UserWatchlist.php');
require_once ('UserHistory.php');
require_once ('Movie.php');

// Create instances of the required classes
$userModel = new UserModel();
$userWatchList = new UserWatchList();
$userHistory = new UserHistory();
$movieModel = new Movie();

function randomString($length = 10)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

// Populate database with 100 users
for ($i = 0; $i < 100; $i++) {
    $username = 'user' . $i;
    $email = 'user' . $i . '@example.com';
    $password = '12345678';
    $fullName = 'User ' . $i;
    $gender = rand(0, 1) ? 'male' : 'female';
    $profilePic = 'no_pic.png';

    $userID = $userModel->createUser($username, $email, $password, $fullName, $gender, $profilePic);

    if ($userID) {
        echo "Created user: $username\n";

        for ($j = 0; $j < rand(1, 10); $j++) {
            $type = rand(0, 1) ? 'movie' : 'tv';

            if ($type == 'movie') {
                $randomPage = rand(1, 50);
                $searchResults = $movieModel->getTopRatedMovies($randomPage);
                $movieID = $searchResults['results'][rand(0, 19)]['id']; // Corrected index to 0-19
            } elseif ($type == 'tv') {
                $randomPage = rand(1, 50);
                $searchResults = $movieModel->getTopRatedTVShows($randomPage);
                $movieID = $searchResults['results'][rand(0, 19)]['id']; // Corrected index to 0-19
            }

            if ($userWatchList->addToWatchlist($userID, $movieID, $type)) {
                echo "Added $type ID $movieID to user $username's watchlist\n";
            }
        }

        // Add random movies to the user's history
        for ($k = 0; $k < rand(1, 10); $k++) {
            $type = rand(0, 1) ? 'movie' : 'tv';

            if ($type == 'movie') {
                $randomPage = rand(1, 50);
                $searchResults = $movieModel->getTopRatedMovies($randomPage);
                $movieID = $searchResults['results'][rand(0, 19)]['id']; // Corrected index to 0-19
            } elseif ($type == 'tv') {
                $randomPage = rand(1, 50);
                $searchResults = $movieModel->getTopRatedTVShows($randomPage);
                $movieID = $searchResults['results'][rand(0, 19)]['id']; // Corrected index to 0-19
            }

            $watchTime = date('Y-m-d H:i:s', strtotime('-' . rand(0, 365) . ' days')); // Random watch time within the last year

            if ($userHistory->create($userID, $movieID, $watchTime, $type)) {
                echo "Added $type ID $movieID to user $username's history at $watchTime\n";
            }
        }
    } else {
        echo "Failed to create user: $username\n";
    }
}
?>

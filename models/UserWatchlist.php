<?php
require_once('../includes/db_connection.php');

class UserWatchList {
    private $db;

    public function __construct() {
        $this->db = get_connection();
    }

    public function addToWatchlist($userId, $movieId) {
        $query = "INSERT INTO user_watchlist (user_id, movie_id) VALUES (?, ?)";
        $statement = $this->db->prepare($query);
        $statement->bind_param("ii", $userId, $movieId);
        $statement->execute();
        $statement->close();
    }

    public function clearWatchlist($userId) {
        $query = "DELETE FROM user_watchlist WHERE user_id = ?";
        $statement = $this->db->prepare($query);
        $statement->bind_param("i", $userId);
        $statement->execute();
        $statement->close();
    }

    public function clearMovieFromWatchlist($userId, $movieId) {
        $query = "DELETE FROM user_watchlist WHERE user_id = ? AND movie_id = ?";
        $statement = $this->db->prepare($query);
        $statement->bind_param("ii", $userId, $movieId);
        $statement->execute();
        $statement->close();
    }

}
?>

<?php
require_once('../includes/db_connection.php');

class UserWatchList {
    private $db;

    public function __construct() {
        $this->db = get_connection();
    }

    public function addToWatchlist($userId, $movieId, $type) {
        if ($this->isMovieInWatchlist($userId, $movieId)) {
            return false;
        }

        $query = "INSERT INTO UserWatchlist (user_id, movie_id, added_at, type) VALUES (?, ?, CURRENT_TIMESTAMP, ?)";
        $statement = $this->db->prepare($query);
        $statement->bind_param("iss", $userId, $movieId, $type);
        $statement->execute();
        if ($statement->error) {
            error_log("Error adding to watchlist: " . $statement->error);
        }
        $statement->close();
        return true;
    }

    public function clearWatchlist($userId) {
        $query = "DELETE FROM UserWatchlist WHERE user_id = ?";
        $statement = $this->db->prepare($query);
        $statement->bind_param("i", $userId);
        $statement->execute();
        if ($statement->error) {
            error_log("Error clearing watchlist: " . $statement->error);
        }
        $statement->close();
    }

    public function clearMovieFromWatchlist($userId, $movieId) {
        $query = "DELETE FROM UserWatchlist WHERE user_id = ? AND movie_id = ?";
        $statement = $this->db->prepare($query);
        $statement->bind_param("is", $userId, $movieId);
        $statement->execute();
        if ($statement->error) {
            error_log("Error removing movie from watchlist: " . $statement->error);
        }
        $statement->close();
    }

    public function removeMovieFromWatchlist($userId, $watchlist_id) {
        $query = "DELETE FROM UserWatchlist WHERE user_id = ? AND watchlist_id = ?";
        $statement = $this->db->prepare($query);
        $statement->bind_param("ii", $userId, $watchlist_id);
        $statement->execute();
        if ($statement->error) {
            error_log("Error removing movie from watchlist: " . $statement->error);
        }
        $statement->close();
    }

    // Get the user's watchlist
    public function getWatchlist($userId) {
        $query = "SELECT * FROM UserWatchlist WHERE user_id = ?";
        $statement = $this->db->prepare($query);
        $statement->bind_param("i", $userId);
        $statement->execute();
        $result = $statement->get_result();
        $watchlist = [];
        while ($row = $result->fetch_assoc()) {
            $watchlist[] = $row;
        }
        $statement->close();
        return $watchlist;
    }

    public function getMovieFromWatchlist($userId, $movieId) {
        $query = "SELECT movie_id, type, added_at FROM UserWatchlist WHERE user_id = ? AND movie_id = ?";
        $statement = $this->db->prepare($query);
        $statement->bind_param("is", $userId, $movieId);
        $statement->execute();
        $result = $statement->get_result();
        $movie = $result->fetch_assoc();
        $statement->close();
        return $movie;
    }

    public function updateMovieType($userId, $movieId, $newType) {
        $query = "UPDATE UserWatchlist SET type = ? WHERE user_id = ? AND movie_id = ?";
        $statement = $this->db->prepare($query);
        $statement->bind_param("sis", $newType, $userId, $movieId);
        $statement->execute();
        if ($statement->error) {
            // Handle error
            error_log("Error updating movie type: " . $statement->error);
        }
        $statement->close();
    }

    public function isMovieInWatchlist($userId, $movieId) {
        $query = "SELECT COUNT(*) as count FROM UserWatchlist WHERE user_id = ? AND movie_id = ?";
        $statement = $this->db->prepare($query);
        $statement->bind_param("is", $userId, $movieId);
        $statement->execute();
        $result = $statement->get_result();
        $row = $result->fetch_assoc();
        $statement->close();
        return $row['count'] > 0;
    }

    public function __destruct() {
        $this->db->close();
    }
}
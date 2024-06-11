<?php
require_once('../includes/db_connection.php');

class UserHistory {
    private $conn;

    public function __construct() {
        $this->conn = get_connection();
    }

    // Create a new record in the UserHistory table
    public function create($user_id, $movie_id, $date_watched, $type) {
        $stmt = $this->conn->prepare("INSERT INTO UserHistory (user_id, movie_id, date_watched, type) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("isss", $user_id, $movie_id, $date_watched, $type);

        if ($stmt->execute()) {
            return $stmt->insert_id;
        } else {
            return false;
        }
    }

    // Read a record from the UserHistory table by history_id
    public function getByHistoryId($history_id) {
        $stmt = $this->conn->prepare("SELECT * FROM UserHistory WHERE history_id = ?");
        $stmt->bind_param("i", $history_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        } else {
            return null;
        }
    }

    // Get all records from the UserHistory table by user_id
    public function getByUserId($user_id) {
        $stmt = $this->conn->prepare("SELECT * FROM UserHistory WHERE user_id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();

        $records = [];
        while ($row = $result->fetch_assoc()) {
            $records[] = $row;
        }

        return $records;
    }

    // Check if a movie is already in the user's history
    public function isMovieInHistory($user_id, $movie_id) {
        $stmt = $this->conn->prepare("SELECT * FROM UserHistory WHERE user_id = ? AND movie_id = ?");
        $stmt->bind_param("is", $user_id, $movie_id);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->num_rows > 0;
    }

    // Update a record in the UserHistory table
    public function update($history_id, $user_id, $movie_id, $date_watched, $type) {
        $stmt = $this->conn->prepare("UPDATE UserHistory SET user_id = ?, movie_id = ?, date_watched = ?, type = ? WHERE history_id = ?");
        $stmt->bind_param("isssi", $user_id, $movie_id, $date_watched, $type, $history_id);
        
        return $stmt->execute();
    }

    // Delete a record from the UserHistory table
    public function delete($history_id) {
        $stmt = $this->conn->prepare("DELETE FROM UserHistory WHERE history_id = ?");
        $stmt->bind_param("i", $history_id);
        
        return $stmt->execute();
    }

    // Clear all history for a specific user
    public function clearHistory($user_id) {
        $stmt = $this->conn->prepare("DELETE FROM UserHistory WHERE user_id = ?");
        $stmt->bind_param("i", $user_id);
        
        return $stmt->execute();
    }

    // Close the database connection
    public function __destruct() {
        $this->conn->close();
    }
}


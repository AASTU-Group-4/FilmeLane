<?php
require_once('../includes/db_connection.php');

class UserHistory {
    private $conn;

    public function __construct() {
        $this->conn = get_connection();
    }

    public function create($user_id, $movie_id, $date_watched, $type) {
        $stmt = $this->conn->prepare("INSERT INTO UserHistory (user_id, movie_id, date_watched, type) VALUES (?, ?, CURRENT_TIMESTAMP, ?)");
        $stmt->bind_param("iss", $user_id, $movie_id, $type);

        if ($stmt->execute()) {
            return $stmt->insert_id;
        } else {
            return false;
        }
    }

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

    public function isMovieInHistory($user_id, $movie_id) {
        $stmt = $this->conn->prepare("SELECT * FROM UserHistory WHERE user_id = ? AND movie_id = ?");
        $stmt->bind_param("is", $user_id, $movie_id);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->num_rows > 0;
    }

    public function update($history_id, $user_id, $movie_id, $date_watched, $type) {
        $stmt = $this->conn->prepare("UPDATE UserHistory SET user_id = ?, movie_id = ?, date_watched = ?, type = ? WHERE history_id = ?");
        $stmt->bind_param("isssi", $user_id, $movie_id, $date_watched, $type, $history_id);
        
        return $stmt->execute();
    }

    public function delete($history_id) {
        $stmt = $this->conn->prepare("DELETE FROM UserHistory WHERE history_id = ?");
        $stmt->bind_param("i", $history_id);
        
        return $stmt->execute();
    }

    public function clearHistory($user_id) {
        $stmt = $this->conn->prepare("DELETE FROM UserHistory WHERE user_id = ?");
        $stmt->bind_param("i", $user_id);
        
        return $stmt->execute();
    }

    public function __destruct() {
        $this->conn->close();
    }
}


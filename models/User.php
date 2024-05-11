<?php
require_once('../includes/db_connection.php');

class UserModel {
    private $conn;

    public function __construct() {
        $this->conn = get_connection();
    }

    public function createUser($username, $email, $password) {
        if ($this->checkEmailExists($email)) {
            return false; 
        }

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $createdDate = date('Y-m-d');

        $stmt = $this->conn->prepare("INSERT INTO Users (username, email, password, created_at) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $username, $email, $hashedPassword, $createdDate);
        
        if ($stmt->execute()) {
            return $stmt->insert_id; 
        } else {
            return false; 
        }
    }

    public function changeUsername($userID, $newUsername) {
        $stmt = $this->conn->prepare("UPDATE Users SET username = ? WHERE user_id = ?");
        $stmt->bind_param("si", $newUsername, $userID);
        return $stmt->execute(); 
    }

    public function loginUser($usernameOrEmail, $password) {
        $stmt = $this->conn->prepare("SELECT * FROM Users WHERE username = ? OR email = ?");
        $stmt->bind_param("ss", $usernameOrEmail, $usernameOrEmail);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['password'])) {
                return $user; 
            }
        }

        return null; 
    }

    public function getUserInfo($userID) {
        $stmt = $this->conn->prepare("SELECT * FROM Users WHERE user_id = ?");
        $stmt->bind_param("i", $userID);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            return $result->fetch_assoc(); 
        }

        return null; 
    }

    public function deleteUser($userID) {
        $stmt = $this->conn->prepare("DELETE FROM Users WHERE user_id = ?");
        $stmt->bind_param("i", $userID);
        return $stmt->execute(); 
    }

    public function changePassword($userID, $newPassword) {
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

        $stmt = $this->conn->prepare("UPDATE Users SET password = ? WHERE user_id = ?");
        $stmt->bind_param("si", $hashedPassword, $userID);
        return $stmt->execute(); 
    }

    public function checkEmailExists($email) {
        $stmt = $this->conn->prepare("SELECT * FROM Users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->num_rows > 0;
    }
}
?>
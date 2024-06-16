<?php
require_once ('../includes/db_connection.php');

class UserModel
{
    private $conn;

    public function __construct()
    {
        $this->conn = get_connection();
    }

    public function createUser($username, $email, $password, $fullName, $gender, $profilePic)
    {
        if ($this->checkEmailExists($email)) {
            return false;
        }

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $createdDate = date('Y-m-d');
        $updatedDate = date('Y-m-d'); // Initialize updated_at with the same date

        $stmt = $this->conn->prepare("INSERT INTO Users (username, email, password, full_name, gender, profile_pic, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssss", $username, $email, $hashedPassword, $fullName, $gender, $profilePic, $createdDate, $updatedDate);

        if ($stmt->execute()) {
            return $stmt->insert_id;
        } else {
            return false;
        }
    }

    public function updateUser($userID, $username, $email, $password, $fullName, $gender, $profilePic)
    {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $updateDate = date('Y-m-d');

        $stmt = $this->conn->prepare("UPDATE Users SET username=?, email=?, password=?, full_name=?, gender=?, profile_pic=?, updated_at=? WHERE user_id=?");
        $stmt->bind_param("sssssssi", $username, $email, $hashedPassword, $fullName, $gender, $profilePic, $updateDate, $userID);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function updateUserNoPassword($userID, $username, $email, $fullName, $gender, $profilePic)
    {
        $updateDate = date('Y-m-d');

        $stmt = $this->conn->prepare("UPDATE Users SET username=?, email=?, full_name=?, gender=?, profile_pic=?, updated_at=? WHERE user_id=?");
        $stmt->bind_param("ssssssi", $username, $email, $fullName, $gender, $profilePic, $updateDate, $userID);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function changeUsername($userID, $newUsername)
    {
        $updateDate = date('Y-m-d');

        $stmt = $this->conn->prepare("UPDATE Users SET username=?, updated_at=? WHERE user_id=?");
        $stmt->bind_param("ssi", $newUsername, $updateDate, $userID);
        return $stmt->execute();
    }

    public function changeFullName($userID, $newFullName)
    {
        $updateDate = date('Y-m-d');

        $stmt = $this->conn->prepare("UPDATE Users SET full_name=?, updated_at=? WHERE user_id=?");
        $stmt->bind_param("ssi", $newFullName, $updateDate, $userID);
        return $stmt->execute();
    }

    public function loginUser($email, $password)
    {
        $stmt = $this->conn->prepare("SELECT * FROM Users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if ($user && password_verify($password, $user['password'])) {
            return $user;
        } else {
            return false;
        }
    }

    public function getUserInfo($userID)
    {
        $stmt = $this->conn->prepare("SELECT * FROM Users WHERE user_id = ?");
        $stmt->bind_param("i", $userID);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            return $result->fetch_assoc();
        }

        return null;
    }

    public function deleteUser($userID)
    {
        $stmt = $this->conn->prepare("DELETE FROM Users WHERE user_id = ?");
        $stmt->bind_param("i", $userID);
        return $stmt->execute();
    }

    public function changePassword($userID, $newPassword)
    {
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        $updateDate = date('Y-m-d');

        $stmt = $this->conn->prepare("UPDATE Users SET password=?, updated_at=? WHERE user_id=?");
        $stmt->bind_param("ssi", $hashedPassword, $updateDate, $userID);
        return $stmt->execute();
    }

    public function checkEmailExists($email)
    {
        $stmt = $this->conn->prepare("SELECT * FROM Users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->num_rows > 0;
    }

    public function changeProfilePic($userID, $newProfilePic)
    {
        $updateDate = date('Y-m-d');

        $stmt = $this->conn->prepare("UPDATE Users SET profile_pic=?, updated_at=? WHERE user_id=?");
        $stmt->bind_param("ssi", $newProfilePic, $updateDate, $userID);
        return $stmt->execute();
    }

    public function addResetToken($email, $token)
    {
        $token_hash = hash("sha256", $token);
        $expiry = date("Y-m-d H:i:s", time() + 60 * 30);
        $updateDate = date('Y-m-d');

        $stmt = $this->conn->prepare("UPDATE Users SET reset_token_hash=?, reset_token_expires_at=?, updated_at=? WHERE email=?");
        $stmt->bind_param("ssss", $token_hash, $expiry, $updateDate, $email);
        return $stmt->execute();
    }

    public function getUserByResetToken($token_hash)
    {
        $stmt = $this->conn->prepare("SELECT * FROM Users WHERE reset_token_hash = ?");
        $stmt->bind_param("s", $token_hash);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            return $result->fetch_assoc();
        }

        return null;
    }


    public function __destruct()
    {
        $this->conn->close();
    }
}

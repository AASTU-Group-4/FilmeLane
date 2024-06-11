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

        $stmt = $this->conn->prepare("INSERT INTO Users (username, email, password, full_name, gender, profile_pic, created_at) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssss", $username, $email, $hashedPassword, $fullName, $gender, $profilePic, $createdDate);

        if ($stmt->execute()) {
            return $stmt->insert_id;
        } else {
            return false;
        }
    }

    public function UpdateUser($userID, $username, $email, $password, $fullName, $gender, $profilePic)
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

    public function UpdateUserNopassword($userID, $username, $email, $fullName, $gender, $profilePic)
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
        $stmt = $this->conn->prepare("UPDATE Users SET username = ? WHERE user_id = ?");
        $stmt->bind_param("si", $newUsername, $userID);
        return $stmt->execute();
    }

    public function changeFullName($userID, $newFullName)
    {
        $stmt = $this->conn->prepare("UPDATE Users SET full_name = ? WHERE user_id = ?");
        $stmt->bind_param("si", $newFullName, $userID);
        return $stmt->execute();
    }

    public function loginUser($email, $password) {
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

        $stmt = $this->conn->prepare("UPDATE Users SET password = ? WHERE user_id = ?");
        $stmt->bind_param("si", $hashedPassword, $userID);
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
        $stmt = $this->conn->prepare("UPDATE Users SET profile_pic = ? WHERE user_id = ?");
        $stmt->bind_param("si", $newProfilePic, $userID);
        return $stmt->execute();
    }
}

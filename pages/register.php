<?php 
require_once '../models/User.php';

session_start();
if (isset($_SESSION['user_id']) && isset($_SESSION['islogin']) && $_SESSION['islogin'] === true) {
    header('Location: home.php');
    exit;
}

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST')  {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];
    $fullName = $_POST['fullName'];
    $gender = $_POST['gender'];
    $user = new UserModel();
    $isVerified = true;

    if (empty($username)) {
        $errors['username'] = 'Username is required';
        $isVerified = false;
    }else if (strlen($username) < 4) {
        $errors['username'] = 'Username must be at least 4 characters';
        $isVerified = false;
    }

    if (empty($email)) {
        $errors['email'] = 'Email is required';
        $isVerified = false;
    }else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Email is invalid';
        $isVerified = false;   
    }elseif ($user->checkEmailExists($email)) {
        $errors['email'] = 'Email already exists';
        $isVerified = false;
    }

    if (empty($password)) {
        $errors['password'] = 'Password is required';
        $isVerified = false;
    }else if (strlen($password) < 8) {
        $errors['password'] = 'Password must be at least 8 characters';
        $isVerified = false;
    }

    if (empty($confirmPassword)) {
        $errors['confirm_password'] = 'Confirm password is required';
        $isVerified = false;
    }else if ($password !== $confirmPassword) {
        $errors['confirm_password'] = 'Password does not match';
        $isVerified = false;
    }

    if (empty($fullName)) {
        $errors['fullName'] = 'Full name is required';
        $isVerified = false;
    } 

    if (empty($gender)) {
        $errors['gender'] = 'Gender is required';
        $isVerified = false;
    } elseif ($gender != "male" and $gender != "female") {
        $errors['gender'] = "gender is Invalid";
        $isVerified = false;
    }

    if (isset($_FILES["photo"])) {
        $allowed = [
            "jpg" => "image/jpeg",
            "jpeg" => "image/jpeg",
            "gif" => "image/gif",
            "png" => "image/png"
        ];
        $filename = $_FILES["photo"]["name"];
        $filetype = $_FILES["photo"]["type"];
        $filesize = $_FILES["photo"]["size"];
        $maxsize = 5 * 1024 * 1024; // 5MB
    
        $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        $errors['photo'] = "";
    
        if (!array_key_exists($ext, $allowed)) {
            $errors['photo'] = "Invalid file format.";
            $isVerified = false;
        } elseif (!in_array($filetype, $allowed)) {
            $errors['photo'] = "Invalid file type.";
            $isVerified = false;
        } elseif ($filesize > $maxsize) {
            $errors['photo'] = "File size exceeds the maximum limit of 5MB.";
            $isVerified = false;
        } else {
            // Generate a unique file name to avoid conflicts
            $newFilename = uniqid() . "." . $ext;
            $uploadDir = "../public/storage/";
            $uploadPath = $uploadDir . $newFilename;
    
            if ($isVerified) {
                try {
                    if (move_uploaded_file($_FILES["photo"]["tmp_name"], $uploadPath)) {
                        $photo = $newFilename;
                    } else {
                        $errors['photo'] = "Failed to move uploaded file.";
                        $isVerified = false;
                    }
                } catch (Exception $e) {
                    $errors['photo'] = "An error occurred during file upload: " . $e->getMessage();
                    $isVerified = false;
                }
            }
        }
    } else {
        $errors['photo'] = "No file uploaded.";
        $isVerified = false;
    }

    if ($isVerified) {
        $result = $user->createUser($username, $email, $password, $fullName, $gender, $photo);
        if ($result) {
            header('Location: login.php');
        } else {
            $errors['register'] = 'Failed to register';
        }

    }
    
}
require_once '../views/register_view.php';
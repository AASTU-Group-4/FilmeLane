<?php
require_once '../models/User.php';

session_start();

if (!isset($_SESSION['user_id']) || !isset($_SESSION['islogin']) || $_SESSION['islogin'] !== true) {
    header('Location: login.php');
    exit;
}

$errors = [];
$userM = new UserModel();
$user = $userM->getUserInfo($_SESSION['user_id']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $Newpassword = $_POST['Newpassword'];
    $Oldpassword = $_POST['Oldpassword'];
    $fullName = $_POST['fullName'];
    $gender = $_POST['gender'];
    $isVerified = true;


    if (empty($username)) {
        $errors['username'] = 'Username is required';
        $isVerified = false;
    } else if (strlen($username) < 4) {
        $errors['username'] = 'Username must be at least 4 characters';
        $isVerified = false;
    }

    if (empty($email)) {
        $errors['email'] = 'Email is required';
        $isVerified = false;
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Email is invalid';
        $isVerified = false;
    } elseif ($email != $user['email'] and $userM->checkEmailExists($email)) {
        $errors['email'] = 'Email already exists';
        $isVerified = false;
    }

    if (!empty($Oldpassword) or !empty($Newpassword)) {
        if (empty($Oldpassword)) {
            $errors['Oldpassword'] = 'Old password is required';
            $isVerified = false;
        } else if (!password_verify($Oldpassword, $user['password'])) {
            $errors['Oldpassword'] = 'Old password is incorrect';
            $isVerified = false;
        }

        if (empty($Newpassword)) {
            $errors['Newpassword'] = 'New password is required';
            $isVerified = false;
        } else if (strlen($Newpassword) < 8) {
            $errors['Newpassword'] = 'New password must be at least 8 characters';
            $isVerified = false;
        }
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

    if (isset($_FILES["photo"]) and $_FILES["photo"]["error"] == UPLOAD_ERR_OK and $_FILES["photo"]["name"] != $user['profile_pic']) {
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
            $newFilename = uniqid() . "." . $ext;
            $uploadDir = "../public/storage/";
            $uploadPath = $uploadDir . $newFilename;

            if ($isVerified) {
                try {
                    if (move_uploaded_file($_FILES["photo"]["tmp_name"], $uploadPath)) {
                        if (file_exists($uploadDir . $user['profile_pic'])) {
                            unlink($uploadDir . $user['profile_pic']);
                        }
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
        $photo = $user['profile_pic'];
    }

    if ($isVerified) {
        if (!empty($Newpassword)) {
            $result = $userM->UpdateUser($user['user_id'], $username, $email, $Newpassword, $fullName, $gender, $photo);
        } else {
            $result = $userM->UpdateUserNopassword($user['user_id'], $username, $email, $fullName, $gender, $photo);
        }
        if ($result) {
            $errors['update'] = 'update successfull';
            $user = $userM->getUserInfo($_SESSION['user_id']);

        } else {
            $errors['update'] = 'Failed to upadte';
        }

    } else {
        $errors['update'] = 'Failed to upadte';
    }


}


require_once '../views/update_account_view.php';
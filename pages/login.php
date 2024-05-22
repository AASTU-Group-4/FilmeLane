<?php
require_once '../models/User.php';

session_start();
if (isset($_SESSION['user_id']) && isset($_SESSION['islogin']) && $_SESSION['islogin'] === true) {
    header('Location: home.php');
    exit;
}

$errors = array();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $identifier = $_POST['identifier'];
    $password = $_POST['password'];

    if (empty($password)) {
        $errors["password"] = "Password is required.";
    }

    if (empty($identifier)) {
        $errors["identifier"] = "Email or Username is required.";
    } else {
        $identifier = htmlspecialchars($identifier, ENT_QUOTES, 'UTF-8');
        $isEmail = filter_var($identifier, FILTER_VALIDATE_EMAIL);

        if ($isEmail) {
            $user = new UserModel();
            $isLoggedIn = $user->loginUser($identifier, $password);
            if ($isLoggedIn) {
                $_SESSION['islogin'] = true;
                $_SESSION['user_id'] = $isLoggedIn['user_id'];
                header('Location: home.php');
                exit;
            } else {
                $errors["login"] = "Invalid email or password.";
            }
        } else {
            $errors["identifier"] = "Invalid email format.";
        }
    }
}

require '../views/login_view.php';


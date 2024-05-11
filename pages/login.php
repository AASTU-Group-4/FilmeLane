<?php
require_once 'module/User.php';
require 'views/login_view.php';

$errors = array();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $identifier = $_POST['identifier'];
    $password = $_POST['password'];

    if (empty($password) ) {
        $errors["password"] = "Password is required .";
    }

    if (empty($identifier)) {
        $errors["identifier"] = "Email or Username is required.";
    } else {
        $identifier = htmlspecialchars($identifier); 

        $isEmail = filter_var($identifier, FILTER_VALIDATE_EMAIL);

        if ($isEmail) {
            $user = new User();
            $isLoggedIn = $user->loginUserWithEmail($identifier, $password);

            if ($isLoggedIn) {
                session_start();
                $_SESSION['User'] = $identifier;
                header('Location: home.php');
                exit;
            } else {
                $errors["login"] = "Invalid email or password.";
            }
        } else {
            $user = new User();
            $isLoggedIn = $user->loginUserWithUsername($identifier, $password);

            if ($isLoggedIn) {
                session_start();
                $_SESSION['User'] = $identifier;
                header('Location: home.php');
                exit;
            } else {
                $errors["login"] = "Invalid username or password.";
            }
        }
    }
}
?>
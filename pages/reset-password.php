<?php

require_once '../models/User.php';

$msg = ""; 

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $token = $_GET["token"];
    $token_hash = hash("sha256", $token);

    $userModel = new UserModel();

    $user = $userModel->getUserByResetToken($token_hash);

    if ($user === null) {
        die("Token not found");
    }

    if (strtotime($user["reset_token_expires_at"]) <= time()) {
        die("Token has expired");
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = $_POST["token"];
    $token_hash = hash("sha256", $token);
    $password = $_POST["password"];
    $password_confirmation = $_POST["password_confirmation"];

    if ($password !== $password_confirmation) {
        $msg = "Passwords do not match";
    } else {
        $userModel = new UserModel();

        $user = $userModel->getUserByResetToken($token_hash);

        if ($user === null) {
            $msg = "Token not found";
        } elseif (strtotime($user["reset_token_expires_at"]) <= time()) {
            $msg = "Token has expired";
        } else {
            if ($userModel->changePassword($user['user_id'], $password)) {
                $msg = "Password successfully changed";
            } else {
                $msg = "Failed to change the password";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="../public/favicon.svg" type="image/svg+xml">
    <style>
        body {
            background-color: #121212;
            color: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .card {
            width: 100%;
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            background-color: #1f1f1f;
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        .form-control {
            background-color: #333;
            color: #fff;
            border: none;
        }
        .form-control:focus {
            background-color: #444;
            color: #fff;
            border-color: #555;
        }
        .btn-primary {
            background-color: #007bff;
            border: none;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
        .text-danger, .text-success {
            text-align: center;
        }
    </style>
</head>
<body>

<div class="card p-4">
    <h1 class="h4 mb-3 text-center">Reset Password</h1>

    <?php if ($msg): ?>
        <p class="<?= strpos($msg, 'successfully') !== false ? 'text-success' : 'text-danger' ?>"><?= htmlspecialchars($msg) ?></p>
    <?php endif; ?>

    <form method="post" action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>">
        <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">
        <div class="mb-3">
            <label for="password" class="form-label">New Password</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <div class="mb-3">
            <label for="password_confirmation" class="form-label">Repeat Password</label>
            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
        </div>
        <button type="submit" class="btn btn-primary w-100">Send</button>
        <a href="/pages/login.php" class="d-block text-center mt-3">Login</a>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.min.js"></script>
<script>
    document.querySelector('form').addEventListener('submit', function (e) {
        const password = document.getElementById('password').value;
        const passwordConfirmation = document.getElementById('password_confirmation').value;

        if (password !== passwordConfirmation) {
            e.preventDefault();
            alert("Passwords do not match");
        }
    });
</script>

</body>
</html>

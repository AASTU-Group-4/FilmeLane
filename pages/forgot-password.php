<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once '../models/User.php';

    $email = $_POST["email"];

    $userModel = new UserModel();
    $token = bin2hex(random_bytes(16));

    if ($userModel->addResetToken($email, $token)) {
        $mail = require "../includes/mailer.php";

        $mail->setFrom("yeabsirafikadu89@gmail.com");
        $mail->addAddress($email);
        $mail->Subject = "Password Reset";
        $mail->Body = <<<END
        Click <a href="http://127.0.0.1:8080/pages/reset-password.php?token=$token">here</a> 
        to reset your password.
        END;

        try {
            $mail->send();
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer error: {$mail->ErrorInfo}";
        }
    }

    $msg = "Message sent, please check your inbox.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
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
        .text-success {
            text-align: center;
        }
    </style>
</head>
<body>

<div class="card p-4">
    <h1 class="h4 mb-3 text-center">Forgot Password</h1>

    <?php if (isset($msg)): ?>
        <p class="text-success"><?= htmlspecialchars($msg) ?></p>
    <?php endif; ?>

    <form method="post" action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>">
        <div class="mb-3">
            <label for="email" class="form-label">Email address</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <button type="submit" class="btn btn-primary w-100">Send</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.min.js"></script>

</body>
</html>

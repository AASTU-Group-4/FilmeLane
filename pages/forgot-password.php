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
<html>

<head>
    <title>Forgot Password</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
    <link rel="shortcut icon" href="../public/favicon.svg" type="image/svg+xml">

</head>

<body>

    <h1>Forgot Password</h1>

    <form method="post" action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>">

        <label for="email">email</label>
        <input type="email" name="email" id="email">

        <button>Send</button>
        <?php if(isset($msg)) echo "<p>$msg</p>";?>

    </form>

</body>

</html>
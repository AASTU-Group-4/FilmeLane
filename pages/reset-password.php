<?php

require_once '../models/User.php';

$msg = ""; // Initialize message variable

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
<html>
<head>
    <title>Reset Password</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
    <style>
        .error { color: red; }
        .success { color: green; }
    </style>
</head>
<body>

<h1>Reset Password</h1>

<?php if ($msg): ?>
    <p class="<?= strpos($msg, 'successfully') !== false ? 'success' : 'error' ?>"><?= htmlspecialchars($msg) ?></p>
<?php endif; ?>

<form method="post" action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>">

    <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">

    <label for="password">New password</label>
    <input type="password" id="password" name="password" required>

    <label for="password_confirmation">Repeat password</label>
    <input type="password" id="password_confirmation" name="password_confirmation" required>

    <button type="submit">Send</button>
    <a href="/pages/login.php">Login</a>
</form>

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

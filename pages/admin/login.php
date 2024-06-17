<?php

session_start();

require_once '../../includes/db_connection.php';

$error = '';

function login($username, $password) {
    $conn = get_connection();
    $stmt = $conn->prepare('SELECT * FROM Admin WHERE username = ?');
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $admin = $result->fetch_assoc();
    $conn->close();
    
    if ($admin && password_verify($password, $admin['password'])) {
        $_SESSION['admin_id'] = $admin['admin_id'];
        $_SESSION['admin_username'] = $admin['username'];
        return true;
    } else {
        return false;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    if (login($username, $password)) {
        header('Location: index.php');
    } else {
        $error = 'Invalid username or password.';
    }
}

include 'templates/header.php';

?>



<h2>Login</h2>

<form method="post" action="">
    <label for="username">Username:</label>
    <input type="text" id="username" name="username" required>
    <br>
    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required>
    <br>
    <button type="submit">Login</button>
</form>

<p><?php echo $error; ?></p>

<?php include 'templates/footer.php'; ?>

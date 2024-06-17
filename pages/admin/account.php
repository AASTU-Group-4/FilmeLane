<?php
session_start();

if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit();
}

require_once 'templates/header.php';
require_once '../../includes/db_connection.php';

$new_username = $new_email = $new_password = $confirm_password = "";
$admin_id = $_SESSION['admin_id']; // Get the admin_id from the session

// Get current username and email
$conn = get_connection();
$sql = "SELECT username, email FROM Admin WHERE admin_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $admin_id);
$stmt->execute();
$stmt->bind_result($current_username, $current_email);
$stmt->fetch();
$stmt->close();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_username = filter_input(INPUT_POST, 'new_username', FILTER_SANITIZE_SPECIAL_CHARS);
    $new_email = filter_input(INPUT_POST, 'new_email', FILTER_SANITIZE_EMAIL);
    $new_password = $_POST["new_password"];
    $confirm_password = $_POST["confirm_password"];

    try {
        if (!empty($new_password) && $new_password === $confirm_password) {
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
            $sql = "UPDATE Admin SET password = ? WHERE admin_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("si", $hashed_password, $admin_id);
            $stmt->execute();
            $stmt->close();
        } elseif (!empty($new_password) && $new_password !== $confirm_password) {
            throw new Exception("Passwords do not match.");
        }

        if (!empty($new_username)) {
            $sql = "UPDATE Admin SET username = ? WHERE admin_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("si", $new_username, $admin_id);
            $stmt->execute();
            $stmt->close();
        }

        if (!empty($new_email)) {
            $sql = "UPDATE Admin SET email = ? WHERE admin_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("si", $new_email, $admin_id);
            $stmt->execute();
            $stmt->close();
        }

        echo "<div class='success'>Account details updated successfully.</div>";

        $sql = "SELECT username, email FROM Admin WHERE admin_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $admin_id);
        $stmt->execute();
        $stmt->bind_result($current_username, $current_email);
        $stmt->fetch();
        $stmt->close();
    } catch (Exception $e) {
        echo "<div class='error'>Error: " . $e->getMessage() . "</div>";
    }
    $conn->close();
} else {
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Manage Account</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7fa;
            padding: 20px;
        }

        h2 {
            text-align: center;
            color: #333;
        }

        form {
            max-width: 400px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-bottom: 8px;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: calc(100% - 20px);
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        input[type="submit"] {
            width: calc(100% - 20px);
            padding: 10px;
            background-color: #4caf50;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        .success {
            color: green;
            text-align: center;
            margin-bottom: 15px;
        }

        .error {
            color: red;
            text-align: center;
            margin-bottom: 15px;
        }
    </style>
</head>

<body>
    <h2>Manage Admin Account</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="new_username">New Username:</label>
        <input type="text" id="new_username" name="new_username" value="<?php echo htmlspecialchars($current_username); ?>" placeholder="Insert new username if any"><br><br>

        <label for="new_email">New Email:</label>
        <input type="email" id="new_email" name="new_email" value="<?php echo htmlspecialchars($current_email); ?>" placeholder="Insert new email if any"><br><br>

        <label for="new_password">New Password:</label>
        <input type="password" id="new_password" name="new_password" placeholder="Insert new password if any"><br><br>

        <label for="confirm_password">Confirm Password:</label>
        <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm the new password"><br><br>

        <input type="submit" value="Update Profile">
    </form>
    <?php require_once 'templates/footer.php'; ?>
</body>

</html>

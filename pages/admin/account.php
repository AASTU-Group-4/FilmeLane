<?php
require_once "templates/header.php";
require_once "../../includes/db_connection.php";

$new_username = $new_email = $new_password = $confirm_password = "";
$admin_id = 1;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_username = filter_input(INPUT_POST, 'new_username', FILTER_SANITIZE_STRING);
    $new_email = filter_input(INPUT_POST, 'new_email', FILTER_SANITIZE_EMAIL);
    $new_password = $_POST["new_password"];
    $confirm_password = $_POST["confirm_password"];

   
    if (!empty($new_password) && $new_password == $confirm_password) {
        $new_password = filter_var($new_password, FILTER_SANITIZE_STRING);
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        $sql = "UPDATE Admin SET password = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $hashed_password, $admin_id);
        $stmt->execute();
    }

    
    if (!empty($new_username)) {
        $new_username = filter_var($new_username, FILTER_SANITIZE_STRING);
        $sql = "UPDATE Admin SET username = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $new_username, $admin_id);
        $stmt->execute();
    }

  
    if (!empty($new_email)) {
        $new_email = filter_var($new_email, FILTER_SANITIZE_EMAIL);
        $sql = "UPDATE Admin SET email = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $new_email, $admin_id);
        $stmt->execute();
    }

    echo "Account details updated successfully.";
}

require_once "templates/footer.php";
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Account</title>
</head>>

<body>
    <h2>Manage Admin Account</h2>
     <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <label for="new_username">New Username:</label>
        <input type="text" id="new_username" name="new_username" placeholder="insert new username if any"><br><br>

        <label for="new_email">New Email:</label>
        <input type="email" id="new_email" name="new_email"  placeholder="insert new email if any"><br><br>

        <label for="new_password">New Password:</label>
        <input type="password" id="new_password" name="new_password" placeholder="insert new password if any"><br><br>

        <label for="confirm_password">Confirm Password:</label>
        <input type="password" id="confirm_password" name="confirm_password"  placeholder="confirm the new password"><br><br>

        <input type="submit" value="Update Profile">
    </form>
</body>
</html>
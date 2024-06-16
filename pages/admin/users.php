<?php
require_once "../../includes/db_connection.php";

function fetch_all_users() {
    $conn = get_connection();
    $sql = "SELECT id, username, email FROM Users";
    $result = $conn->query($sql);
    $users = [];

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $users[] = $row;
        }
    }

    $conn->close();
    return $users;
}

if (isset($_POST['update_user'])) {
    $id = $_POST['id'];
    $username = $_POST['username'];
    $email = $_POST['email'];

    $conn = get_connection();
    $stmt = $conn->prepare("UPDATE Users SET username = ?, email = ? WHERE id = ?");
    $stmt->bind_param("ssi", $username, $email, $id);

    if ($stmt->execute()) {
        echo "User updated successfully.";
    } else {
        echo "Error updating user: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
}

if (isset($_GET['delete_user'])) {
    $id = $_GET['id'];

    $conn = get_connection();
    $stmt = $conn->prepare("DELETE FROM Users WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "User deleted successfully.";
    } else {
        echo "Error deleting user: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
}

$users = fetch_all_users();
?>

<?php require_once "templates/header.php";
 ?>

    <h1>User Management</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($users) > 0): ?>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <form method="post">
                            <td><?php echo htmlspecialchars($user['id']); ?></td>
                            <td><input type="text" name="username" value="<?php echo htmlspecialchars($user['username']); ?>"></td>
                            <td><input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>"></td>
                            <td class="actions">
                                <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
                                <button type="submit" name="update_user">Save</button>
                                <a href="?delete_user=1&id=<?php echo $user['id']; ?>" onclick="return confirm('Are you sure you want to delete this user?');">Delete</a>
                            </td>
                        </form>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4">No users found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

<?php require_once "templates/footer.php"; ?>

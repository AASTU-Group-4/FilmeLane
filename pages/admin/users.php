<?php
require_once "templates/header.php";
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
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - User Management</title>
    <style>
        body {
            background-color: #fff;
            color: #ffdd00;
            font-family: Arial, sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ffdd00;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #ffdd00;
            color: #000;
        }
        .actions a {
            margin-right: 10px;
            color: #ffdd00;
            text-decoration: none;
            background: none;
            border: none;
            cursor: pointer;
        }
        .actions a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
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
                        <td><?php echo htmlspecialchars($user['id']); ?></td>
                        <td><?php echo htmlspecialchars($user['username']); ?></td>
                        <td><?php echo htmlspecialchars($user['email']); ?></td>
                        <td class="actions">
                            <a href="?delete_user=1&id=<?php echo $user['id']; ?>" onclick="return confirm('Are you sure you want to delete this user?');">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4">No users found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>
<?php require_once "templates/footer.php"; ?>

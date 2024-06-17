<?php 
require_once "templates/header.php";
require_once "../../includes/db_connection.php";

$user_id = isset($_GET['user_id']) ? $_GET['user_id'] : '';

if ($user_id) {
    $sql = "SELECT u.username, uh.user_id, uh.movie_id, uh.watched_date, uh.duration
            FROM UserHistory uh
            JOIN Users u ON uh.user_id = u.id
            WHERE uh.user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $sql = "SELECT u.username, uh.user_id, uh.movie_id, uh.watched_date, uh.duration
            FROM UserHistory uh
            JOIN Users u ON uh.user_id = u.id";
    $result = $conn->query($sql);
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Filmlane - Best movie collections</title>
    <link rel="stylesheet" href="css/User_history_Style.css">
</head>
<body>
    <div class="container">
        <h2>User History</h2>
        <form method="GET" action="user_history.php">
            <label for="user_id">Enter User ID:</label>
            <input type="text" id="user_id" name="user_id" value="<?php echo htmlspecialchars($user_id); ?>">
            <button type="submit">Search</button>
        </form>
        <table>
            <thead>
                <tr>
                    <th>User ID</th>
                    <th>Username</th>
                    <th>Movie ID</th>
                    <th>Watched Date</th>
                    <th>Duration</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>".$row["user_id"]."</td>";
                        echo "<td>".$row["username"]."</td>";
                        echo "<td>".$row["movie_id"]."</td>";
                        echo "<td>".$row["watched_date"]."</td>";
                        echo "<td>".$row["duration"]."</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>No user history found.</td></tr>";
                }
                ?>
            </tbody>
        </table> 
    </div>
    <?php 
    require_once "templates/footer.php";
    $conn->close();
    ?>
</body>
</html>

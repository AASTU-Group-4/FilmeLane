<?php

session_start();

if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

require_once "templates/header.php";
require_once "../../includes/db_connection.php";

$conn = get_connection();

$user_id = filter_input(INPUT_GET, 'user_id', FILTER_SANITIZE_NUMBER_INT);

if ($user_id) {
    $sql = "SELECT u.username, uh.user_id, uh.movie_id, uh.date_watched, uh.type
            FROM UserHistory uh
            JOIN Users u ON uh.user_id = u.user_id
            WHERE uh.user_id = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Error preparing the statement: " . $conn->error);
    }
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $sql = "SELECT u.username, uh.user_id, uh.movie_id, uh.date_watched, uh.type
            FROM UserHistory uh
            JOIN Users u ON uh.user_id = u.user_id";
    $result = $conn->query($sql);
    if ($result === false) {
        die("Error executing the query: " . $conn->error);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Filmlane - Best Movie Collections</title>
    <style>
        /* General Styles */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7fa;
            margin: 0;
            padding: 20px;
        }

        .header {
            background-color: #333;
            color: white;
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo img {
            height: 40px; /* Adjust height as needed */
            vertical-align: middle;
        }

        .navbar ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }

        .navbar ul li {
            display: inline-block;
            margin-right: 20px;
        }

        .navbar ul li a {
            color: white;
            text-decoration: none;
            font-weight: bold;
            font-size: 16px;
        }

        .navbar ul li a:hover {
            color: #ffc107; /* Change color on hover as needed */
        }

        .highlight {
            background-color: #ffc107; /* Highlight background color */
            padding: 2px 6px; /* Adjust padding as needed */
            border-radius: 10px; /* Rounded corners */
            color: #333; /* Text color */
            font-weight: bold; /* Bold text */
        }

        .highlight-movie {
            background-color: #4CAF50; /* Green background for 'movie' */
        }

        .highlight-tv {
            background-color: #fde55e; /* Yellow background for 'tv' */
        }

        .highlight-other {
            background-color: #FF6347; /* Red background for other types */
        }

        /* Table Styles */
        .styled-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .styled-table th,
        .styled-table td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #e5e5e5;
        }

        .styled-table th {
            background-color: #c0ca68;
            border-bottom: 2px solid #e5e5e5;
        }

        .styled-table tr {
            background-color: #f1f1f1;
        }

        /* Footer Styles */
        .footer {
            background-color: #20232a;
            color: #ffffff;
            padding: 20px 0;
            position: relative;
            bottom: 0;
            width: 100%;
        }

        .footer-top {
            padding: 20px 0;
        }

        .footer .container {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .footer-brand-wrapper {
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 100%;
            max-width: 800px;
        }

        .footer .logo img {
            height: 40px;
        }

        .footer-list {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
        }

        .footer-list li {
            margin: 0 10px;
        }

        .footer-link {
            color: #ffffff;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .footer-link:hover {
            color: #61dafb;
        }

        .divider {
            width: 80%;
            height: 1px;
            background-color: #ffffff;
            margin: 20px 0;
        }

        .quicklink-wrapper {
            display: flex;
            justify-content: center;
            width: 100%;
        }

        .social-list {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
        }

        .social-list li {
            margin: 0 10px;
        }

        .social-link {
            color: #ffffff;
            text-decoration: none;
            font-size: 24px;
            transition: color 0.3s ease;
        }

        .social-link:hover {
            color: #61dafb;
        }

        /* Responsive Styles */
        @media (max-width: 768px) {
            .footer-brand-wrapper {
                flex-direction: column;
                align-items: center;
            }

            .footer-list {
                flex-direction: column;
                align-items: center;
            }

            .footer-list li {
                margin: 5px 0;
            }

            .divider {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>User History</h2>
        <form method="GET" action="user_history.php">
            <label for="user_id">Enter User ID:</label>
            <input type="text" id="user_id" name="user_id" value="<?php echo htmlspecialchars($user_id ?? ''); ?>">
            <button type="submit">Search</button>
        </form>
        <table class="styled-table">
            <thead>
                <tr>
                    <th>User ID</th>
                    <th>Username</th>
                    <th>Movie ID</th>
                    <th>Watched Date</th>
                    <th>Type</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row["user_id"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["username"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["movie_id"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["date_watched"]) . "</td>";
                        echo "<td class='highlight ";
                        if ($row["type"] == "movie") {
                            echo "highlight-movie";
                        } elseif ($row["type"] == "tv") {
                            echo "highlight-tv";
                        } else {
                            echo "highlight-other";
                        }
                        echo "'>" . htmlspecialchars($row["type"]) . "</td>";
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
    ?>
</body>
</html>

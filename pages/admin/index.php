<?php
session_start();

if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit();
}

require_once '../../includes/db_connection.php';

// Fetch summary data
function fetch_summary_data() {
    $conn = get_connection();
    $data = [];

    // Total Users
    $result = $conn->query("SELECT COUNT(*) AS total_users FROM Users");
    $data['total_users'] = $result->fetch_assoc()['total_users'];

    // Total Movies Watched
    $result = $conn->query("SELECT COUNT(*) AS total_watched FROM UserHistory");
    $data['total_watched'] = $result->fetch_assoc()['total_watched'];

    // Total Watchlist Entries
    $result = $conn->query("SELECT COUNT(*) AS total_watchlist FROM UserWatchlist");
    $data['total_watchlist'] = $result->fetch_assoc()['total_watchlist'];

    // Active Users (example: users logged in within last 30 days)
    $result = $conn->query("SELECT COUNT(*) AS active_users FROM Users WHERE updated_at >= NOW() - INTERVAL 30 DAY");
    $data['active_users'] = $result->fetch_assoc()['active_users'];

    $conn->close();
    return $data;
}

// Fetch recent activities
function fetch_recent_activities() {
    $conn = get_connection();
    $activities = [];

    // Recent sign-ups
    $result = $conn->query("SELECT username, created_at FROM Users ORDER BY created_at DESC LIMIT 5");
    while ($row = $result->fetch_assoc()) {
        $activities[] = "User '{$row['username']}' signed up at {$row['created_at']}";
    }

    // Recently watched movies
    $result = $conn->query("SELECT U.username, UH.movie_id, UH.date_watched FROM UserHistory UH JOIN Users U ON UH.user_id = U.user_id ORDER BY UH.date_watched DESC LIMIT 5");
    while ($row = $result->fetch_assoc()) {
        $activities[] = "User '{$row['username']}' watched movie '{$row['movie_id']}' at {$row['date_watched']}";
    }

    // Recent additions to watchlists
    $result = $conn->query("SELECT U.username, UW.movie_id, UW.added_at FROM UserWatchlist UW JOIN Users U ON UW.user_id = U.user_id ORDER BY UW.added_at DESC LIMIT 5");
    while ($row = $result->fetch_assoc()) {
        $activities[] = "User '{$row['username']}' added movie '{$row['movie_id']}' to watchlist at {$row['added_at']}";
    }

    $conn->close();
    return $activities;
}

// Generate CSV report
function generateCSV($filename, $data) {
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment;filename=' . $filename);

    $output = fopen('php://output', 'w');
    // Add BOM to fix UTF-8 in Excel
    fputs($output, $bom = (chr(0xEF) . chr(0xBB) . chr(0xBF)));

    foreach ($data as $row) {
        fputcsv($output, $row);
    }
    fclose($output);
    exit();
}

// Handle report generation
if (isset($_POST['generate_report'])) {
    $reportType = $_POST['report_type'];
    $conn = get_connection();

    if ($reportType == 'users') {
        $query = "SELECT * FROM Users";
        $result = $conn->query($query);
        if ($result->num_rows > 0) {
            $data = [['user_id', 'username', 'email', 'full_name', 'gender', 'created_at', 'updated_at']];
            while ($row = $result->fetch_assoc()) {
                $data[] = [$row['user_id'], $row['username'], $row['email'], $row['full_name'], $row['gender'], $row['created_at'], $row['updated_at']];
            }
            generateCSV('users_report.csv', $data);
        }
    } elseif ($reportType == 'user_history') {
        $query = "SELECT * FROM UserHistory";
        $result = $conn->query($query);
        if ($result->num_rows > 0) {
            $data = [['history_id', 'user_id', 'movie_id', 'date_watched', 'type']];
            while ($row = $result->fetch_assoc()) {
                $data[] = [$row['history_id'], $row['user_id'], $row['movie_id'], $row['date_watched'], $row['type']];
            }
            generateCSV('user_history_report.csv', $data);
        }
    } elseif ($reportType == 'watchlist') {
        $query = "SELECT * FROM UserWatchlist";
        $result = $conn->query($query);
        if ($result->num_rows > 0) {
            $data = [['watchlist_id', 'user_id', 'movie_id', 'added_at', 'type']];
            while ($row = $result->fetch_assoc()) {
                $data[] = [$row['watchlist_id'], $row['user_id'], $row['movie_id'], $row['added_at'], $row['type']];
            }
            generateCSV('watchlist_report.csv', $data);
        }
    }

    $conn->close();
}

$summary_data = fetch_summary_data();
$recent_activities = fetch_recent_activities();

include 'templates/header.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>

        .header {
            background-color: #333;
            color: #fff;
            padding: 10px 0;
            text-align: center;
        }
        .header .nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 20px;
        }
        .header .nav a {
            color: #fff;
            text-decoration: none;
            margin: 0 10px;
        }
        .header .nav a:hover {
            text-decoration: underline;
        }
        .content {
            padding: 20px;
        }
        .summary-cards {
            display: flex;
            justify-content: space-around;
            margin-bottom: 20px;
        }
        .summary-card {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 22%;
            text-align: center;
        }
        .summary-card .icon {
            font-size: 2em;
            margin-bottom: 10px;
        }
        .summary-card .metric {
            font-size: 1.5em;
            margin-bottom: 10px;
        }
        .summary-card .description {
            font-size: 1em;
            color: #555;
        }
        .recent-activities, .user-management, .reports, .admin-tools {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }
        .section-title {
            font-size: 1.2em;
            margin-bottom: 10px;
        }
        .activities-list, .management-buttons, .report-buttons, .tools-buttons {
            list-style: none;
            padding: 0;
        }
        .activities-list li, .management-buttons a, .report-buttons button, .tools-buttons a {
            margin-bottom: 10px;
        }
        .management-buttons a, .report-buttons button, .tools-buttons a {
            display: inline-block;
            padding: 10px;
            background-color: #333;
            color: #fff;
            text-decoration: none;
            border-radius: 4px;
        }
        .management-buttons a:hover, .report-buttons button:hover, .tools-buttons a:hover {
            background-color: #555;
        }
    </style>
</head>
<body>
    <div class="content">
        <div class="summary-cards">
            <div class="summary-card">
                <div class="icon">👤</div>
                <div class="metric"><?php echo $summary_data['total_users']; ?></div>
                <div class="description">Total Users</div>
            </div>
            <div class="summary-card">
                <div class="icon">🎬</div>
                <div class="metric"><?php echo $summary_data['total_watched']; ?></div>
                <div class="description">Movies Watched</div>
            </div>
            <div class="summary-card">
                <div class="icon">📋</div>
                <div class="metric"><?php echo $summary_data['total_watchlist']; ?></div>
                <div class="description">Watchlist Entries</div>
            </div>
            <div class="summary-card">
                <div class="icon">✅</div>
                <div class="metric"><?php echo $summary_data['active_users']; ?></div>
                <div class="description">Active Users</div>
            </div>
        </div>

        <div class="recent-activities">
            <div class="section-title">Recent Activities</div>
            <ul class="activities-list">
                <?php foreach ($recent_activities as $activity): ?>
                    <li><?php echo htmlspecialchars($activity); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>

        <div class="user-management">
            <div class="section-title">User Management Shortcuts</div>
            <div class="management-buttons">
                <a href="users.php">Manage Users</a>
                <a href="user_history.php">View User History</a>
                <a href="watchlist.php">Manage Watchlists</a>
            </div>
        </div>

        <div class="reports">
            <div class="section-title">Reports</div>
            <form method="POST" action="index.php">
                <label for="report_type">Select Report Type:</label>
                <select name="report_type" id="report_type" required>
                    <option value="users">Users</option>
                    <option value="user_history">User History</option>
                    <option value="watchlist">Watchlist</option>
                </select>
                <button type="submit" name="generate_report">Generate Report</button>
            </form>
        </div>

        <div class="admin-tools">
            <div class="section-title">Admin Tools</div>
            <div class="tools-buttons">
                <a href="account.php">Account Management</a>
                <a href="tools.php">Other Tools</a>
            </div>
        </div>
    </div>
</body>
</html>

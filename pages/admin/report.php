<?php
// Start the session
session_start();

// Include the header
include '../../templates/header.php';

// Check if the admin is logged in
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit();
}

// Database connection
require_once '../../includes/db_connection.php';

// Function to generate CSV file
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

// Check if form is submitted
if (isset($_POST['generate_report'])) {
    $reportType = $_POST['report_type'];
    $conn = get_connection();

    if ($reportType == 'users') {
        // Fetch users data
        $query = "SELECT * FROM Users";
        $result = $conn->query($query);

        if ($result->num_rows > 0) {
            $data = [];
            // Column headers
            $data[] = ['user_id', 'username', 'email', 'full_name', 'gender', 'created_at', 'updated_at'];

            // Fetch rows
            while ($row = $result->fetch_assoc()) {
                $data[] = [$row['user_id'], $row['username'], $row['email'], $row['full_name'], $row['gender'], $row['created_at'], $row['updated_at']];
            }

            // Generate CSV
            generateCSV('users_report.csv', $data);
        }
    } elseif ($reportType == 'user_history') {
        // Fetch user history data
        $query = "SELECT * FROM UserHistory";
        $result = $conn->query($query);

        if ($result->num_rows > 0) {
            $data = [];
            // Column headers
            $data[] = ['history_id', 'user_id', 'movie_id', 'date_watched', 'type'];

            // Fetch rows
            while ($row = $result->fetch_assoc()) {
                $data[] = [$row['history_id'], $row['user_id'], $row['movie_id'], $row['date_watched'], $row['type']];
            }

            // Generate CSV
            generateCSV('user_history_report.csv', $data);
        }
    } elseif ($reportType == 'watchlist') {
        // Fetch watchlist data
        $query = "SELECT * FROM UserWatchlist";
        $result = $conn->query($query);

        if ($result->num_rows > 0) {
            $data = [];
            // Column headers
            $data[] = ['watchlist_id', 'user_id', 'movie_id', 'added_at', 'type'];

            // Fetch rows
            while ($row = $result->fetch_assoc()) {
                $data[] = [$row['watchlist_id'], $row['user_id'], $row['movie_id'], $row['added_at'], $row['type']];
            }

            // Generate CSV
            generateCSV('watchlist_report.csv', $data);
        }
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Generate Report</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="container">
        <h1>Generate Report</h1>
        <form method="POST" action="report.php">
            <label for="report_type">Select Report Type:</label>
            <select name="report_type" id="report_type" required>
                <option value="users">Users</option>
                <option value="user_history">User History</option>
                <option value="watchlist">Watchlist</option>
            </select>
            <button type="submit" name="generate_report">Generate Report</button>
        </form>
    </div>
    <script src="../js/script.js"></script>
</body>
</html>

<?php
// Include the footer
include '../../templates/footer.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Watchlist </title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    
  </head>
<body>
<header class="header">
    <div class="logo">
    <img src="../../public/images/logo.svg" alt="Filmlane Logo">
    </div>
    <nav class="navbar">
        <ul>
        <li><a href="index.php">Home</a></li>
            <li><a href="users.php">Users</a></li>
            <li><a href="user_history.php">User History</a></li>
            <li><a href="watchlist.php">Watchlist</a></li>
            <li><a href="report.php">Reports</a></li>
            <li><a href="account.php">Account</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </nav>
</header>

<h2>Watchlist</h2>


<?php

 function get_connection() {
     $servername = "localhost";
     $username = "root";
     $password = "Yelakew26@aa";
     $dbname = "testfilmlane";
 
     $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: ". $conn->connect_error);
    }
     
     return $conn;
 }
 $conn = get_connection();

 // Query to retrieve data from the UserWatchlist table
$query = "SELECT u.username, uw.movie_id, uw.added_at, uw.type 
           FROM UserWatchlist uw 
           JOIN Users u ON uw.user_id = u.user_id";

$result = $conn->query($query);
// Check if there are results

if ($result === false) {
  echo "Error: " . $conn->error;
} else {
  // Check if there are results
  
if ($result->num_rows > 0) {
  // Display the table

echo '<div class="table-container">';
echo '<table class="styled-table">';
echo '<thead>';
echo '<tr><th>Username</th><th>Movie ID</th><th>Added At</th><th>Type</th></tr>';
echo '</thead>';
echo '<tbody>';

while ($row = $result->fetch_assoc()) {
    echo '<tr>';
    echo '<td>' . $row['username'] . '</td>';
    echo '<td>' . $row['movie_id'] . '</td>';
    echo '<td>' . $row['added_at'] . '</td>';
    $highlightClass = '';
    switch ($row['type']) {
        case 'movie':
            $highlightClass = 'highlight-movie';
            break;
        case 'tv':
            $highlightClass = 'highlight-tv';
            break;
        default:
            $highlightClass = 'highlight-other';
            break;
    }
    echo '<td><span class="highlight">' . $row['type'] . '</span></td>'; // Add span with class 'highlight'
    echo '</tr>';
}

echo '</tbody>';
echo '</table>';
echo '</div>';

} else {
    echo "No results found";
}
}
// Close the database connection
$conn->close();


?>
</body>


<footer class="footer">

        <div class="footer-top">
            <div class="container">

                <div class="footer-brand-wrapper">

                    <a href="" class="logo">
                        <img src="/public/images/logo.svg" alt="Filmlane logo">
                    </a>

                    <ul class="footer-list">

                        <li>
                            <a href="./index.html" class="footer-link">Home</a>
                        </li>

                        <li>
                            <a href="#" class="footer-link">Movie</a>
                        </li>

                        <li>
                            <a href="#" class="footer-link">TV Show</a>
                        </li>

                        <li>
                            <a href="#" class="footer-link">Web Series</a>
                        </li>

                    </ul>

                </div>

                <div class="divider"></div>

                <div class="quicklink-wrapper">

                    <ul class="social-list">

                        <li>
                            <a href="#" class="social-link">
                                <ion-icon name="logo-facebook"></ion-icon>
                            </a>
                        </li>

                        <li>
                            <a href="#" class="social-link">
                                <ion-icon name="logo-twitter"></ion-icon>
                            </a>
                        </li>

                        <li>
                            <a href="#" class="social-link">
                                <ion-icon name="logo-pinterest"></ion-icon>
                            </a>
                        </li>

                        <li>
                            <a href="#" class="social-link">
                                <ion-icon name="logo-linkedin"></ion-icon>
                            </a>
                        </li>

                    </ul>

                </div>

            </div>
        </div>

    </footer>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>


</html>
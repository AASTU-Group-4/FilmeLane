<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard: Watchlist </title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    
  </head>
<body>
<?php
// Include the footer
include 'templates/header.php';
?>


<h3>Watchlist</h3>

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


<?php
// Include the footer
include 'templates/footer.php';
?>
</html>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Filmlane - Best movie collections</title>

</head>
<body>



<?php
require_once '../../includes/db_connection.php';
// Query to retrieve data from the UserWatchlist table
$query = "SELECT u.username, uw.movie_id, uw.added_at, uw.type 
           FROM UserWatchlist uw 
           JOIN Users u ON uw.user_id = u.user_id";

$result = $conn->query($query);
// Check if there are results
if ($result->num_rows > 0) {
  // Display the table
  echo '<table border="1" cellpadding="5" cellspacing="0">';
  echo '<tr><th>Username</th><th>Movie ID</th><th>Added At</th><th>Type</th></tr>';
  while($row = $result->fetch_assoc()) {
      echo '<tr>';
      echo '<td>' . $row['username'] . '</td>';
      echo '<td>' . $row['movie_id'] . '</td>';
      echo '<td>' . $row['added_at'] . '</td>';
      echo '<td>' . $row['type'] . '</td>';
      echo '</tr>';
  }
  echo '</table>';
} else {
    echo "No results found";
}

// Close the database connection
$conn->close();


?>
</body>
<footer>
  <!-- <p>Copyright &copy; 2022 Filmlane</p> -->
</footer>
<?php 
require_once "templates/header.php";
require_once "../../includes/db_connection.php";
$sql = "SELECT u.username, uh.user_id, uh.movie_id, uh.watched_date, uh.duration
        FROM UserHistory uh
        JOIN Users u ON uh.user_id = u.id";
$result = $conn->query($sql);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Filmlane - Best movie collections</title>
</head>
<body>
   <table>
    <thead>
        <tr>
            <th>User ID </th>
            <th> Username </th>
            <th>Movie ID </th>
            <th>Watched Date</th>
            <th>Type</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                echo "<tr>";
                echo "<td>".$row["user_id"]."</td>";
                echo "<td>".$row["username"]."</td>";
                echo "<td>".$row["movie_id"]."</td>";
                echo "<td>".$row["date_watched"]."</td>";
                echo "<td>".$row["type"]."</td>";
                echo "</tr>";
                }

        } else{
            echo "<tr><td> colspan='4'> No user history found.</td></tr>";
        }
        ?>
    </tbody>
   </table> 
   <?php 
   require_once "templates/footer.php";
   $conn->close();
   ?>
</body>
</html>
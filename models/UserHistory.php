<?php

// import function to establish connection
require_once 'FilmeLane\includes\db_connection.php';

// add new record to user's watch history
function addToHistory($userId, $movieId, $dateWatched) {
    // Connect to the database
    $conn = get_connection();
    // Prepare the SQL statement with parameter placeholders
    $sql = "INSERT INTO UserHistory (user_id, movie_id, date_watched) VALUES (?, ?, ?)";

    // Prepare the statement
    $stmt = mysqli_prepare($conn, $sql);
    
    // Bind parameters to the prepared statement
    mysqli_stmt_bind_param($stmt, "sss", $userId, $movieId, $dateWatched);
    
    // Execute the prepared statement
    mysqli_stmt_execute($stmt);

    // Close the statement and the database connection
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}


// display full watch history of a user
function getHistory($userId) { 

    try{
    // Connect to the database
    $conn = get_connection();
    // Prepare the SQL statement with parameter placeholders
    $sql = "SELECT * FROM UserHistory WHERE user_id = ? ORDER BY date_watched DESC";

    // Prepare the statement
    $stmt = mysqli_prepare($conn, $sql);
    if (!$stmt) {
        throw new Exception("Failed to prepare statement: " . mysqli_error($conn));
    }
    
    // Bind the user_id parameter to the prepared statement
    mysqli_stmt_bind_param($stmt, "s", $userId);
    
    // Execute the prepared statement
    if (!mysqli_stmt_execute($stmt)) {
            throw new Exception("Failed to execute statement: " . mysqli_stmt_error($stmt));
        }
    
    // Get the result set
    $result = mysqli_stmt_get_result($stmt);
    
    // Fetch all rows from the result set
    $history = mysqli_fetch_all($result, MYSQLI_ASSOC);

    // Close the statement and the database connection
    mysqli_stmt_close($stmt);
    mysqli_close($conn);

    // Return the history data
    return $history;
    }
    catch (Exception $e) {
        // Handle the error
        echo "Error: " . $e->getMessage();
        return array(); // or some default value
    }
}

if (isset($_POST['clearHistory'])) {
    $userId = $_SESSION['user_id'];
    clearHistory($userId);
    header('Location: history_view.php'); // redirect back to history view page
    exit;
}

// delete all watch history for a user
function clearHistory($userId) {
    // Connect to the database
    $conn = get_connection();
    // Prepare the SQL statement with parameter placeholders
    $sql = "DELETE FROM UserHistory WHERE user_id = ?";

    // Prepare the statement
    $stmt = mysqli_prepare($conn, $sql);
    
    // Bind the user_id parameter to the prepared statement
    mysqli_stmt_bind_param($stmt, "s", $userId);
    
    // Execute the prepared statement
    mysqli_stmt_execute($stmt);

    // Close the statement and the database connection
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}

// remove a single watch history of a user
function removeFromHistory($userId, $movieId) {
    // Connect to the database
    $conn = get_connection();
    // Prepare the SQL statement with parameter placeholders
    $sql = "DELETE FROM UserHistory WHERE user_id = ? AND movie_id = ?";

    // Prepare the statement
    $stmt = mysqli_prepare($conn, $sql);
    
    // Bind the user_id and movie_id parameters to the prepared statement
    mysqli_stmt_bind_param($stmt, "ss", $userId, $movieId);
    
    // Execute the prepared statement
    mysqli_stmt_execute($stmt);

    // Close the statement and the database connection
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
?>
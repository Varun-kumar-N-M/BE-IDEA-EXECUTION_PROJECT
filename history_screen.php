<?php
session_start();
include 'includes/db.php'; // Include the database connection file

// Check if username is provided in the URL
if(isset($_POST["username"])){
    $username = $_POST["username"];

    // Retrieve game history for the specified username
    $query = "SELECT * FROM game_history WHERE username='$username'";
    $result = execute_query($query); // Assuming execute_query() is a function in db.php
    // Display the game history
    echo"Hello $username<br><br>";
    while($row = $result->fetch_assoc()) {
        echo " - Winner: " . $row["winner"]. " - Date & Time: " . $row["date_time"]. "<br>";
    }
} else {
    echo "No username provided.";
}
?>

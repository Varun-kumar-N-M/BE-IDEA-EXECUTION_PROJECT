<?php
session_start(); // Start the session to store game state
include 'includes/db.php'; // Include the database connection file

// Initialize variables
$winner = null;

// Reset the game if the page is refreshed
if (!isset($_POST['pick_coins']) && !isset($_SESSION['totalCoins'])) {
    $_SESSION['totalCoins'] = 0;
    $humanChoice = null;
    $aiChoice = null;
}

// Check if the form is submitted and human has made a choice
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['pick_coins'])) {
    // Get human's choice
    $humanChoice = intval($_POST['coins']);
    
    // Update total coins picked
    $_SESSION['totalCoins'] += $humanChoice;

    // Check if human has picked the last coin
    if ($_SESSION['totalCoins'] >= 21) {
        $winner = "AI"; // Human wins
        $_SESSION['totalCoins'] = 0; // Reset total coins
    } else {
        // AI player's turn
        $aiChoice = 5 - $humanChoice; // AI picks the number of coins to make total remaining a multiple of 5
        
        // Update total coins picked
        $_SESSION['totalCoins'] += $aiChoice;

        // Check if AI has picked the last coin
        if ($_SESSION['totalCoins'] >= 21) {
            $winner = "Human"; // AI wins
            $_SESSION['totalCoins'] = 0; // Reset total coins
        }
    }

    // Insert game history into the database
    if ($winner !== null) {
        $username = $_SESSION['username']; // Assuming you have stored the username in session
        $currentDateTime = date("Y-m-d H:i:s");
        $insert_query = "INSERT INTO game_history (username, winner, date_time) VALUES ('$username', '$winner', '$currentDateTime')";
        $result = execute_query($insert_query); // Assuming execute_query() is a function in db.php
        if (!$result) {
            // Error handling
            echo "Error: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coin Game</title>
    <style>
        body {
            text-align: center;
            font-family: Arial, sans-serif;
        }
        .container {
            margin: 0 auto;
            max-width: 600px;
        }
        .game-container {
            margin-top: 50px;
        }
        .result {
            font-weight: bold;
            margin-top: 20px;
        }
    </style>
    <script>
        // Disable form submission on page refresh
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
    </script>
</head>
<body>
    <div class="container">
        <div class="game-container">
            <h2>Game Play</h2>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <label for="coins">Pick coins (1-4):</label>
                <input type="number" name="coins" id="coins" min="1" max="4" required>
                <button type="submit" name="pick_coins" class="green-button">Pick</button>
            </form>
            <?php if (isset($humanChoice)) { ?>
                <p>Human picked <?php echo $humanChoice; ?> coin(s)</p>
                <p>AI picked <?php echo isset($aiChoice) ? $aiChoice : ''; ?> coin(s)</p>
                <p>Total coins picked: <?php echo $_SESSION['totalCoins']; ?></p>
            <?php } ?>
            <?php if ($winner !== null) { ?>
                <div class="result" style="color:red;">
                    <?php echo $winner; ?> picked the last coin. <?php echo $winner === 'AI' ? 'AI wins!' : 'Human wins!'; ?>
                </div>
            <?php } ?>
        </div>
        <br>
        <form action="history_screen.php" method="post">
            <input type="hidden" name="username" value="<?php echo $_SESSION['username'];?>">
            <button type="submit" name="viewhistory">View History</button>
        </form>
    </div>
</body>
</html>

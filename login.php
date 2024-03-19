<?php
session_start();
include 'includes/db.php'; // Include the database connection file

// Handle registration if registration form data is received
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["register"])) {
    // Sanitize and validate registration input fields
    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);
    $email = trim($_POST["email"]);
    $phone_number = $_POST["phone_number"];
      
    // Check if any required field is empty
    if (empty($username) || empty($password) || empty($email) || empty($phone_number) ) {
        $error = "All fields are required.";
    } else {
        

        // Check if the username or email already exists in the database
        $existing_user_query = "SELECT * FROM users WHERE username='$username' OR email='$email'";
        $existing_user_result = execute_query($existing_user_query);

        if ($existing_user_result->num_rows > 0) {
            $error = "Username or email already exists. Please choose a different one.";
        } else {
            // Insert user data into the database
            $insert_query = "INSERT INTO users (username, password, email, phone_number) VALUES ('$username', '$password', '$email', '$phone_number')";
            if (execute_query($insert_query)) {
                $message = "Registration successful. Please log in.";
            } else {
                $error = "Registration failed. Please try again later.";
            }
        }
    }
}


// Handle login
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["login"])) {
    // Sanitize and validate login input fields
    $username_or_email = trim($_POST["username_or_email"]);
    $password = trim($_POST["password"]);

    // Check if any required field is empty
    if (empty($username_or_email) || empty($password)) {
        $error = "Username/email and password are required.";
    } else {

        // Query to check if the user exists
        $login_query = "SELECT * FROM users WHERE (username='$username_or_email' OR email='$username_or_email') AND password='$password'";
        $login_result = execute_query($login_query);

        if ($login_result->num_rows == 1) {
            // User found, start session and log in
            $_SESSION["username"] = $username_or_email;
            header("Location: game_play.php"); // Redirect to game_play.php
            exit();
        } else {
            // Invalid username/email or password, display error message
            $error = "Invalid username/email or password.";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class="login-container">
        <h2>Login</h2>
        <form action="" method="post">
            <input type="text" name="username_or_email" placeholder="Username or Email" required><br><br>
            <input type="password" name="password" placeholder="Password" required><br><br>
            <button type="submit" name="login">Login</button>
        </form>
        <?php if (isset($error)) echo '<div class="error">' . $error . '</div>'; ?>
    </div>
</body>
</html>

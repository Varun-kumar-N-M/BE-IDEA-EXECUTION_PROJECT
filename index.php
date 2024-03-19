<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class="register-container" style="text-align: center;">
        <h2>Register</h2>
        <form action="login.php" method="post">
            <input type="text" name="username" placeholder="Username" required><br><br>

            <input type="password" name="password" placeholder="Password" required><br><br>

            <input type="email" name="email" placeholder="Email" required><br><br>

            <input type="text" name="phone_number" placeholder="Phone Number" required><br><br>
            
            <button type="submit" name="register">Register</button>
        </form>
    </div>
</body>
</html>

<?php
require_once 'db.php';

if (isset($_POST['username']) && isset($_POST['email']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format";
    } else {
        // Query to insert user into database
        $sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $username, $email, password_hash($password, PASSWORD_DEFAULT));
        $stmt->execute();

        // Redirect to login page
        header("Location: login.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/png" href="ktv_logo.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="login_styles.css">
</head>
<body>
    <div class="container">
        <div class="left">
            <div class="signup-content">
                <button class="button" onclick="location.href='index.php'">Home</button>
                <h1>Create Account</h1>
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                    <label for="username">Username:</label>
                    <input type="text" id="username" name="username" required>
                    <label for="email">Email address:</label>
                    <input type="text" id="email" name="email" required>
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" required>
                    <input type="submit" value="Sign up">
                </form>
                <?php if (isset($error)) { echo "<p class='error'>$error</p>"; } ?>
                <p>Already have an account? <a href="login.php">Login</a></p>
            </div>
        </div>
        <div class="right">
            <div class="background-image"></div>
        </div>
    </div>
</body>
</html>

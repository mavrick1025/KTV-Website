<?php
session_start();

// Check if user is already logged in
if (isset($_SESSION['username'])) {
    if (isset($_SESSION['admin']) && $_SESSION['admin'] === true) {
        header('Location: admin.php');
    } else {
        header('Location: index.php');
    }
    exit;
}

require_once 'db.php';

if (isset($_POST['email']) && isset($_POST['password'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Query to select user from database
    $sql = "SELECT id, username, password, is_admin FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if ($row && password_verify($password, $row['password'])) {
        // Login successful, start session and redirect to appropriate page
        $_SESSION['username'] = $row['username'];
        $_SESSION['user_id'] = $row['id'];
        if ($row['is_admin']) {
            $_SESSION['admin'] = true;
            header("Location: admin.php");
        } else {
            header("Location: index.php");
        }
        exit;
    } else {
        // Login failed, display error message
        $error = "Invalid email or password";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="ktv_logo.png">
    <title>Login</title>
    <link rel="stylesheet" href="login_styles.css">
</head>
<body>
    <div class="container">
        <div class="left">
            <div class="login-content">
                <button class="button" onclick="location.href='index.php'">Home</button>
                <h1>Hello, welcome!</h1>
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                    <label for="email">Email address:</label>
                    <input type="text" id="email" name="email" required>
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" required>
                    <div class="actions">
                        <input type="submit" value="Login">
                        <a href="signup.php" class="signup-btn">Sign up</a>
                    </div>
                </form>
                <?php if (isset($error)) { echo "<p class='error'>$error</p>"; } ?>
            </div>
        </div>
        <div class="right">
            <div class="background-image"></div>
        </div>
    </div>
</body>
</html>

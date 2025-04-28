<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="../css/loginstyle.css">
</head>
<body>
    <div class="banner">
        <h2>Login</h2>
    </div>  

    <?php
    session_start();
    if (isset($_SESSION['error'])) {
        echo "<div class='error-message'>" . $_SESSION['error'] . "</div>";
        unset($_SESSION['error']); 
    } 
    ?>

    <div class="login-container">
        <form id="loginForm" action="../actions/login_action.php" method="POST">
            <div class="form-group">
                <input type="text" name="username" placeholder="Username" required>
            </div>
            <div class="form-group">
                <input type="password" name="password" placeholder="Password" required>
            </div>
            <button type="submit" class="btn">Login</button>
            <p class="signup-link">Don't have an account? <a href="../login/register.php">Sign Up!</a></p>
        </form>
    </div>
</body>
</html>

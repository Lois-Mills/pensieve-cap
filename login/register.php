<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" type="text/css" href="../css/regstyle.css">
</head>
<body>
    <div class="banner">
        <h2>Register</h2>
    </div>  

    <div class="register-container">
        <form id="registerForm" action="../actions/register_action.php" method="POST">
            <div class="form-group">
                <input type="text" name="username" placeholder="Username" required>
            </div>
            <div class="form-group">
                <input type="email" name="email" placeholder="Email" required>
            </div>
            <div class="form-group">
                <input type="password" name="password" placeholder="Password" required>
            </div>
            <!-- <div class="form-group">
                <select name="gender" required>
                    <option value="" disabled selected>Select Gender</option>
                    <option value="female">Female</option>
                    <option value="male">Male</option>
                    <option value="other">Other</option>
                </select>
            </div>
            <div class="form-group">
                <input type="text" name="contact" placeholder="Contact" required> -->
            <!-- </div> -->
            <button type="submit" class="btn">Register</button>
        </form>
    </div>

    <script src="../js/registervalidation.js"></script>
</body>
</html>

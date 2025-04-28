<?php
session_start(); 

require("../controllers/user_controller.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["username"]) && isset($_POST["password"]) && !empty($_POST["username"]) && !empty($_POST["password"])) {
        $username = $_POST["username"];
        $password = $_POST["password"];

        $user = loginUser_ctr($username, $password);

        if ($user) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['username'] = $user['username'];


                header("Location: ../view/home.php");
                exit();
           
        } else {
            header("Location: ../login/login.php?error=invalid_credentials");
            exit();
        }
    } else {
        header("Location: ../login/login.php?error=missing_fields");
        exit();
    }
} else {
    header("Location: ../login/login.php");
    exit();
}



            
            

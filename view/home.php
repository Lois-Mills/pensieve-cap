<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>
<?php
session_start();
require_once("../controllers/book_controller.php");
require_once("../controllers/streak_controller.php");
require_once("../controllers/badge_controller.php");

$username = $_SESSION['username'] ?? 'Guest';
$user_id = $_SESSION['user_id'] ?? null;
$books = getUserBooksController($user_id);
if ($username === 'Guest') {
    header("Location: ../login/login.php?error=notloggedin");
    exit();
} elseif ($user_id) {
    // Show books for the logged-in user
    $books = getUserBooksController($user_id);
} else {
    $books = []; // fallback in case something goes wrong
}

// Check streak, XP, and award badges if logged in
if ($user_id) {
    updateStreakController($user_id); // Update user streak
    checkAndAwardBadges($user_id); // Check and award badges
}
?>
<script>
  const USER_ID = <?php echo json_encode($user_id); ?>;
</script>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADHD Reading Platform</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<?php include "topbar.php"; ?>

    <div class="container">
        <h1>Welcome to PENSIEVE  </h1>
        
        <div class="upload-section">
            <h2>Upload a Book</h2>
            <form action="../actions/upload_book_action.php" method="POST" enctype="multipart/form-data">
                <input type="text" name="title" placeholder="Book Title" required>
                <input type="text" name="author" placeholder="Author" required>
                <input type="file" name="book_file" required>
                <button type="submit">Upload</button>
            </form>
        </div>

        <div class="books-section">
            <h2>Available Books</h2>
            <ul>
                <?php
                if ($books) {
                    foreach ($books as $b) {
                        echo "<li><a href='#' onclick=\"openReader('../uploads/{$b['file_path']}')\">{$b['title']} by {$b['author']}</a></li>";
                    }
                } else {
                    echo "<li>No books available.</li>";
                }
                ?>
            </ul>
        </div>

        

        <div id="reader-container" class="reader-hidden">
            <iframe id="book-reader" src="" frameborder="0"></iframe>
            <button onclick="closeReader()">Close</button>
            <button onclick="toggleGazeTracker()" id="gaze-toggle-btn"
            style="position: fixed; bottom: 20px; left: 20px; z-index: 1101; background: #d63384; color: white; padding: 10px 15px; border: none; border-radius: 8px; cursor: pointer;">
            👁 Show Gaze Tracker
            </button>
        </div>
        
        <div id="gaze-container">
            <button onclick="closeGazeTracker()">✖</button>
            <iframe src="https://34.30.26.22:5000/track_gaze" width="680" height="540" allow="camera; microphone" id="gaze-feed"
            style="border: none; border-radius: 6px;"></iframe>
        </div>

    </div>

    <script>
        function openReader(filePath) {
            console.log("Opening file:", filePath);
            document.getElementById('book-reader').src = filePath;
            document.getElementById('reader-container').style.display = "flex"; 

            document.getElementById('gaze-container').style.display = "block";
            const iframe = document.getElementById('gaze-feed');
            iframe.contentWindow.postMessage({ action: "startSession", user_id: USER_ID }, "https://34.30.26.22:5000");
        }

        function closeGazeTracker() {
            const iframe = document.getElementById('gaze-feed');
            iframe.contentWindow.postMessage({ action: "endSession" }, "https://34.30.26.22:5000");
            
            setTimeout(() => {
                document.getElementById('gaze-container').style.display = 'none';
            }, 700);
        }

        function closeReader() {
            document.getElementById('reader-container').style.display = "none"; 
            closeGazeTracker();
        

        }

        function toggleGazeTracker() {
            const gazeContainer = document.getElementById('gaze-container');
            const iframe = document.getElementById('gaze-feed');

            if (gazeContainer.style.display === "none" || gazeContainer.style.display === "") {
                gazeContainer.style.display = "block";

                iframe.contentWindow.postMessage({ action: "startSession" }, "https://34.30.26.22:5000");

                console.log("🔁 Gaze tracker opened and webcam session triggered");
            } else {
                gazeContainer.style.display = "none";
                iframe.contentWindow.postMessage({ action: "endSession" }, "https://34.30.26.22:5000");

                console.log("⛔️ Gaze tracker hidden and session ended");
            }
        }
    </script>

</body>
</html>

<style>
    body {
        font-family: 'Arial', sans-serif;
        margin: 0;
        padding: 0;
        display: flex;
        flex-direction: column;
        align-items: center;
        height: 100vh;
        background-color: #ffe6f2;
        color: #333;
    }
    .top-bar {
        width: 100%;
        background: #d63384;
        color: white;
        padding: 10px;
        display: flex;
        justify-content: space-around;
        align-items: center;
        font-weight: bold;
    }
    .top-bar a {
        color: white;
        text-decoration: none;
        font-weight: bold;
    }
    .top-bar a:hover {
        text-decoration: underline;
    }
    .container {
        background: white;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        width: 500px;
        text-align: center;
        margin-top: 20px;
    }
    h1 {
        color: #d63384;
        font-size: 24px;
    }
    .upload-section, .books-section {
        margin-top: 20px;
    }
    form {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }
    input, button {
        padding: 12px;
        font-size: 16px;
        border-radius: 5px;
        border: 1px solid #ccc;
    }
    input {
        background: #fff;
    }
    button {
        background: #d63384;
        color: white;
        border: none;
        cursor: pointer;
        transition: background 0.3s;
    }
    button:hover {
        background: #b82e72;
    }
    ul {
        list-style: none;
        padding: 0;
        margin-top: 10px;
    }
    li {
        padding: 10px;
        background: #f8d7da;
        margin: 5px 0;
        border-radius: 5px;
        transition: transform 0.2s;
    }
    li:hover {
        transform: scale(1.05);
    }
    a {
        color: #d63384;
        text-decoration: none;
        font-weight: bold;
        cursor: pointer;
    }
    a:hover {
        text-decoration: underline;
    }
    
    #reader-container {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        position: fixed;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        background: rgba(255, 255, 255, 0.95);
        padding: 0px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        border-radius: 0;
        z-index: 1000;
        display: none;
    }
    iframe {
        width: 100%;
        height: 100vh;
        border: none;
    }
    #gaze-container {
        position: fixed;
        top: 20px;
        right: 10px;
        width: 230px;
        height: 200px;
        background: #fff;
        border: 2px solid #d63384;
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.2);
        z-index: 1100;
        display: none;
        overflow: hidden; /* Important to avoid overflow artifacts */
    }
    #gaze-feed {
        width: 100%;
        height: 100%;
        border: none;
        object-fit: cover;  
        border-radius: 0 0 8px 8px; 
        display: block;
    }
    #gaze-container button {
        width: 100%;             /* Stretch to container width */
        padding: 10px 0;         /* Vertical padding only */
        font-size: 1rem;
        background: #d63384;
        color: white;
        border: none;
        border-radius: 8px 8px 0 0;  /* Optional: rounded top only */
        cursor: pointer;
        transition: background 0.3s;
        box-sizing: border-box;  /* Prevent weird overflow */
    }

</style>
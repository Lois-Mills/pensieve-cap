<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once("../controllers/leaderboard_controller.php");

$user_id = $_SESSION['user_id'] ?? null;
$username = $_SESSION['username'] ?? 'Guest';

$leaderboard = getLeaderboardController();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leaderboard</title>
    <link rel="stylesheet" href="../css/leaderboardstyle.css">
</head>
<body>
    <div class="top-bar">
        <span>🏆 Leaderboard</span>
        <a href="home.php">🏠 Home</a>
        <a href="profile.php">👤 Profile</a>
        <a href="../login/logout.php" class="logout-btn">🚪 Logout</a>
    </div>

    <div class="leaderboard-container">
        <h1>Top Players</h1>
        <div class="leaderboard-list">
            <?php if (!empty($leaderboard)): ?>
                <table class="leaderboard-table">
                    <thead>
                        <tr>
                            <th>Rank</th>
                            <th>Username</th>
                            <th>XP Points</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($leaderboard as $index => $user): ?>
                            <tr>
                                <td><?= $index + 1 ?></td>
                                <td><?= htmlspecialchars($user['username']) ?></td>
                                <td><?= $user['xp_points'] ?> 🎮</td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No users available yet. Keep earning XP to climb the ranks! 🚀</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>

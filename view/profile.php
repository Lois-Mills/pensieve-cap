<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once("../controllers/streak_controller.php");
require_once("../controllers/badge_controller.php");

$user_id = $_SESSION['user_id'] ?? null;
$username = $_SESSION['username'] ?? 'Guest';
$streak = $user_id ? getUserStreakController($user_id) : null;
$streakCount = $streak ? $streak['streak_count'] : 0;
$xpPoints = $streak ? $streak['xp_points'] : 0;
$badges = $user_id ? getUserBadgesController($user_id) : [];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="../css/profilestylle.css">
</head>
<body>
    <div class="top-bar">
        <span>👤 Hello, <?= htmlspecialchars($username) ?></span>
        <a href="home.php">🏠 Home</a>
        <a href="leaderboard.php">🏆 Leaderboard</a>
        <a href="../login/logout.php" class="logout-btn">🚪 Logout</a>
    </div>

    <div class="profile-container">
        <h1>My Profile</h1>
        <p><strong>XP:</strong> <?= $xpPoints ?> 🎮</p>
        <p><strong>Current Streak:</strong> <?= $streakCount ?> 🔥</p>
        
        <h2>My Badges</h2>
        <div class="badges">
            <?php if (!empty($badges)): ?>
                <?php foreach ($badges as $badge): ?>
                    <div class="badge">
                        <img src="../images/badges/<?= htmlspecialchars($badge['icon']) ?>" alt="<?= htmlspecialchars($badge['badge_name']) ?>">
                        <p><?= htmlspecialchars($badge['badge_name']) ?></p>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No badges earned yet. Keep going! 🎯</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>

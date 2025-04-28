<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once("../controllers/streak_controller.php");

$user_id = $_SESSION['user_id'] ?? null;
$username = $_SESSION['username'] ?? 'Guest'; 
$streak = $user_id ? getUserStreakController($user_id) : null;
$streakCount = $streak ? $streak['streak_count'] : 0;
$xpPoints = $streak ? $streak['xp_points'] : 0;
?>

<div class="top-bar">
    <span>👋 Hello, <?= htmlspecialchars($username) ?>!</span>
    <span>🔥 Streak: <?= $streakCount ?> days</span>
    <span>⭐ XP: <?= $xpPoints ?> points</span>
    <a href="profile.php">👤 Profile</a>
    <a href="leaderboard.php">🏆 Leaderboard</a>
    <!-- <a href="rewards.php">🎁 Rewards</a> -->
    <a href="../login/logout.php" class="logout-btn">🚪 Logout</a>
</div>

<style>
.top-bar {
    background: #d63384;
    color: white;
    padding: 10px 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 16px;
}
.top-bar a {
    color: white;
    text-decoration: none;
    margin-left: 15px;
}
.top-bar a:hover {
    text-decoration: underline;
}
</style>

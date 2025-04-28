<?php
include_once("../classes/badge_class.php");
include_once("../controllers/streak_controller.php");


function getAllBadgesController() {
    $badge = new Badge();
    return $badge->getAllBadges();
}

function getUserBadgesController($user_id) {
    $badge = new Badge();
    return $badge->getUserBadges($user_id);
}

// Check if the user meets conditions for any badges
function checkAndAwardBadges($user_id) {
    $badge = new Badge();
    $badges = $badge->getAllBadges();

    $streak = getUserStreakController($user_id);
    $xp = getUserXPController($user_id);

    foreach ($badges as $b) {
        if ($b['condition_type'] === 'streak' && $streak['streak_count'] >= $b['condition_value']) {
            $badge->awardBadge($user_id, $b['badge_id']);
        }
        
        if ($b['condition_type'] === 'xp' && $xp['xp_points'] >= $b['condition_value']) {
            $badge->awardBadge($user_id, $b['badge_id']);
        }
    }
}
?>

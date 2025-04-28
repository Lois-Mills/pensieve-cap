<?php
include_once("../classes/streak_class.php");

function getUserStreakController($user_id) {
    $streak = new Streak();
    return $streak->getUserStreak($user_id);
}

function getUserXPController($user_id) {
    $streak = new Streak();
    return $streak->getUserXP($user_id);
}


function updateStreakController($user_id) {
    $streak = new Streak();
    return $streak->updateStreak($user_id);
}

function updateXPController($user_id, $xp_amount) {
    $streak = new Streak();
    return $streak->addXP($user_id, $xp_amount);
}


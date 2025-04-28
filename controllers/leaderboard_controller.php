<?php
require_once("../classes/leaderboard_class.php");

function getLeaderboardController() {
    $leaderboard = new Leaderboard();
    return $leaderboard->getLeaderboard();
}
?>

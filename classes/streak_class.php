<?php
require_once("../settings/db_class.php");

class Streak extends db_connection {
    // Function to get the user's streak and XP
    public function getUserStreak($user_id) {
        $sql = "SELECT * FROM streaks WHERE user_id = '$user_id'";
        return $this->db_fetch_one($sql);
    }

    public function getUserXP($user_id) {
        $sql = "SELECT xp_points FROM streaks WHERE user_id = '$user_id'";
        return $this->db_fetch_one($sql);
    }

    // Function to update the user's streak and award XP
    public function updateStreak($user_id) {
        $streak = $this->getUserStreak($user_id);
        $today = date('Y-m-d');

        if (!$streak) {
            // First-time streak entry
            $sql = "INSERT INTO streaks (user_id, streak_count, last_active, xp_points) 
                    VALUES ('$user_id', 1, '$today', 10)";
        } elseif ($streak['last_active'] == date('Y-m-d', strtotime('-1 day'))) {
            // Continue streak & add XP
            $xpBonus = ($streak['streak_count'] % 7 == 0) ? 50 : 10; // +50 XP for every 7-day streak
            $sql = "UPDATE streaks 
                    SET streak_count = streak_count + 1, last_active = '$today', xp_points = xp_points + $xpBonus 
                    WHERE user_id = '$user_id'";
        } elseif ($streak['last_active'] < date('Y-m-d', strtotime('-1 day'))) {
            // Reset streak but keep XP
            $sql = "UPDATE streaks 
                    SET streak_count = 1, last_active = '$today', xp_points = xp_points + 5 
                    WHERE user_id = '$user_id'";
        } else {
            return false;
        }
        return $this->db_query($sql);
    }

    // Function to add XP manually (e.g., when completing a quiz or challenge)
    public function addXP($user_id, $xp_amount) {
        $sql = "UPDATE streaks SET xp_points = xp_points + $xp_amount WHERE user_id = '$user_id'";
        return $this->db_query($sql);
    }
}

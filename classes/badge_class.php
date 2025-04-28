<?php
require_once("../settings/db_class.php");

class Badge extends db_connection {
    
    // Get all badges from the database
    public function getAllBadges() {
        $sql = "SELECT * FROM badges";
        return $this->db_fetch_all($sql);
    }

    // Get badges earned by a specific user
    public function getUserBadges($user_id) {
        $sql = "SELECT b.badge_name, b.description, b.icon, ub.date_earned 
                FROM user_badges ub
                JOIN badges b ON ub.badge_id = b.badge_id
                WHERE ub.user_id = '$user_id'";
        return $this->db_fetch_all($sql);
    }

    // Award a badge to a user
    public function awardBadge($user_id, $badge_id) {
        // Check if the user already has the badge
        $sql = "SELECT * FROM user_badges WHERE user_id = '$user_id' AND badge_id = '$badge_id'";
        $existingBadge = $this->db_fetch_one($sql);

        if ($existingBadge) {
            // Badge already earned
            return false;
        }

        // Insert new badge
        $sql = "INSERT INTO user_badges (user_id, badge_id) VALUES ('$user_id', '$badge_id')";
        return $this->db_query($sql);
    }
}
?>

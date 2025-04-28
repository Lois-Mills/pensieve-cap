<?php
require_once("../settings/db_class.php");

class Leaderboard extends db_connection {
    
    // Fetch top 10 users based on XP
    public function getLeaderboard() {
        $query = "SELECT users.id, users.username, streaks.xp_points 
                  FROM users 
                  JOIN streaks ON users.id = streaks.user_id
                  ORDER BY streaks.xp_points DESC
                  LIMIT 10";
                  
        return $this->db_fetch_all($query);
    }
}
?>

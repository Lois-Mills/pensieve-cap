<?php
require_once('db_cred.php');

class db_connection
{
    // Properties
    public $db = null;
    public $results = null;

    // Connect to the database
    public function db_connect()
    {
        // Connection
        $this->db = mysqli_connect(SERVER, USERNAME, PASSWD, DATABASE);

        // Test the connection
        if (mysqli_connect_errno()) {
            return false;
        } else {
            return true;
        }
    }

    // Return connection object
    public function db_conn()
    {
        $this->db = mysqli_connect(SERVER, USERNAME, PASSWD, DATABASE);

        if (mysqli_connect_errno()) {
            return false;
        } else {
            return $this->db;
        }
    }

    // Execute query
    public function db_query($sqlQuery)
    {
        if (!$this->db_connect()) {
            return false;
        } elseif ($this->db == null) {
            return false;
        }

        $this->results = mysqli_query($this->db, $sqlQuery);

        if ($this->results == false) {
            return false;
        } else {
            return true;
        }
    }

    // Fetch one row
    public function db_fetch_one($sql)
    {
        if (!$this->db_query($sql)) {
            return false;
        }
        return mysqli_fetch_assoc($this->results);
    }

    // Fetch all rows
    public function db_fetch_all($sql)
    {
        if (!$this->db_query($sql)) {
            return false;
        }
        return mysqli_fetch_all($this->results, MYSQLI_ASSOC);
    }

    // Get row count
    public function db_count()
    {
        if ($this->results == null) {
            return false;
        } elseif ($this->results == false) {
            return false;
        }

        return mysqli_num_rows($this->results);
    }
}

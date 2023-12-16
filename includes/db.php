<?php
class Database {
    private $db;

    public function __construct() {
        $this->db = new SQLite3('db.sqlite');
        if (!$this->db) {
            die("Connection failed: " . $this->db->lastErrorMsg());
        }
    }

    public function getDb() {
        return $this->db;
    }
}

$dbConnection = new Database();

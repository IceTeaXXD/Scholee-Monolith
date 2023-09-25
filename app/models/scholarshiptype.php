<?php

class ScholarshipType
{
    private int $user_id;
    private int $scholarship_id;
    private string $type;

    private $db;
    private $table;   

    public function __construct() {
        $this->table = 'scholarshiptype';
        $this->db = new Database;
    }

    // Getters and setters for each property
    public function getUserId()
    {
        return $this->user_id;
    }

    public function setUserId($user_id)
    {
        $this->user_id = $user_id;
    }

    public function getScholarshipId()
    {
        return $this->scholarship_id;
    }

    public function setScholarshipId($scholarship_id)
    {
        $this->scholarship_id = $scholarship_id;
    }

    public function getType()
    {
        return $this->type;
    }

    public function setType($type)
    {
        $this->type = $type;
    }
}
?>

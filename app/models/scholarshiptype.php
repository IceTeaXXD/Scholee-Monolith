<?php

class ScholarshipType
{
    private int $user_id;
    private int $scholarship_id;
    private string $type;

    private $db;
    private $table;   

    public function __construct() {
        $this->table = 'scholarshipType';
        $this->db = new Database;
    }

    public function addType($uid, $sid, $type){
        $query = "INSERT INTO $this->table (user_id, scholarship_id, type)
                    VALUES (?,?,?)";
        $stmt = $this->db->setSTMT($query);
        mysqli_stmt_bind_param($stmt, "iis", $uid, $sid, $type);
        $res = mysqli_stmt_execute($stmt);
        return $res;
    }

    public function updateTypes($uid, $sid, $types){
        $query = "DELETE FROM $this->table WHERE user_id = ? and scholarship_id = ?";

        $stmt = $this->db->setSTMT($query);

        mysqli_stmt_bind_param($stmt, "ii", $uid, $sid);

        mysqli_stmt_execute($stmt);

        foreach($types as $type){
            $this->addType($uid, $sid, $type);
        }
    }
    public function getTypes($uid, $sid){
        $query = "SELECT type FROM $this->table WHERE user_id = ? AND scholarship_id = ?";
        $stmt = $this->db->setSTMT($query);

        mysqli_stmt_bind_param($stmt, "ii", $uid, $sid);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        return $result;
    }
    
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

    public function setType($type)
    {
        $this->type = $type;
    }
}

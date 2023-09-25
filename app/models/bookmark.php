<?php

class Bookmark
{
    private $user_id_student;
    private $user_id_scholarship;
    private $scholarship_id;
    private $priority;
    private $db;
    private $table;

    public function __construct() {
        $this->db = new Database();
        $this->table = 'bookmark';
    }

    public function newBookMark($uid, $uis, $sid, $prio){
        $query = "INSERT INTO bookmark(user_id_student, user_id_scholarship, scholarship_id, priority)
                    VALUES (?,?,?,?)";
        $stmt = $this->db->setSTMT($query);
        mysqli_stmt_bind_param($stmt, "dddd", $uid, $uis, $sid, $prio);
        mysqli_stmt_execute($stmt);
    }

    public function updatePrio($prio, $uid, $uis, $sid){
        $query = "UPDATE bookmark SET prio = ? WHERE user_id_student = ? AND user_id_scholarship = ? AND scholarship_id = ?";
        $stmt = $this->db->setSTMT($query);
        mysqli_stmt_bind_param($stmt, "dddd", $prio, $uid, $uis, $sid);
        mysqli_stmt_execute($stmt);
    }

    public function getUserIdStudent()
    {
        return $this->user_id_student;
    }

    public function setUserIdStudent($user_id_student)
    {
        $this->user_id_student = $user_id_student;
    }

    public function getUserIdScholarship()
    {
        return $this->user_id_scholarship;
    }

    public function setUserIdScholarship($user_id_scholarship)
    {
        $this->user_id_scholarship = $user_id_scholarship;
    }

    public function getScholarshipId()
    {
        return $this->scholarship_id;
    }

    public function setScholarshipId($scholarship_id)
    {
        $this->scholarship_id = $scholarship_id;
    }

    public function getPriority()
    {
        return $this->priority;
    }

    public function setPriority($priority)
    {
        $this->priority = $priority;
    }
}
?>

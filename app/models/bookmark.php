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

    public function getUserBookmark(){
        $query = "SELECT title, description, priority, coverage, contact_name, contact_email
                    FROM $this->table a inner join scholarship b on a.scholarship_id = b.scholarship_id and a.user_id_scholarship = b.user_id
                    Where user_id_student = ?";

        $stmt = $this->db->setSTMT($query);

        mysqli_stmt_bind_param($stmt, "i", $_SESSION['user_id']);

        mysqli_stmt_execute($stmt);

        return mysqli_stmt_get_result($stmt);
    }

    public function countUserBookmark(){
        $query = "SELECT COUNT(*) as total FROM $this->table";
        $stmt = $this->db->setSTMT($query);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);
        return $row['total'];
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

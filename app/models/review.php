<?php

class Review
{
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    public function addStudentDocument($type, $link){
        /* GET NUM OF USER FILES */
        $query = "SELECT COUNT(*) as count FROM additionalfiles
                    WHERE user_id = ?";
        $stmt = $this->db->setSTMT($query);
        mysqli_stmt_bind_param($stmt, "i", $_SESSION['user_id']);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $num = mysqli_fetch_array($result)['count'];
        $num += 1;

        $query = "INSERT INTO additionalfiles values (?,?,?,?)";
        $stmt = $this->db->setSTMT($query);
        mysqli_stmt_bind_param($stmt, "iiss", $_SESSION['user_id'], $num, $type, $link);
        mysqli_stmt_execute($stmt);
    }

    public function submitForReview($uis, $fid){

        /* Generate random */
        $uir = 0;
        $query = "SELECT user_id FROM reviewer ORDER BY RAND() LIMIT 1";
        $stmt = $this->db->setSTMT($query);
        mysqli_stmt_execute($stmt);
        $uir = mysqli_fetch_array(mysqli_stmt_get_result($stmt))['user_id'];

        $query = "INSERT INTO review
                    VALUES ($uir, $uis, $fid, 'waiting', NULL)";
        $stmt = $this->db->setSTMT($query);
        return mysqli_stmt_execute($stmt);
    }

    public function getStudentDocument(){
        $query = "SELECT a.file_id, a.type, a.link, r.review_status, r.comment 
                    FROM additionalfiles a left join review r on r.user_id_student = a.user_id and r.file_id = r.file_id
                    WHERE a.user_id = ?";
        $stmt = $this->db->setSTMT($query);
        mysqli_stmt_bind_param($stmt, "i", $_SESSION['user_id']);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        return $result;
    }

    public function getReviewerDocument(){
        $query = "SELECT file_id, type, link, review_status, comment 
                    FROM additionalfiles a inner join review r on r.user_id_student = a.user_id and r.file_id = r.file_id
                    WHERE r.review_status = 'waiting'
                    GROUP BY a.user_id";
        $stmt = $this->db->setSTMT($query);
        mysqli_stmt_bind_param($stmt, "i", $_SESSION['user_id']);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        return $result;
    }

}
?>

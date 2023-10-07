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
        /* Check if student has uploaded this file before */
        $checkQ = "SELECT count(*) as count FROM review WHERE user_id_student = ? AND file_id = ?";
        $stmtCheck = $this->db->setSTMT($checkQ);
        mysqli_stmt_bind_param($stmtCheck, "ii", $uis, $fid);
        mysqli_stmt_execute($stmtCheck);
        $getRow = mysqli_stmt_get_result($stmtCheck);
        $row = mysqli_fetch_array($getRow);
        if($row['count'] == 0){
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
        }else{
            return false;
        }
    }

    public function getStudentDocument(){
        $query = "SELECT a.file_id, a.type, a.link, r.review_status, r.comment, u.name, re.occupation
                    FROM additionalfiles a left join review r on r.user_id_student = a.user_id and r.file_id = a.file_id
                    left join user u on u.user_id = r.user_id_reviewer left join reviewer re on re.user_id = u.user_id
                    WHERE a.user_id = ?";
        $stmt = $this->db->setSTMT($query);
        mysqli_stmt_bind_param($stmt, "i", $_SESSION['user_id']);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        return $result;
    }

    public function getReviewerDocument(){
        $query = "SELECT a.user_id, a.file_id, a.type, a.link, r.review_status, r.comment 
                    FROM additionalfiles a inner join review r on r.user_id_student = a.user_id and r.file_id = a.file_id
                    WHERE r.user_id_reviewer = ?
                    GROUP BY a.user_id, a.file_id
                    ORDER BY review_status";
        $stmt = $this->db->setSTMT($query);
        mysqli_stmt_bind_param($stmt, "i", $_SESSION['user_id']);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        return $result;
    }

    public function comment($uis, $fid, $comment){
        $query = "UPDATE review
                    SET comment = ?, review_status = 'reviewed'
                    WHERE user_id_student = ? and file_id = ?";
        $stmt = $this->db->setSTMT($query);
        mysqli_stmt_bind_param($stmt, "sii", $comment, $uis, $fid);
        $result = mysqli_stmt_execute($stmt);
        return $result;
    }

    public function findReviewStudent($search){
        $query = "SELECT a.user_id, a.file_id, a.type, a.link, r.review_status, r.comment, u.name, re.occupation
                    FROM additionalfiles a left join review r on r.user_id_student = a.user_id and r.file_id = a.file_id
                    left join user u on u.user_id = r.user_id_reviewer left join reviewer re on re.user_id = u.user_id
                    ";
        $whereClauses = [];
        $params = [];
        $types = '';

        $whereClauses[] = "a.user_id = ?";
        $params[] = $search['user_id'];
        $types .= "i";

        if(isset($search['review_status'])){
            $whereClauses[] = "r.review_status = ?";
            $params[] = strtolower($search['review_status']);
            $types .= "s";
        }

        if (!empty($whereClauses)) {
            $query .= " WHERE " . implode(" AND ", $whereClauses);
        }

        $query .= " LIMIT ? OFFSET ?";
    
        $params[] = $search['limit'];
        $types .= "ii";
        
        // add offset
        $offset = isset($search['page']) && is_numeric($search['page']) ? ($search['page'] - 1) * $search['limit'] : 0;
        $params[] = $offset;
    
        $stmt = $this->db->setSTMT($query);
        
        if (!empty($params)) {
            $stmt->bind_param($types, ...$params);
        }
        
        $stmt->execute();
        $result = $stmt->get_result();
        $reviews = [];
        while ($row = $result->fetch_assoc()) {
            $reviews[] = $row;
        }

        return $reviews;
    }

    public function countSearchStudent($search){
        $query = "SELECT COUNT(*) as total FROM review";
        $whereClauses = [];
        $params = [];
        $types = '';
        
        if(isset($search['review_status'])){
            $whereClauses[] = "review_status = ?";
            $params[] = strtolower($search['review_status']);
            $types .= "s";
        }
        
        if (!empty($whereClauses)) {
            $query .= " WHERE " . implode(" AND ", $whereClauses);
        }
        
        $stmt = $this->db->setSTMT($query);
        
        if (!empty($params)) {
            $stmt->bind_param($types, ...$params);
        }
        
        $stmt->execute();
        $result = $stmt->get_result();
        $row = mysqli_fetch_assoc($result);
        return $row['total'];
    }


    public function findReviewReviewer($search){
        $query = "SELECT a.user_id, a.file_id, a.type, a.link, r.review_status, r.comment 
                FROM additionalfiles a inner join review r on r.user_id_student = a.user_id and r.file_id = a.file_id";
        
        $whereClauses = [];
        $params = [];
        $types = '';

        $whereClauses[] = "r.user_id_reviewer = ?";
        $params[] = $search['user_id'];
        $types .= "i";

        if(isset($search['review_status'])){
            $whereClauses[] = "review_status = ?";
            $params[] = strtolower($search['review_status']);
            $types .= "s";
        }
    
        if(isset($search['review_status'])){
            $whereClauses[] = "r.review_status = ?";
            $params[] = strtolower($search['review_status']);
            $types .= "s";
        }

        if (!empty($whereClauses)) {
            $query .= " WHERE " . implode(" AND ", $whereClauses);
        }
        $query .= " GROUP BY a.user_id, a.file_id ORDER BY review_status";
        $query .= " LIMIT ? OFFSET ?";
    
        $params[] = $search['limit'];
        $types .= "ii";
        
        // add offset
        $offset = isset($search['page']) && is_numeric($search['page']) ? ($search['page'] - 1) * $search['limit'] : 0;
        $params[] = $offset;
        
        $stmt = $this->db->setSTMT($query);
        
        if (!empty($params)) {
            $stmt->bind_param($types, ...$params);
        }
        
        $stmt->execute();
        $result = $stmt->get_result();
        $reviews = [];
        while ($row = $result->fetch_assoc()) {
            $reviews[] = $row;
        }

        return $reviews;
    }

    public function countReviewReviewer($search){
        $query = "SELECT COUNT(*) as total FROM review";
        $whereClauses = [];
        $params = [];
        $types = '';
        
        if(isset($search['review_status'])){
            $whereClauses[] = "review_status = ?";
            $params[] = strtolower($search['review_status']);
            $types .= "s";
        }
        
        if (!empty($whereClauses)) {
            $query .= " WHERE " . implode(" AND ", $whereClauses);
        }
        
        $stmt = $this->db->setSTMT($query);
        
        if (!empty($params)) {
            $stmt->bind_param($types, ...$params);
        }
        
        $stmt->execute();
        $result = $stmt->get_result();
        $row = mysqli_fetch_assoc($result);
        return $row['total'];
    }
}
?>

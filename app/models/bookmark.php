<?php
require_once 'scholarshiptype.php';

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
        $query = "SELECT a.user_id_scholarship, a.scholarship_id, title, description, short_description, priority, coverage, contact_name, contact_email
                    FROM $this->table a inner join scholarship b on a.scholarship_id = b.scholarship_id and a.user_id_scholarship = b.user_id
                    WHERE user_id_student = ?";

        $stmt = $this->db->setSTMT($query);

        mysqli_stmt_bind_param($stmt, "i", $_SESSION['user_id']);

        mysqli_stmt_execute($stmt);

        return mysqli_stmt_get_result($stmt);
    }

    public function deleteUserBookmark($uid, $uis, $sid){
        $query = "DELETE FROM $this->table WHERE user_id_student = ? and user_id_scholarship = ? and scholarship_id = ?";
        $stmt = $this->db->setSTMT($query);
        mysqli_stmt_bind_param($stmt, "iii", $uid, $uis, $sid);

        return mysqli_stmt_execute($stmt);
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
        mysqli_stmt_bind_param($stmt, "iiii", $uid, $uis, $sid, $prio);
        $result = mysqli_stmt_execute($stmt);
        return $result;
    }
    public function findBookmarks($data) {
        $query = "SELECT a.user_id_scholarship, a.scholarship_id, title, description, 
              short_description, priority, coverage, contact_name, contact_email
              FROM $this->table a 
              INNER JOIN scholarship b ON a.scholarship_id = b.scholarship_id";

        $whereClauses = [];
        $params = [];
        $types = '';

        $whereClauses[] = "a.user_id_student = ?";
        $params[] = $_SESSION['user_id'];
        $types .= "i";

        if(isset($data['judul']) && !empty($data['judul'])) {
            $whereClauses[] = "b.title LIKE ?";
            $params[] = "%" . $data['judul'] . "%";
            $types .= "s";
        }

        if(isset($data['coverage']) && is_numeric($data['coverage'])) {
            $whereClauses[] = "b.coverage > ?";
            $params[] = $data['coverage'];
            $types .= "i"; 
        }

        if (!empty($whereClauses)) {
            $query .= " WHERE " . implode(" AND ", $whereClauses);
        }

        $query .= " ORDER BY a.priority DESC";

        // Add LIMIT and OFFSET
        $query .= " LIMIT ? OFFSET ?";

        $params[] = $data['limit'];
        $types .= "ii";
        
        // add offset
        $offset = isset($data['page']) && is_numeric($data['page']) ? ($data['page'] - 1) * $data['limit'] : 0;
        $params[] = $offset;
        
        $stmt = $this->db->setSTMT($query);

        if (!empty($params)) {
            $stmt->bind_param($types, ...$params);
        }

        $stmt->execute();
        $result = $stmt->get_result();
        $bookmarkSchs = [];
        while ($row = $result->fetch_assoc()) {
            $bookmarkSchs[] = $row;
        }
        // var_dump("DSADSDS");
        $scholarshipTypeModel = new ScholarshipType();
        // var_dump($bookmarkSchs);
        foreach ($bookmarkSchs as &$bookmarkSch) {
            // var_dump("------------------");
            // var_dump($bookmarkSch);
            $uid = $bookmarkSch['user_id_scholarship'];
            $sid = $bookmarkSch['scholarship_id'];
            $typesResult = $scholarshipTypeModel->getTypes($uid, $sid);
            
            $types = [];
            while ($typeRow = $typesResult->fetch_assoc()) {
                $types[] = $typeRow['type'];
                // var_dump("=========================");
                // var_dump($typeRow['type']);
            }
            $bookmarkSch['types'] = $types;
        }
        // var_dump("bookmark");
        // var_dump($bookmarkSchs);
        return $bookmarkSchs;
    }
    
    public function countFilteredBookmarks($params) {
        $query = "SELECT COUNT(*) as total 
                  FROM $this->table a 
                  INNER JOIN scholarship b ON a.scholarship_id = b.scholarship_id";
    
        $whereClauses = [];
        $values = [];
        $types = '';
    
        $whereClauses[] = "a.user_id_student = ?";
        $values[] = $_SESSION['user_id'];
        $types .= "i";
    
        if (isset($params['judul']) && !empty($params['judul'])) {
            $whereClauses[] = "LOWER(b.title) LIKE ?";
            $values[] = "%" . strtolower($params['judul']) . "%";
            $types .= "s";
        }
    
        if (isset($params['coverage']) && is_numeric($params['coverage'])) {
            $whereClauses[] = "b.coverage > ?";
            $values[] = $params['coverage'];
            $types .= "i";
        }
    
        if (!empty($whereClauses)) {
            $query .= " WHERE " . implode(" AND ", $whereClauses);
        }
    
        $stmt = $this->db->setSTMT($query);
        if (!empty($values)) {
            $stmt->bind_param($types, ...$values);
        }
    
        $stmt->execute();
    
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
    
        return $row['total'];
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

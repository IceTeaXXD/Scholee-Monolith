<?php
require_once 'scholarshiptype.php';

class Scholarship
{
    private int $user_id;
    private int $scholarship_id;
    private string $title;
    private string $description;
    private $role;
    private $coverage; /*Jumlah beasiswanya*/
    private string $contact_name;
    private string $contact_email;
    private $db;
    private $table;

    public function __construct($role, $user_id){
        $this->db = new Database();
        $this->table = 'scholarship';
        $this->role = $role;
        $this->user_id = $user_id;
    }

    public function addScholarship($user_id, $scholarship_id, $title, $description, $short_description, $coverage, $contact_name, $contact_email){
        $query = "INSERT INTO $this->table(user_id, scholarship_id, title, description, short_description, coverage, contact_name, contact_email)
                    VALUES (?,?,?,?,?,?,?,?)";
        $stmt = $this->db->setSTMT($query);
        mysqli_stmt_bind_param($stmt, "ddsssdss", $user_id, $scholarship_id, $title, $description, $short_description, $coverage, $contact_name, $contact_email);
        $res = mysqli_stmt_execute($stmt);
        return $res;
    }
    public function updateScholarship($user_id, $scholarship_id, $title, $description, $short_description, $coverage, $contact_name, $contact_email){
        $query = "UPDATE $this->table SET title = ?, description = ?, short_description = ?, coverage= ?, contact_name =? , contact_email = ?
                    WHERE user_id = ? AND scholarship_id = ?";
        $stmt = $this->db->setSTMT($query);
        mysqli_stmt_bind_param($stmt, "sssissii", $title, $description, $short_description, $coverage, $contact_name, $contact_email, $user_id, $scholarship_id);
        $res = mysqli_stmt_execute($stmt);
        return $res;
    }

    public function deleteScholarship($user_id, $scholarship_id){
        $query = "DELETE FROM $this->table WHERE user_id = ? AND scholarship_id = ?";
        $stmt = $this->db->setSTMT($query);
        mysqli_stmt_bind_param($stmt, "ii", $user_id, $scholarship_id);
        $exec = mysqli_stmt_execute($stmt);
        return $exec;
    }
    public function searchScholarship($query, $offset, $limit) {
        $searchPattern = "%" . $query . "%";
        $query = "SELECT * FROM $this->table WHERE title LIKE ? OR description LIKE ? LIMIT ?, ?";
        $stmt = $this->db->setSTMT($query);
        mysqli_stmt_bind_param($stmt, "ssii", $searchPattern, $searchPattern, $offset, $limit);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        return $result;
    }
    public function findScholarships($data) {
        $query = "SELECT * FROM $this->table";
        $whereClauses = [];
        $params = [];
        $types = '';

        if($_SESSION['role'] == 'admin'){
            $whereClauses[] = "user_id = ?";
            $params[] = $_SESSION['user_id'];
            $types .= "i";
        }
        
        if (isset($data['judul'])) {
            $whereClauses[] = "LOWER(title) LIKE ?";
            $params[] = "%" . strtolower($data['judul']) . "%";
            $types .= "s";
        }
        
        if (isset($data['coverage'])) {
            $whereClauses[] = "coverage > ?";
            $params[] = $data['coverage'];
            $types .= "i"; 
        }
        
        if (!empty($whereClauses)) {
            $query .= " WHERE " . implode(" AND ", $whereClauses);
        }
    
        // add limit
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
        $scholarships = [];
        while ($row = $result->fetch_assoc()) {
            $scholarships[] = $row;
        }
        // menguli scholarship type
        $scholarshipTypeModel = new ScholarshipType();
        foreach ($scholarships as &$scholarship) {
            $uid = $scholarship['user_id'];
            $sid = $scholarship['scholarship_id'];
            $typesResult = $scholarshipTypeModel->getTypes($uid, $sid);
    
            $types = [];
            while ($typeRow = $typesResult->fetch_assoc()) {
                $types[] = $typeRow['type'];
            }
            $scholarship['types'] = $types;
        }
        return $scholarships;
    }
    public function countFilteredScholarships($data){
        $query = "SELECT COUNT(*) as total FROM $this->table";
        $whereClauses = [];
        $params = [];
        $types = '';

        if($_SESSION['role'] == 'admin'){
            $whereClauses[] = "user_id = ?";
            $params[] = $_SESSION['user_id'];
            $types .= "i";
        }
        
        if (isset($data['judul'])) {
            $whereClauses[] = "LOWER(title) LIKE ?";
            $params[] = "%" . strtolower($data['judul']) . "%";
            $types .= "s";
        }
        
        if (isset($data['coverage'])) {
            $whereClauses[] = "coverage > ?";
            $params[] = $data['coverage'];
            $types .= "i"; 
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
    
    
    public function getScholarship($uid, $sid){
        $query = "SELECT user_id, scholarship_id, title, description, short_description, coverage, contact_name, contact_email
                    FROM $this->table WHERE user_id = ? and scholarship_id = ?";

        $stmt = $this->db->setSTMT($query);

        mysqli_stmt_bind_param($stmt, "ii", $uid, $sid);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        return $result;

    }

    public function getAllScholarship($offset, $limit){
        $query = '';
        $stmt = null;
        if($this->role == 'admin'){
            $query .= "SELECT user_id, scholarship_id, title, description, short_description, coverage, contact_name, contact_email
                    FROM $this->table 
                    WHERE user_id = ?
                    LIMIT ?, ?";
            $stmt = $this->db->setSTMT($query);
            mysqli_stmt_bind_param($stmt, "iii", $this->user_id, $offset, $limit);
        }else{
            $query = "SELECT user_id, scholarship_id, title, description, short_description, coverage, contact_name, contact_email
            FROM $this->table LIMIT ?, ?";
            $stmt = $this->db->setSTMT($query);
            mysqli_stmt_bind_param($stmt, "ii", $offset, $limit);
        }   
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        return $result;
    }
    public function countScholarships(){
        $query = "SELECT COUNT(*) as total FROM $this->table";
        $stmt = $this->db->setSTMT($query);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);
        return $row['total'];
    }    

    public function countOrganizationScholarship($id){
        $query = "SELECT scholarship_id as count FROM $this->table WHERE user_id = $id
                    ORDER BY scholarship_id DESC";
        $stmt = $this->db->setSTMT($query);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);
        return $row['count'];
    }

    public function getUserId(){
        return $this->user_id;
    }

    public function setUserId($user_id){
        $this->user_id = $user_id;
    }

    public function getScholarshipId(){
        return $this->scholarship_id;
    }

    public function setScholarshipId($scholarship_id){
        $this->scholarship_id = $scholarship_id;
    }

    public function getTitle(){
        return $this->title;
    }

    public function setTitle($title){
        $this->title = $title;
    }

    public function getDescription(){
        return $this->description;
    }

    public function setDescription($description){
        $this->description = $description;
    }

    public function getCoverage(){
        return $this->coverage;
    }

    public function setCoverage($coverage){
        $this->coverage = $coverage;
    }

    public function getContactName()
    {
        return $this->contact_name;
    }

    public function setContactName($contact_name)
    {
        $this->contact_name = $contact_name;
    }

    public function getContactEmail()
    {
        return $this->contact_email;
    }

    public function setContactEmail($contact_email)
    {
        $this->contact_email = $contact_email;
    }
}
?>

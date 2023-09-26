<?php

class Scholarship
{
    private int $user_id;
    private int $scholarship_id;
    private string $title;
    private string $description;
    private $coverage; /*Jumlah beasiswanya*/
    private string $contact_name;
    private string $contact_email;
    private $db;
    private $table;

    public function __construct(){
        $this->db = new Database();
        $this->table = 'scholarship';
    }

    public function addScholarship($user_id, $scholarship_id, $title, $description, $coverage, $contact_name, $contact_email){
        $query = "INSERT INTO $this->table(user_id, scholarship_id, title, description, coverage, contact_name, contact_email)
                    VALUES (?,?,?,?,?,?,?)";
        $stmt = $this->db->setSTMT($query);
        mysqli_stmt_bind_param($stmt, "ddssdss", $user_id, $tscholarship_id, $title, $description, $coverage, $contact_name, $contact_email);
        $res = mysqli_stmt_execute($stmt);
        return $res;
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
    
    public function getAllScholarship($offset, $limit){
        $query = "SELECT user_id, scholarship_id, title, description, coverage, contact_name, contact_email
                FROM $this->table LIMIT ?, ?";
        $stmt = $this->db->setSTMT($query);
        mysqli_stmt_bind_param($stmt, "ii", $offset, $limit);
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

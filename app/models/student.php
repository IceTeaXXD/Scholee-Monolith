<?php
class Student extends User {
    private string $university;
    private string $major;
    private string $level;
    private string $street;
    private string $city;
    private string $zipcode;
    private $db;
    private $table;

    public function __construct(){
        $this->db = new Database;
        $this->table = 'student';
    }

    public function update($editVal){
        $query = "UPDATE $this->table SET 
                university = ?, major = ?, level = ?, street = ?, city = ?, zipcode = ?
                WHERE user_id = ?";


        $stmt = $this->db->setSTMT($query);
        
        mysqli_stmt_bind_param($stmt, "sssssii", $editVal['university'], $editVal['major'], $editVal['level'], 
                                $editVal['street'], $editVal['city'], $editVal['zipcode'], $editVal['user_id']);


        mysqli_stmt_execute($stmt);
    }

    public function register(string $name, string $role, string $email, string $password, string $token){
        $this->name = $name;
        $this->role = $role;
        $this->email = $email;
        $this->password = password_hash($password, PASSWORD_DEFAULT);

        try {
            $query = "INSERT INTO user (name, role, email, password, verify_token) VALUES (?,?,?,?,?)";
            $stmt = $this->db->setSTMT($query);
            mysqli_stmt_bind_param($stmt, "sssss", $this->name, $this->role, $this->email, $this->password, $token);
            $insert = mysqli_stmt_execute($stmt);

            if ($insert === false) {
                throw new Exception(mysqli_stmt_error($stmt));
            }else{
                /* Get User ID */
                $this->userID = mysqli_insert_id($this->db->getDatabase());
                
                /* INSERT INTO STUDENT */
                $query = "INSERT INTO student (user_id) values (?)";
                $stmt = $this->db->setSTMT($query);
                mysqli_stmt_bind_param($stmt, "i", $this->userID);
                $insert = mysqli_stmt_execute($stmt);
            }
            return $insert;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function getUniversity(){
        return $this->university;
    }

    public function getMajor(){
        return $this->major;
    }

    public function getLevel(){
        return $this->level;
    }

    public function getStreet(){
        return $this->street;
    }

    public function getCity(){
        return $this->city;
    }

    public function getZipcode(){
        return $this->zipcode;
    }
}
?>
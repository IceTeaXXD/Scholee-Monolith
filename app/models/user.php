<?php
class User{
    protected int $userID;
    protected string $name;
    protected string $role;
    protected string $email;
    protected string $password;
    protected bool $isVerified;
    protected string $image;
    protected $db;
    protected $table;

    public function __construct(){
        $this->db = new Database;
        $this->table = 'user';
    }

    public function getUser(string $email, string $role){
        $query = "";
        if($role == "student"){
            $query = "select name, image, university, major, level, street, city, zipcode
                        from $this->table natural join student where email = ?";
        }else if ($role == "admin"){
            $query = "select name, image, organization from $this->table natural join administrator where email = ?";
        }else if($role == 'reviewer'){
            $query = "select name, occupation, image from $this->table natural join reviewer where email = ?";
        }else{
            $query = "select name, image from $this->table where email = ?";
        }
        $stmt = $this->db->setSTMT($query);
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        return mysqli_stmt_get_result($stmt);
    }

    public function getUserAll(){
        $query = "select user_id, name, image, role, email, is_verified from user where role != 'super admin' order by role desc";
        $stmt = $this->db->setSTMT($query);
        mysqli_stmt_execute($stmt);
        return mysqli_stmt_get_result($stmt);
    }

    public function searchUser($data){
        $query = "SELECT user_id, name, image, role, email FROM user";

        $whereClauses = [];
        $params = [];
        $types = '';

        $whereClauses[] = "role != 'super admin'";
        
        if(isset($data['name'])){
            $whereClauses[] = "LOWER(name) LIKE ?";
            $params[] = "%". strtolower($data['name']). "%";
            $types.='s';
        }

        if(isset($data['role']) && $data['role'] != 'All'){
            $whereClauses[] = "role = ?";
            $params[] = $data['role'];
            $types.='s';
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
        $users = [];
        while ($row = $result->fetch_assoc()) {
            $users[] = $row;
        }

        return $users;
    }

    public function update($editVal){
        if($editVal['image'] == ''){
            $query = "UPDATE $this->table SET 
            name = ? WHERE user_id = ?";

            $stmt = $this->db->setSTMT($query);

            mysqli_stmt_bind_param($stmt, "ss", $editVal['name'],  $editVal['user_id']);

            mysqli_stmt_execute($stmt);
        }else{
            $query = "UPDATE $this->table SET 
                        name = ?, image = ? WHERE user_id = ?";

            $stmt = $this->db->setSTMT($query);

            mysqli_stmt_bind_param($stmt, "sss", $editVal['name'], $editVal['image'], $editVal['user_id']);

            mysqli_stmt_execute($stmt);
        }
    }

    public function register(string $name, string $role, string $email, string $password, string $token, string $university){
        $this->name = $name;
        $this->role = $role;
        $this->email = $email;
        $this->password = password_hash($password, PASSWORD_DEFAULT);

        try {
            $query = "INSERT INTO $this->table (name, role, email, password, verify_token) VALUES (?,?,?,?,?)";
            $stmt = $this->db->setSTMT($query);
            mysqli_stmt_bind_param($stmt, "sssss", $this->name, $this->role, $this->email, $this->password, $token);
            $insert = mysqli_stmt_execute($stmt);
            if ($insert === false) {
                throw new Exception(mysqli_stmt_error($stmt));
            }
            return $insert;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function login($email, $password){
        $query = "SELECT user_id, name, role, email, password, is_verified FROM $this->table WHERE email = ?";
        $stmt = $this->db->setSTMT($query);
        mysqli_stmt_bind_param($stmt, "s", $email);
        $exists = mysqli_stmt_execute($stmt);
        if(!$exists){
            /* Tidak ada usernya */
            return $exists;
        }else{
            /* Ambil hasilnya */
            $result = mysqli_stmt_get_result($stmt);
            $row = mysqli_fetch_array($result);
            if($row){
                if(password_verify($password,$row['password'])){
                    $this->role = $row['role'];
                    $this->name = $row['name'];
                    $this->email = $row['email'];
                    $this->userID = $row['user_id'];
                    $this->isVerified = $row['is_verified'];
                    return true;
                }else{
                    return false;
                }
            }
        }
    }

    public function getUserByEmail($email) {
        $query = "SELECT user_id, name, role, email, password FROM $this->table WHERE email = ?";
        $stmt = $this->db->setSTMT($query);
        mysqli_stmt_bind_param($stmt, "s", $email);
        $exists = mysqli_stmt_execute($stmt);
        if(!$exists){
            /* Tidak ada usernya */
            return $exists;
        }else{
            /* Ambil hasilnya */
            $result = mysqli_stmt_get_result($stmt);
            $row = mysqli_fetch_array($result);
            if($row){
                $this->role = $row['role'];
                $this->name = $row['name'];
                $this->email = $row['email'];
                $this->userID = $row['user_id'];
                return true;
            }
        }
    }

    public function createresettoken($email, $token) {
        $query = "UPDATE $this->table SET reset_token = ? WHERE email = ?";
        $stmt = $this->db->setSTMT($query);
        mysqli_stmt_bind_param($stmt, "ss", $token, $email);
        $insert = mysqli_stmt_execute($stmt);
        if ($insert === false) {
            throw new Exception(mysqli_stmt_error($stmt));
        }
        return $insert;
    }

    public function getUserByResetToken($token) {
        $query = "SELECT user_id, name, role, email, password FROM $this->table WHERE reset_token = ?";
        $stmt = $this->db->setSTMT($query);
        mysqli_stmt_bind_param($stmt, "s", $token);
        $exists = mysqli_stmt_execute($stmt);
        if(!$exists){
            /* Tidak ada usernya */
            return $exists;
        }else{
            /* Ambil hasilnya */
            $result = mysqli_stmt_get_result($stmt);
            $row = mysqli_fetch_array($result);
            if($row){
                $this->role = $row['role'];
                $this->name = $row['name'];
                $this->email = $row['email'];
                $this->userID = $row['user_id'];
                return true;
            }
        }
    }

    public function resetPassword($password, $token) {
        $this->password = password_hash($password, PASSWORD_DEFAULT);
        $query = "UPDATE $this->table SET password = ?, reset_token = NULL WHERE reset_token = ?";
        $stmt = $this->db->setSTMT($query);
        mysqli_stmt_bind_param($stmt, "ss", $this->password, $token);
        $insert = mysqli_stmt_execute($stmt);
        if ($insert === false) {
            throw new Exception(mysqli_stmt_error($stmt));
        }
        return $insert;
    }

    public function verify($userid) {
        $query = "UPDATE $this->table SET is_verified = 1, verify_token = NULL WHERE user_id = ?";
        $stmt = $this->db->setSTMT($query);
        mysqli_stmt_bind_param($stmt, "s", $userid);
        $insert = mysqli_stmt_execute($stmt);
        if ($insert === false) {
            throw new Exception(mysqli_stmt_error($stmt));
        }
        return $insert;
    }

    public function verifyToken($token) {
        $query = "UPDATE $this->table SET is_verified = 1, verify_token = NULL WHERE verify_token = ?";
        $stmt = $this->db->setSTMT($query);
        mysqli_stmt_bind_param($stmt, "s", $token);
        $insert = mysqli_stmt_execute($stmt);
        if ($insert === false) {
            throw new Exception(mysqli_stmt_error($stmt));
        }
        return $insert;
    }

    public function getUserByVerifyToken($token) {
        $query = "SELECT user_id, name, role, email, password FROM $this->table WHERE verify_token = ?";
        $stmt = $this->db->setSTMT($query);
        mysqli_stmt_bind_param($stmt, "s", $token);
        $exists = mysqli_stmt_execute($stmt);
        if(!$exists){
            /* Tidak ada usernya */
            return $exists;
        }else{
            /* Ambil hasilnya */
            $result = mysqli_stmt_get_result($stmt);
            $row = mysqli_fetch_array($result);
            if($row){
                $this->role = $row['role'];
                $this->name = $row['name'];
                $this->email = $row['email'];
                $this->userID = $row['user_id'];
                return true;
            }
        }
    }

    public function createverifytoken($email, $token) {
        $query = "UPDATE $this->table SET verify_token = ? WHERE email = ?";
        $stmt = $this->db->setSTMT($query);
        mysqli_stmt_bind_param($stmt, "ss", $token, $email);
        $insert = mysqli_stmt_execute($stmt);
        if ($insert === false) {
            throw new Exception(mysqli_stmt_error($stmt));
        }
        return $insert;
    }
    
    public function getName(){
        return $this->name;
    }

    public function getRole(){
        return $this->role;
    }

    public function getEmail(){
        return $this->email;
    }

    public function getID(){
        return $this->userID;
    }

    public function getIsVerified(){
        return $this->isVerified;
    }
}

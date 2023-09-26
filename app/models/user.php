<?php
class User{
    private int $userID;
    private string $name;
    private string $role;
    private string $email;
    private string $password;
    private string $image;
    private $db;
    private $table;

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
        }else {
            $query = "select name, image from $this->table where email = ?";
        }
        $stmt = $this->db->setSTMT($query);
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        return mysqli_stmt_get_result($stmt);
    }

    public function getUserAll(){
        $query = "select name, image, role, email from user where role != 'super admin' group by role order by role desc";
        $stmt = $this->db->setSTMT($query);
        mysqli_stmt_execute($stmt);
        return mysqli_stmt_get_result($stmt);
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

    public function register(string $name, string $role, string $email, string $password){
        $this->name = $name;
        $this->role = $role;
        $this->email = $email;
        $this->password = password_hash($password, PASSWORD_DEFAULT);

        try {
            $query = "INSERT INTO $this->table (name, role, email, password) VALUES (?,?,?,?)";
            $stmt = $this->db->setSTMT($query);
            mysqli_stmt_bind_param($stmt, "ssss", $this->name, $this->role, $this->email, $this->password);
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
                if(password_verify($password,$row['password'])){
                    $this->role = $row['role'];
                    $this->name = $row['name'];
                    $this->email = $row['email'];
                    $this->userID = $row['user_id'];
                    return true;
                }else{
                    return false;
                }
            }
        }
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
}
?>
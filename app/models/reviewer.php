<?php
class Reviewer extends User{
    private string $occupation;
    private int $score;

    public function __construct(){
        $this->db = new Database;
    }

    public function addScore(int $add){
        $this->score += $add;
    }
    
    public function update($editVal){
        $query = "UPDATE reviewer SET occupation = ? WHERE user_id = ?";
        $stmt = $this->db->setSTMT($query);
        mysqli_stmt_bind_param($stmt, "si", $editVal['occupation'], $editVal['user_id']);
        return mysqli_stmt_execute($stmt);
    }

    public function register(string $name, string $role, string $email, string $password, string $token, string $university = ""){
        $this->name = $name;
        $this->role = $role;
        $this->email = $email;
        $this->password = password_hash($password, PASSWORD_DEFAULT);

        try {
            $query = "INSERT INTO user (name, role, email, password) VALUES (?,?,?,?)";
            $stmt = $this->db->setSTMT($query);
            mysqli_stmt_bind_param($stmt, "ssss", $this->name, $this->role, $this->email, $this->password);
            $insert = mysqli_stmt_execute($stmt);

            if ($insert === false) {
                throw new Exception(mysqli_stmt_error($stmt));
            }else{
                /* Get User ID */
                $this->userID = mysqli_insert_id($this->db->getDatabase());
                
                /* INSERT INTO Administrator */
                $query = "INSERT INTO reviewer (user_id, occupation, score) values (?, '', 0)";
                $stmt = $this->db->setSTMT($query);
                mysqli_stmt_bind_param($stmt, "i", $this->userID);
                $insert = mysqli_stmt_execute($stmt);
            }
            return $insert;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
?>
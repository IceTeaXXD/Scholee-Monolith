<?php
class Superadmin extends User{
    private $db;
    public function __construct(){
        $this->db = new Database;
    }
    public function deleteUser($user_id){
        $query = "DELETE FROM user WHERE user_id = ?";
        $stmt = $this->db->setSTMT($query);
        mysqli_stmt_bind_param($stmt, "i", $user_id);
        return mysqli_stmt_execute($stmt);
    }
}
?>
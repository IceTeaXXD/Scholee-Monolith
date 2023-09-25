<?php
class Superadmin extends User{
    public function deleteUser($email){
        $query = "DELETE FROM user WHERE email = ?";
        $stmt = $this->db->setSTMT($query);
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
    }
}
?>
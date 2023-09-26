<?php
class Administrator extends User{
    private string $organization;
    
    private $db;

    private $table;

    public function __construct(){
        $this->db = new Database;
        $this->table = 'administrator';
    }

    public function update($editVal){
        $query = "UPDATE $this->table SET organization = ?
                    WHERE user_id = ?";
        
        $stmt = $this->db->setSTMT($query);

        mysqli_stmt_bind_param($stmt, "si", $editVal['organization'], $editVal['user_id']);

        mysqli_stmt_execute($stmt);
    }
}
?>
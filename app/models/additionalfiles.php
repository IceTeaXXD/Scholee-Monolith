<?php

class AdditionalFile
{
    private $db;
    private $table;

    public function __construct(){
        $this->db = new Database;
        $this->table = 'additionalfile';
    }  
    public function getAllAdditionalFiles(){
        $query = "SELECT * FROM $this->table";
        $stmt = $this->db->setSTMT($query);
        mysqli_stmt_execute($stmt);
        return mysqli_stmt_get_result($stmt);
    }
}
?>

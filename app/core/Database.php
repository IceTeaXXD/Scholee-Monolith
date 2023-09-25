<?php
class Database{
    private $database;
    private $stmt;
    
    public function __construct(){
        $host = DB_HOST;
        $dbname = DB_NAME;
        $user = DB_USER;
        $pass = DB_PASSWORD;

        $this->database = mysqli_connect($host, $user, $pass, $dbname);
    }

    public function setSTMT($query){
        $this->stmt = mysqli_prepare($this->database, $query);
        return $this->stmt;
    }

    public function getDatabase(){
        return $this->database;
    }
}
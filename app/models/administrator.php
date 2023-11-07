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
                $query = "INSERT INTO administrator (user_id, organization) values (?, '')";
                $stmt = $this->db->setSTMT($query);
                mysqli_stmt_bind_param($stmt, "i", $this->userID);
                $insert = mysqli_stmt_execute($stmt);

                /* Insert to SOAP */
                $soapClient = new SOAP("OrganizationRegistration?wsdl");
                $param = array("org_id_php"=>$this->userID);
                $soapClient->doRequest("registerOrganization", $param);
            }
            return $insert;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
?>
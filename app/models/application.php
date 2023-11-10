<?php

class Application{

    private $db;

    public function __construct(){
        $this->db = new Database;
    }

    public function apply($user_id_student, $user_id_scholarship, $scholarship_id){
        $soapClient = new SOAP("ScholarshipAcceptanceService?wsdl");
        $param = array("user_id_student"=>$user_id_student, "user_id_scholarship" => $user_id_scholarship, "scholarship_id" => $scholarship_id);
        $response = $soapClient->doRequest("registerScholarshipApplication", $param);
        return $response->return;
    }

    public function getApplications($user_id_student){
        $soapClient = new SOAP("ScholarshipAcceptanceService?wsdl");
        $param = array("user_id_student"=>$user_id_student);
        $response = $soapClient->doRequest("getAcceptanceStatus", $param);
        $return = [];
        if(isset($response->return)){
            if(is_array($response->return)){
                for($i = 0; $i < count($response->return); $i++){

                    $user_id_student = $response->return[$i]->user_id_student;
                    $user_id_scholarship = $response->return[$i]->user_id_scholarship;
                    $scholarship_id_php = $response->return[$i]->scholarship_id_php;
                    $scholarship_id_rest = $response->return[$i]->scholarship_id_rest;
                    $status = $response->return[$i]->status;

                    $query = "SELECT ? as user_id_student, user_id as user_id_scholarship, scholarship_id as scholarship_id_php, ? as scholarship_id_rest, title, description, coverage, ? as status FROM scholarship WHERE user_id = ? AND scholarship_id = ?";

                    $stmt = $this->db->setSTMT($query);

                    mysqli_stmt_bind_param($stmt, "iisii", $user_id_student, $scholarship_id_rest, $status, $user_id_scholarship, $scholarship_id_php);

                    mysqli_stmt_execute($stmt);

                    $result = mysqli_stmt_get_result($stmt);

                    while ($row = mysqli_fetch_assoc($result)) {
                        $return[] = $row;
                    }

                }
            }else{
                $returnElement = $response->return;

                $user_id_student = $returnElement->user_id_student;
                $user_id_scholarship = $returnElement->user_id_scholarship;
                $scholarship_id_php = $returnElement->scholarship_id_php;
                $scholarship_id_rest = $returnElement->scholarship_id_rest;
                $status = $returnElement->status;

                $query = "SELECT ? as user_id_student, user_id as user_id_scholarship, scholarship_id as scholarship_id_php, title, description, coverage, ? as scholarship_id_rest, ? as status FROM scholarship WHERE user_id = ? AND scholarship_id = ?";
                $stmt = $this->db->setSTMT($query);

                mysqli_stmt_bind_param($stmt, "iisii", $user_id_student, $scholarship_id_rest, $status, $user_id_scholarship, $scholarship_id_php);
                mysqli_stmt_execute($stmt);

                $result = mysqli_stmt_get_result($stmt);

                while ($row = mysqli_fetch_assoc($result)) {
                    $return[] = $row;
                }
            }
        }else{
            /* Do Nothing */
        }
        return $return;
    }
}

?>
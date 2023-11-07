<?php

class RegistrationModel{

    private $db;

    public function __construct(){
        $this->db = new Database;
    }

    public function register($user_id_student, $user_id_scholarship, $scholarship_id){
        $soapClient = new SOAP("ScholarshipAcceptanceService?wsdl");
        $param = array("user_id_student"=>$user_id_student, "user_id_scholarship" => $user_id_scholarship, "scholarship_id" => $scholarship_id);
        $response = $soapClient->doRequest("registerScholarshipApplication", $param);
        return $response->return;
    }

    public function getRegistrations($user_id_student){
        $soapClient = new SOAP("ScholarshipAcceptanceService?wsdl");
        $param = array("user_id_student"=>$user_id_student);
        $response = $soapClient->doRequest("getAcceptanceStatus", $param);
        var_dump($response->return);
        return $response->return;
    }
}

?>
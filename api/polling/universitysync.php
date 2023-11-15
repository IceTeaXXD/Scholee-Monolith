<?php
require_once 'app/core/App.php';
require_once 'app/core/Database.php';
require_once 'app/models/soap.php';
require_once 'config/config.php';

$soap = new SOAP("UniversityService?wsdl");

$response = $soap->doRequest("getAllUniversities", null);

$db = new Database();

if ($response->return != null) {
    if (!is_array($response->return)) {
        $response->return = array($response->return);
    }
    foreach ($response->return as $uni) {
        $uni_name = $uni->name;
        $phpUniId = $uni->phpUniId;
        $restUniId = $uni->restUniId;

        if ($phpUniId == -1) {
            // Insert to database
            $query = "INSERT INTO university (name) VALUES (?)";
            $stmt = $db->setSTMT($query);
            mysqli_stmt_bind_param($stmt, "s", $uni_name);
            $exec = mysqli_stmt_execute($stmt);
            if ($exec) {
                $id = mysqli_insert_id($db->getDatabase());
                $params = array("php_uni_id" => $id, "rest_uni_id" => $restUniId);
                $response = $soap->doRequest("setPHPId", $params);
            } else {
                echo "Error: " . mysqli_error($db->getDatabase());
            }
        }
    }
}

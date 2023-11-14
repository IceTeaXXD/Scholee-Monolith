<?php
require_once 'app/core/App.php';
require_once 'app/core/Database.php';
require_once 'app/models/soap.php';
require_once 'config/config.php';

$soap = new SOAP("UniversityService?wsdl");

$response = $soap->doRequest("getAllUniversities", null);

$db = new Database();

if ($response->return != null) {
    if (is_array($response->return)) {
        for ($i = 0; $i < count($response->return); $i++) {
            $uni_name = $response->return[$i]->name;
            $phpUniId = $response->return[$i]->phpUniId;
            $restUniId = $response->return[$i]->restUniId;

            if ($phpUniId == -1) {
                $query = "SELECT * FROM university WHERE name = ?";
                $stmt = $db->setSTMT($query);
                mysqli_stmt_bind_param($stmt, "s", $uni_name);
                $exec = mysqli_stmt_execute($stmt);
                /* If there is this instance do a soap request*/
                if ($exec) {
                    $res = mysqli_stmt_get_result($stmt);
                    $row = mysqli_fetch_array($res);
                    $params = array("php_uni_id" => $row['university_id'], "rest_uni_id" => $restUniId);
                    $response = $soap->doRequest("setPHPId", $params);
                } else {
                    /* Create the instance in PHP*/
                    $query = "INSERT INTO university (name) VALUES ?";
                    $stmt = $db->setSTMT($query);
                    mysqli_stmt_bind_param($stmt, "s", $uni_name);
                    $exec = mysqli_stmt_execute($stmt);
                    if ($exec) {
                        $id = mysqli_insert_id($db->getDatabase());
                        $params = array("php_uni_id" => $id, "rest_uni_id" => $restUniId);
                        $response = $soap->doRequest("setPHPId", $params);
                    }
                }
            }
        }
    } else {
        $uni_name = $response->return->name;
        $phpUniId = $response->return->phpUniId;
        $restUniId = $response->return->restUniId;

        if ($phpUniId == -1) {
            $query = "SELECT * FROM university WHERE name = ?";
            $stmt = $db->setSTMT($query);
            mysqli_stmt_bind_param($stmt, "s", $uni_name);
            $exec = mysqli_stmt_execute($stmt);
            /* If there is this instance do a soap request*/
            if ($exec) {
                $res = mysqli_stmt_get_result($stmt);
                $row = mysqli_fetch_array($res);
                $params = array("php_uni_id" => $row["university_id"], "rest_uni_id" => $restUniId);
                $response = $soap->doRequest("setPHPId", $params);
            } else {
                /* Create the instance in PHP*/
                $query = "INSERT INTO university (name) VALUES ?";
                $stmt = $db->setSTMT($query);
                mysqli_stmt_bind_param($stmt, "s", $uni_name);
                $exec = mysqli_stmt_execute($stmt);
                if ($exec) {
                    $id = mysqli_insert_id($db->getDatabase());
                    $params = array("php_uni_id" => $id, "rest_uni_id" => $restUniId);
                    $response = $soap->doRequest("setPHPId", $params);
                }
            }
        }
    }
}

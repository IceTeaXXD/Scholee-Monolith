<?php

require_once '../../app/core/App.php';
require_once '../../app/core/Database.php';
require_once '../../app/models/application.php';
require_once '../../app/models/soap.php';
require_once '../../config/config.php';

session_start();

if (!isset($_SESSION['role'], $_SESSION['user_id'])) {
    $response['status'] = 'error';
    $response['message'] = 'You are not logged in.';
    echo json_encode($response);
    exit;
}

$model = new Application;

$data = $model->getApplications($_SESSION['user_id']);
if($data != null){
    $response = [
        'data'=> $data
    ];
    echo json_encode($response);
}else{
    http_response_code(200);
    echo json_encode(array('status' => 'error', 'message' => 'End of list.'));
}

?>
<?php

require_once '../../app/core/App.php';
require_once '../../app/core/Database.php';
require_once '../../app/models/registration.php';
require_once '../../app/models/soap.php';
require_once '../../config/config.php';

session_start();

if (!isset($_SESSION['role'], $_SESSION['user_id'])) {
    $response['status'] = 'error';
    $response['message'] = 'You are not logged in.';
    echo json_encode($response);
    exit;
}

$model = new RegistrationModel;

$response = [
    'data'=> $model->getRegistrations($_SESSION['user_id'])
];

echo json_encode($response);

?>
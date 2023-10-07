<?php
require_once '../../app/core/App.php';
require_once '../../app/core/Database.php';
require_once '../../app/models/User.php';
require_once '../../config/config.php';

session_start();

$model = new User;
$params = array();

if (isset($_GET['name'])) {
    $name = $_GET['name'];
    $params['name'] = $name;
}

if (isset($_GET['role'])) {
    $role = $_GET['role'];
    $params['role'] = $role;
}

$scholarships = $model->searchUser($params);

if ($scholarships != null) {
    http_response_code(200);
    $response = [
        'data' => $scholarships,
    ];
    echo json_encode($response);
} else {
    http_response_code(200);
    echo json_encode(array('status' => 'error', 'message' => 'End of list.'));
}

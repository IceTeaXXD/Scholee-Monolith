<?php
require_once '../../app/core/App.php';
require_once '../../app/core/Database.php';
require_once '../../app/models/Scholarship.php';
require_once '../../app/models/scholarshiptype.php';
require_once '../../config/config.php';

session_start();
header('Content-Type: application/json');

$response = [];

if (!isset($_SESSION['role'], $_SESSION['user_id'])) {
    $response['status'] = 'error';
    $response['message'] = 'You are not logged in.';
    echo json_encode($response);
    exit;
}
// check for data in post
if (!isset($_POST['title'], $_POST['description'], $_POST['coverage'], $_POST['contact_name'], $_POST['contact_email'], $_POST['type'])) {
    $response['status'] = 'error';
    $response['message'] = 'Please complete the form.';
    echo json_encode($response);
    exit;
}

$scholarship = new Scholarship($_SESSION['role'], $_SESSION['user_id']);
$typeModel = new ScholarshipType;


$types = explode(",", $_POST['type']);
$scholarshipTypes = array_map('trim', $types);

$updateSuccess = $scholarship->updateScholarship($_SESSION['user_id'], $_POST['scholarship_id'], $_POST['title'], $_POST['description'],
                                $_POST['short_description'], $_POST['coverage'], $_POST['contact_name'], $_POST['contact_email']);

if ($updateSuccess) {
    $typeModel->updateTypes($_SESSION['user_id'], $_POST['scholarship_id'], $scholarshipTypes);
    $response['status'] = 'success';
    $response['message'] = 'Scholarship updated successfully';
} else {
    $response['status'] = 'error';
    $response['message'] = 'Failed to update scholarship';
}

header('Content-Type: application/json');
echo json_encode($response);

?>
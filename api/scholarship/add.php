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

// Explode into Array for Type
$types = explode(",", $_POST['type']);
$scholarshipTypes = array_map('trim', $types);

$scholarshipID = $scholarship->countOrganizationScholarship($_SESSION['user_id']) + 1;

$in = $scholarship->addScholarship($_SESSION['user_id'],
                            $scholarshipID, 
                            $_POST['title'],
                            $_POST['description'],
                            $_POST['coverage'],
                            $_POST['contact_name'],
                            $_POST['contact_email'],
                        );

if (!$in) {
    $response['status'] = 'error';
    $response['message'] = 'Failed to add scholarship.';
    echo json_encode($response);
    exit;
}

foreach($scholarshipTypes as $type){
    $typeModel->addType($_SESSION['user_id'], $scholarshipID, $type);
}

$response['status'] = 'success';
$response['message'] = 'Successfully added scholarship and its types.';
echo json_encode($response);

?>
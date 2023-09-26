<?php
require_once '../../app/core/App.php';
require_once '../../app/core/Database.php';
require_once '../../app/models/Scholarship.php';
require_once '../../app/models/scholarshiptype.php';
require_once '../../config/config.php';

session_start();

$scholarship = new Scholarship;
$typeModel = new ScholarshipType;

/* Explode into Array for Type */
$types = explode(",", $_POST['type']);
$scholarshipTypes = array_map('trim', $types);

$scholarshipID = $scholarship->countOrganizationScholarship($_SESSION['user_id']) + 1;

$in = $scholarship->addScholarship($_SESSION['user_id'],
                            $scholarshipID, 
                            $_POST['title'],
                            $_POST['description'],
                            $_POST['coverage'],
                            $_POST['contact_name'],
                            $_POST['contact_email']);

foreach($scholarshipTypes as $type){
    $typeModel->addType($_SESSION['user_id'], $scholarshipID, $type);
}

header('Location: /scholarships');

?>
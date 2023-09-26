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

$scholarship->updateScholarship($_SESSION['user_id'], $_POST['scholarship_id'], $_POST['title'], $_POST['description'],
                                $_POST['coverage'], $_POST['contact_name'], $_POST['contact_email']);

$typeModel->updateTypes($_SESSION['user_id'], $_POST['scholarship_id'], $scholarshipTypes);

header('Location: /scholarships');

?>
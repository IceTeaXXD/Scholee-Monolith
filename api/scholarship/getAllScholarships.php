<?php
require_once '../../app/core/App.php';
require_once '../../app/core/Database.php';
require_once '../../app/models/Scholarship.php';
require_once '../../config/config.php';

$scholarship = new Scholarship(0,0);

$data = $scholarship->getAllScholarshipREST();

$results = mysqli_fetch_all($data, MYSQLI_ASSOC);

echo json_encode($results);
?>
<?php
require_once '../../config/config.php';
require_once '../../app/models/Scholarship.php';
require_once '../../app/core/Database.php';

session_start();
header('Content-Type: application/json');
$scholarship_model = new Scholarship($_SESSION['role'], $_SESSION['user_id']);
$params = array();

if (isset($_GET['judul'])) {
    $judul = $_GET['judul'];
    $params['judul'] = $judul;
}

if (isset($_GET['coverage'])) {
    $coverage = $_GET['coverage'];
    $params['coverage'] = $coverage;
}

if (isset($_GET['page'])) {
    $page = $_GET['page'];
    $params['page'] = $page;
}
if (isset($_GET['itemsPerPage'])) {
    $itemsPerPage = $_GET['itemsPerPage'];
    if ($itemsPerPage !== 'all') {
        $params['limit'] = (int) $itemsPerPage;
    } else {
        $params['limit'] = 1000000;
    }
} else {
    $params['limit'] = 5;
}

if (isset($_GET['sort'])) {
    $sort = $_GET['sort'];
    $params['sort'] = $sort;
}

$scholarships = $scholarship_model->findScholarships($params);
$total = $scholarship_model->countFilteredScholarships($params);
if ($scholarships != null) {
    http_response_code(200);
    $response = [
        'data' => $scholarships,
        'currentPage' => $page,
        'total' => $total,
    ];
    echo json_encode($response);
} else {
    http_response_code(200);
    echo json_encode(array('status' => 'error', 'message' => 'End of list.'));
}

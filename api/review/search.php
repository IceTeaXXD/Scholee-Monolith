<?php
require_once '../../config/config.php';
require_once '../../app/models/review.php';
require_once '../../app/core/Database.php';

$model = new Review;

session_start();
$params[] = [];
$params['user_id'] = $_SESSION['user_id'];

if(isset($_GET['review_status'])){
    $params['review_status'] = $_GET['review_status'];
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
$reviews = "";
$total = "";

if($_GET['role'] == 'student'){
    $reviews = $model->findReviewStudent($params);
    $total = $model->countSearchStudent($params);
}else{
    $reviews = $model->findReviewReviewer($params);
    $total = $model->countReviewReviewer($params);
}

if ($reviews != null) {
    http_response_code(200);
    $response = [
        'data' => $reviews,
        'currentPage' => $page,
        'total' => $total,
    ];
    echo json_encode($response);
} else {
    http_response_code(200);
    echo json_encode(array('status' => 'error', 'message' => 'End of list.'));
}
?>
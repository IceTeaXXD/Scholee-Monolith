<?php
require_once '../../app/core/App.php';
require_once '../../app/core/Database.php';
require_once '../../app/models/bookmark.php';
require_once '../../config/config.php';

session_start();
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $model = new Bookmark;
    $params = [];

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

    $bookmarks = $model->findBookmarks($params);
    $total = $model->countFilteredBookmarks($params);

    if ($bookmarks !== null) {
        http_response_code(200);
        $response = [
            'data' => $bookmarks,
            'currentPage' => $page,
            'total' => $total,
        ];
        echo json_encode($response);
    } else {
        http_response_code(200);
        echo json_encode(['status' => 'error', 'message' => 'No bookmarks found.']);
    }
} else {
    http_response_code(405);
    echo json_encode(['status' => 'error', 'message' => 'Method not allowed']);
}
?>

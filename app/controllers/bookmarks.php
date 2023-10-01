<?php
require_once 'app/core/App.php';
require_once 'app/core/Database.php';
require_once 'app/models/Bookmark.php';
require_once 'config/config.php';

class Bookmarks extends Controller{
    public function index(){
        $model = new Bookmark;

        $data['judul'] = 'Bookmarks';
        $data['style'] = "/public/css/dashboard.css";
        $data['style'] = "/public/css/scholarships.css";
        $data['row'] = $model->getUserBookmark();
        $itemsPerPage = isset($_GET['itemsPerPage']) ? $_GET['itemsPerPage'] : 5;
        $totalBookmark = $model->countUserBookmark();
        if ($itemsPerPage === 'all') {
            $itemsPerPage = $totalBookmark;
        }
        $currentPage = isset($_GET['page']) ? $_GET['page'] : 1; 
        $offset = ($currentPage - 1) * $itemsPerPage;
        $data['totalScholarships'] = $totalBookmark;
        $data['itemsPerPage'] = $itemsPerPage;
        $data['currentPage'] = $currentPage;
        if (isset($_SESSION['username'])) {
            $this->view('header/index', $data);
            $this->view('navbar/index', $data);
            $this->view('bookmarks/index', $data);
        } else {
            header('Location: /login');
        }
    }

    public function add(){
        $model = new Bookmark;
        $model->newBookMark($_SESSION['user_id'], $_GET['uis'], $_GET['sid'], 1);
        header("Location: /bookmarks");
    }
}
<?php
require_once 'app/core/App.php';
require_once 'app/core/Database.php';
require_once 'app/models/Bookmark.php';
require_once 'config/config.php';
require_once 'app/models/Scholarship.php';

class Bookmarks extends Controller{
    public function index(){
        $model = new Bookmark;
        $data['judul'] = 'Bookmarks';
        $data['style'] = "/public/css/dashboard.css";
        $data['style'] = "/public/css/scholarships.css";
        $data['row'] = $model->getUserBookmark();
        $data['max_coverage'] = $model->maxCoverage();
        $data['user_id'] = $_SESSION['user_id'];
        if (isset($_SESSION['username'])) {
            $this->view('header/index', $data);
            $this->view('navbar/index', $data);
            $this->view('bookmarks/index', $data);
        } else {
            header('Location: /login');
        }
    }
}
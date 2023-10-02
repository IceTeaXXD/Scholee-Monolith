<?php
require_once 'app/core/App.php';
require_once 'app/core/Database.php';
require_once 'app/models/Review.php';
require_once 'config/config.php';

class Reviews extends Controller{
    public function index(){
        $model = new Review();
        $data['row'] = null;
        $data['style'] = "/public/css/scholarships.css";
        $data['judul'] = "Documents Reviews";
        $data['totalScholarships'] = 0;
        $data['itemsPerPage'] = 0;
        $data['currentPage'] = 0;
        if($_SESSION['role'] == 'student'){
            $data['row'] = $model->getStudentDocument();
        }else{
            $data['row'] = $model->getReviewerDocument();
        }
        if (isset($_SESSION['username'])) {
            $this->view('header/index', $data);
            $this->view('navbar/index', $data);
            $this->view('review/index', $data);
        } else {
            header('Location: /login');
        }
    }

    public function add(){
        $data['row'] = null;
        $data['style'] = "/public/css/addbeasiswa.css";
        $data['judul'] = "Documents Reviews";
        $data['totalScholarships'] = 0;
        $data['itemsPerPage'] = 0;
        $data['currentPage'] = 0;
        if (isset($_SESSION['username'])) {
            $this->view('header/index', $data);
            $this->view('navbar/index', $data);
            $this->view('addDocument/index', $data);
        } else {
            header('Location: /login');
        }
    }
}
?>
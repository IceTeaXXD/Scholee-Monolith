<?php
require_once 'app/core/App.php';
require_once 'app/core/Database.php';
require_once 'app/models/Scholarship.php';
require_once 'config/config.php';

class Scholarships extends Controller {
    public function index() {
        $data['judul'] = 'Scholarships';
        $data['style'] = "/public/css/scholarships.css";
        $this->view('header/index', $data);
        $this->view('navbar/index', $data);

        $model = new Scholarship();
        $data['scholarships'] = $model->getAllScholarship();
        $this->view('scholarships/index', $data);
    }
}
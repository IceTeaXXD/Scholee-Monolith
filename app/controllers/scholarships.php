<?php
require_once 'app/core/App.php';
require_once 'app/core/Database.php';
require_once 'app/models/Scholarship.php';
require_once 'app/models/Scholarshiptype.php';
require_once 'config/config.php';

class Scholarships extends Controller
{
    public function index()
    {
        $data['judul'] = 'Scholarships';
        $data['style'] = "/public/css/scholarships.css";
        $this->view('header/index', $data);
        $this->view('navbar/index', $data);
        $this->view('scholarships/index', $data);
    }

    public function add()
    {
        $data['judul'] = 'Add Beasiswa';
        $data['style'] = "/public/css/dashboard.css";
        $data['style'] = "/public/css/addbeasiswa.css";
        if (isset($_SESSION['username']) && $_SESSION['role'] == 'admin') {
            $this->view('header/index', $data);
            $this->view('navbar/index', $data);
            $this->view('addbeasiswa/index', $data);
        } else {
            header('Location: /login');
        }
    }

    public function edit()
    {
        $data['judul'] = 'Edit Beasiswa';
        $data['style'] = "/public/css/dashboard.css";
        $data['style'] = "/public/css/addbeasiswa.css";

        $scholarshipModel = new Scholarship($_SESSION['role'], $_SESSION['user_id']);
        $types = new ScholarshipType();

        $data['row'] = $scholarshipModel->getScholarship($_GET['user_id'], $_GET['scholarship_id']);
        $data['type'] = $types->getTypes($_GET['user_id'], $_GET['scholarship_id']);

        if (isset($_SESSION['username']) && $_SESSION['role'] == 'admin') {
            $this->view('header/index', $data);
            $this->view('navbar/index', $data);
            $this->view('editbeasiswa/index', $data);
        } else {
            header('Location: /login');
        }
    }

    // view per scholarship
    public function description()
    {
    }
}

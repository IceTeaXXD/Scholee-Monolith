<?php
require_once 'app/core/App.php';
require_once 'app/core/Database.php';
require_once 'app/models/Scholarship.php';
require_once 'config/config.php';

class Scholarships extends Controller
{
    public function index()
    {
        $args = func_get_args();
        if (!isset($args[0])) {
            $data['judul'] = 'Scholarships';
            $data['style'] = "/public/css/scholarships.css";
            $this->view('header/index', $data);
            $this->view('navbar/index', $data);
            $this->view('scholarships/index', $data);
        } else {
            $scholarshipModel = new Scholarship($_SESSION['role'], $_SESSION['user_id']);
            $result = $scholarshipModel->getScholarship($args[0], $args[1]);
            foreach ($result as $row) {
                $data['user_id'] = $row['user_id'];
                $data['scholarship_id'] = $row['scholarship_id'];
                $data['title'] = $row['title'];
                $data['short_description'] = $row['short_description'];
                $data['description'] = $row['description'];
                $data['coverage'] = $row['coverage'];
                $data['contact_name'] = $row['contact_name'];
                $data['contact_email'] = $row['contact_email'];
            }
            $data['judul'] = $data['title'];
            $data['style'] = "/public/css/description.css";
            $this->view('header/index', $data);
            $this->view('navbar/index', $data);
            $this->view('scholarships/description', $data);
        }
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

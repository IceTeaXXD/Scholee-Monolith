<?php
require_once 'app/core/App.php';
require_once 'app/core/Database.php';
require_once 'app/models/Scholarship.php';
require_once 'app/models/user.php';
require_once 'config/config.php';
class Dashboard extends Controller
{
    public function index()
    {
        if ($_SESSION['role']=="student")
        {
            $data['judul'] = 'Dashboard';
            $data['style'] = "/public/css/dashboard.css";
            $model = new Scholarship($_SESSION['role'], $_SESSION['user_id']);
            $itemsPerPage = 10;
            $offset = 0;
            $data['scholarships'] = $model->getAllScholarship($offset, $itemsPerPage);
            if (isset($_SESSION['username'])) {
                $this->view('header/index', $data);
                $this->view('navbar/index', $data);
                $this->view('dashboard/index', $data);
                $this->view('dashboard/student', $data);
            } else {
                header('Location: /login');
            }
        }
        else if ($_SESSION['role'] =="super admin")
        {
            $data['judul'] = 'Dashboard';
            $data['style'] = "/public/css/dashboard.css";
            $model = new User();
            $data['user'] = $model->getUserAll();
            if (isset($_SESSION['username'])) {
                $this->view('header/index', $data);
                $this->view('navbar/index', $data);
                $this->view('dashboard/index', $data);
                $this->view('dashboard/superAdmin', $data);
            } else {
                header('Location: /login');
            }
        }
    }
}
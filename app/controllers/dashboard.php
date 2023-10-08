<?php
require_once 'app/core/App.php';
require_once 'app/core/Database.php';
require_once 'app/models/Scholarship.php';
require_once 'config/config.php';
class Dashboard extends Controller
{
    public function index()
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
        } else {
            header('Location: /login');
        }
    }
}
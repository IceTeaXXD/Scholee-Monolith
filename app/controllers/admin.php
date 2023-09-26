<?php
require_once 'app/core/App.php';
require_once 'app/core/Database.php';
require_once 'app/models/User.php';
require_once 'config/config.php';

class Admin extends Controller{

    public function index(){
        if (isset($_SESSION['username']) && $_SESSION['role'] == 'super admin') {
            $this->list();
        } else {
            header('Location: /login');
        }
    }


    public function list(){
        $userModel = new User();
        $data['users'] = $userModel->getUserAll();
        $data['judul'] = 'List User';
        $data['style'] = "/public/css/userlist.css";
        $this->view('header/index', $data);
        $this->view('navbar/index', $data);
        $this->view('userlist/index', $data);
    }
}
<?php
require_once 'app/core/App.php';
require_once 'app/core/Database.php';
require_once 'app/models/User.php';
require_once 'app/models/superadmin.php';
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
        if(isset($_SESSION['role'])){
            $this->view('header/index', $data);
            $this->view('navbar/index', $data);
            $this->view('admin/userlist', $data);
        }else{
            header("Location: /login"); 
        }
    }

    public function update(){

        $data['judul'] = 'Update User';
        $data['style'] = "/public/css/editprofile.css";
        $data['role'] = $_GET['role'];
        $data['email'] = $_GET['email'];
        $data['user_id'] = $_GET['user_id'];
        $user = new User;
        $data['user'] = $user->getUser($_GET['email'], $_GET['role']);

        if(isset($_SESSION['user_id'])){
            $this->view('header/index', $data);
            $this->view('navbar/index', $data);
            $this->view('admin/update', $data);
        }else{
            header("Location: /login");
        }
    }

    public function add(){
        $data['judul'] = 'Add User';
        $data['style'] = "/public/css/adduser.css";

        if(isset($_SESSION['user_id'])){
            $this->view('header/index', $data);
            $this->view('navbar/index', $data);
            $this->view('admin/addnewuser', $data);
        }else{
            header("Location: /login");
        }
    }
}
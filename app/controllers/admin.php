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
        $this->view('header/index', $data);
        $this->view('navbar/index', $data);
        $this->view('userlist/index', $data);
    }

    public function update(){

        $data['judul'] = 'Update User';
        $data['style'] = "/public/css/editprofile.css";
        $data['role'] = $_GET['role'];
        $data['email'] = $_GET['email'];
        $data['user_id'] = $_GET['user_id'];
        $user = new User;
        $data['user'] = $user->getUser($_GET['email'], $_GET['role']);

        $this->view('header/index', $data);
        $this->view('navbar/index', $data);
        $this->view('updateuser/index', $data);
    }

    public function delete(){
        $model = new Superadmin;

        $exec = $model->deleteUser($_GET['user_id']);

        if($exec){
            header("Location: /admin/list");
        }
    }

    public function add(){
        $data['judul'] = 'Add User';
        $data['style'] = "/public/css/addbeasiswa.css";
        $this->view('header/index', $data);
        $this->view('navbar/index', $data);
        $this->view('addnewuser/index', $data);
    }
}
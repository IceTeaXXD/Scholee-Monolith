<?php
require_once 'app/core/App.php';
require_once 'app/core/Database.php';
require_once 'app/models/User.php';
require_once 'config/config.php';

class EditProfile extends Controller
{
    public function index()
    {
        $model = new User();
        $data['user'] = $model->getUser($_SESSION['email'], $_SESSION['role']);
        $data['judul'] = 'Edit Profile';
        $data['style'] = "/public/css/editprofile.css";
        $this->view('header/index', $data);
        $this->view('navbar/index', $data);
        $this->view('editprofile/index', $data);
    }
}

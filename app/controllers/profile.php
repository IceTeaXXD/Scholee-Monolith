<?php
require_once 'app/core/App.php';
require_once 'app/core/Database.php';
require_once 'app/models/User.php';
require_once 'config/config.php';
class Profile extends Controller
{
    public function index()
    {   
        if (isset($_SESSION['username'])) {
            $data['judul'] = 'Profile';
            $data['style'] = "/public/css/profile.css";
            $model = new User();
            $data['user'] = $model->getUser($_SESSION['email'], $_SESSION['role']);
            $this->view('header/index', $data);
            $this->view('navbar/index', $data);
            $this->view('profile/index', $data);
        } else {
            header('Location: /login');
        }
    }

    public function edit() 
    {
        if (isset($_SESSION['username'])) {
            $model = new User();
            $data['user'] = $model->getUser($_SESSION['email'], $_SESSION['role']);
            $data['judul'] = 'Edit Profile';
            $data['style'] = "/public/css/editprofile.css";
            $this->view('header/index', $data);
            $this->view('navbar/index', $data);
            $this->view('profile/edit', $data);
        } else {
            header('Location: /login');
        }
    }
}